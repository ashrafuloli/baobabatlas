@extends('backend.layouts.backend')

@section('title', 'Refund Request')

@section('content')
    <div class="ecommerce-refund-request-show-page">
        <div class="container-fluid">

            {{-- Header --}}
            <div class="refund-request-show-header">
                <div class="refund-request-show-header__content">
                    <div class="refund-request-show-header__breadcrumb">
                        <a href="{{ route('admin-ecommerce-payments') }}">
                            Payments
                        </a>

                        <span>/</span>

                        <a href="{{ route('admin-ecommerce-payment-refund-requests') }}">
                            Refund Requests
                        </a>

                        <span>/</span>

                        <span>
                            #{{ $refundRequest->id }}
                        </span>
                    </div>

                    <div class="refund-request-show-header__main">
                        <div>
                            <h1>
                                Refund Request #{{ $refundRequest->id }}
                            </h1>

                            <p>
                                Review the customer's refund request and take the appropriate action.
                            </p>
                        </div>

                        @php
                            $statusClass = match ($refundRequest->status) {
                                'pending' => 'pending',
                                'approved' => 'approved',
                                'rejected' => 'rejected',
                                default => 'default',
                            };
                        @endphp

                        <span class="refund-request-show-status refund-request-show-status--{{ $statusClass }}">
                            <i class="fa-light fa-circle"></i>

                            {{ ucfirst($refundRequest->status) }}
                        </span>
                    </div>
                </div>

                <div class="refund-request-show-header__actions">
                    <a
                        href="{{ route('admin-ecommerce-payment-refund-requests') }}"
                        class="refund-request-show-button refund-request-show-button--secondary"
                    >
                        <i class="fa-light fa-arrow-left"></i>
                        <span>Back to Requests</span>
                    </a>

                    @if($refundRequest->order)
                        <a
                            href="{{ route(
                                'admin-ecommerce-payment-show',
                                ['order' => $refundRequest->order]
                            ) }}"
                            class="refund-request-show-button refund-request-show-button--secondary"
                        >
                            <i class="fa-light fa-receipt"></i>
                            <span>View Order</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Main Layout --}}
            <div class="refund-request-show-layout">

                {{-- Main Content --}}
                <div class="refund-request-show-main">

                    {{-- Refund Summary --}}
                    <section class="refund-request-show-card">
                        <div class="refund-request-show-card__header">
                            <div>
                                <h2>Refund Summary</h2>
                                <p>Financial details of this refund request.</p>
                            </div>
                        </div>

                        <div class="refund-request-summary">
                            <div class="refund-request-summary__item refund-request-summary__item--highlight">
                                <span class="refund-request-summary__label">
                                    Requested Amount
                                </span>

                                <strong class="refund-request-summary__value">
                                    {{ $refundRequest->order?->currency ?? 'USD' }}
                                    {{ number_format((float) $refundRequest->amount, 2) }}
                                </strong>
                            </div>

                            <div class="refund-request-summary__item">
                                <span class="refund-request-summary__label">
                                    Deduction
                                </span>

                                <strong class="refund-request-summary__value">
                                    {{ $refundRequest->order?->currency ?? 'USD' }}
                                    {{ number_format((float) $refundRequest->deduction_amount, 2) }}
                                </strong>
                            </div>

                            <div class="refund-request-summary__item refund-request-summary__item--final">
                                <span class="refund-request-summary__label">
                                    Final Refund Amount
                                </span>

                                <strong class="refund-request-summary__value">
                                    {{ $refundRequest->order?->currency ?? 'USD' }}
                                    {{ number_format($refundRequest->finalRefundAmount(), 2) }}
                                </strong>
                            </div>
                        </div>

                        @if($refundRequest->hasDeduction())
                            <div class="refund-request-deduction">
                                <div class="refund-request-deduction__icon">
                                    <i class="fa-light fa-circle-info"></i>
                                </div>

                                <div class="refund-request-deduction__content">
                                    <strong>Deduction applied</strong>

                                    <p>
                                        {{ $refundRequest->deduction_reason ?: 'No deduction reason provided.' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </section>

                    {{-- Customer Reason --}}
                    <section class="refund-request-show-card">
                        <div class="refund-request-show-card__header">
                            <div>
                                <h2>Refund Reason</h2>
                                <p>Information submitted by the customer.</p>
                            </div>
                        </div>

                        <div class="refund-request-reason">
                            <div class="refund-request-reason__field">
                                <span class="refund-request-reason__label">
                                    Reason
                                </span>

                                <div class="refund-request-reason__value">
                                    {{ $refundRequest->reason ?: 'No reason provided.' }}
                                </div>
                            </div>

                            <div class="refund-request-reason__field">
                                <span class="refund-request-reason__label">
                                    Customer Message
                                </span>

                                <div class="refund-request-reason__message">
                                    @if($refundRequest->message)
                                        {{ $refundRequest->message }}
                                    @else
                                        <span>No additional message provided.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Order Items --}}
                    @if($refundRequest->order?->items?->count())
                        <section class="refund-request-show-card">
                            <div class="refund-request-show-card__header">
                                <div>
                                    <h2>Order Items</h2>
                                    <p>Products included in the original order.</p>
                                </div>

                                <a
                                    href="{{ route(
                                        'admin-ecommerce-payment-show',
                                        ['order' => $refundRequest->order]
                                    ) }}"
                                    class="refund-request-show-link"
                                >
                                    View Order
                                    <i class="fa-light fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>

                            <div class="refund-request-items">
                                @foreach($refundRequest->order->items as $item)
                                    <div class="refund-request-item">
                                        <div class="refund-request-item__image">
                                            @if($item->image)
                                                <img
                                                    src="{{ asset( $item->image) }}"
                                                    alt="{{ $item->product_name }}"
                                                >
                                            @else
                                                <div class="refund-request-item__placeholder">
                                                    <i class="fa-light fa-image"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="refund-request-item__content">
                                            <strong>
                                                {{ $item->product_name }}
                                            </strong>

                                            @if($item->sku)
                                                <span>
                                                    SKU: {{ $item->sku }}
                                                </span>
                                            @endif

                                            <span>
                                                Quantity: {{ $item->quantity }}
                                            </span>
                                        </div>

                                        <div class="refund-request-item__price">
                                            <strong>
                                                {{ $refundRequest->order->currency ?? 'USD' }}
                                                {{ number_format((float) $item->line_total, 2) }}
                                            </strong>

                                            <span>
                                                {{ number_format((float) $item->unit_price, 2) }}
                                                × {{ $item->quantity }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Previous Refunds --}}
                    @if($refundRequest->order?->refunds?->count())
                        <section class="refund-request-show-card">
                            <div class="refund-request-show-card__header">
                                <div>
                                    <h2>Refund History</h2>
                                    <p>Previous refund transactions for this order.</p>
                                </div>
                            </div>

                            <div class="refund-request-refunds">
                                @foreach($refundRequest->order->refunds as $refund)
                                    <div class="refund-request-refund">
                                        <div class="refund-request-refund__icon">
                                            <i class="fa-light fa-rotate-left"></i>
                                        </div>

                                        <div class="refund-request-refund__content">
                                            <strong>
                                                {{ $refund->stripe_refund_id ?: 'Refund #' . $refund->id }}
                                            </strong>

                                            <span>
                                                {{ $refund->created_at?->format('M d, Y h:i A') }}
                                            </span>
                                        </div>

                                        <div class="refund-request-refund__amount">
                                            <strong>
                                                {{ $refund->currency }}
                                                {{ number_format((float) $refund->amount, 2) }}
                                            </strong>

                                            <span class="refund-request-refund__status refund-request-refund__status--{{ $refund->status }}">
                                                {{ ucfirst($refund->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Admin Note --}}
                    @if($refundRequest->admin_note)
                        <section class="refund-request-show-card">
                            <div class="refund-request-show-card__header">
                                <div>
                                    <h2>Admin Note</h2>
                                    <p>Internal note associated with this request.</p>
                                </div>
                            </div>

                            <div class="refund-request-admin-note">
                                {{ $refundRequest->admin_note }}
                            </div>
                        </section>
                    @endif

                </div>

                {{-- Sidebar --}}
                <aside class="refund-request-show-sidebar">

                    {{-- Action Card --}}
                    @if($refundRequest->isPending())
                        <section class="refund-request-action-card">
                            <div class="refund-request-action-card__header">
                                <div class="refund-request-action-card__icon">
                                    <i class="fa-light fa-shield-check"></i>
                                </div>

                                <div>
                                    <h2>Review Request</h2>

                                    <p>
                                        This request is waiting for your decision.
                                    </p>
                                </div>
                            </div>

                            <div class="refund-request-action-card__amount">
                                <span>Refund amount</span>

                                <strong>
                                    {{ $refundRequest->order?->currency ?? 'USD' }}
                                    {{ number_format($refundRequest->finalRefundAmount(), 2) }}
                                </strong>
                            </div>

                            <div class="refund-request-action-card__actions">
                                <button
                                    type="button"
                                    class="refund-request-action-button refund-request-action-button--approve"
                                    data-refund-action="approve"
                                    data-refund-request-id="{{ $refundRequest->id }}"
                                >
                                    <i class="fa-light fa-circle-check"></i>
                                    <span>Approve Request</span>
                                </button>

                                <button
                                    type="button"
                                    class="refund-request-action-button refund-request-action-button--reject"
                                    data-refund-action="reject"
                                    data-refund-request-id="{{ $refundRequest->id }}"
                                >
                                    <i class="fa-light fa-circle-xmark"></i>
                                    <span>Reject Request</span>
                                </button>
                            </div>
                        </section>
                    @else
                        <section class="refund-request-status-card">
                            <div class="refund-request-status-card__icon refund-request-status-card__icon--{{ $statusClass }}">
                                @if($refundRequest->isApproved())
                                    <i class="fa-light fa-circle-check"></i>
                                @elseif($refundRequest->isRejected())
                                    <i class="fa-light fa-circle-xmark"></i>
                                @else
                                    <i class="fa-light fa-circle-info"></i>
                                @endif
                            </div>

                            <h2>
                                Request {{ ucfirst($refundRequest->status) }}
                            </h2>

                            <p>
                                This refund request has already been reviewed.
                            </p>

                            @if($refundRequest->approved_at)
                                <span>
                                    Reviewed {{ $refundRequest->approved_at->format('M d, Y h:i A') }}
                                </span>
                            @endif
                        </section>
                    @endif

                    {{-- Request Information --}}
                    <section class="refund-request-info-card">
                        <div class="refund-request-info-card__header">
                            <h2>Request Information</h2>
                        </div>

                        <div class="refund-request-info-list">
                            <div class="refund-request-info-row">
                                <span>Request ID</span>

                                <strong>
                                    #{{ $refundRequest->id }}
                                </strong>
                            </div>

                            <div class="refund-request-info-row">
                                <span>Requested</span>

                                <strong>
                                    {{ $refundRequest->created_at?->format('M d, Y') }}
                                </strong>
                            </div>

                            <div class="refund-request-info-row">
                                <span>Time</span>

                                <strong>
                                    {{ $refundRequest->created_at?->format('h:i A') }}
                                </strong>
                            </div>

                            <div class="refund-request-info-row">
                                <span>Status</span>

                                <span class="refund-request-info-status refund-request-info-status--{{ $statusClass }}">
                                    {{ ucfirst($refundRequest->status) }}
                                </span>
                            </div>

                            @if($refundRequest->approved_at)
                                <div class="refund-request-info-row">
                                    <span>Reviewed At</span>

                                    <strong>
                                        {{ $refundRequest->approved_at->format('M d, Y') }}
                                    </strong>
                                </div>
                            @endif
                        </div>
                    </section>

                    {{-- Customer --}}
                    <section class="refund-request-customer-card">
                        <div class="refund-request-customer-card__header">
                            <h2>Customer</h2>
                        </div>

                        @php
                            $customerName = trim(
                                ($refundRequest->requester?->first_name ?? $refundRequest->order?->first_name ?? '')
                                . ' '
                                . ($refundRequest->requester?->last_name ?? $refundRequest->order?->last_name ?? '')
                            );

                            if ($customerName === '') {
                                $customerName = $refundRequest->requester?->name
                                    ?? $refundRequest->order?->email
                                    ?? 'Customer';
                            }
                        @endphp

                        <div class="refund-request-customer">
                            <div class="refund-request-customer__avatar">
                                {{ strtoupper(mb_substr($customerName, 0, 1)) }}
                            </div>

                            <div class="refund-request-customer__content">
                                <strong>
                                    {{ $customerName }}
                                </strong>

                                @if($refundRequest->order?->email)
                                    <span>
                                        {{ $refundRequest->order->email }}
                                    </span>
                                @endif

                                @if($refundRequest->order?->phone)
                                    <span>
                                        {{ $refundRequest->order->phone }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </section>

                    {{-- Order --}}
                    @if($refundRequest->order)
                        <section class="refund-request-order-card">
                            <div class="refund-request-order-card__header">
                                <h2>Order</h2>

                                <a
                                    href="{{ route(
                                        'admin-ecommerce-payment-show',
                                        ['order' => $refundRequest->order]
                                    ) }}"
                                    title="View order"
                                    aria-label="View order"
                                >
                                    <i class="fa-light fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>

                            <div class="refund-request-order-card__number">
                                {{ $refundRequest->order->order_number }}
                            </div>

                            <div class="refund-request-order-card__details">
                                <div>
                                    <span>Total</span>

                                    <strong>
                                        {{ $refundRequest->order->currency }}
                                        {{ number_format((float) $refundRequest->order->total, 2) }}
                                    </strong>
                                </div>

                                <div>
                                    <span>Payment</span>

                                    <strong>
                                        {{ ucfirst($refundRequest->order->payment_status) }}
                                    </strong>
                                </div>

                                <div>
                                    <span>Gateway</span>

                                    <strong>
                                        {{ ucfirst($refundRequest->order->payment_gateway ?? 'N/A') }}
                                    </strong>
                                </div>
                            </div>
                        </section>
                    @endif

                </aside>
            </div>
        </div>

        {{-- Confirmation Modal --}}
        <div
            class="refund-request-confirm-modal"
            data-refund-confirm-modal
            aria-hidden="true"
        >
            <div
                class="refund-request-confirm-modal__overlay"
                data-refund-modal-close
            ></div>

            <div
                class="refund-request-confirm-modal__dialog"
                role="dialog"
                aria-modal="true"
                aria-labelledby="refund-request-confirm-title"
            >
                <button
                    type="button"
                    class="refund-request-confirm-modal__close"
                    data-refund-modal-close
                    aria-label="Close"
                >
                    <i class="fa-light fa-xmark"></i>
                </button>

                <div class="refund-request-confirm-modal__icon" data-refund-modal-icon>
                    <i class="fa-light fa-circle-question"></i>
                </div>

                <h2 id="refund-request-confirm-title">
                    Confirm Action
                </h2>

                <p data-refund-modal-message>
                    Are you sure you want to continue?
                </p>

                <form
                    method="POST"
                    action=""
                    data-refund-action-form
                >
                    @csrf

                    <textarea
                        name="admin_note"
                        rows="4"
                        placeholder="Add an optional admin note..."
                        data-refund-admin-note
                    ></textarea>

                    <div class="refund-request-confirm-modal__actions">
                        <button
                            type="button"
                            class="refund-request-show-button refund-request-show-button--secondary"
                            data-refund-modal-close
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="refund-request-show-button refund-request-show-button--primary"
                            data-refund-confirm-submit
                        >
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            'use strict';

            const page = document.querySelector(
                '.ecommerce-refund-request-show-page'
            );

            if (!page) {
                return;
            }

            const modal = page.querySelector(
                '[data-refund-confirm-modal]'
            );

            const modalMessage = page.querySelector(
                '[data-refund-modal-message]'
            );

            const modalIcon = page.querySelector(
                '[data-refund-modal-icon]'
            );

            const actionForm = page.querySelector(
                '[data-refund-action-form]'
            );

            const adminNote = page.querySelector(
                '[data-refund-admin-note]'
            );

            const confirmButton = page.querySelector(
                '[data-refund-confirm-submit]'
            );

            const actionButtons = page.querySelectorAll(
                '[data-refund-action]'
            );

            if (!modal || !actionForm) {
                return;
            }

            let currentAction = null;

            const getActionUrl = (action) => {
                const baseUrl = @json(
                    route(
                        'admin-ecommerce-payment-refund-request-show',
                        ['refundRequest' => $refundRequest]
                    )
                );

                return `${baseUrl}/${action}`;
            };

            const openModal = (action) => {
                currentAction = action;

                const isApprove = action === 'approve';

                if (modalMessage) {
                    modalMessage.textContent = isApprove
                        ? 'Are you sure you want to approve this refund request?'
                        : 'Are you sure you want to reject this refund request?';
                }

                if (modalIcon) {
                    modalIcon.classList.toggle(
                        'is-approve',
                        isApprove
                    );

                    modalIcon.classList.toggle(
                        'is-reject',
                        !isApprove
                    );

                    modalIcon.innerHTML = isApprove
                        ? '<i class="fa-light fa-circle-check"></i>'
                        : '<i class="fa-light fa-circle-xmark"></i>';
                }

                if (confirmButton) {
                    confirmButton.textContent = isApprove
                        ? 'Approve Request'
                        : 'Reject Request';

                    confirmButton.classList.toggle(
                        'is-approve',
                        isApprove
                    );

                    confirmButton.classList.toggle(
                        'is-reject',
                        !isApprove
                    );
                }

                actionForm.action = getActionUrl(action);

                if (adminNote) {
                    adminNote.value = '';
                }

                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');

                document.body.classList.add(
                    'refund-request-modal-open'
                );

                adminNote?.focus();
            };

            const closeModal = () => {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');

                document.body.classList.remove(
                    'refund-request-modal-open'
                );

                currentAction = null;
            };

            actionButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const action = button.dataset.refundAction;

                    if (
                        action !== 'approve'
                        && action !== 'reject'
                    ) {
                        return;
                    }

                    openModal(action);
                });
            });

            page.querySelectorAll(
                '[data-refund-modal-close]'
            ).forEach((element) => {
                element.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', (event) => {
                if (
                    event.key === 'Escape'
                    && modal.classList.contains('is-open')
                ) {
                    closeModal();
                }
            });

            actionForm.addEventListener('submit', () => {
                if (!confirmButton) {
                    return;
                }

                confirmButton.disabled = true;
                confirmButton.classList.add('is-loading');

                confirmButton.innerHTML = `
                    <i class="fa-light fa-spinner"></i>
                    <span>
                        ${currentAction === 'approve'
                    ? 'Approving...'
                    : 'Rejecting...'}
                    </span>
                `;
            });
        })();
    </script>
@endpush
