<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Cart\MergeGuestCart;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class LoginController extends Controller
{
    public function showLogin(): View
    {
        return view('backend.pages.auth.login');
    }

    public function login(
        Request $request,
        MergeGuestCart $mergeGuestCart,
    ): RedirectResponse {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        /*
         * IMPORTANT:
         *
         * Capture the guest session ID BEFORE Auth::attempt().
         *
         * Laravel may migrate the session when authentication
         * succeeds, so capturing it after Auth::attempt() can
         * lose the session ID used by the guest cart.
         */
        $guestSessionId =
            $request->session()->getId();

        $remember =
            $request->boolean('remember');


        if (!Auth::attempt(
            $credentials,
            $remember
        )) {
            return back()
                ->with(
                    'error',
                    'The email or password you entered is incorrect.'
                )
                ->withInput(
                    $request->only(
                        'email',
                        'remember'
                    )
                );
        }


        $user =
            $request->user();


        if ($user === null) {
            Auth::logout();

            return back()
                ->with(
                    'error',
                    'Unable to authenticate your account.'
                );
        }


        if (!$user->isActive()) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $message = match ($user->status) {
                'inactive' =>
                'Your account is currently inactive.',

                'suspended' =>
                'Your account has been suspended.',

                default =>
                'Your account is not active.',
            };


            return back()
                ->with(
                    'error',
                    $message
                )
                ->withInput(
                    $request->only(
                        'email',
                        'remember'
                    )
                );
        }


        /*
         * Regenerate the session after authentication.
         *
         * The original guest session ID has already been
         * captured above.
         */
        $request->session()->regenerate();


        /*
         * Merge the cart that belonged to the guest session
         * into the authenticated user's cart.
         */
        $mergeGuestCart->execute(
            $user,
            $guestSessionId,
        );


        /*
         * Cart merge must happen before the email verification
         * redirect so the guest cart is preserved even when
         * verification is still required.
         */
        if (!$user->hasVerifiedEmail()) {
            return redirect()
                ->route('verification.notice')
                ->with(
                    'info',
                    'Please verify your email address before continuing.'
                );
        }


        return redirect()
            ->intended(
                route('my-account')
            )
            ->with(
                'success',
                'Welcome back, ' . $user->name . '!'
            );
    }

    public function logout(
        Request $request,
    ): RedirectResponse {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }
}
