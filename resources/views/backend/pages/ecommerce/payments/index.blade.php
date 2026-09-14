@extends('backend.layouts.backend')

@section('title', 'Payments')

@section('content')
    <div class="ecommerce-payments-page">
        <div class="ecommerce-payments-page__header">
            <div class="ecommerce-payments-page__heading">
                <div class="ecommerce-payments-page__breadcrumb">
                    <a href="{{ route('dashboard') }}">
                        E-commerce
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>Payments</span>
                </div>

                <h1 class="ecommerce-payments-page__title">
                    Payments
                </h1>

                <p class="ecommerce-payments-page__subtitle">
                    Track customer payments, transactions, and refund status.
                </p>
            </div>

            <a
                href="{{ route('admin-ecommerce-payment-refund-requests') }}"
                class="ecommerce-payments-page__refund-button"
            >
                <i class="fa-solid fa-rotate-left"></i>
                <span>Refund Requests</span>
            </a>
        </div>

        <div class="ecommerce-payments-page__stats">
            <div class="ecommerce-payments-page__stat">
                <div class="ecommerce-payments-page__stat-icon">
                    <i class="fa-solid fa-wallet"></i>
                </div>

                <div class="ecommerce-payments-page__stat-content">
                    <span>Total Payments</span>
                    <strong>{{ number_format($stats['totalPayments']) }}</strong>
                </div>
            </div>

            <div class="ecommerce-payments-page__stat">
                <div class="ecommerce-payments-page__stat-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div class="ecommerce-payments-page__stat-content">
                    <span>Paid</span>
                    <strong>{{ number_format($stats['paidPayments']) }}</strong>
                </div>
            </div>

            <div class="ecommerce-payments-page__stat">
                <div class="ecommerce-payments-page__stat-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div class="ecommerce-payments-page__stat-content">
                    <span>Pending</span>
                    <strong>{{ number_format($stats['pendingPayments']) }}</strong>
                </div>
            </div>

            <div class="ecommerce-payments-page__stat">
                <div class="ecommerce-payments-page__stat-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>

                <div class="ecommerce-payments-page__stat-content">
                    <span>Failed</span>
                    <strong>{{ number_format($stats['failedPayments']) }}</strong>
                </div>
            </div>

            <div class="ecommerce-payments-page__stat">
                <div class="ecommerce-payments-page__stat-icon">
                    <i class="fa-solid fa-rotate-left"></i>
                </div>

                <div class="ecommerce-payments-page__stat-content">
                    <span>Refunded</span>
                    <strong>{{ number_format($stats['refundedPayments']) }}</strong>
                </div>
            </div>

            <div class="ecommerce-payments-page__stat ecommerce-payments-page__stat--revenue">
                <div class="ecommerce-payments-page__stat-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

                <div class="ecommerce-payments-page__stat-content">
                    <span>Paid Revenue</span>
                    <strong>
                        ${{ number_format($stats['paidRevenue'], 2) }}
                    </strong>
                </div>
            </div>
        </div>

        <div class="ecommerce-payments-page__filters">
            <form
                action="{{ route('admin-ecommerce-payments') }}"
                method="GET"
                class="ecommerce-payments-page__filter-form"
            >
                <div class="ecommerce-payments-page__search">
                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search order, customer or transaction..."
                    >
                </div>

                <div class="ecommerce-payments-page__filter">
                    <label for="payment-status">
                        Payment Status
                    </label>

                    <select
                        id="payment-status"
                        name="payment_status"
                    >
                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="{{ \App\Models\Order::PAYMENT_STATUS_PAID }}"
                            @selected(request('payment_status') === \App\Models\Order::PAYMENT_STATUS_PAID)
                        >
                            Paid
                        </option>

                        <option
                            value="{{ \App\Models\Order::PAYMENT_STATUS_PENDING }}"
                            @selected(request('payment_status') === \App\Models\Order::PAYMENT_STATUS_PENDING)
                        >
                            Pending
                        </option>

                        <option
                            value="{{ \App\Models\Order::PAYMENT_STATUS_FAILED }}"
                            @selected(request('payment_status') === \App\Models\Order::PAYMENT_STATUS_FAILED)
                        >
                            Failed
                        </option>
                    </select>
                </div>

                <div class="ecommerce-payments-page__filter">
                    <label for="refund-status">
                        Refund Status
                    </label>

                    <select
                        id="refund-status"
                        name="refund_status"
                    >
                        <option value="">
                            All Refunds
                        </option>

                        <option
                            value="{{ \App\Models\Order::REFUND_STATUS_NONE }}"
                            @selected(request('refund_status') === \App\Models\Order::REFUND_STATUS_NONE)
                        >
                            No Refund
                        </option>

                        <option
                            value="{{ \App\Models\Order::REFUND_STATUS_PENDING }}"
                            @selected(request('refund_status') === \App\Models\Order::REFUND_STATUS_PENDING)
                        >
                            Pending
                        </option>

                        <option
                            value="{{ \App\Models\Order::REFUND_STATUS_APPROVED }}"
                            @selected(request('refund_status') === \App\Models\Order::REFUND_STATUS_APPROVED)
                        >
                            Approved
                        </option>

                        <option
                            value="{{ \App\Models\Order::REFUND_STATUS_REJECTED }}"
                            @selected(request('refund_status') === \App\Models\Order::REFUND_STATUS_REJECTED)
                        >
                            Rejected
                        </option>

                        <option
                            value="{{ \App\Models\Order::REFUND_STATUS_REFUNDED }}"
                            @selected(request('refund_status') === \App\Models\Order::REFUND_STATUS_REFUNDED)
                        >
                            Refunded
                        </option>
                    </select>
                </div>

                <div class="ecommerce-payments-page__filter">
                    <label for="payment-gateway">
                        Gateway
                    </label>

                    <input
                        type="text"
                        id="payment-gateway"
                        name="payment_gateway"
                        value="{{ request('payment_gateway') }}"
                        placeholder="e.g. stripe"
                    >
                </div>

                <div class="ecommerce-payments-page__filter ecommerce-payments-page__filter--date">
                    <label for="date-from">
                        From
                    </label>

                    <input
                        type="date"
                        id="date-from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                    >
                </div>

                <div class="ecommerce-payments-page__filter ecommerce-payments-page__filter--date">
                    <label for="date-to">
                        To
                    </label>

                    <input
                        type="date"
                        id="date-to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                    >
                </div>

                <div class="ecommerce-payments-page__filter-actions">
                    <button
                        type="submit"
                        class="ecommerce-payments-page__apply"
                    >
                        <i class="fa-solid fa-filter"></i>
                        <span>Apply</span>
                    </button>

                    <a
                        href="{{ route('admin-ecommerce-payments') }}"
                        class="ecommerce-payments-page__reset"
                        data-reset-filters
                    >
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="ecommerce-payments-page__table-card">
            <div class="ecommerce-payments-page__table-header">
                <div>
                    <h2>
                        Payment Transactions
                    </h2>

                    <p>
                        {{ $payments->total() }}
                        {{ Str::plural('payment', $payments->total()) }}
                        found
                    </p>
                </div>
            </div>

            @if ($payments->isNotEmpty())
                <div class="ecommerce-payments-page__table-wrapper">
                    <table class="ecommerce-payments-page__table">
                        <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Gateway</th>
                            <th>Transaction</th>
                            <th>Payment</th>
                            <th>Refund</th>
                            <th>Paid At</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($payments as $payment)
                            @php
                                $customerName = trim(
                                    $payment->first_name . ' ' . $payment->last_name
                                );

                                $transactionId = $payment->stripe_payment_intent_id
                                    ?: $payment->stripe_checkout_session_id;

                                $paymentStatusClass = match ($payment->payment_status) {
                                    \App\Models\Order::PAYMENT_STATUS_PAID => 'paid',
                                    \App\Models\Order::PAYMENT_STATUS_FAILED => 'failed',
                                    default => 'pending',
                                };

                                $refundStatusClass = match ($payment->refund_status) {
                                    \App\Models\Order::REFUND_STATUS_REFUNDED => 'refunded',
                                    \App\Models\Order::REFUND_STATUS_PENDING => 'pending',
                                    \App\Models\Order::REFUND_STATUS_APPROVED => 'approved',
                                    \App\Models\Order::REFUND_STATUS_REJECTED => 'rejected',
                                    default => 'none',
                                };
                            @endphp

                            <tr>
                                <td>
                                    <a
                                        href="{{ route('admin-ecommerce-payment-show', [
                                                'order' => $payment,
                                            ]) }}"
                                        class="ecommerce-payments-page__order"
                                    >
                                        #{{ $payment->order_number }}
                                    </a>
                                </td>

                                <td>
                                    <div class="ecommerce-payments-page__customer">
                                        <div class="ecommerce-payments-page__customer-avatar">
                                            {{ strtoupper(
                                                mb_substr(
                                                    $customerName ?: $payment->email ?: 'C',
                                                    0,
                                                    1,
                                                )
                                            ) }}
                                        </div>

                                        <div class="ecommerce-payments-page__customer-info">
                                            <strong>
                                                {{ $customerName ?: 'Customer' }}
                                            </strong>

                                            <span>
                                                    {{ $payment->email }}
                                                </span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="ecommerce-payments-page__amount">
                                        <strong>
                                            {{ strtoupper($payment->currency) }}
                                            {{ number_format((float) $payment->total, 2) }}
                                        </strong>
                                    </div>
                                </td>

                                <td>
                                        <span class="ecommerce-payments-page__gateway">
                                            {{ $payment->payment_gateway ?: '—' }}
                                        </span>
                                </td>

                                <td>
                                    @if ($transactionId)
                                        <button
                                            type="button"
                                            class="ecommerce-payments-page__transaction"
                                            data-copy-transaction
                                            data-transaction="{{ $transactionId }}"
                                            title="Copy transaction ID"
                                        >
                                                <span>
                                                    {{ \Illuminate\Support\Str::limit(
                                                        $transactionId,
                                                        20,
                                                        '...'
                                                    ) }}
                                                </span>

                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    @else
                                        <span class="ecommerce-payments-page__muted">
                                                —
                                            </span>
                                    @endif
                                </td>

                                <td>
                                        <span
                                            class="ecommerce-payments-page__status ecommerce-payments-page__status--{{ $paymentStatusClass }}"
                                        >
                                            <i class="fa-solid fa-circle"></i>

                                            @if ($payment->payment_status === \App\Models\Order::PAYMENT_STATUS_PAID)
                                                Paid
                                            @elseif ($payment->payment_status === \App\Models\Order::PAYMENT_STATUS_FAILED)
                                                Failed
                                            @else
                                                Pending
                                            @endif
                                        </span>
                                </td>

                                <td>
                                        <span
                                            class="ecommerce-payments-page__status ecommerce-payments-page__status--refund-{{ $refundStatusClass }}"
                                        >
                                            @switch($payment->refund_status)
                                                @case(\App\Models\Order::REFUND_STATUS_PENDING)
                                                    Pending
                                                    @break

                                                @case(\App\Models\Order::REFUND_STATUS_APPROVED)
                                                    Approved
                                                    @break

                                                @case(\App\Models\Order::REFUND_STATUS_REJECTED)
                                                    Rejected
                                                    @break

                                                @case(\App\Models\Order::REFUND_STATUS_REFUNDED)
                                                    Refunded
                                                    @break

                                                @default
                                                    No Refund
                                            @endswitch
                                        </span>
                                </td>

                                <td>
                                        <span class="ecommerce-payments-page__date">
                                            {{ $payment->paid_at?->format('M d, Y') ?: '—' }}
                                        </span>
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin-ecommerce-payment-show', [
                                                'order' => $payment,
                                            ]) }}"
                                        class="ecommerce-payments-page__view"
                                        title="View payment"
                                        aria-label="View payment"
                                    >
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                {{ $payments->links('backend.components.pagination') }}

            @else
                <div class="ecommerce-payments-page__empty">
                    <div class="ecommerce-payments-page__empty-icon">
                        <i class="fa-solid fa-receipt"></i>
                    </div>

                    <h2>
                        No Payments Found
                    </h2>

                    <p>
                        No payment transactions match your current filters.
                    </p>

                    <a
                        href="{{ route('admin-ecommerce-payments') }}"
                        class="ecommerce-payments-page__empty-button"
                    >
                        Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector(
                '.ecommerce-payments-page'
            );

            if (!page) {
                return;
            }

            const transactionButtons = page.querySelectorAll(
                '[data-copy-transaction]'
            );

            transactionButtons.forEach((button) => {
                button.addEventListener('click', async () => {
                    const transaction = button.dataset.transaction;

                    if (!transaction) {
                        return;
                    }

                    try {
                        await navigator.clipboard.writeText(
                            transaction
                        );

                        const icon = button.querySelector('i');

                        if (!icon) {
                            return;
                        }

                        icon.classList.remove(
                            'fa-copy'
                        );

                        icon.classList.add(
                            'fa-check'
                        );

                        button.classList.add(
                            'is-copied'
                        );

                        window.setTimeout(() => {
                            icon.classList.remove(
                                'fa-check'
                            );

                            icon.classList.add(
                                'fa-copy'
                            );

                            button.classList.remove(
                                'is-copied'
                            );
                        }, 1500);
                    } catch {
                        return;
                    }
                });
            });

            const filterForm = page.querySelector(
                '.ecommerce-payments-page__filter-form'
            );

            if (filterForm) {
                filterForm.addEventListener('submit', () => {
                    const applyButton = filterForm.querySelector(
                        '.ecommerce-payments-page__apply'
                    );

                    if (!applyButton) {
                        return;
                    }

                    applyButton.disabled = true;

                    const icon = applyButton.querySelector('i');
                    const text = applyButton.querySelector('span');

                    if (icon) {
                        icon.className =
                            'fa-solid fa-spinner fa-spin';
                    }

                    if (text) {
                        text.textContent = 'Applying';
                    }
                });
            }

            const resetButton = page.querySelector(
                '[data-reset-filters]'
            );

            if (resetButton) {
                resetButton.addEventListener('click', () => {
                    resetButton.classList.add(
                        'is-loading'
                    );
                });
            }
        });
    </script>
@endpush
