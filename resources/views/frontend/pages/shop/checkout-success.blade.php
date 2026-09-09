@extends('frontend.layouts.frontend')

@section('title', 'Order Confirmation')

@section('contents')

    <div class="checkout-success-page">
        <div class="checkout-success-page__container">

            {{-- Success / Pending Icon --}}
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

            {{-- Heading --}}
            <div class="checkout-success-page__heading">
                @if($paymentConfirmed)
                    <h1>Thank You For Your Order!</h1>

                    <p>
                        Your order has been successfully placed and your payment
                        has been confirmed.
                    </p>
                @else
                    <h1>We’re Confirming Your Payment</h1>

                    <p>
                        Your order has been received. We’re waiting for Stripe to
                        confirm your payment. This page will update automatically.
                    </p>
                @endif
            </div>

            {{-- Order Number --}}
            <div class="checkout-success-page__order-number">
                <span>Order Number</span>

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

                    <span>Copy</span>
                </button>
            </div>

            {{-- Order Content --}}
            <div class="checkout-success-page__content">

                {{-- Order Summary --}}
                <div class="checkout-success-page__card checkout-success-page__card--order">
                    <div class="checkout-success-page__card-header">
                        <div>
                        <span class="checkout-success-page__eyebrow">
                            Order Summary
                        </span>

                            <h2>Your Items</h2>
                        </div>

                        <span class="checkout-success-page__item-count">
                        {{ $order->items->sum('quantity') }}
                            {{ $order->items->sum('quantity') === 1 ? 'item' : 'items' }}
                    </span>
                    </div>

                    <div class="checkout-success-page__items">
                        @foreach($order->items as $item)
                            <div class="checkout-success-page__item">
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
                                </div>

                                <div class="checkout-success-page__item-price">
                                    <strong>
                                        ${{ number_format((float) $item->line_total, 2) }}
                                    </strong>

                                    @if($item->quantity > 1)
                                        <span>
                                        ${{ number_format((float) $item->unit_price, 2) }}
                                        each
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="checkout-success-page__totals">
                        <div class="checkout-success-page__total-row">
                            <span>Subtotal</span>
                            <strong>
                                ${{ number_format((float) $order->subtotal, 2) }}
                            </strong>
                        </div>

                        @if((float) $order->discount > 0)
                            <div class="checkout-success-page__total-row checkout-success-page__total-row--discount">
                                <span>Discount</span>
                                <strong>
                                    -${{ number_format((float) $order->discount, 2) }}
                                </strong>
                            </div>
                        @endif

                        @if((float) $order->shipping > 0)
                            <div class="checkout-success-page__total-row">
                                <span>Shipping</span>
                                <strong>
                                    ${{ number_format((float) $order->shipping, 2) }}
                                </strong>
                            </div>
                        @endif

                        @if((float) $order->tax > 0)
                            <div class="checkout-success-page__total-row">
                                <span>Tax</span>
                                <strong>
                                    ${{ number_format((float) $order->tax, 2) }}
                                </strong>
                            </div>
                        @endif

                        <div class="checkout-success-page__total-row checkout-success-page__total-row--grand">
                            <span>Total</span>

                            <strong>
                                ${{ number_format((float) $order->total, 2) }}
                            </strong>
                        </div>
                    </div>
                </div>

                {{-- Order Details --}}
                <div class="checkout-success-page__side">

                    {{-- Payment Status --}}
                    <div class="checkout-success-page__card">
                        <div class="checkout-success-page__card-header">
                            <div>
                            <span class="checkout-success-page__eyebrow">
                                Payment
                            </span>

                                <h2>Status</h2>
                            </div>
                        </div>

                        <div
                            class="checkout-success-page__payment-status
                        {{ $paymentConfirmed
                            ? 'checkout-success-page__payment-status--confirmed'
                            : 'checkout-success-page__payment-status--pending' }}"
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

                    {{-- Shipping Information --}}
                    <div class="checkout-success-page__card">
                        <div class="checkout-success-page__card-header">
                            <div>
                            <span class="checkout-success-page__eyebrow">
                                Delivery
                            </span>

                                <h2>Shipping Address</h2>
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

            {{-- Actions --}}
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

            {{-- Pending Notice --}}
            @unless($paymentConfirmed)
                <div
                    class="checkout-success-page__pending-notice"
                    data-payment-pending
                >
                    <span class="checkout-success-page__pending-spinner"></span>

                    <div>
                        <strong>Payment confirmation in progress</strong>

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
        document.addEventListener("DOMContentLoaded", function () {
            const page = document.querySelector(".checkout-success-page");

            if (!page) {
                return;
            }

            const copyButton = page.querySelector("[data-copy-order]");
            const orderNumberElement = page.querySelector(
                ".checkout-success-page__order-number strong"
            );

            /*
            |--------------------------------------------------------------------------
            | Copy Order Number
            |--------------------------------------------------------------------------
            */

            if (copyButton && orderNumberElement) {
                copyButton.addEventListener("click", async function () {
                    const orderNumber = orderNumberElement.textContent.trim();

                    if (!orderNumber) {
                        return;
                    }

                    try {
                        await navigator.clipboard.writeText(orderNumber);

                        const label = copyButton.querySelector("span");

                        if (label) {
                            const originalText = label.textContent;

                            label.textContent = "Copied";

                            window.setTimeout(function () {
                                label.textContent = originalText;
                            }, 1800);
                        }

                        if (
                            window.AppToast &&
                            typeof window.AppToast.fire === "function"
                        ) {
                            window.AppToast.fire({
                                icon: "success",
                                title: "Order number copied.",
                            });
                        }
                    } catch (error) {
                        console.error(
                            "Unable to copy order number.",
                            error
                        );
                    }
                });
            }
        });
    </script>
@endpush
