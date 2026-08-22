<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RoleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | System Roles
    |--------------------------------------------------------------------------
    |
    | These roles are required by the application.
    | Their slug should not be changed or deleted.
    |
    */

    protected array $systemRoles = [
        'admin',
        'client',
    ];


    /*
    |--------------------------------------------------------------------------
    | Display Roles
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Get Roles
        |--------------------------------------------------------------------------
        */

        $roles = Role::withCount([
            'users',
            'permissions',
        ])
            ->latest()
            ->paginate(15);


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.roles.index',
            compact('roles')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Create Form
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view(
            'backend.pages.roles.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Role
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

            'name' => [
                'required',
                'string',
                'max:100',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug(
            $validated['name']
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Generated Slug
        |--------------------------------------------------------------------------
        */

        if (empty($slug)) {

            return back()
                ->withErrors([
                    'name' => 'A valid role name is required.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate
        |--------------------------------------------------------------------------
        */

        if (
            Role::where('slug', $slug)->exists()
        ) {

            return back()
                ->withErrors([
                    'name' => 'This role already exists.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Create Role
        |--------------------------------------------------------------------------
        */

        Role::create([

            'name' => trim(
                $validated['name']
            ),

            'slug' => $slug,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('roles')
            ->with(
                'success',
                'Role has been created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Role
    |--------------------------------------------------------------------------
    */

    public function show(Role $role): View
    {
        /*
        |--------------------------------------------------------------------------
        | Load Permissions + Users
        |--------------------------------------------------------------------------
        */

        $role->load([
            'permissions',
            'users',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Load Counts
        |--------------------------------------------------------------------------
        */

        $role->loadCount([
            'users',
            'permissions',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.roles.details',
            compact('role')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Edit Form
    |--------------------------------------------------------------------------
    */

    public function edit(Role $role): View
    {
        return view(
            'backend.pages.roles.edit',
            compact('role')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Role
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Role $role
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:100',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate New Slug
        |--------------------------------------------------------------------------
        */

        $newName = trim(
            $validated['name']
        );

        $newSlug = Str::slug(
            $newName
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Generated Slug
        |--------------------------------------------------------------------------
        */

        if (empty($newSlug)) {

            return back()
                ->withErrors([
                    'name' => 'A valid role name is required.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Protect System Role Slug
        |--------------------------------------------------------------------------
        |
        | Admin and Client slugs are used throughout the application.
        | Their names can be updated, but their slugs must remain stable.
        |
        */

        if (
            in_array(
                $role->slug,
                $this->systemRoles,
                true
            )
            &&
            $newSlug !== $role->slug
        ) {

            return back()
                ->withErrors([
                    'name' =>
                        'The "' .
                        $role->name .
                        '" system role cannot change its role identifier.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Slug
        |--------------------------------------------------------------------------
        */

        $exists = Role::where(
            'slug',
            $newSlug
        )
            ->where(
                'id',
                '!=',
                $role->id
            )
            ->exists();


        if ($exists) {

            return back()
                ->withErrors([
                    'name' => 'This role already exists.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Update Role
        |--------------------------------------------------------------------------
        */

        $role->update([

            'name' => $newName,

            'slug' => $newSlug,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('roles')
            ->with(
                'success',
                'Role has been updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Manage Role Permissions
    |--------------------------------------------------------------------------
    |
    | Display all available permissions and the permissions
    | currently assigned to the selected role.
    |
    */

    public function permissions(Role $role): View
    {
        /*
        |--------------------------------------------------------------------------
        | Get Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = Permission::query()
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Load Assigned Permissions
        |--------------------------------------------------------------------------
        */

        $role->load('permissions');


        /*
        |--------------------------------------------------------------------------
        | Assigned Permission IDs
        |--------------------------------------------------------------------------
        */

        $assignedPermissionIds = $role
            ->permissions
            ->pluck('id')
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.roles.permissions',
            compact(
                'role',
                'permissions',
                'assignedPermissionIds'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Role Permissions
    |--------------------------------------------------------------------------
    |
    | Replace the current role permissions with the selected
    | permissions from the form.
    |
    */

    public function updatePermissions(
        Request $request,
        Role $role
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Selected Permissions
        |--------------------------------------------------------------------------
        */

        $permissionIds = $validated['permissions'] ?? [];


        /*
        |--------------------------------------------------------------------------
        | Sync Permissions
        |--------------------------------------------------------------------------
        */

        $role->permissions()->sync(
            $permissionIds
        );


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'role-permissions',
                $role
            )
            ->with(
                'success',
                'Role permissions have been updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Role
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Role $role
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Prevent Deleting System Roles
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $role->slug,
                $this->systemRoles,
                true
            )
        ) {

            return back()->with(
                'error',
                'System roles cannot be deleted.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Deleting Role With Users
        |--------------------------------------------------------------------------
        */

        if (
            $role->users()->exists()
        ) {

            return back()->with(
                'error',
                'This role cannot be deleted because users are assigned to it.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Role
        |--------------------------------------------------------------------------
        |
        | role_permissions has cascadeOnDelete().
        | user_roles also has cascadeOnDelete().
        |
        | Therefore deleting the role automatically removes
        | its pivot relationships.
        |
        */

        DB::transaction(function () use ($role) {

            /*
            |--------------------------------------------------------------------------
            | Remove Permissions
            |--------------------------------------------------------------------------
            */

            $role->permissions()->detach();


            /*
            |--------------------------------------------------------------------------
            | Delete Role
            |--------------------------------------------------------------------------
            */

            $role->delete();

        });


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('roles')
            ->with(
                'success',
                'Role has been deleted successfully.'
            );
    }
}
