<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\Checkout\PrepareCheckout;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

final class CheckoutController extends Controller
{
    public function index(
        Request $request,
        PrepareCheckout $prepareCheckout,
    ): View|RedirectResponse {
        $user = $request->user();

        $cart = Cart::query()
            ->where('user_id', $user->id)
            ->first();

        if ($cart === null) {
            return redirect()
                ->route('cart')
                ->with('error', 'Your cart is empty.');
        }

        try {
            $checkout = $prepareCheckout->execute($cart);
        } catch (ValidationException $exception) {
            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    $exception->validator->errors()->first(),
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Saved Shipping Addresses
        |--------------------------------------------------------------------------
        */

        $addresses = $user->addresses()
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        $defaultAddress = $addresses->firstWhere(
            'is_default',
            true,
        );

        /*
        |--------------------------------------------------------------------------
        | Checkout View Data
        |--------------------------------------------------------------------------
        */

        $checkout['addresses'] = $addresses;
        $checkout['default_address'] = $defaultAddress;

        return view(
            'frontend.pages.shop.checkout',
            $checkout,
        );
    }
}
