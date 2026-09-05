<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

final class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Profile
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $user = Auth::user();

        $addresses = $user->addresses()
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return view(
            'backend.pages.profile.index',
            compact(
                'user',
                'addresses',
            ),
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

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {
            $newProfileImage = $this->storeProfileImage(
                $request->file('profile_image'),
            );

            if (!empty($user->profile_image)) {
                $this->deleteProfileImage(
                    $user->profile_image,
                );
            }

            $user->profile_image = $newProfileImage;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['new_password'])) {
            $user->password = $validated['new_password'];
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
            'Your profile has been updated successfully.',
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Profile Image
    |--------------------------------------------------------------------------
    */

    private function storeProfileImage(
        UploadedFile $file,
    ): string {
        $uploadPath = public_path(
            'uploads/users',
        );

        if (!File::exists($uploadPath)) {
            File::makeDirectory(
                $uploadPath,
                0755,
                true,
            );
        }

        $fileName = uniqid(
                'user_',
                true,
            )
            . '.'
            . $file->getClientOriginalExtension();

        $file->move(
            $uploadPath,
            $fileName,
        );

        return 'uploads/users/' . $fileName;
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Profile Image
    |--------------------------------------------------------------------------
    */

    private function deleteProfileImage(
        string $profileImage,
    ): void {
        $profileImage = ltrim(
            $profileImage,
            '/\\',
        );

        if (
            !str_starts_with(
                $profileImage,
                'uploads/users/',
            )
        ) {
            return;
        }

        $filePath = public_path(
            $profileImage,
        );

        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
}
