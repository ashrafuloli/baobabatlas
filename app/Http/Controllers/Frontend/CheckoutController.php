<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\Checkout\CreateStripeCheckoutSession;
use App\Actions\Checkout\PrepareCheckout;
use App\Actions\Order\CompleteOrder;
use App\Actions\Order\CreateOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Stripe\StripeClient;
use Throwable;

final class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index(
        Request $request,
        PrepareCheckout $prepareCheckout,
    ): View|RedirectResponse {
        $user = $request->user();

        $cart = Cart::query()
            ->where('user_id', $user->id)
            ->withCount('items')
            ->first();

        if ($cart === null || $cart->items_count === 0) {
            return redirect()
                ->route('my-cart')
                ->with(
                    'error',
                    'Your cart is empty.',
                );
        }

        try {
            $checkout = $prepareCheckout->execute($cart);
        } catch (ValidationException $exception) {
            return redirect()
                ->route('my-cart')
                ->with(
                    'error',
                    $exception->validator
                        ->errors()
                        ->first(),
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Saved Shipping Addresses
        |--------------------------------------------------------------------------
        */

        $addresses = $user->addresses()
            ->orderByDesc('is_default')
            ->latest('id')
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

    /**
     * Create an order and redirect the customer to Stripe Checkout.
     */
    public function payment(
        CheckoutRequest $request,
        PrepareCheckout $prepareCheckout,
        CreateOrder $createOrder,
        CreateStripeCheckoutSession $createStripeCheckoutSession,
    ): RedirectResponse {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Resolve User Cart
        |--------------------------------------------------------------------------
        */

        $cart = Cart::query()
            ->where('user_id', $user->id)
            ->with([
                'items.product',
                'items.product.images' => function ($query): void {
                    $query
                        ->whereNull('variant_id')
                        ->orderByDesc('is_primary')
                        ->orderBy('sort_order');
                },
                'items.variant',
            ])
            ->first();

        if ($cart === null || $cart->items->isEmpty()) {
            return redirect()
                ->route('my-cart')
                ->with(
                    'error',
                    'Your cart is empty.',
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve Validated Checkout Data
        |--------------------------------------------------------------------------
        */

        $checkoutData = $request->validated();

        $addressId = $request->integer('address_id');

        /*
        |--------------------------------------------------------------------------
        | Saved Address
        |--------------------------------------------------------------------------
        */

        if ($addressId > 0) {
            $address = UserAddress::query()
                ->whereKey($addressId)
                ->where('user_id', $user->id)
                ->first();

            if ($address === null) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'The selected shipping address is invalid.',
                    );
            }

            $checkoutData = array_merge(
                $checkoutData,
                [
                    'first_name' => $address->first_name,
                    'last_name' => $address->last_name,
                    'phone' => $address->phone,
                    'country' => $address->country,
                    'address' => $address->address,
                    'apartment' => $address->apartment,
                    'city' => $address->city,
                    'state' => $address->state,
                    'postal_code' => $address->postal_code,
                ],
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Prepare Fresh Checkout
        |--------------------------------------------------------------------------
        */

        try {
            $checkout = $prepareCheckout->execute($cart);
        } catch (ValidationException $exception) {
            return redirect()
                ->route('my-cart')
                ->with(
                    'error',
                    $exception->validator
                        ->errors()
                        ->first(),
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Checkout Totals
        |--------------------------------------------------------------------------
        */

        $totals = [
            'currency' => $checkout['currency'] ?? 'usd',
            'subtotal' => $checkout['subtotal'] ?? 0,
            'discount' => $checkout['discount'] ?? 0,
            'shipping' => $checkout['shipping'] ?? 0,
            'tax' => $checkout['tax'] ?? 0,
            'total' => $checkout['total'] ?? 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Validate Payable Amount
        |--------------------------------------------------------------------------
        */

        if ((float) $totals['total'] <= 0) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'There is no payable amount for this order.',
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Pending Order
        |--------------------------------------------------------------------------
        */

        try {
            $order = $createOrder->execute(
                $cart,
                $checkoutData,
                $totals,
            );

            /*
            |--------------------------------------------------------------------------
            | Create Stripe Checkout Session
            |--------------------------------------------------------------------------
            */

            $session = $createStripeCheckoutSession->execute(
                $order,
            );
        } catch (ValidationException $exception) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->validator
                        ->errors()
                        ->first(),
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to start the payment process. Please try again.',
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Save New Address
        |--------------------------------------------------------------------------
        */

        if (
            $addressId === 0
            && $request->boolean('save_address')
        ) {
            try {
                $this->saveAddress(
                    $user->id,
                    $checkoutData,
                );
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Stripe Checkout URL
        |--------------------------------------------------------------------------
        */

        if (
            !is_string($session->url)
            || trim($session->url) === ''
        ) {
            report(
                new \RuntimeException(
                    'Stripe Checkout Session URL is missing.',
                ),
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to start the payment process. Please try again.',
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect To Stripe
        |--------------------------------------------------------------------------
        */

        return redirect()->away(
            $session->url,
        );
    }

    /**
     * Display the order/payment result after returning from Stripe.
     *
     * Stripe webhook remains the source of truth for payment confirmation.
     */
    public function success(Request $request): View
    {
        $sessionId = trim((string) $request->query('session_id'));

        $order = $request->user()
            ->orders()
            ->with('items')
            ->where('stripe_checkout_session_id', $sessionId)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | If webhook already completed the order
        |--------------------------------------------------------------------------
        */

        if ($order->isPaid()) {
            $request->session()->forget('cart_coupon');

            return view(
                'frontend.pages.shop.checkout-success',
                [
                    'order' => $order,
                    'paymentConfirmed' => true,
                ],
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Stripe fallback confirmation
        |--------------------------------------------------------------------------
        |
        | The customer can return to this page before Stripe's webhook reaches
        | the application. We verify the Checkout Session directly with Stripe.
        |
        */

        if ($sessionId === '') {
            return view(
                'frontend.pages.shop.checkout-success',
                [
                    'order' => $order,
                    'paymentConfirmed' => false,
                ],
            );
        }

        try {
            $stripe = new StripeClient(
                (string) config('services.stripe.secret'),
            );

            $session = $stripe->checkout->sessions->retrieve(
                $sessionId,
                [],
            );

            $paymentStatus = (string) ($session->payment_status ?? '');

            /*
            |--------------------------------------------------------------------------
            | Verify the Checkout Session belongs to this order
            |--------------------------------------------------------------------------
            */

            if (
                $order->stripe_checkout_session_id !== $session->id
            ) {
                Log::warning(
                    'Stripe success session mismatch.',
                    [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'stored_session_id' =>
                            $order->stripe_checkout_session_id,
                        'received_session_id' => $session->id,
                    ],
                );

                return view(
                    'frontend.pages.shop.checkout-success',
                    [
                        'order' => $order,
                        'paymentConfirmed' => false,
                    ],
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Payment confirmed by Stripe
            |--------------------------------------------------------------------------
            */

            if ($paymentStatus === 'paid') {
                $paymentIntentId = null;

                if (
                    isset($session->payment_intent)
                    && is_string($session->payment_intent)
                ) {
                    $paymentIntentId = $session->payment_intent;
                }

                $order = app(CompleteOrder::class)->execute(
                    $order,
                    $session->id,
                    $paymentIntentId,
                );

                /*
                |--------------------------------------------------------------------------
                | Coupon belongs to browser session, not Stripe webhook
                |--------------------------------------------------------------------------
                */

                $request->session()->forget('cart_coupon');

                Log::info(
                    'Order completed from checkout success fallback.',
                    [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'stripe_session_id' => $session->id,
                    ],
                );

                return view(
                    'frontend.pages.shop.checkout-success',
                    [
                        'order' => $order->load('items'),
                        'paymentConfirmed' => true,
                    ],
                );
            }

            Log::info(
                'Stripe payment is not confirmed yet.',
                [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'stripe_session_id' => $session->id,
                    'payment_status' => $paymentStatus,
                ],
            );
        } catch (Throwable $exception) {
            Log::error(
                'Checkout success payment verification failed.',
                [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'stripe_session_id' => $sessionId,
                    'message' => $exception->getMessage(),
                ],
            );
        }

        return view(
            'frontend.pages.shop.checkout-success',
            [
                'order' => $order->load('items'),
                'paymentConfirmed' => $order->isPaid(),
            ],
        );
    }

    /**
     * Save a new shipping address.
     */
    private function saveAddress(
        int $userId,
        array $checkoutData,
    ): UserAddress {
        $hasDefaultAddress = UserAddress::query()
            ->where('user_id', $userId)
            ->where('is_default', true)
            ->exists();

        return UserAddress::query()->create([
            'user_id' => $userId,

            'label' => trim(
                (string) (
                    $checkoutData['address_label']
                    ?? 'Home'
                ),
            ),

            'first_name' => trim(
                (string) $checkoutData['first_name'],
            ),

            'last_name' => trim(
                (string) $checkoutData['last_name'],
            ),

            'phone' => trim(
                (string) $checkoutData['phone'],
            ),

            'country' => strtoupper(
                trim(
                    (string) $checkoutData['country'],
                ),
            ),

            'address' => trim(
                (string) $checkoutData['address'],
            ),

            'apartment' => isset($checkoutData['apartment'])
                ? trim(
                    (string) $checkoutData['apartment'],
                )
                : null,

            'city' => trim(
                (string) $checkoutData['city'],
            ),

            'state' => isset($checkoutData['state'])
                ? trim(
                    (string) $checkoutData['state'],
                )
                : null,

            'postal_code' => trim(
                (string) $checkoutData['postal_code'],
            ),

            'is_default' => !$hasDefaultAddress,
        ]);
    }
}
