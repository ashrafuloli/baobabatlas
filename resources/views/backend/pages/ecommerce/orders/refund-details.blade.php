@extends('backend.layouts.backend')

@section('title', 'Refund Request Details')

@section('content')
    <div class="admin-refund-details-page">
        <div class="admin-refund-details-container">

            {{-- Page Header --}}
            <div class="admin-refund-details-header">
                <div class="admin-refund-details-header-content">

                    <div class="admin-refund-details-breadcrumb">
                        <a href="{{ route('admin-refunds') }}">
                            <i class="ri-refund-2-line"></i>
                            Refund Requests
                        </a>

                        <i class="ri-arrow-right-s-line"></i>

                        <span>
                            Request #{{ $refundRequest->id }}
                        </span>
                    </div>

                    <div class="admin-refund-details-title-row">
                        <div>
                            <h1>
                                Refund Request #{{ $refundRequest->id }}
                            </h1>

                            <p>
                                Review the customer's refund request and process
                                the approved refund.
                            </p>
                        </div>

                        <a
                            href="{{ route('admin-refunds') }}"
                            class="admin-refund-details-back-btn"
                        >
                            <i class="ri-arrow-left-line"></i>
                            <span>Back to Requests</span>
                        </a>
                    </div>

                </div>
            </div>


            {{-- Main Grid --}}
            <div class="admin-refund-details-grid">

                {{-- Left Column --}}
                <div class="admin-refund-details-main">

                    {{-- Request Summary --}}
                    <section class="admin-refund-details-card">

                        <div class="admin-refund-details-card-header">

                            <div class="admin-refund-details-card-heading">

                                <span class="admin-refund-details-card-icon">
                                    <i class="ri-refund-2-line"></i>
                                </span>

                                <div>
                                    <h2>Refund Request</h2>

                                    <p>
                                        Request information and refund details.
                                    </p>
                                </div>

                            </div>


                            @php
                                $statusClass = match ($refundRequest->status) {
                                    \App\Models\RefundRequest::STATUS_PENDING => 'is-pending',
                                    \App\Models\RefundRequest::STATUS_APPROVED => 'is-approved',
                                    \App\Models\RefundRequest::STATUS_REJECTED => 'is-rejected',
                                    default => 'is-default',
                                };
                            @endphp


                            <span
                                class="admin-refund-details-status {{ $statusClass }}"
                            >
                                @if (
                                    $refundRequest->status
                                    === \App\Models\RefundRequest::STATUS_PENDING
                                )
                                    <i class="ri-time-line"></i>
                                @elseif (
                                    $refundRequest->status
                                    === \App\Models\RefundRequest::STATUS_APPROVED
                                )
                                    <i class="ri-checkbox-circle-line"></i>
                                @elseif (
                                    $refundRequest->status
                                    === \App\Models\RefundRequest::STATUS_REJECTED
                                )
                                    <i class="ri-close-circle-line"></i>
                                @else
                                    <i class="ri-information-line"></i>
                                @endif

                                {{ ucfirst($refundRequest->status) }}
                            </span>

                        </div>


                        <div class="admin-refund-details-card-body">

                            <div class="admin-refund-details-amount-box">

                                <div class="admin-refund-details-amount-icon">
                                    <i class="ri-money-dollar-circle-line"></i>
                                </div>

                                <div>

                                    <span>
                                        Original Refundable Amount
                                    </span>

                                    <strong>
                                        ${{ number_format(
                                            (float) $refundRequest->amount,
                                            2,
                                        ) }}
                                    </strong>

                                    <small>
                                        Shipping cost is non-refundable.
                                    </small>

                                </div>

                            </div>


                            <div class="admin-refund-details-info-grid">

                                <div class="admin-refund-details-info-item">
                                    <span class="label">
                                        Request ID
                                    </span>

                                    <strong>
                                        #{{ $refundRequest->id }}
                                    </strong>
                                </div>


                                <div class="admin-refund-details-info-item">

                                    <span class="label">
                                        Order Number
                                    </span>

                                    <strong>
                                        <a
                                            href="{{ route(
                                                'admin-order-details',
                                                $refundRequest->order,
                                            ) }}"
                                        >
                                            {{ $refundRequest->order->order_number }}
                                        </a>
                                    </strong>

                                </div>


                                <div class="admin-refund-details-info-item">

                                    <span class="label">
                                        Reason
                                    </span>

                                    <strong>
                                        {{ $refundRequest->reason }}
                                    </strong>

                                </div>


                                <div class="admin-refund-details-info-item">

                                    <span class="label">
                                        Submitted
                                    </span>

                                    <strong>
                                        {{ $refundRequest->created_at?->format(
                                            'M d, Y h:i A',
                                        ) }}
                                    </strong>

                                </div>

                            </div>


                            @if ($refundRequest->message)

                                <div class="admin-refund-details-message">

                                    <div class="admin-refund-details-message-heading">
                                        <i class="ri-message-3-line"></i>
                                        <span>Customer Message</span>
                                    </div>

                                    <div class="admin-refund-details-message-content">
                                        {{ $refundRequest->message }}
                                    </div>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- Order Information --}}
                    <section class="admin-refund-details-card">

                        <div class="admin-refund-details-card-header">

                            <div class="admin-refund-details-card-heading">

                                <span class="admin-refund-details-card-icon">
                                    <i class="ri-shopping-bag-3-line"></i>
                                </span>

                                <div>
                                    <h2>Order Information</h2>

                                    <p>
                                        Original order details related to this refund.
                                    </p>
                                </div>

                            </div>


                            <a
                                href="{{ route(
                                    'admin-order-details',
                                    $refundRequest->order,
                                ) }}"
                                class="admin-refund-details-view-order"
                            >
                                View Order
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>


                        <div class="admin-refund-details-card-body">

                            <div class="admin-refund-details-order-summary">

                                <div class="admin-refund-details-order-number">

                                    <span>
                                        Order
                                    </span>

                                    <strong>
                                        {{ $refundRequest->order->order_number }}
                                    </strong>

                                </div>


                                <div class="admin-refund-details-order-status">

                                    <span class="label">
                                        Order Status
                                    </span>

                                    <strong>
                                        {{ ucfirst($refundRequest->order->status) }}
                                    </strong>

                                </div>


                                <div class="admin-refund-details-order-status">

                                    <span class="label">
                                        Payment Status
                                    </span>

                                    <strong>
                                        {{ ucfirst(
                                            $refundRequest->order->payment_status,
                                        ) }}
                                    </strong>

                                </div>


                                <div class="admin-refund-details-order-total">

                                    <span class="label">
                                        Order Total
                                    </span>

                                    <strong>
                                        ${{ number_format(
                                            (float) $refundRequest->order->total,
                                            2,
                                        ) }}
                                    </strong>

                                </div>

                            </div>


                            <div class="admin-refund-details-breakdown">

                                <div>

                                    <span>
                                        Subtotal
                                    </span>

                                    <strong>
                                        ${{ number_format(
                                            (float) $refundRequest->order->subtotal,
                                            2,
                                        ) }}
                                    </strong>

                                </div>


                                @if (
                                    (float) $refundRequest->order->discount > 0
                                )
                                    <div>

                                        <span>
                                            Discount
                                        </span>

                                        <strong class="is-discount">
                                            -${{ number_format(
                                                (float) $refundRequest->order->discount,
                                                2,
                                            ) }}
                                        </strong>

                                    </div>
                                @endif


                                <div>

                                    <span>
                                        Shipping
                                    </span>

                                    <strong>
                                        ${{ number_format(
                                            (float) $refundRequest->order->shipping,
                                            2,
                                        ) }}
                                    </strong>

                                </div>


                                @if (
                                    (float) $refundRequest->order->tax > 0
                                )
                                    <div>

                                        <span>
                                            Tax
                                        </span>

                                        <strong>
                                            ${{ number_format(
                                                (float) $refundRequest->order->tax,
                                                2,
                                            ) }}
                                        </strong>

                                    </div>
                                @endif


                                <div class="is-total">

                                    <span>
                                        Order Total
                                    </span>

                                    <strong>
                                        ${{ number_format(
                                            (float) $refundRequest->order->total,
                                            2,
                                        ) }}
                                    </strong>

                                </div>


                                <div class="is-refundable">

                                    <span>
                                        Refundable Amount
                                    </span>

                                    <strong>
                                        ${{ number_format(
                                            (float) $refundRequest->amount,
                                            2,
                                        ) }}
                                    </strong>

                                </div>

                            </div>


                            {{-- Order Items --}}
                            @if ($refundRequest->order->items->isNotEmpty())

                                <div class="admin-refund-details-items">

                                    <div class="admin-refund-details-section-label">
                                        <span>Order Items</span>
                                    </div>


                                    <div class="admin-refund-details-items-list">

                                        @foreach (
                                            $refundRequest->order->items as $item
                                        )

                                            <div class="admin-refund-details-item">

                                                <div class="admin-refund-details-item-image">

                                                    @if ($item->image)

                                                        <img
                                                            src="{{ asset($item->image) }}"
                                                            alt="{{ $item->product_name }}"
                                                        >

                                                    @else

                                                        <span>
                                                            <i class="ri-image-line"></i>
                                                        </span>

                                                    @endif

                                                </div>


                                                <div class="admin-refund-details-item-content">

                                                    <h3>
                                                        {{ $item->product_name }}
                                                    </h3>


                                                    @if ($item->sku)

                                                        <span class="sku">
                                                            SKU: {{ $item->sku }}
                                                        </span>

                                                    @endif


                                                    <div class="admin-refund-details-item-meta">

                                                        <span>
                                                            Qty:
                                                            {{ $item->quantity }}
                                                        </span>

                                                        <span>
                                                            Unit:
                                                            ${{ number_format(
                                                                (float) $item->unit_price,
                                                                2,
                                                            ) }}
                                                        </span>

                                                    </div>

                                                </div>


                                                <strong class="admin-refund-details-item-total">
                                                    ${{ number_format(
                                                        (float) $item->line_total,
                                                        2,
                                                    ) }}
                                                </strong>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- Customer Information --}}
                    <section class="admin-refund-details-card">

                        <div class="admin-refund-details-card-header">

                            <div class="admin-refund-details-card-heading">

                                <span class="admin-refund-details-card-icon">
                                    <i class="ri-user-3-line"></i>
                                </span>

                                <div>
                                    <h2>Customer Information</h2>

                                    <p>
                                        Customer who submitted the refund request.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="admin-refund-details-card-body">

                            <div class="admin-refund-details-customer">

                                <div class="admin-refund-details-customer-avatar">
                                    {{
                                        strtoupper(
                                            substr(
                                                $refundRequest->requester?->name
                                                    ?? $refundRequest->order->first_name,
                                                0,
                                                1,
                                            ),
                                        )
                                    }}
                                </div>


                                <div class="admin-refund-details-customer-content">

                                    <h3>
                                        {{
                                            $refundRequest->requester?->name
                                                ?? $refundRequest->order->first_name
                                                    . ' '
                                                    . $refundRequest->order->last_name
                                        }}
                                    </h3>


                                    <div class="admin-refund-details-customer-meta">

                                        <span>
                                            <i class="ri-mail-line"></i>
                                            {{ $refundRequest->order->email }}
                                        </span>


                                        @if ($refundRequest->order->phone)

                                            <span>
                                                <i class="ri-phone-line"></i>
                                                {{ $refundRequest->order->phone }}
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            <div class="admin-refund-details-address">

                                <div class="admin-refund-details-address-heading">

                                    <i class="ri-map-pin-line"></i>

                                    <span>
                                        Billing / Shipping Address
                                    </span>

                                </div>


                                <address>

                                    {{ $refundRequest->order->first_name }}
                                    {{ $refundRequest->order->last_name }}<br>

                                    {{ $refundRequest->order->address }}

                                    @if ($refundRequest->order->apartment)
                                        , {{ $refundRequest->order->apartment }}
                                    @endif

                                    <br>

                                    {{ $refundRequest->order->city }},
                                    {{ $refundRequest->order->state }}
                                    {{ $refundRequest->order->postal_code }}<br>

                                    {{ $refundRequest->order->country }}

                                </address>

                            </div>

                        </div>

                    </section>


                    {{-- Existing Stripe Refund --}}
                    @if ($refundRequest->refund)

                        <section class="admin-refund-details-card">

                            <div class="admin-refund-details-card-header">

                                <div class="admin-refund-details-card-heading">

                                    <span class="admin-refund-details-card-icon">
                                        <i class="ri-bank-card-line"></i>
                                    </span>

                                    <div>
                                        <h2>Stripe Refund</h2>

                                        <p>
                                            Refund transaction information.
                                        </p>
                                    </div>

                                </div>


                                <span class="admin-refund-details-status is-refunded">

                                    <i class="ri-checkbox-circle-line"></i>

                                    {{ ucfirst(
                                        $refundRequest->refund->status,
                                    ) }}

                                </span>

                            </div>


                            <div class="admin-refund-details-card-body">

                                <div class="admin-refund-details-refund-grid">

                                    <div>

                                        <span>
                                            Refund Amount
                                        </span>

                                        <strong>
                                            ${{ number_format(
                                                (float) $refundRequest->refund->amount,
                                                2,
                                            ) }}
                                        </strong>

                                    </div>


                                    <div>

                                        <span>
                                            Currency
                                        </span>

                                        <strong>
                                            {{ strtoupper(
                                                $refundRequest->refund->currency,
                                            ) }}
                                        </strong>

                                    </div>


                                    <div>

                                        <span>
                                            Stripe Refund ID
                                        </span>

                                        <strong class="refund-id">
                                            {{ $refundRequest->refund->stripe_refund_id }}
                                        </strong>

                                    </div>


                                    <div>

                                        <span>
                                            Processed At
                                        </span>

                                        <strong>
                                            {{ $refundRequest->refund->created_at?->format(
                                                'M d, Y h:i A',
                                            ) }}
                                        </strong>

                                    </div>

                                </div>


                                {{-- Deduction Summary --}}
                                @if ($refundRequest->hasDeduction())

                                    <div class="admin-refund-details-deduction">

                                        <div class="admin-refund-details-deduction-summary">

                                            <div>

                                                <span>
                                                    Original Refundable
                                                </span>

                                                <strong>
                                                    ${{ number_format(
                                                        (float) $refundRequest->amount,
                                                        2,
                                                    ) }}
                                                </strong>

                                            </div>


                                            <div class="is-deduction">

                                                <span>
                                                    Deduction
                                                </span>

                                                <strong>
                                                    -${{ number_format(
                                                        (float) $refundRequest->deduction_amount,
                                                        2,
                                                    ) }}
                                                </strong>

                                            </div>


                                            <div class="is-final">

                                                <span>
                                                    Final Refund
                                                </span>

                                                <strong>
                                                    ${{ number_format(
                                                        (float) $refundRequest->refund->amount,
                                                        2,
                                                    ) }}
                                                </strong>

                                            </div>

                                        </div>


                                        @if ($refundRequest->deduction_reason)

                                            <div class="admin-refund-details-deduction-field">

                                                <label>
                                                    Deduction Reason
                                                </label>

                                                <input
                                                    type="text"
                                                    value="{{ $refundRequest->deduction_reason }}"
                                                    readonly
                                                >

                                            </div>

                                        @endif

                                    </div>

                                @endif

                            </div>

                        </section>

                    @endif

                </div>


                {{-- Right Sidebar --}}
                <aside class="admin-refund-details-sidebar">

                    {{-- Requester --}}
                    <section class="admin-refund-details-side-card">

                        <div class="admin-refund-details-side-heading">

                            <i class="ri-user-line"></i>

                            <span>
                                Requested By
                            </span>

                        </div>


                        <div class="admin-refund-details-requester">

                            <div class="admin-refund-details-requester-avatar">

                                {{
                                    strtoupper(
                                        substr(
                                            $refundRequest->requester?->name
                                                ?? 'U',
                                            0,
                                            1,
                                        ),
                                    )
                                }}

                            </div>


                            <div>

                                <strong>
                                    {{ $refundRequest->requester?->name ?? 'Unknown User' }}
                                </strong>

                                <span>
                                    {{ $refundRequest->created_at?->format(
                                        'M d, Y',
                                    ) }}
                                </span>

                            </div>

                        </div>

                    </section>


                    {{-- Approval --}}
                    @if ($refundRequest->approver)

                        <section class="admin-refund-details-side-card">

                            <div class="admin-refund-details-side-heading">

                                <i class="ri-shield-check-line"></i>

                                <span>
                                    Approval
                                </span>

                            </div>


                            <div class="admin-refund-details-approval">

                                <strong>
                                    {{ $refundRequest->approver->name }}
                                </strong>


                                @if ($refundRequest->approved_at)

                                    <span>
                                        Approved
                                        {{ $refundRequest->approved_at->format(
                                            'M d, Y h:i A',
                                        ) }}
                                    </span>

                                @endif

                            </div>


                            @if ($refundRequest->admin_note)

                                <div class="admin-refund-details-admin-note">

                                    <span>
                                        Admin Note
                                    </span>

                                    <p>
                                        {{ $refundRequest->admin_note }}
                                    </p>

                                </div>

                            @endif

                        </section>

                    @endif


                    {{-- Request Actions --}}
                    @if (
                        $refundRequest->status
                        === \App\Models\RefundRequest::STATUS_PENDING
                    )

                        <section
                            class="admin-refund-details-side-card
                            admin-refund-details-actions-card"
                        >

                            <div class="admin-refund-details-side-heading">

                                <i class="ri-settings-3-line"></i>

                                <span>
                                    Request Actions
                                </span>

                            </div>


                            <p class="admin-refund-details-action-description">
                                Review the request carefully before approving
                                or rejecting it.
                            </p>


                            {{-- Approve --}}
                            <form
                                action="{{ route(
                                    'admin-refunds.approve',
                                    $refundRequest,
                                ) }}"
                                method="POST"
                                class="admin-refund-details-action-form"
                                data-confirm-action="approve"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="admin-refund-details-action-btn is-approve"
                                >
                                    <i class="ri-checkbox-circle-line"></i>

                                    <span>
                                        Approve Refund
                                    </span>
                                </button>
                            </form>


                            {{-- Reject --}}
                            <form
                                action="{{ route(
                                    'admin-refunds.reject',
                                    $refundRequest,
                                ) }}"
                                method="POST"
                                class="admin-refund-details-reject-form"
                                data-confirm-action="reject"
                            >
                                @csrf
                                @method('PATCH')

                                <div class="admin-refund-details-note-field">

                                    <label for="refund-admin-note">

                                        Admin Note

                                        <span>
                                            (optional)
                                        </span>

                                    </label>


                                    <textarea
                                        id="refund-admin-note"
                                        name="admin_note"
                                        rows="4"
                                        maxlength="5000"
                                        placeholder="Add a note for the customer..."
                                    ></textarea>

                                </div>


                                <button
                                    type="submit"
                                    class="admin-refund-details-action-btn is-reject"
                                >
                                    <i class="ri-close-circle-line"></i>

                                    <span>
                                        Reject Refund
                                    </span>
                                </button>

                            </form>

                        </section>

                    @endif


                    {{-- Deduction & Process Refund --}}
                    @if (
                        $refundRequest->status
                        === \App\Models\RefundRequest::STATUS_APPROVED
                        && ! $refundRequest->refund
                    )

                        @php
                            $originalRefundAmount = round(
                                (float) $refundRequest->amount,
                                2,
                            );

                            $currentDeductionAmount = round(
                                (float) $refundRequest->deduction_amount,
                                2,
                            );

                            $currentFinalRefundAmount = max(
                                0,
                                round(
                                    $originalRefundAmount
                                    - $currentDeductionAmount,
                                    2,
                                ),
                            );
                        @endphp


                        <section
                            class="admin-refund-details-side-card
                            admin-refund-details-process-card"
                        >

                            <div class="admin-refund-details-side-heading">

                                <i class="ri-bank-card-line"></i>

                                <span>
                                    Process Refund
                                </span>

                            </div>


                            <div class="admin-refund-details-process-warning">

                                <i class="ri-information-line"></i>

                                <p>
                                    The request is approved. You can optionally
                                    apply a deduction before processing the
                                    Stripe refund.
                                </p>

                            </div>


                            {{-- Refund Calculation --}}
                            <div
                                class="admin-refund-details-refund-calculation"
                                data-original-amount="{{ number_format(
                                    $originalRefundAmount,
                                    2,
                                    '.',
                                    '',
                                ) }}"
                            >

                                {{-- Original Amount --}}
                                <div class="admin-refund-details-calculation-row">

                                    <span>
                                        Original Refundable Amount
                                    </span>

                                    <strong>
                                        $<span data-original-refund>
                                            {{ number_format(
                                                $originalRefundAmount,
                                                2,
                                            ) }}
                                        </span>
                                    </strong>

                                </div>


                                {{-- Deduction Form --}}
                                <form
                                    action="{{ route(
                                        'admin-refunds.deduction',
                                        $refundRequest,
                                    ) }}"
                                    method="POST"
                                    class="admin-refund-details-deduction-form"
                                    data-deduction-form
                                >
                                    @csrf
                                    @method('PATCH')


                                    <div class="admin-refund-details-deduction">

                                        {{-- Deduction Amount --}}
                                        <div class="admin-refund-details-deduction-field">

                                            <label for="refund-deduction-amount">

                                                Deduction Amount

                                                <span>
                                                    (optional)
                                                </span>

                                            </label>


                                            <div class="admin-refund-details-input-group">

                                                <span>
                                                    $
                                                </span>

                                                <input
                                                    type="number"
                                                    id="refund-deduction-amount"
                                                    name="deduction_amount"
                                                    value="{{
                                                        $currentDeductionAmount > 0
                                                            ? number_format(
                                                                $currentDeductionAmount,
                                                                2,
                                                                '.',
                                                                '',
                                                            )
                                                            : ''
                                                    }}"
                                                    min="0"
                                                    max="{{ number_format(
                                                        $originalRefundAmount,
                                                        2,
                                                        '.',
                                                        '',
                                                    ) }}"
                                                    step="0.01"
                                                    inputmode="decimal"
                                                    placeholder="0.00"
                                                    data-deduction-input
                                                >

                                            </div>


                                            <small
                                                class="admin-refund-details-field-error"
                                                data-deduction-error
                                            ></small>

                                        </div>


                                        {{-- Deduction Reason --}}
                                        <div class="admin-refund-details-deduction-field">

                                            <label for="refund-deduction-reason">

                                                Deduction Reason

                                                <span>
                                                    (optional)
                                                </span>

                                            </label>


                                            <input
                                                type="text"
                                                id="refund-deduction-reason"
                                                name="deduction_reason"
                                                value="{{ $refundRequest->deduction_reason }}"
                                                maxlength="255"
                                                placeholder="e.g. Restocking fee"
                                            >

                                        </div>


                                        {{-- Live Deduction Summary --}}
                                        <div class="admin-refund-details-deduction-summary">

                                            <div>

                                                <span>
                                                    Original Refundable
                                                </span>

                                                <strong>
                                                    $<span data-summary-original>
                                                        {{ number_format(
                                                            $originalRefundAmount,
                                                            2,
                                                        ) }}
                                                    </span>
                                                </strong>

                                            </div>


                                            <div class="is-deduction">

                                                <span>
                                                    Deduction
                                                </span>

                                                <strong>
                                                    -$<span data-current-deduction>
                                                        {{ number_format(
                                                            $currentDeductionAmount,
                                                            2,
                                                        ) }}
                                                    </span>
                                                </strong>

                                            </div>


                                            <div class="is-final">

                                                <span>
                                                    Final Refund
                                                </span>

                                                <strong>
                                                    $<span data-final-refund>
                                                        {{ number_format(
                                                            $currentFinalRefundAmount,
                                                            2,
                                                        ) }}
                                                    </span>
                                                </strong>

                                            </div>

                                        </div>


                                        {{-- Save Deduction --}}
                                        <button
                                            type="submit"
                                            class="admin-refund-details-action-btn is-save"
                                            data-save-deduction
                                        >
                                            <i class="ri-save-3-line"></i>

                                            <span>
                                                Save Deduction
                                            </span>
                                        </button>

                                    </div>

                                </form>


                                {{-- Final Refund Status --}}
                                <div
                                    class="admin-refund-details-final-refund-status"
                                    data-final-refund-status
                                ></div>

                            </div>


                            {{-- Process Stripe Refund --}}
                            <form
                                action="{{ route(
                                    'admin-refunds.process',
                                    $refundRequest,
                                ) }}"
                                method="POST"
                                class="admin-refund-details-action-form"
                                data-confirm-action="refund"
                                data-refund-process-form
                            >
                                @csrf


                                <button
                                    type="submit"
                                    class="admin-refund-details-action-btn is-process"
                                    data-process-refund
                                    @disabled($currentFinalRefundAmount <= 0)
                                >
                                    <i class="ri-bank-card-line"></i>

                                    <span>
                                        Process Stripe Refund
                                    </span>
                                </button>

                            </form>

                        </section>

                    @endif


                    {{-- Refund Completed --}}
                    @if ($refundRequest->refund)

                        <section
                            class="admin-refund-details-side-card
                            admin-refund-details-completed-card"
                        >

                            <div class="admin-refund-details-completed-icon">

                                <i class="ri-checkbox-circle-line"></i>

                            </div>


                            <h3>
                                Refund Processed
                            </h3>


                            <p>
                                This refund request has already been processed
                                through Stripe.
                            </p>


                            <div class="admin-refund-details-completed-amount">

                                <span>
                                    Refunded Amount
                                </span>

                                <strong>
                                    ${{ number_format(
                                        (float) $refundRequest->refund->amount,
                                        2,
                                    ) }}
                                </strong>

                            </div>

                        </section>

                    @endif


                    {{-- Refund Policy --}}
                    <section
                        class="admin-refund-details-side-card
                        admin-refund-details-policy-card"
                    >

                        <div class="admin-refund-details-side-heading">

                            <i class="ri-information-line"></i>

                            <span>
                                Refund Policy
                            </span>

                        </div>


                        <ul>

                            <li>
                                <i class="ri-checkbox-circle-line"></i>

                                Refund applies to the whole order.
                            </li>


                            <li>
                                <i class="ri-checkbox-circle-line"></i>

                                Shipping cost is non-refundable.
                            </li>


                            <li>
                                <i class="ri-checkbox-circle-line"></i>

                                Stock is not automatically restored.
                            </li>


                            <li>
                                <i class="ri-checkbox-circle-line"></i>

                                Stripe refund is processed only after approval.
                            </li>


                            <li>
                                <i class="ri-checkbox-circle-line"></i>

                                Any deduction is subtracted from the refundable amount.
                            </li>

                        </ul>

                    </section>

                </aside>

            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const page = document.querySelector(
                '.admin-refund-details-page'
            );

            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Helpers
            |--------------------------------------------------------------------------
            */

            const formatAmount = function (amount) {
                return Number(amount || 0).toLocaleString(
                    'en-US',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }
                );
            };


            const showToast = function (
                message,
                icon = 'error'
            ) {
                if (
                    window.AppToast
                    && typeof window.AppToast.fire === 'function'
                ) {
                    window.AppToast.fire({
                        icon: icon,
                        title: message,
                    });
                }
            };


            /*
            |--------------------------------------------------------------------------
            | Deduction
            |--------------------------------------------------------------------------
            */

            const deductionForm = page.querySelector(
                '[data-deduction-form]'
            );

            if (deductionForm) {
                const calculation = page.querySelector(
                    '[data-original-amount]'
                );

                const deductionInput = deductionForm.querySelector(
                    '[data-deduction-input]'
                );

                const deductionError = deductionForm.querySelector(
                    '[data-deduction-error]'
                );

                const currentDeductionElement =
                    deductionForm.querySelector(
                        '[data-current-deduction]'
                    );

                const finalRefundElement =
                    deductionForm.querySelector(
                        '[data-final-refund]'
                    );

                const saveButton =
                    deductionForm.querySelector(
                        '[data-save-deduction]'
                    );

                const processRefundButton =
                    page.querySelector(
                        '[data-process-refund]'
                    );


                const originalAmount = Number(
                    calculation?.dataset.originalAmount
                ) || 0;


                const getDeduction = function () {
                    if (!deductionInput) {
                        return 0;
                    }

                    const value = Number(
                        deductionInput.value
                    );

                    if (!Number.isFinite(value)) {
                        return 0;
                    }

                    return Math.max(0, value);
                };


                const setError = function (message) {
                    if (deductionError) {
                        deductionError.textContent = message;
                    }

                    if (deductionInput) {
                        deductionInput.classList.toggle(
                            'is-invalid',
                            Boolean(message)
                        );
                    }
                };


                const updateRefundCalculation = function () {
                    if (!deductionInput) {
                        return;
                    }

                    const deduction = getDeduction();


                    /*
                     * Deduction cannot exceed original refundable amount.
                     */
                    if (deduction > originalAmount) {
                        setError(
                            'Deduction cannot exceed $'
                            + formatAmount(originalAmount)
                            + '.'
                        );

                        if (saveButton) {
                            saveButton.disabled = true;
                        }

                        if (processRefundButton) {
                            processRefundButton.disabled = true;
                        }

                        return;
                    }


                    setError('');


                    const finalAmount = Math.max(
                        0,
                        Math.round(
                            (
                                originalAmount
                                - deduction
                            ) * 100
                        ) / 100
                    );


                    if (currentDeductionElement) {
                        currentDeductionElement.textContent =
                            formatAmount(deduction);
                    }


                    if (finalRefundElement) {
                        finalRefundElement.textContent =
                            formatAmount(finalAmount);
                    }


                    /*
                     * Save deduction is allowed when the
                     * deduction itself is valid.
                     */
                    if (saveButton) {
                        saveButton.disabled = false;
                    }


                    /*
                     * Stripe refund must be greater than zero.
                     */
                    if (processRefundButton) {
                        processRefundButton.disabled =
                            finalAmount <= 0;
                    }
                };


                /*
                 * Live calculation.
                 */
                if (deductionInput) {
                    deductionInput.addEventListener(
                        'input',
                        updateRefundCalculation
                    );

                    deductionInput.addEventListener(
                        'change',
                        updateRefundCalculation
                    );

                    deductionInput.addEventListener(
                        'blur',
                        updateRefundCalculation
                    );
                }


                /*
                 * Save deduction.
                 */
                deductionForm.addEventListener(
                    'submit',
                    function (event) {
                        const deduction = getDeduction();


                        if (deduction > originalAmount) {
                            event.preventDefault();

                            setError(
                                'Deduction cannot exceed $'
                                + formatAmount(originalAmount)
                                + '.'
                            );

                            deductionInput?.focus();

                            return;
                        }


                        if (deduction < 0) {
                            event.preventDefault();

                            setError(
                                'Deduction cannot be negative.'
                            );

                            deductionInput?.focus();

                            return;
                        }


                        if (saveButton) {
                            saveButton.disabled = true;

                            saveButton.innerHTML = `
                                <i class="ri-loader-4-line ri-spin"></i>
                                <span>Saving...</span>
                            `;
                        }
                    }
                );


                /*
                 * Initial calculation.
                 */
                updateRefundCalculation();
            }


            /*
            |--------------------------------------------------------------------------
            | Approve / Reject / Process Refund
            |--------------------------------------------------------------------------
            */

            const actionForms = page.querySelectorAll(
                '[data-confirm-action]'
            );


            actionForms.forEach(function (form) {
                form.addEventListener(
                    'submit',
                    function (event) {
                        const action =
                            form.dataset.confirmAction;


                        let title = 'Are you sure?';
                        let text =
                            'Please confirm this action.';
                        let confirmText = 'Confirm';
                        let icon = 'question';


                        /*
                         * Approve
                         */
                        if (action === 'approve') {
                            title =
                                'Approve refund request?';

                            text =
                                'This will approve the whole-order refund request.';

                            confirmText =
                                'Approve Refund';

                            icon = 'question';
                        }


                        /*
                         * Reject
                         */
                        if (action === 'reject') {
                            const note =
                                form.querySelector(
                                    '[name="admin_note"]'
                                );


                            if (
                                !note
                                || !note.value.trim()
                            ) {
                                event.preventDefault();

                                showToast(
                                    'Please add an admin note before rejecting the request.',
                                    'warning'
                                );

                                note?.focus();

                                return;
                            }


                            title =
                                'Reject refund request?';

                            text =
                                'The customer refund request will be rejected.';

                            confirmText =
                                'Reject Refund';

                            icon = 'warning';
                        }


                        /*
                         * Process Stripe Refund
                         */
                        if (action === 'refund') {
                            const calculation =
                                page.querySelector(
                                    '[data-original-amount]'
                                );


                            const originalAmount =
                                Number(
                                    calculation?.dataset
                                        .originalAmount
                                ) || 0;


                            const deductionInput =
                                page.querySelector(
                                    '[data-deduction-input]'
                                );


                            const deduction =
                                Number(
                                    deductionInput?.value
                                ) || 0;


                            const finalAmount =
                                Math.max(
                                    0,
                                    Math.round(
                                        (
                                            originalAmount
                                            - deduction
                                        ) * 100
                                    ) / 100
                                );


                            if (
                                deduction < 0
                                || deduction > originalAmount
                            ) {
                                event.preventDefault();

                                showToast(
                                    'The deduction amount is invalid.',
                                    'error'
                                );

                                deductionInput?.focus();

                                return;
                            }


                            if (finalAmount <= 0) {
                                event.preventDefault();

                                showToast(
                                    'The final refund amount must be greater than zero.',
                                    'error'
                                );

                                return;
                            }


                            title =
                                'Process Stripe refund?';

                            text =
                                'This will create a Stripe refund of $'
                                + formatAmount(finalAmount)
                                + '. This action cannot be undone.';

                            confirmText =
                                'Process Refund';

                            icon = 'warning';
                        }


                        /*
                         * SweetAlert confirmation.
                         */
                        if (
                            window.Swal
                            && typeof window.Swal.fire
                            === 'function'
                        ) {
                            event.preventDefault();


                            window.Swal.fire({
                                icon: icon,
                                title: title,
                                text: text,
                                showCancelButton: true,
                                confirmButtonText:
                                confirmText,
                                cancelButtonText:
                                    'Cancel',
                                reverseButtons: true,
                                focusCancel: true,
                            }).then(function (result) {
                                if (
                                    ! result.isConfirmed
                                ) {
                                    return;
                                }


                                const button =
                                    form.querySelector(
                                        'button[type="submit"]'
                                    );


                                if (button) {
                                    button.disabled = true;


                                    button.dataset.originalHtml =
                                        button.innerHTML;


                                    if (
                                        action
                                        === 'approve'
                                    ) {
                                        button.innerHTML = `
                                            <i class="ri-loader-4-line ri-spin"></i>
                                            <span>Approving...</span>
                                        `;
                                    } else if (
                                        action
                                        === 'reject'
                                    ) {
                                        button.innerHTML = `
                                            <i class="ri-loader-4-line ri-spin"></i>
                                            <span>Rejecting...</span>
                                        `;
                                    } else {
                                        button.innerHTML = `
                                            <i class="ri-loader-4-line ri-spin"></i>
                                            <span>Processing...</span>
                                        `;
                                    }
                                }


                                /*
                                 * Native submit prevents
                                 * this listener from firing again.
                                 */
                                HTMLFormElement.prototype.submit.call(
                                    form
                                );
                            });

                            return;
                        }


                        /*
                         * Fallback if SweetAlert is unavailable.
                         */
                        const button =
                            form.querySelector(
                                'button[type="submit"]'
                            );


                        if (button) {
                            button.disabled = true;
                        }
                    }
                );
            });
        });
    </script>
@endpush
