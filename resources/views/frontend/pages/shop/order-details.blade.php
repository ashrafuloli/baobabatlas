@extends('frontend.layouts.frontend')

@section('title', 'Order Details')

@section('contents')

    @php
        $status = match ($order->status) {
            \App\Models\Order::STATUS_COMPLETED => 'completed',

            \App\Models\Order::STATUS_CANCELLED,
            \App\Models\Order::STATUS_FAILED => 'cancelled',

            \App\Models\Order::STATUS_PROCESSING,
            \App\Models\Order::STATUS_PAID => 'processing',

            default => 'pending',
        };

        $statusLabel = match ($status) {
            'completed' => 'Delivered',
            'processing' => 'Processing',
            'cancelled' => 'Cancelled',
            default => 'Pending',
        };

        $statusIcon = match ($status) {
            'completed' => 'ri-checkbox-circle-fill',
            'processing' => 'ri-loader-4-line',
            'cancelled' => 'ri-close-circle-line',
            default => 'ri-time-line',
        };


        /*
         * Payment
         */
        $canContinuePayment =
            $order->status === \App\Models\Order::STATUS_PENDING
            && $order->payment_status === \App\Models\Order::PAYMENT_STATUS_PENDING;


        /*
         * Cancel
         */
        $canCancelOrder =
            $order->status === \App\Models\Order::STATUS_PENDING
            && $order->payment_status === \App\Models\Order::PAYMENT_STATUS_PENDING;


        /*
         * Refund eligibility.
         *
         * Refund is available only for paid orders
         * that are paid, processing or completed.
         */
        $canRequestRefund =
            $order->payment_status === \App\Models\Order::PAYMENT_STATUS_PAID
            && in_array(
                $order->status,
                [
                    \App\Models\Order::STATUS_PAID,
                    \App\Models\Order::STATUS_PROCESSING,
                    \App\Models\Order::STATUS_COMPLETED,
                ],
                true,
            );


        /*
         * Full order refund.
         *
         * Shipping is non-refundable.
         */
        $refundAmount = max(
            0,
            round(
                (float) $order->total
                - (float) $order->shipping,
                2,
            ),
        );


        /*
         * Always use the latest refund request
         * for the visible customer-facing state.
         *
         * This prevents an old rejected request from
         * overriding a newer pending/approved request.
         */
        $latestRefundRequest = $order->refundRequests
            ->sortByDesc('created_at')
            ->first();

        $latestRefundStatus = $latestRefundRequest?->status;


        /*
         * Successful Stripe refund.
         *
         * This state always takes priority over
         * refund request status.
         */
        $hasSuccessfulRefund = $order->refunds->contains(
            fn ($refund): bool =>
                $refund->status
                === \App\Models\Refund::STATUS_SUCCEEDED
        );


        $isRefunded =
            $hasSuccessfulRefund
            || $order->payment_status
            === \App\Models\Order::PAYMENT_STATUS_REFUNDED;


        /*
         * Current refund request state.
         */
        $hasPendingRefundRequest =
            $latestRefundStatus
            === \App\Models\RefundRequest::STATUS_PENDING;

        $hasApprovedRefundRequest =
            $latestRefundStatus
            === \App\Models\RefundRequest::STATUS_APPROVED;

        $hasRejectedRefundRequest =
            $latestRefundStatus
            === \App\Models\RefundRequest::STATUS_REJECTED;


        /*
         * Customer can submit a new request when:
         *
         * - Order is refundable
         * - No successful refund exists
         * - Latest request is not pending
         * - Latest request is not approved
         *
         * Therefore a rejected request can be submitted again.
         */
        $canSubmitNewRefundRequest =
            $canRequestRefund
            && ! $isRefunded
            && ! $hasPendingRefundRequest
            && ! $hasApprovedRefundRequest;
    @endphp


    <div class="order-details-page">

        <div class="container">

            {{-- Breadcrumb --}}
            <div class="order-details-page__breadcrumb">

                <a href="{{ route('shop') }}">
                    Shop
                </a>

                <i class="ri-arrow-right-s-line"></i>

                <a href="{{ route('my-orders') }}">
                    My Orders
                </a>

                <i class="ri-arrow-right-s-line"></i>

                <span>
                    Order #{{ $order->order_number }}
                </span>

            </div>


            {{-- Header --}}
            <div class="order-details-page__header">

                <div class="order-details-page__header-content">

                    <a
                        href="{{ route('my-orders') }}"
                        class="order-details-page__back"
                    >
                        <i class="ri-arrow-left-line"></i>
                        Back to My Orders
                    </a>

                    <span class="order-details-page__eyebrow">
                        ORDER DETAILS
                    </span>

                    <h1 class="order-details-page__title">
                        Order #{{ $order->order_number }}
                    </h1>

                    <p class="order-details-page__subtitle">
                        Placed on {{ $order->created_at->format('F j, Y') }}
                    </p>

                </div>


                <span
                    class="order-details-page__status order-details-page__status--{{ $status }}"
                >
                    <i class="{{ $statusIcon }}"></i>
                    {{ $statusLabel }}
                </span>

            </div>


            {{-- Payment Actions --}}
            @if($canContinuePayment || $canCancelOrder)

                <section class="order-details-page__payment-actions">

                    <div class="order-details-page__payment-actions-content">

                        <div class="order-details-page__payment-actions-icon">
                            <i class="ri-bank-card-line"></i>
                        </div>

                        <div>

                            <span class="order-details-page__section-label">
                                PAYMENT REQUIRED
                            </span>

                            <h2>
                                Complete your payment
                            </h2>

                            <p>
                                Your order has been placed but payment is still
                                pending. Complete the payment to confirm your order.
                            </p>

                        </div>

                    </div>


                    <div class="order-details-page__payment-actions-buttons">

                        @if($canContinuePayment)

                            <a
                                href="{{ route('my-order.payment', $order) }}"
                                class="order-details-page__continue-payment"
                            >
                                <i class="ri-bank-card-line"></i>
                                Continue to Payment
                            </a>

                        @endif


                        @if($canCancelOrder)

                            <form
                                action="{{ route('my-order.cancel', $order) }}"
                                method="POST"
                                class="order-details-page__cancel-form"
                                data-cancel-order
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="order-details-page__cancel-order"
                                >
                                    <i class="ri-close-circle-line"></i>
                                    Cancel Order
                                </button>

                            </form>

                        @endif

                    </div>

                </section>

            @endif


            {{-- Main Grid --}}
            <div class="order-details-page__grid">

                {{-- Main --}}
                <div class="order-details-page__main">

                    {{-- Products --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    ORDER ITEMS
                                </span>

                                <h2>
                                    {{ $order->items->sum('quantity') }}
                                    {{ $order->items->sum('quantity') === 1 ? 'Item' : 'Items' }}
                                </h2>

                            </div>

                        </div>


                        <div class="order-details-page__items">

                            @foreach($order->items as $item)

                                @php
                                    $attributes = [];

                                    if ($item->variant?->values) {
                                        foreach ($item->variant->values as $value) {
                                            $attributeName = $value->attribute?->name;
                                            $valueName = $value->value ?? null;

                                            if ($attributeName && $valueName) {
                                                $attributes[] =
                                                    $attributeName . ': ' . $valueName;
                                            }
                                        }
                                    }

                                    $category = $item->product?->categories?->first()?->name;
                                @endphp

                                <div class="order-details-page__item">

                                    <div class="order-details-page__item-image">

                                        @if($item->image)

                                            <img
                                                src="{{ asset($item->image) }}"
                                                alt="{{ $item->product_name }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <span>
                                                No Image
                                            </span>

                                        @endif

                                    </div>


                                    <div class="order-details-page__item-info">

                                        @if($category)

                                            <span class="order-details-page__item-category">
                                                {{ $category }}
                                            </span>

                                        @endif


                                        <h3>
                                            {{ $item->product_name }}
                                        </h3>


                                        @if(count($attributes))

                                            <div class="order-details-page__item-attributes">

                                                @foreach($attributes as $attribute)

                                                    <span>
                                                        {{ $attribute }}
                                                    </span>

                                                @endforeach

                                            </div>

                                        @endif


                                        <span class="order-details-page__item-quantity">
                                            Quantity: {{ $item->quantity }}
                                        </span>


                                        @if($item->sku)

                                            <span class="order-details-page__item-sku">
                                                SKU: {{ $item->sku }}
                                            </span>

                                        @endif

                                    </div>


                                    <div class="order-details-page__item-price">

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

                    </section>


                    {{-- Refund --}}
                    @if($canRequestRefund)

                        <section
                            class="order-details-page__card order-details-page__refund-card"
                        >

                            <div class="order-details-page__refund-content">

                                <div
                                    class="order-details-page__refund-icon
                                    @if($isRefunded)
                                        order-details-page__refund-icon--success
                                    @elseif($hasApprovedRefundRequest)
                                        order-details-page__refund-icon--approved
                                    @elseif($hasPendingRefundRequest)
                                        order-details-page__refund-icon--pending
                                    @elseif($hasRejectedRefundRequest)
                                        order-details-page__refund-icon--rejected
                                    @endif"
                                >

                                    @if($isRefunded)

                                        <i class="ri-checkbox-circle-line"></i>

                                    @elseif($hasApprovedRefundRequest)

                                        <i class="ri-checkbox-circle-line"></i>

                                    @elseif($hasPendingRefundRequest)

                                        <i class="ri-time-line"></i>

                                    @elseif($hasRejectedRefundRequest)

                                        <i class="ri-close-circle-line"></i>

                                    @else

                                        <i class="ri-refund-2-line"></i>

                                    @endif

                                </div>


                                <div class="order-details-page__refund-info">

                                    <span class="order-details-page__section-label">
                                        REFUND
                                    </span>


                                    {{-- Refunded --}}
                                    @if($isRefunded)

                                        <h2>
                                            Your order has been refunded
                                        </h2>

                                        <p>
                                            Your refund has been successfully
                                            processed. The refundable amount has
                                            been returned through the original
                                            payment method.
                                        </p>


                                        {{-- Approved --}}
                                    @elseif($hasApprovedRefundRequest)

                                        <h2>
                                            Refund request approved
                                        </h2>

                                        <p>
                                            Your refund request has been approved
                                            by our team. The actual refund is now
                                            being processed.
                                        </p>


                                        {{-- Pending --}}
                                    @elseif($hasPendingRefundRequest)

                                        <h2>
                                            Refund request is under review
                                        </h2>

                                        <p>
                                            Your refund request has been submitted
                                            successfully. Our team will review
                                            your request and update its status.
                                        </p>


                                        {{-- Rejected --}}
                                    @elseif($hasRejectedRefundRequest)

                                        <h2>
                                            Refund request was rejected
                                        </h2>

                                        <p>
                                            Your previous refund request was not
                                            approved. You can review the reason
                                            below and submit a new request if
                                            necessary.
                                        </p>


                                        {{-- No Request --}}
                                    @else

                                        <h2>
                                            Need a refund?
                                        </h2>

                                        <p>
                                            You can request a refund for this
                                            entire order. Shipping charges are
                                            non-refundable.
                                        </p>

                                    @endif


                                    {{-- Refund Amount --}}
                                    <div class="order-details-page__refund-amount">

                                        <span>
                                            Refundable amount
                                        </span>

                                        <strong>
                                            ${{ number_format($refundAmount, 2) }}
                                        </strong>

                                    </div>


                                    @if((float) $order->shipping > 0)

                                        <small>
                                            Shipping charge of
                                            ${{ number_format((float) $order->shipping, 2) }}
                                            is excluded from the refund.
                                        </small>

                                    @endif


                                    {{-- Rejection Details --}}
                                    @if(
                                        $hasRejectedRefundRequest
                                        && $latestRefundRequest
                                    )

                                        <div
                                            class="order-details-page__refund-rejected"
                                        >

                                            <div
                                                class="order-details-page__refund-rejected-heading"
                                            >
                                                <i class="ri-information-line"></i>

                                                <span>
                                                    Previous Request
                                                </span>
                                            </div>


                                            <div
                                                class="order-details-page__refund-rejected-details"
                                            >

                                                <div>

                                                    <span>
                                                        Reason
                                                    </span>

                                                    <strong>
                                                        {{ $latestRefundRequest->reason }}
                                                    </strong>

                                                </div>


                                                @if($latestRefundRequest->admin_note)

                                                    <div>

                                                        <span>
                                                            Admin Note
                                                        </span>

                                                        <p>
                                                            {{ $latestRefundRequest->admin_note }}
                                                        </p>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    @endif


                                    {{-- Approved Details --}}
                                    @if(
                                        $hasApprovedRefundRequest
                                        && $latestRefundRequest
                                    )

                                        <div
                                            class="order-details-page__refund-approved"
                                        >

                                            <div
                                                class="order-details-page__refund-approved-heading"
                                            >
                                                <i class="ri-checkbox-circle-line"></i>

                                                <span>
                                                    Approved Request
                                                </span>
                                            </div>


                                            <div
                                                class="order-details-page__refund-approved-details"
                                            >

                                                @if($latestRefundRequest->approver)

                                                    <div>

                                                        <span>
                                                            Approved By
                                                        </span>

                                                        <strong>
                                                            {{ $latestRefundRequest->approver->name }}
                                                        </strong>

                                                    </div>

                                                @endif


                                                @if($latestRefundRequest->approved_at)

                                                    <div>

                                                        <span>
                                                            Approved On
                                                        </span>

                                                        <strong>
                                                            {{ $latestRefundRequest->approved_at->format('M d, Y h:i A') }}
                                                        </strong>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    @endif

                                </div>

                            </div>


                            {{-- Refund Action --}}
                            <div class="order-details-page__refund-action">

                                {{-- Successfully Refunded --}}
                                @if($isRefunded)

                                    <span
                                        class="order-details-page__refund-status
                                        order-details-page__refund-status--success"
                                    >
                                        <i class="ri-checkbox-circle-line"></i>
                                        Refunded
                                    </span>


                                    {{-- Pending --}}
                                @elseif($hasPendingRefundRequest)

                                    <span
                                        class="order-details-page__refund-status
                                        order-details-page__refund-status--pending"
                                    >
                                        <i class="ri-time-line"></i>
                                        Refund Request Pending
                                    </span>


                                    {{-- Approved --}}
                                @elseif($hasApprovedRefundRequest)

                                    <span
                                        class="order-details-page__refund-status
                                        order-details-page__refund-status--approved"
                                    >
                                        <i class="ri-checkbox-circle-line"></i>
                                        Refund Approved
                                    </span>


                                    {{-- Rejected --}}
                                @elseif($hasRejectedRefundRequest)

                                    <div
                                        class="order-details-page__refund-action-group"
                                    >

                                        <span
                                            class="order-details-page__refund-status
                                            order-details-page__refund-status--rejected"
                                        >
                                            <i class="ri-close-circle-line"></i>
                                            Request Rejected
                                        </span>


                                        @if($canSubmitNewRefundRequest)

                                            <button
                                                type="button"
                                                class="order-details-page__refund-button"
                                                data-refund-order
                                                data-order-number="{{ $order->order_number }}"
                                                data-refund-amount="{{ number_format($refundAmount, 2, '.', '') }}"
                                            >
                                                <i class="ri-refresh-line"></i>
                                                Request Again
                                            </button>

                                        @endif

                                    </div>


                                    {{-- New Request --}}
                                @elseif($canSubmitNewRefundRequest)

                                    <button
                                        type="button"
                                        class="order-details-page__refund-button"
                                        data-refund-order
                                        data-order-number="{{ $order->order_number }}"
                                        data-refund-amount="{{ number_format($refundAmount, 2, '.', '') }}"
                                    >
                                        <i class="ri-refund-2-line"></i>
                                        Request Refund
                                    </button>

                                @endif

                            </div>

                        </section>

                    @endif


                    {{-- Shipping Address --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    SHIPPING
                                </span>

                                <h2>
                                    Delivery Address
                                </h2>

                            </div>

                            <i class="ri-map-pin-line"></i>

                        </div>


                        <div class="order-details-page__address">

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

                        </div>

                    </section>

                </div>


                {{-- Sidebar --}}
                <aside class="order-details-page__sidebar">

                    {{-- Summary --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    SUMMARY
                                </span>

                                <h2>
                                    Order Total
                                </h2>

                            </div>

                        </div>


                        <div class="order-details-page__summary">

                            <div>

                                <span>
                                    Subtotal
                                </span>

                                <strong>
                                    ${{ number_format((float) $order->subtotal, 2) }}
                                </strong>

                            </div>


                            @if((float) $order->discount > 0)

                                <div class="order-details-page__summary-discount">

                                    <span>
                                        Discount
                                    </span>

                                    <strong>
                                        -${{ number_format((float) $order->discount, 2) }}
                                    </strong>

                                </div>

                            @endif


                            @if((float) $order->shipping > 0)

                                <div>

                                    <span>
                                        Shipping
                                    </span>

                                    <strong>
                                        ${{ number_format((float) $order->shipping, 2) }}
                                    </strong>

                                </div>

                            @endif


                            @if((float) $order->tax > 0)

                                <div>

                                    <span>
                                        Tax
                                    </span>

                                    <strong>
                                        ${{ number_format((float) $order->tax, 2) }}
                                    </strong>

                                </div>

                            @endif


                            <div class="order-details-page__summary-total">

                                <span>
                                    Total
                                </span>

                                <strong>
                                    ${{ number_format((float) $order->total, 2) }}
                                </strong>

                            </div>

                        </div>

                    </section>


                    {{-- Payment --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    PAYMENT
                                </span>

                                <h2>
                                    Payment Information
                                </h2>

                            </div>

                        </div>


                        <div class="order-details-page__payment">

                            <div>

                                <span>
                                    Payment Status
                                </span>

                                <strong
                                    class="order-details-page__payment-status
                                    order-details-page__payment-status--{{ $order->payment_status }}"
                                >
                                    {{ ucfirst($order->payment_status) }}
                                </strong>

                            </div>


                            @if($order->payment_gateway)

                                <div>

                                    <span>
                                        Method
                                    </span>

                                    <strong>
                                        {{ ucfirst($order->payment_gateway) }}
                                    </strong>

                                </div>

                            @endif


                            @if($order->paid_at)

                                <div>

                                    <span>
                                        Paid On
                                    </span>

                                    <strong>
                                        {{ $order->paid_at->format('M j, Y') }}
                                    </strong>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- Customer --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    CUSTOMER
                                </span>

                                <h2>
                                    Contact Information
                                </h2>

                            </div>

                        </div>


                        <div class="order-details-page__contact">

                            <div>

                                <i class="ri-user-line"></i>

                                <span>
                                    {{ $order->first_name }}
                                    {{ $order->last_name }}
                                </span>

                            </div>


                            <div>

                                <i class="ri-mail-line"></i>

                                <span>
                                    {{ $order->email }}
                                </span>

                            </div>


                            <div>

                                <i class="ri-phone-line"></i>

                                <span>
                                    {{ $order->phone }}
                                </span>

                            </div>

                        </div>

                    </section>

                </aside>

            </div>


            {{-- Bottom CTA --}}
            <div class="order-details-page__bottom">

                <div>

                    <span>
                        Looking for something new?
                    </span>

                    <strong>
                        Explore our latest products.
                    </strong>

                </div>


                <a href="{{ route('shop') }}">
                    Continue Shopping
                    <i class="ri-arrow-right-line"></i>
                </a>

            </div>

        </div>


        {{-- Refund Modal --}}
        <div
            class="order-details-page__refund-modal"
            data-refund-modal
            aria-hidden="true"
        >

            <div
                class="order-details-page__refund-modal-overlay"
                data-refund-close
            ></div>


            <div
                class="order-details-page__refund-modal-dialog"
                role="dialog"
                aria-modal="true"
                aria-labelledby="refund-modal-title"
            >

                <button
                    type="button"
                    class="order-details-page__refund-modal-close"
                    data-refund-close
                    aria-label="Close"
                >
                    <i class="ri-close-line"></i>
                </button>


                <span class="order-details-page__section-label">
                    REFUND REQUEST
                </span>


                <h2 id="refund-modal-title">
                    Request a Refund
                </h2>


                <p class="order-details-page__refund-modal-description">
                    Submit a refund request for your entire order.
                    Shipping charges are not included in the refund.
                </p>


                <div class="order-details-page__refund-modal-summary">

                    <div>

                        <span>
                            Order
                        </span>

                        <strong data-refund-order-number>
                            #{{ $order->order_number }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            Refund Amount
                        </span>

                        <strong data-refund-modal-amount>
                            ${{ number_format($refundAmount, 2) }}
                        </strong>

                    </div>


                    @if((float) $order->shipping > 0)

                        <div>

                            <span>
                                Shipping excluded
                            </span>

                            <strong>
                                ${{ number_format((float) $order->shipping, 2) }}
                            </strong>

                        </div>

                    @endif

                </div>


                <form
                    action="{{ route('my-order.refund-request', $order) }}"
                    method="POST"
                    data-refund-form
                >
                    @csrf


                    <div class="order-details-page__refund-field">

                        <label for="refund-reason">
                            Reason
                        </label>

                        <select
                            id="refund-reason"
                            name="reason"
                            required
                        >

                            <option value="">
                                Select a reason
                            </option>

                            <option value="wrong_item">
                                Wrong item received
                            </option>

                            <option value="damaged">
                                Item arrived damaged
                            </option>

                            <option value="defective">
                                Item is defective
                            </option>

                            <option value="not_as_described">
                                Item is not as described
                            </option>

                            <option value="changed_mind">
                                Changed my mind
                            </option>

                            <option value="other">
                                Other
                            </option>

                        </select>

                    </div>


                    <div class="order-details-page__refund-field">

                        <label for="refund-message">

                            Message

                            <span>
                                (Optional)
                            </span>

                        </label>

                        <textarea
                            id="refund-message"
                            name="message"
                            rows="4"
                            maxlength="5000"
                            placeholder="Please provide additional details..."
                        ></textarea>

                    </div>


                    <div class="order-details-page__refund-notice">

                        <i class="ri-information-line"></i>

                        <p>

                            The refundable amount is fixed at

                            <strong>
                                ${{ number_format($refundAmount, 2) }}
                            </strong>.

                            Shipping charges are excluded.

                        </p>

                    </div>


                    <div class="order-details-page__refund-actions">

                        <button
                            type="button"
                            class="order-details-page__refund-cancel"
                            data-refund-close
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            class="order-details-page__refund-submit"
                        >
                            <i class="ri-send-plane-line"></i>
                            Submit Request
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const page = document.querySelector(
                '.order-details-page'
            );

            if (!page) {
                return;
            }


            /*
             * Cancel Order
             */
            const cancelForm = page.querySelector(
                '[data-cancel-order]'
            );

            if (cancelForm) {
                cancelForm.addEventListener(
                    'submit',
                    function () {
                        const button = this.querySelector(
                            'button[type="submit"]'
                        );

                        if (button) {
                            button.disabled = true;

                            button.innerHTML = `
                                <i class="ri-loader-4-line ri-spin"></i>
                                Cancelling...
                            `;
                        }
                    }
                );
            }


            /*
             * Refund Modal
             */
            const refundModal = page.querySelector(
                '[data-refund-modal]'
            );

            const refundButtons = page.querySelectorAll(
                '[data-refund-order]'
            );

            const refundForm = page.querySelector(
                '[data-refund-form]'
            );


            if (
                !refundModal
                || !refundButtons.length
                || !refundForm
            ) {
                return;
            }


            const reasonInput = refundForm.querySelector(
                '[name="reason"]'
            );

            const messageInput = refundForm.querySelector(
                '[name="message"]'
            );


            /*
             * Open modal
             */
            function openRefundModal(button) {
                const orderNumber =
                    button.dataset.orderNumber || '';

                const refundAmount =
                    Number(
                        button.dataset.refundAmount || 0
                    );


                const orderNumberElement =
                    refundModal.querySelector(
                        '[data-refund-order-number]'
                    );

                const amountElement =
                    refundModal.querySelector(
                        '[data-refund-modal-amount]'
                    );


                if (orderNumberElement) {
                    orderNumberElement.textContent =
                        `#${orderNumber}`;
                }


                if (amountElement) {
                    amountElement.textContent =
                        `$${refundAmount.toLocaleString(
                            'en-US',
                            {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            }
                        )}`;
                }


                /*
                 * Reset form whenever modal opens.
                 */
                refundForm.reset();


                refundModal.classList.add(
                    'is-open'
                );

                refundModal.setAttribute(
                    'aria-hidden',
                    'false'
                );

                document.body.classList.add(
                    'order-details-page--modal-open'
                );


                window.setTimeout(function () {
                    if (reasonInput) {
                        reasonInput.focus();
                    }
                }, 50);
            }


            /*
             * Close modal
             */
            function closeRefundModal() {
                refundModal.classList.remove(
                    'is-open'
                );

                refundModal.setAttribute(
                    'aria-hidden',
                    'true'
                );

                document.body.classList.remove(
                    'order-details-page--modal-open'
                );
            }


            /*
             * Refund buttons.
             *
             * This supports both:
             *
             * Request Refund
             * Request Again
             */
            refundButtons.forEach(function (button) {
                button.addEventListener(
                    'click',
                    function () {
                        openRefundModal(this);
                    }
                );
            });


            /*
             * Close buttons / overlay
             */
            refundModal
                .querySelectorAll('[data-refund-close]')
                .forEach(function (element) {
                    element.addEventListener(
                        'click',
                        closeRefundModal
                    );
                });


            /*
             * Escape key
             */
            document.addEventListener(
                'keydown',
                function (event) {
                    if (
                        event.key === 'Escape'
                        && refundModal.classList.contains(
                            'is-open'
                        )
                    ) {
                        closeRefundModal();
                    }
                }
            );


            /*
             * Refund submit
             */
            refundForm.addEventListener(
                'submit',
                function (event) {
                    event.preventDefault();


                    if (
                        !reasonInput
                        || !reasonInput.value
                    ) {
                        if (reasonInput) {
                            reasonInput.focus();
                        }


                        if (
                            window.AppToast
                            && typeof window.AppToast.fire
                            === 'function'
                        ) {
                            window.AppToast.fire({
                                icon: 'error',
                                title:
                                    'Please select a refund reason.',
                            });
                        }


                        return;
                    }


                    const submitButton =
                        refundForm.querySelector(
                            '[type="submit"]'
                        );


                    if (submitButton) {
                        submitButton.disabled = true;

                        submitButton.innerHTML = `
                            <i class="ri-loader-4-line ri-spin"></i>
                            Submitting...
                        `;
                    }


                    /*
                     * Native form submit prevents
                     * this submit listener from firing again.
                     */
                    HTMLFormElement.prototype.submit.call(
                        refundForm
                    );
                }
            );
        });
    </script>
@endpush
