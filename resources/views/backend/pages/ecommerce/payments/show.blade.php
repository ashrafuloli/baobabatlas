@extends('backend.layouts.backend')

@section('title', 'Payment Details')

@section('content')
    <div class="ecommerce-payment-show-page">
        @php
            $customerName = trim(
                $order->first_name . ' ' . $order->last_name
            );

            $paymentStatusClass = match ($order->payment_status) {
                \App\Models\Order::PAYMENT_STATUS_PAID => 'paid',
                \App\Models\Order::PAYMENT_STATUS_FAILED => 'failed',
                default => 'pending',
            };

            $refundStatusClass = match ($order->refund_status) {
                \App\Models\Order::REFUND_STATUS_PENDING => 'pending',
                \App\Models\Order::REFUND_STATUS_APPROVED => 'approved',
                \App\Models\Order::REFUND_STATUS_REJECTED => 'rejected',
                \App\Models\Order::REFUND_STATUS_REFUNDED => 'refunded',
                default => 'none',
            };

            $successfulRefunds = $order->refunds->filter(
                fn ($refund): bool =>
                    $refund->status === \App\Models\Refund::STATUS_SUCCEEDED
            );

            $totalRefunded = (float) $successfulRefunds->sum(
                fn ($refund): float => (float) $refund->amount
            );
        @endphp

        <div class="ecommerce-payment-show-page__header">
            <div class="ecommerce-payment-show-page__heading">
                <div class="ecommerce-payment-show-page__breadcrumb">
                    <a href="{{ route('admin-ecommerce-payments') }}">
                        Payments
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>
                        #{{ $order->order_number }}
                    </span>
                </div>

                <div class="ecommerce-payment-show-page__title-row">
                    <div>
                        <h1 class="ecommerce-payment-show-page__title">
                            Payment #{{ $order->order_number }}
                        </h1>

                        <p class="ecommerce-payment-show-page__subtitle">
                            Payment and transaction details for this order.
                        </p>
                    </div>

                    <span
                        class="ecommerce-payment-show-page__payment-status ecommerce-payment-show-page__payment-status--{{ $paymentStatusClass }}"
                    >
                        <i class="fa-solid fa-circle"></i>

                        @if ($order->payment_status === \App\Models\Order::PAYMENT_STATUS_PAID)
                            Paid
                        @elseif ($order->payment_status === \App\Models\Order::PAYMENT_STATUS_FAILED)
                            Failed
                        @else
                            Pending
                        @endif
                    </span>
                </div>
            </div>

            <a
                href="{{ route('admin-ecommerce-payments') }}"
                class="ecommerce-payment-show-page__back"
            >
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Payments</span>
            </a>
        </div>

        <div class="ecommerce-payment-show-page__layout">
            <div class="ecommerce-payment-show-page__main">
                {{-- Payment Summary --}}
                <section class="ecommerce-payment-show-page__card">
                    <div class="ecommerce-payment-show-page__card-header">
                        <div>
                            <h2>Payment Summary</h2>
                            <p>Current payment information for this order.</p>
                        </div>
                    </div>

                    <div class="ecommerce-payment-show-page__summary">
                        <div class="ecommerce-payment-show-page__summary-item">
                            <span>Order Number</span>

                            <strong>
                                #{{ $order->order_number }}
                            </strong>
                        </div>

                        <div class="ecommerce-payment-show-page__summary-item">
                            <span>Amount</span>

                            <strong>
                                {{ strtoupper($order->currency) }}
                                {{ number_format((float) $order->total, 2) }}
                            </strong>
                        </div>

                        <div class="ecommerce-payment-show-page__summary-item">
                            <span>Gateway</span>

                            <strong>
                                {{ $order->payment_gateway ?: '—' }}
                            </strong>
                        </div>

                        <div class="ecommerce-payment-show-page__summary-item">
                            <span>Payment Status</span>

                            <span
                                class="ecommerce-payment-show-page__status ecommerce-payment-show-page__status--{{ $paymentStatusClass }}"
                            >
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>

                        <div class="ecommerce-payment-show-page__summary-item">
                            <span>Paid At</span>

                            <strong>
                                {{ $order->paid_at?->format('M d, Y h:i A') ?: 'Not paid yet' }}
                            </strong>
                        </div>

                        <div class="ecommerce-payment-show-page__summary-item">
                            <span>Order Created</span>

                            <strong>
                                {{ $order->created_at?->format('M d, Y h:i A') }}
                            </strong>
                        </div>
                    </div>
                </section>

                {{-- Stripe Information --}}
                <section class="ecommerce-payment-show-page__card">
                    <div class="ecommerce-payment-show-page__card-header">
                        <div>
                            <h2>Transaction Information</h2>
                            <p>Gateway and transaction identifiers.</p>
                        </div>
                    </div>

                    <div class="ecommerce-payment-show-page__transaction-list">
                        <div class="ecommerce-payment-show-page__transaction-item">
                            <div class="ecommerce-payment-show-page__transaction-label">
                                <span>Payment Intent</span>

                                <small>
                                    Stripe payment intent identifier
                                </small>
                            </div>

                            @if ($order->stripe_payment_intent_id)
                                <button
                                    type="button"
                                    class="ecommerce-payment-show-page__copy"
                                    data-copy-value="{{ $order->stripe_payment_intent_id }}"
                                >
                                    <span>
                                        {{ $order->stripe_payment_intent_id }}
                                    </span>

                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            @else
                                <span class="ecommerce-payment-show-page__muted">
                                    Not available
                                </span>
                            @endif
                        </div>

                        <div class="ecommerce-payment-show-page__transaction-item">
                            <div class="ecommerce-payment-show-page__transaction-label">
                                <span>Checkout Session</span>

                                <small>
                                    Stripe checkout session identifier
                                </small>
                            </div>

                            @if ($order->stripe_checkout_session_id)
                                <button
                                    type="button"
                                    class="ecommerce-payment-show-page__copy"
                                    data-copy-value="{{ $order->stripe_checkout_session_id }}"
                                >
                                    <span>
                                        {{ $order->stripe_checkout_session_id }}
                                    </span>

                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            @else
                                <span class="ecommerce-payment-show-page__muted">
                                    Not available
                                </span>
                            @endif
                        </div>

                        <div class="ecommerce-payment-show-page__transaction-item">
                            <div class="ecommerce-payment-show-page__transaction-label">
                                <span>Currency</span>
                            </div>

                            <strong>
                                {{ strtoupper($order->currency) }}
                            </strong>
                        </div>

                        <div class="ecommerce-payment-show-page__transaction-item">
                            <div class="ecommerce-payment-show-page__transaction-label">
                                <span>Gateway</span>
                            </div>

                            <strong>
                                {{ $order->payment_gateway ?: '—' }}
                            </strong>
                        </div>
                    </div>
                </section>

                {{-- Order Items --}}
                <section class="ecommerce-payment-show-page__card">
                    <div class="ecommerce-payment-show-page__card-header">
                        <div>
                            <h2>Order Items</h2>

                            <p>
                                Products included in this payment.
                            </p>
                        </div>

                        <span class="ecommerce-payment-show-page__item-count">
                            {{ $order->items->count() }}
                            {{ Str::plural('item', $order->items->count()) }}
                        </span>
                    </div>

                    <div class="ecommerce-payment-show-page__items">
                        @foreach ($order->items as $item)
                            <div class="ecommerce-payment-show-page__item">
                                <div class="ecommerce-payment-show-page__item-image">
                                    @if ($item->image)
                                        <img
                                            src="{{ asset($item->image) }}"
                                            alt="{{ $item->product_name }}"
                                        >
                                    @else
                                        <i class="fa-solid fa-box"></i>
                                    @endif
                                </div>

                                <div class="ecommerce-payment-show-page__item-info">
                                    <strong>
                                        {{ $item->product_name }}
                                    </strong>

                                    <span>
                                        SKU:
                                        {{ $item->sku ?: '—' }}
                                    </span>

                                    @if ($item->variant)
                                        <span>
                                            Variant:
                                            {{ $item->variant->sku ?: '—' }}
                                        </span>
                                    @endif
                                </div>

                                <div class="ecommerce-payment-show-page__item-quantity">
                                    <span>Qty</span>
                                    <strong>
                                        {{ $item->quantity }}
                                    </strong>
                                </div>

                                <div class="ecommerce-payment-show-page__item-price">
                                    <span>
                                        {{ strtoupper($order->currency) }}
                                        {{ number_format((float) $item->unit_price, 2) }}
                                        × {{ $item->quantity }}
                                    </span>

                                    <strong>
                                        {{ strtoupper($order->currency) }}
                                        {{ number_format((float) $item->line_total, 2) }}
                                    </strong>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="ecommerce-payment-show-page__totals">
                        <div>
                            <span>Subtotal</span>

                            <strong>
                                {{ strtoupper($order->currency) }}
                                {{ number_format((float) $order->subtotal, 2) }}
                            </strong>
                        </div>

                        <div>
                            <span>Discount</span>

                            <strong>
                                -{{ strtoupper($order->currency) }}
                                {{ number_format((float) $order->discount, 2) }}
                            </strong>
                        </div>

                        <div>
                            <span>Shipping</span>

                            <strong>
                                {{ strtoupper($order->currency) }}
                                {{ number_format((float) $order->shipping, 2) }}
                            </strong>
                        </div>

                        <div>
                            <span>Tax</span>

                            <strong>
                                {{ strtoupper($order->currency) }}
                                {{ number_format((float) $order->tax, 2) }}
                            </strong>
                        </div>

                        <div class="ecommerce-payment-show-page__totals-total">
                            <span>Total</span>

                            <strong>
                                {{ strtoupper($order->currency) }}
                                {{ number_format((float) $order->total, 2) }}
                            </strong>
                        </div>
                    </div>
                </section>

                {{-- Refund Information --}}
                <section class="ecommerce-payment-show-page__card">
                    <div class="ecommerce-payment-show-page__card-header">
                        <div>
                            <h2>Refund Information</h2>

                            <p>
                                Refund status and processed refund details.
                            </p>
                        </div>

                        <span
                            class="ecommerce-payment-show-page__status ecommerce-payment-show-page__status--refund-{{ $refundStatusClass }}"
                        >
                            {{ match ($order->refund_status) {
                                \App\Models\Order::REFUND_STATUS_PENDING => 'Pending',
                                \App\Models\Order::REFUND_STATUS_APPROVED => 'Approved',
                                \App\Models\Order::REFUND_STATUS_REJECTED => 'Rejected',
                                \App\Models\Order::REFUND_STATUS_REFUNDED => 'Refunded',
                                default => 'No Refund',
                            } }}
                        </span>
                    </div>

                    <div class="ecommerce-payment-show-page__refund-summary">
                        <div>
                            <span>Order Total</span>

                            <strong>
                                {{ strtoupper($order->currency) }}
                                {{ number_format((float) $order->total, 2) }}
                            </strong>
                        </div>

                        <div>
                            <span>Total Refunded</span>

                            <strong>
                                {{ strtoupper($order->currency) }}
                                {{ number_format($totalRefunded, 2) }}
                            </strong>
                        </div>

                        <div>
                            <span>Refund Records</span>

                            <strong>
                                {{ $order->refunds->count() }}
                            </strong>
                        </div>
                    </div>

                    @if ($order->refunds->isNotEmpty())
                        <div class="ecommerce-payment-show-page__refund-list">
                            @foreach ($order->refunds as $refund)
                                <div class="ecommerce-payment-show-page__refund-item">
                                    <div>
                                        <strong>
                                            {{ strtoupper($refund->currency ?: $order->currency) }}
                                            {{ number_format((float) $refund->amount, 2) }}
                                        </strong>

                                        <span>
                                            {{ $refund->created_at?->format('M d, Y h:i A') }}
                                        </span>
                                    </div>

                                    <div>
                                        <span
                                            class="ecommerce-payment-show-page__refund-record-status ecommerce-payment-show-page__refund-record-status--{{ $refund->status }}"
                                        >
                                            {{ ucfirst($refund->status) }}
                                        </span>

                                        @if ($refund->stripe_refund_id)
                                            <button
                                                type="button"
                                                class="ecommerce-payment-show-page__copy"
                                                data-copy-value="{{ $refund->stripe_refund_id }}"
                                                title="Copy refund ID"
                                            >
                                                <span>
                                                    {{ \Illuminate\Support\Str::limit(
                                                        $refund->stripe_refund_id,
                                                        22,
                                                        '...'
                                                    ) }}
                                                </span>

                                                <i class="fa-regular fa-copy"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($order->refundRequests->isNotEmpty())
                        <div class="ecommerce-payment-show-page__refund-requests">
                            <div class="ecommerce-payment-show-page__section-label">
                                Refund Requests
                            </div>

                            @foreach ($order->refundRequests as $refundRequest)
                                <a
                                    href="{{ route('admin-ecommerce-payment-refund-request-show', [
                                        'refundRequest' => $refundRequest,
                                    ]) }}"
                                    class="ecommerce-payment-show-page__refund-request"
                                >
                                    <div>
                                        <strong>
                                            {{ strtoupper($order->currency) }}
                                            {{ number_format(
                                                $refundRequest->finalRefundAmount(),
                                                2
                                            ) }}
                                        </strong>

                                        <span>
                                            {{ $refundRequest->reason }}
                                        </span>
                                    </div>

                                    <div>
                                        <span
                                            class="ecommerce-payment-show-page__request-status ecommerce-payment-show-page__request-status--{{ $refundRequest->status }}"
                                        >
                                            {{ ucfirst($refundRequest->status) }}
                                        </span>

                                        <i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>

            <aside class="ecommerce-payment-show-page__sidebar">
                {{-- Customer --}}
                <section class="ecommerce-payment-show-page__card">
                    <div class="ecommerce-payment-show-page__card-header">
                        <div>
                            <h2>Customer</h2>
                        </div>
                    </div>

                    <div class="ecommerce-payment-show-page__customer">
                        <div class="ecommerce-payment-show-page__customer-avatar">
                            {{ strtoupper(
                                mb_substr(
                                    $customerName ?: $order->email ?: 'C',
                                    0,
                                    1
                                )
                            ) }}
                        </div>

                        <div class="ecommerce-payment-show-page__customer-name">
                            <strong>
                                {{ $customerName ?: 'Customer' }}
                            </strong>

                            <span>
                                {{ $order->email }}
                            </span>
                        </div>
                    </div>

                    <div class="ecommerce-payment-show-page__customer-details">
                        @if ($order->phone)
                            <div>
                                <i class="fa-solid fa-phone"></i>
                                <span>{{ $order->phone }}</span>
                            </div>
                        @endif

                        @if ($order->country)
                            <div>
                                <i class="fa-solid fa-location-dot"></i>
                                <span>
                                    {{ $order->city }},
                                    {{ $order->country }}
                                </span>
                            </div>
                        @endif
                    </div>
                </section>

                {{-- Billing / Address --}}
                <section class="ecommerce-payment-show-page__card">
                    <div class="ecommerce-payment-show-page__card-header">
                        <div>
                            <h2>Billing Details</h2>
                        </div>
                    </div>

                    <div class="ecommerce-payment-show-page__address">
                        <strong>
                            {{ $customerName ?: 'Customer' }}
                        </strong>

                        @if ($order->address)
                            <span>{{ $order->address }}</span>
                        @endif

                        @if ($order->apartment)
                            <span>{{ $order->apartment }}</span>
                        @endif

                        @if ($order->city || $order->state)
                            <span>
                                {{ $order->city }}
                                @if ($order->city && $order->state)
                                    ,
                                @endif
                                {{ $order->state }}
                            </span>
                        @endif

                        @if ($order->postal_code)
                            <span>{{ $order->postal_code }}</span>
                        @endif

                        @if ($order->country)
                            <span>{{ $order->country }}</span>
                        @endif
                    </div>
                </section>

                {{-- Order Information --}}
                <section class="ecommerce-payment-show-page__card">
                    <div class="ecommerce-payment-show-page__card-header">
                        <div>
                            <h2>Order Information</h2>
                        </div>
                    </div>

                    <div class="ecommerce-payment-show-page__meta-list">
                        <div>
                            <span>Order Status</span>

                            <strong>
                                {{ ucfirst($order->status) }}
                            </strong>
                        </div>

                        <div>
                            <span>Order Number</span>

                            <strong>
                                #{{ $order->order_number }}
                            </strong>
                        </div>

                        <div>
                            <span>Created</span>

                            <strong>
                                {{ $order->created_at?->format('M d, Y') }}
                            </strong>
                        </div>

                        <div>
                            <span>Updated</span>

                            <strong>
                                {{ $order->updated_at?->format('M d, Y') }}
                            </strong>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector(
                '.ecommerce-payment-show-page'
            );

            if (!page) {
                return;
            }

            const copyButtons = page.querySelectorAll(
                '[data-copy-value]'
            );

            copyButtons.forEach((button) => {
                button.addEventListener('click', async () => {
                    const value = button.dataset.copyValue;

                    if (!value) {
                        return;
                    }

                    try {
                        await navigator.clipboard.writeText(
                            value
                        );

                        const icon = button.querySelector('i');

                        if (icon) {
                            icon.classList.remove(
                                'fa-copy'
                            );

                            icon.classList.add(
                                'fa-check'
                            );
                        }

                        button.classList.add(
                            'is-copied'
                        );

                        window.setTimeout(() => {
                            if (icon) {
                                icon.classList.remove(
                                    'fa-check'
                                );

                                icon.classList.add(
                                    'fa-copy'
                                );
                            }

                            button.classList.remove(
                                'is-copied'
                            );
                        }, 1500);
                    } catch {
                        return;
                    }
                });
            });
        });
    </script>
@endpush
