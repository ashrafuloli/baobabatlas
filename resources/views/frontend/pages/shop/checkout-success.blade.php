@extends('frontend.layouts.frontend')

@section('title', 'Order Confirmation')

@section('contents')

    @php
        /*
        |--------------------------------------------------------------------------
        | Order Totals
        |--------------------------------------------------------------------------
        */

        $orderSubtotal = (float) $order->subtotal;
        $orderDiscount = (float) $order->discount;
        $orderShipping = (float) $order->shipping;
        $orderTax = (float) $order->tax;
        $orderTotal = (float) $order->total;

        /*
        |--------------------------------------------------------------------------
        | Order Item Quantity
        |--------------------------------------------------------------------------
        */

        $totalItemQuantity = $order->items->sum('quantity');
    @endphp

    <div class="checkout-success-page">

        <div class="checkout-success-page__container">


            {{-- =========================================================
                SUCCESS / PENDING STATUS
            ========================================================== --}}
            <div
                class="checkout-success-page__status"
                data-payment-status="{{ $paymentConfirmed ? 'confirmed' : 'pending' }}"
            >

                @if($paymentConfirmed)

                    <div class="checkout-success-page__icon checkout-success-page__icon--success">

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                d="M20 6 9 17l-5-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </div>

                @else

                    <div class="checkout-success-page__icon checkout-success-page__icon--pending">

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            />

                            <path
                                d="M12 7v5l3 2"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </div>

                @endif


                <span class="checkout-success-page__status-badge">

                    @if($paymentConfirmed)
                        Payment Confirmed
                    @else
                        Payment Processing
                    @endif

                </span>

            </div>


            {{-- =========================================================
                HEADING
            ========================================================== --}}
            <div class="checkout-success-page__heading">

                @if($paymentConfirmed)

                    <h1>
                        Thank You For Your Order!
                    </h1>

                    <p>
                        Your order has been successfully placed and your payment
                        has been confirmed.
                    </p>

                @else

                    <h1>
                        We’re Confirming Your Payment
                    </h1>

                    <p>
                        Your order has been received. We’re waiting for Stripe to
                        confirm your payment. This page will update automatically.
                    </p>

                @endif

            </div>


            {{-- =========================================================
                ORDER NUMBER
            ========================================================== --}}
            <div class="checkout-success-page__order-number">

                <span>
                    Order Number
                </span>

                <strong>
                    {{ $order->order_number }}
                </strong>

                <button
                    type="button"
                    class="checkout-success-page__copy"
                    data-copy-order
                    aria-label="Copy order number"
                >

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <rect
                            x="9"
                            y="9"
                            width="11"
                            height="11"
                            rx="2"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        />

                        <path
                            d="M6 15H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v1"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>

                    <span>
                        Copy
                    </span>

                </button>

            </div>


            {{-- =========================================================
                ORDER CONTENT
            ========================================================== --}}
            <div class="checkout-success-page__content">


                {{-- =====================================================
                    ORDER SUMMARY
                ====================================================== --}}
                <div class="checkout-success-page__card checkout-success-page__card--order">

                    <div class="checkout-success-page__card-header">

                        <div>

                            <span class="checkout-success-page__eyebrow">
                                Order Summary
                            </span>

                            <h2>
                                Your Items
                            </h2>

                        </div>


                        <span class="checkout-success-page__item-count">

                            {{ $totalItemQuantity }}

                            {{ $totalItemQuantity === 1 ? 'item' : 'items' }}

                        </span>

                    </div>


                    {{-- =================================================
                        ORDER ITEMS
                    ================================================== --}}
                    <div class="checkout-success-page__items">

                        @foreach($order->items as $item)

                            @php
                                /*
                                |--------------------------------------------------------------------------
                                | Item Shipping Cost
                                |--------------------------------------------------------------------------
                                |
                                | This is the shipping cost snapshot saved
                                | on the order item.
                                |
                                | It is NOT multiplied by quantity.
                                |
                                */

                                $itemShippingCost = (float) (
                                    $item->shipping_cost ?? 0
                                );

                                /*
                                |--------------------------------------------------------------------------
                                | Item Unit Price
                                |--------------------------------------------------------------------------
                                */

                                $itemUnitPrice = (float) $item->unit_price;

                                /*
                                |--------------------------------------------------------------------------
                                | Item Line Total
                                |--------------------------------------------------------------------------
                                */

                                $itemLineTotal = (float) $item->line_total;
                            @endphp


                            <div
                                class="checkout-success-page__item"
                                data-order-item="{{ $item->id }}"
                                data-shipping-cost="{{ $itemShippingCost }}"
                            >


                                {{-- =================================================
                                    ITEM IMAGE
                                ================================================== --}}
                                <div class="checkout-success-page__item-image">

                                    @if($item->image)

                                        <img
                                            src="{{ asset($item->image) }}"
                                            alt="{{ $item->product_name }}"
                                        >

                                    @else

                                        <span>

                                            <svg
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >

                                                <rect
                                                    x="3"
                                                    y="4"
                                                    width="18"
                                                    height="16"
                                                    rx="2"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />

                                                <circle
                                                    cx="8"
                                                    cy="9"
                                                    r="1.5"
                                                    fill="currentColor"
                                                />

                                                <path
                                                    d="m4 17 5-5 4 4 2-2 5 5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                />

                                            </svg>

                                        </span>

                                    @endif

                                </div>


                                {{-- =================================================
                                    ITEM INFO
                                ================================================== --}}
                                <div class="checkout-success-page__item-info">

                                    <h3>
                                        {{ $item->product_name }}
                                    </h3>


                                    @if($item->sku)

                                        <span class="checkout-success-page__item-sku">
                                            SKU: {{ $item->sku }}
                                        </span>

                                    @endif


                                    <span class="checkout-success-page__item-quantity">
                                        Qty: {{ $item->quantity }}
                                    </span>


                                    {{-- =================================================
                                        ITEM SHIPPING
                                    ================================================== --}}
                                    @if($itemShippingCost > 0)

                                        <span class="checkout-success-page__item-shipping">

                                            <svg
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    d="M3 7h11v10H3z"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                    stroke-linejoin="round"
                                                />

                                                <path
                                                    d="M14 10h4l3 3v4h-7z"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                    stroke-linejoin="round"
                                                />

                                                <circle
                                                    cx="7"
                                                    cy="18"
                                                    r="1.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                />

                                                <circle
                                                    cx="18"
                                                    cy="18"
                                                    r="1.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                />
                                            </svg>

                                            <span>
                                                Shipping:
                                            </span>

                                            <strong>
                                                ${{ number_format($itemShippingCost, 2) }}
                                            </strong>

                                        </span>

                                    @else

                                        <span class="checkout-success-page__item-shipping checkout-success-page__item-shipping--free">

                                            <svg
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    d="M20 6 9 17l-5-5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                />
                                            </svg>

                                            <span>
                                                Free Shipping
                                            </span>

                                        </span>

                                    @endif

                                </div>


                                {{-- =================================================
                                    ITEM PRICE
                                ================================================== --}}
                                <div class="checkout-success-page__item-price">

                                    <strong>
                                        ${{ number_format($itemLineTotal, 2) }}
                                    </strong>


                                    @if($item->quantity > 1)

                                        <span>
                                            ${{ number_format($itemUnitPrice, 2) }}
                                            each
                                        </span>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>


                    {{-- =================================================
                        TOTALS
                    ================================================== --}}
                    <div class="checkout-success-page__totals">


                        {{-- Subtotal --}}
                        <div class="checkout-success-page__total-row">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                ${{ number_format($orderSubtotal, 2) }}
                            </strong>

                        </div>


                        {{-- Discount --}}
                        @if($orderDiscount > 0)

                            <div class="checkout-success-page__total-row checkout-success-page__total-row--discount">

                                <span>
                                    Discount
                                </span>

                                <strong>
                                    -${{ number_format($orderDiscount, 2) }}
                                </strong>

                            </div>

                        @endif


                        {{-- =================================================
                            SHIPPING
                        ================================================== --}}
                        <div class="checkout-success-page__total-row">

                            <span>
                                Shipping
                            </span>

                            <strong>

                                @if($orderShipping > 0)

                                    ${{ number_format($orderShipping, 2) }}

                                @else

                                    Free

                                @endif

                            </strong>

                        </div>


                        {{-- Tax --}}
                        @if($orderTax > 0)

                            <div class="checkout-success-page__total-row">

                                <span>
                                    Tax
                                </span>

                                <strong>
                                    ${{ number_format($orderTax, 2) }}
                                </strong>

                            </div>

                        @endif


                        {{-- Grand Total --}}
                        <div class="checkout-success-page__total-row checkout-success-page__total-row--grand">

                            <span>
                                Total
                            </span>

                            <strong>
                                ${{ number_format($orderTotal, 2) }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    SIDE CONTENT
                ====================================================== --}}
                <div class="checkout-success-page__side">


                    {{-- =================================================
                        PAYMENT STATUS
                    ================================================== --}}
                    <div class="checkout-success-page__card">

                        <div class="checkout-success-page__card-header">

                            <div>

                                <span class="checkout-success-page__eyebrow">
                                    Payment
                                </span>

                                <h2>
                                    Status
                                </h2>

                            </div>

                        </div>


                        <div
                            class="
                                checkout-success-page__payment-status
                                {{ $paymentConfirmed
                                    ? 'checkout-success-page__payment-status--confirmed'
                                    : 'checkout-success-page__payment-status--pending'
                                }}
                            "
                        >

                            <span class="checkout-success-page__payment-status-icon">

                                @if($paymentConfirmed)

                                    <svg
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >

                                        <path
                                            d="M20 6 9 17l-5-5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />

                                    </svg>

                                @else

                                    <svg
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        />

                                        <path
                                            d="M12 7v5l3 2"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                        />

                                    </svg>

                                @endif

                            </span>


                            <div>

                                <strong>

                                    @if($paymentConfirmed)
                                        Payment Confirmed
                                    @else
                                        Payment Processing
                                    @endif

                                </strong>


                                <span>

                                    @if($paymentConfirmed)

                                        Your payment has been successfully received.

                                    @else

                                        We are waiting for payment confirmation.

                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        SHIPPING INFORMATION
                    ================================================== --}}
                    <div class="checkout-success-page__card">

                        <div class="checkout-success-page__card-header">

                            <div>

                                <span class="checkout-success-page__eyebrow">
                                    Delivery
                                </span>

                                <h2>
                                    Shipping Address
                                </h2>

                            </div>

                        </div>


                        <address class="checkout-success-page__address">

                            <strong>
                                {{ $order->first_name }}
                                {{ $order->last_name }}
                            </strong>


                            <span>
                                {{ $order->address }}
                            </span>


                            @if($order->apartment)

                                <span>
                                    {{ $order->apartment }}
                                </span>

                            @endif


                            <span>

                                {{ $order->city }}

                                @if($order->state)
                                    , {{ $order->state }}
                                @endif

                                {{ $order->postal_code }}

                            </span>


                            <span>
                                {{ $order->country }}
                            </span>


                            <span>
                                {{ $order->phone }}
                            </span>

                        </address>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                ACTIONS
            ========================================================== --}}
            <div class="checkout-success-page__actions">

                <a
                    href="{{ route('shop') }}"
                    class="checkout-success-page__button checkout-success-page__button--primary"
                >

                    Continue Shopping

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M5 12h14M13 6l6 6-6 6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                    </svg>

                </a>


                <a
                    href="{{ route('my-orders') }}"
                    class="checkout-success-page__button checkout-success-page__button--secondary"
                >
                    View My Orders
                </a>

            </div>


            {{-- =========================================================
                PENDING NOTICE
            ========================================================== --}}
            @unless($paymentConfirmed)

                <div
                    class="checkout-success-page__pending-notice"
                    data-payment-pending
                >

                    <span class="checkout-success-page__pending-spinner"></span>


                    <div>

                        <strong>
                            Payment confirmation in progress
                        </strong>

                        <p>
                            Please keep this page open for a moment while we
                            confirm your payment.
                        </p>

                    </div>

                </div>

            @endunless

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener(
            "DOMContentLoaded",
            function () {

                const page =
                    document.querySelector(
                        ".checkout-success-page"
                    );


                if (!page) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Copy Order Number
                |--------------------------------------------------------------------------
                */

                const copyButton =
                    page.querySelector(
                        "[data-copy-order]"
                    );

                const orderNumberElement =
                    page.querySelector(
                        ".checkout-success-page__order-number strong"
                    );


                if (
                    !copyButton ||
                    !orderNumberElement
                ) {
                    return;
                }


                copyButton.addEventListener(
                    "click",
                    async function () {

                        const orderNumber =
                            orderNumberElement
                                .textContent
                                .trim();


                        if (!orderNumber) {
                            return;
                        }


                        try {

                            await navigator.clipboard.writeText(
                                orderNumber
                            );


                            const label =
                                copyButton.querySelector(
                                    "span"
                                );


                            if (label) {

                                const originalText =
                                    label.textContent;

                                label.textContent =
                                    "Copied";


                                window.setTimeout(
                                    function () {

                                        label.textContent =
                                            originalText;

                                    },
                                    1800
                                );

                            }


                            if (
                                window.AppToast &&
                                typeof window.AppToast.fire ===
                                "function"
                            ) {

                                window.AppToast.fire({
                                    icon: "success",
                                    title: "Order number copied.",
                                });

                            }

                        } catch (error) {

                            /*
                            |--------------------------------------------------------------------------
                            | Clipboard Fallback
                            |--------------------------------------------------------------------------
                            */

                            const temporaryInput =
                                document.createElement(
                                    "input"
                                );


                            temporaryInput.value =
                                orderNumber;


                            temporaryInput.setAttribute(
                                "readonly",
                                ""
                            );


                            temporaryInput.style.position =
                                "fixed";

                            temporaryInput.style.opacity =
                                "0";


                            document.body.appendChild(
                                temporaryInput
                            );


                            temporaryInput.select();


                            try {

                                document.execCommand(
                                    "copy"
                                );


                                const label =
                                    copyButton.querySelector(
                                        "span"
                                    );


                                if (label) {

                                    const originalText =
                                        label.textContent;

                                    label.textContent =
                                        "Copied";


                                    window.setTimeout(
                                        function () {

                                            label.textContent =
                                                originalText;

                                        },
                                        1800
                                    );

                                }


                                if (
                                    window.AppToast &&
                                    typeof window.AppToast.fire ===
                                    "function"
                                ) {

                                    window.AppToast.fire({
                                        icon: "success",
                                        title: "Order number copied.",
                                    });

                                }

                            } catch (fallbackError) {

                                console.error(
                                    "Unable to copy order number.",
                                    fallbackError
                                );

                            } finally {

                                temporaryInput.remove();

                            }

                        }

                    }
                );

            }
        );
    </script>

@endpush
