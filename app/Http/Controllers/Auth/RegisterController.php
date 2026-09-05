<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Cart\MergeGuestCart;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

final class RegisterController extends Controller
{
    public function showRegister(): View
    {
        return view('backend.pages.auth.register');
    }

    public function register(
        Request $request,
        MergeGuestCart $mergeGuestCart,
    ): RedirectResponse {
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
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'terms' => [
                'required',
                'accepted',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Client Role
        |--------------------------------------------------------------------------
        */

        $clientRole = Role::query()
            ->where('slug', 'client')
            ->first();


        if ($clientRole === null) {
            return back()
                ->with(
                    'error',
                    'Client role is not configured. Please contact the administrator.'
                )
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Guest Cart Session
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Capture the guest session ID before authentication.
        | The cart in the database is connected to this session ID.
        |
        */

        $guestSessionId =
            $request->session()->getId();


        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        $user = DB::transaction(
            function () use (
                $request,
                $validated,
                $clientRole,
            ): User {
                $profileImage = null;


                /*
                 * Profile image upload.
                 */
                if ($request->hasFile('profile_image')) {
                    $uploadPath =
                        public_path('uploads/users');


                    if (!File::exists($uploadPath)) {
                        File::makeDirectory(
                            $uploadPath,
                            0755,
                            true,
                        );
                    }


                    $file =
                        $request->file('profile_image');


                    $fileName =
                        uniqid(
                            'user_',
                            true,
                        )
                        . '.'
                        . $file->getClientOriginalExtension();


                    $file->move(
                        $uploadPath,
                        $fileName,
                    );


                    $profileImage =
                        'uploads/users/' . $fileName;
                }


                /*
                 * Create user.
                 */
                $user = User::create([
                    'first_name' =>
                        $validated['first_name'],

                    'last_name' =>
                        $validated['last_name'] ?? null,

                    'email' =>
                        $validated['email'],

                    'phone' =>
                        $validated['phone'] ?? null,

                    'password' =>
                        $validated['password'],

                    'status' =>
                        'active',

                    'profile_image' =>
                        $profileImage,
                ]);


                /*
                 * Assign client role.
                 */
                $user->assignRole(
                    $clientRole
                );


                return $user;
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Registered Event
        |--------------------------------------------------------------------------
        */

        event(
            new Registered($user)
        );


        /*
        |--------------------------------------------------------------------------
        | Authenticate User
        |--------------------------------------------------------------------------
        */

        Auth::login($user);


        /*
        |--------------------------------------------------------------------------
        | Merge Guest Cart
        |--------------------------------------------------------------------------
        |
        | The original guest session ID is intentionally used here.
        | This allows the guest cart to be transferred to the new
        | authenticated user's cart.
        |
        */

        $mergeGuestCart->execute(
            $user,
            $guestSessionId,
        );


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        |
        | Regenerate after authentication and cart merge.
        | The guest session ID has already been captured above,
        | so the cart merge is not affected by this regeneration.
        |
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Email Verification
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('verification.notice')
            ->with(
                'success',
                'Your account has been created successfully. Please check your inbox to verify your email address.'
            );
    }

    public function showVerificationNotice(): View|RedirectResponse
    {
        $user = Auth::user();


        if (
            $user === null ||
            $user->hasVerifiedEmail()
        ) {
            return redirect()
                ->route('dashboard');
        }


        return view(
            'backend.pages.auth.verify-email',
            compact('user'),
        );
    }

    public function verifyEmail(
        EmailVerificationRequest $request,
    ): RedirectResponse {
        if (
            $request->user()->hasVerifiedEmail()
        ) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'success',
                    'Your email address has already been verified.'
                );
        }


        if ($request->fulfill()) {
            event(
                new Verified(
                    $request->user()
                )
            );
        }


        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Your email address has been verified successfully.'
            );
    }

    public function resendVerificationEmail(
        Request $request,
    ): RedirectResponse {
        $user = $request->user();


        if ($user->hasVerifiedEmail()) {
            return redirect()
                ->route('dashboard');
        }


        $user->sendEmailVerificationNotification();


        return back()->with(
            'success',
            'A new verification link has been sent to your email address.'
        );
    }
}
