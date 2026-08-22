<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display Users
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $query = User::with('roles')
            ->latest();


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'first_name',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'last_name',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'phone',
                        'like',
                        "%{$search}%"
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter By Role
        |--------------------------------------------------------------------------
        */

        if ($request->filled('role')) {

            $query->whereHas('roles', function ($q) use ($request) {

                $q->where(
                    'slug',
                    $request->role
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter By Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        $users = $query
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $activeUsers = User::where(
            'status',
            'active'
        )->count();

        $adminUsers = User::whereHas(
            'roles',
            fn ($q) => $q->where('slug', 'admin')
        )->count();

        $staffUsers = User::whereHas(
            'roles',
            fn ($q) => $q->where('slug', 'staff')
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        |
        | Load roles dynamically from database.
        |
        */

        $roles = Role::orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.users.index',
            compact(
                'users',
                'totalUsers',
                'activeUsers',
                'adminUsers',
                'staffUsers',
                'roles'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create User
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $roles = Role::orderBy('name')
            ->get();

        return view(
            'backend.pages.users.create',
            compact('roles')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store User
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            /*
            |--------------------------------------------------------------------------
            | Single Role
            |--------------------------------------------------------------------------
            */

            'role' => [
                'required',
                'integer',
                'exists:roles,id',
            ],

            'status' => [
                'required',
                'in:active,inactive,suspended',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'email_verified' => [
                'nullable',
                'boolean',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        |
        | Store directly inside:
        |
        | public/uploads/users/
        |
        */

        $profileImage = null;

        if ($request->hasFile('profile_image')) {

            $profileImage = $this->storeProfileImage(
                $request->file('profile_image')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        |
        | User creation and role assignment are handled
        | inside one database transaction.
        |
        */

        $user = DB::transaction(function () use (
            $validated,
            $profileImage
        ) {

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = User::create([

                'first_name' => $validated['first_name'],

                'last_name' => $validated['last_name'] ?? null,

                'email' => $validated['email'],

                'phone' => $validated['phone'] ?? null,

                'address' => $validated['address'] ?? null,

                'password' => $validated['password'],

                'status' => $validated['status'],

                'profile_image' => $profileImage,

                'email_verified_at' =>
                    !empty($validated['email_verified'])
                        ? now()
                        : null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Assign Single Role
            |--------------------------------------------------------------------------
            |
            | Only ONE role is assigned to each user.
            |
            */

            $user->roles()->sync([
                $validated['role'],
            ]);


            return $user;
        });


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('users')
            ->with(
                'success',
                'User has been created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show User
    |--------------------------------------------------------------------------
    */

    public function show(User $user): View
    {
        /*
        |--------------------------------------------------------------------------
        | Load Role
        |--------------------------------------------------------------------------
        */

        $user->load('roles');


        return view(
            'backend.pages.users.details',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit User
    |--------------------------------------------------------------------------
    */

    public function edit(User $user): View
    {
        /*
        |--------------------------------------------------------------------------
        | Load Current Role
        |--------------------------------------------------------------------------
        */

        $user->load('roles');


        /*
        |--------------------------------------------------------------------------
        | Available Roles
        |--------------------------------------------------------------------------
        */

        $roles = Role::orderBy('name')
            ->get();


        return view(
            'backend.pages.users.edit',
            compact(
                'user',
                'roles'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update User
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $user
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Password
            |--------------------------------------------------------------------------
            |
            | Password is optional during update.
            |
            */

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            /*
            |--------------------------------------------------------------------------
            | Single Role
            |--------------------------------------------------------------------------
            */

            'role' => [
                'required',
                'integer',
                'exists:roles,id',
            ],

            'status' => [
                'required',
                'in:active,inactive,suspended',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'email_verified' => [
                'nullable',
                'boolean',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        */

        $profileImage = $user->profile_image;


        if ($request->hasFile('profile_image')) {

            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if ($user->profile_image) {

                $this->deleteProfileImage(
                    $user->profile_image
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Store New Image
            |--------------------------------------------------------------------------
            */

            $profileImage = $this->storeProfileImage(
                $request->file('profile_image')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $user,
            $validated,
            $profileImage
        ) {

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            $user->first_name =
                $validated['first_name'];

            $user->last_name =
                $validated['last_name'] ?? null;

            $user->email =
                $validated['email'];

            $user->phone =
                $validated['phone'] ?? null;

            $user->address =
                $validated['address'] ?? null;

            $user->status =
                $validated['status'];

            $user->profile_image =
                $profileImage;


            /*
            |--------------------------------------------------------------------------
            | Email Verification
            |--------------------------------------------------------------------------
            */

            if (
                !empty($validated['email_verified'])
            ) {

                if (!$user->email_verified_at) {

                    $user->email_verified_at =
                        now();
                }

            } else {

                $user->email_verified_at = null;
            }


            /*
            |--------------------------------------------------------------------------
            | Password
            |--------------------------------------------------------------------------
            */

            if (
                !empty($validated['password'])
            ) {

                $user->password =
                    $validated['password'];
            }


            /*
            |--------------------------------------------------------------------------
            | Save User
            |--------------------------------------------------------------------------
            */

            $user->save();


            /*
            |--------------------------------------------------------------------------
            | Sync Single Role
            |--------------------------------------------------------------------------
            |
            | sync() removes the old role and assigns
            | the newly selected role.
            |
            */

            $user->roles()->sync([
                $validated['role'],
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'user-details',
                $user->id
            )
            ->with(
                'success',
                'User has been updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete User
    |--------------------------------------------------------------------------
    */

    public function destroy(
        User $user
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Delete Profile Image
        |--------------------------------------------------------------------------
        */

        if ($user->profile_image) {

            $this->deleteProfileImage(
                $user->profile_image
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete User
        |--------------------------------------------------------------------------
        |
        | user_roles will be deleted automatically if
        | cascadeOnDelete() is configured on the pivot.
        |
        */

        $user->delete();


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('users')
            ->with(
                'success',
                'User has been deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Profile Image
    |--------------------------------------------------------------------------
    |
    | Stores the image directly inside:
    |
    | public/uploads/users/
    |
    | Returns the relative path that is stored
    | in the database.
    |
    */

    private function storeProfileImage($file): string
    {
        /*
        |--------------------------------------------------------------------------
        | Upload Directory
        |--------------------------------------------------------------------------
        */

        $uploadPath = public_path(
            'uploads/users'
        );


        /*
        |--------------------------------------------------------------------------
        | Create Directory If Not Exists
        |--------------------------------------------------------------------------
        */

        if (!File::exists($uploadPath)) {

            File::makeDirectory(
                $uploadPath,
                0755,
                true
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Unique File Name
        |--------------------------------------------------------------------------
        */

        $fileName = uniqid(
                'user_',
                true
            )
            . '.'
            . $file->getClientOriginalExtension();


        /*
        |--------------------------------------------------------------------------
        | Move File
        |--------------------------------------------------------------------------
        */

        $file->move(
            $uploadPath,
            $fileName
        );


        /*
        |--------------------------------------------------------------------------
        | Return Relative Database Path
        |--------------------------------------------------------------------------
        */

        return 'uploads/users/' . $fileName;
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Profile Image
    |--------------------------------------------------------------------------
    */

    private function deleteProfileImage(
        string $profileImage
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Prevent Invalid Paths
        |--------------------------------------------------------------------------
        */

        $profileImage = ltrim(
            $profileImage,
            '/\\'
        );


        /*
        |--------------------------------------------------------------------------
        | Only Delete Files Inside Upload Directory
        |--------------------------------------------------------------------------
        */

        if (
            !str_starts_with(
                $profileImage,
                'uploads/users/'
            )
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Full File Path
        |--------------------------------------------------------------------------
        */

        $filePath = public_path(
            $profileImage
        );


        /*
        |--------------------------------------------------------------------------
        | Delete File
        |--------------------------------------------------------------------------
        */

        if (File::exists($filePath)) {

            File::delete($filePath);
        }
    }
}
