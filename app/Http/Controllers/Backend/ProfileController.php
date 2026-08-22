<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Profile
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $user = Auth::user();

        return view(
            'backend.pages.profile.index',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();


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
                'required',
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
                'max:500',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'new_password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Personal Information
        |--------------------------------------------------------------------------
        */

        $user->first_name =
            $validated['first_name'];

        $user->last_name =
            $validated['last_name'];

        $user->email =
            $validated['email'];

        $user->phone =
            $validated['phone'] ?? null;

        $user->address =
            $validated['address'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        |
        | Images are stored directly inside:
        |
        | public/uploads/users/
        |
        */

        if ($request->hasFile('profile_image')) {

            /*
            |--------------------------------------------------------------------------
            | Store New Image
            |--------------------------------------------------------------------------
            */

            $newProfileImage = $this->storeProfileImage(
                $request->file('profile_image')
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Previous Image
            |--------------------------------------------------------------------------
            */

            if (!empty($user->profile_image)) {

                $this->deleteProfileImage(
                    $user->profile_image
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Save New Image Path
            |--------------------------------------------------------------------------
            */

            $user->profile_image =
                $newProfileImage;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        |
        | User model uses:
        |
        | 'password' => 'hashed'
        |
        | Therefore Hash::make() is not required here.
        |
        */

        if (!empty($validated['new_password'])) {

            $user->password =
                $validated['new_password'];
        }


        /*
        |--------------------------------------------------------------------------
        | Save User
        |--------------------------------------------------------------------------
        */

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Your profile has been updated successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Profile Image
    |--------------------------------------------------------------------------
    |
    | Store directly inside:
    |
    | public/uploads/users/
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
        | Create Directory
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
        | Return Database Path
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
        | Clean Path
        |--------------------------------------------------------------------------
        */

        $profileImage = ltrim(
            $profileImage,
            '/\\'
        );


        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        |
        | Only allow deletion from:
        |
        | uploads/users/
        |
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
