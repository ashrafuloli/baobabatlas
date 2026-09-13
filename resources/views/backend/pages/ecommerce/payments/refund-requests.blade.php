@extends('backend.layouts.backend')

@section('title', 'Refund Requests')

@section('content')
    <div class="ecommerce-refund-requests-page">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="refund-requests-header">
                <div class="refund-requests-header__content">
                    <div class="refund-requests-header__breadcrumb">
                        <a href="{{ route('admin-ecommerce-payments') }}">
                            Payments
                        </a>

                        <span class="refund-requests-header__separator">/</span>

                        <span>Refund Requests</span>
                    </div>

                    <h1 class="refund-requests-header__title">
                        Refund Requests
                    </h1>

                    <p class="refund-requests-header__description">
                        Review, approve, reject, and manage customer refund requests.
                    </p>
                </div>

                <div class="refund-requests-header__actions">
                    <a
                        href="{{ route('admin-ecommerce-payments') }}"
                        class="refund-requests-button refund-requests-button--secondary"
                    >
                        <i class="fa-light fa-arrow-left"></i>
                        <span>Back to Payments</span>
                    </a>
                </div>
            </div>

            {{-- Statistics --}}
            <div class="refund-requests-stats">
                <div class="refund-requests-stat-card">
                    <div class="refund-requests-stat-card__icon">
                        <i class="fa-light fa-rotate-left"></i>
                    </div>

                    <div class="refund-requests-stat-card__content">
                        <span class="refund-requests-stat-card__label">
                            Total Requests
                        </span>

                        <strong class="refund-requests-stat-card__value">
                            {{ $stats['total'] ?? $refundRequests->total() }}
                        </strong>
                    </div>
                </div>

                <div class="refund-requests-stat-card refund-requests-stat-card--pending">
                    <div class="refund-requests-stat-card__icon">
                        <i class="fa-light fa-clock"></i>
                    </div>

                    <div class="refund-requests-stat-card__content">
                        <span class="refund-requests-stat-card__label">
                            Pending
                        </span>

                        <strong class="refund-requests-stat-card__value">
                            {{ $stats['pending'] ?? 0 }}
                        </strong>
                    </div>
                </div>

                <div class="refund-requests-stat-card refund-requests-stat-card--approved">
                    <div class="refund-requests-stat-card__icon">
                        <i class="fa-light fa-circle-check"></i>
                    </div>

                    <div class="refund-requests-stat-card__content">
                        <span class="refund-requests-stat-card__label">
                            Approved
                        </span>

                        <strong class="refund-requests-stat-card__value">
                            {{ $stats['approved'] ?? 0 }}
                        </strong>
                    </div>
                </div>

                <div class="refund-requests-stat-card refund-requests-stat-card--rejected">
                    <div class="refund-requests-stat-card__icon">
                        <i class="fa-light fa-circle-xmark"></i>
                    </div>

                    <div class="refund-requests-stat-card__content">
                        <span class="refund-requests-stat-card__label">
                            Rejected
                        </span>

                        <strong class="refund-requests-stat-card__value">
                            {{ $stats['rejected'] ?? 0 }}
                        </strong>
                    </div>
                </div>
            </div>

            {{-- Main Card --}}
            <div class="refund-requests-card">
                {{-- Toolbar --}}
                <div class="refund-requests-toolbar">
                    <div class="refund-requests-toolbar__left">
                        <div class="refund-requests-toolbar__title">
                            <h2>All Refund Requests</h2>

                            <span class="refund-requests-toolbar__count">
                                {{ $refundRequests->total() }}
                            </span>
                        </div>
                    </div>

                    <form
                        method="GET"
                        action="{{ route('admin-ecommerce-payment-refund-requests') }}"
                        class="refund-requests-filter"
                        data-refund-filter
                    >
                        <div class="refund-requests-filter__search">
                            <i class="fa-light fa-magnifying-glass"></i>

                            <input
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search order, customer..."
                                autocomplete="off"
                            >
                        </div>

                        <div class="refund-requests-filter__select">
                            <select name="status">
                                <option value="">All Statuses</option>

                                <option
                                    value="pending"
                                    @selected(request('status') === 'pending')
                                >
                                    Pending
                                </option>

                                <option
                                    value="approved"
                                    @selected(request('status') === 'approved')
                                >
                                    Approved
                                </option>

                                <option
                                    value="rejected"
                                    @selected(request('status') === 'rejected')
                                >
                                    Rejected
                                </option>
                            </select>

                            <i class="fa-light fa-chevron-down"></i>
                        </div>

                        <button
                            type="submit"
                            class="refund-requests-button refund-requests-button--primary"
                        >
                            <i class="fa-light fa-filter"></i>
                            <span>Filter</span>
                        </button>

                        @if(request()->filled('search') || request()->filled('status'))
                            <a
                                href="{{ route('admin-ecommerce-payment-refund-requests') }}"
                                class="refund-requests-filter__clear"
                                title="Clear filters"
                            >
                                <i class="fa-light fa-xmark"></i>
                                <span>Clear</span>
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="refund-requests-table-wrapper">
                    @if($refundRequests->count())
                        <table class="refund-requests-table">
                            <thead>
                            <tr>
                                <th>
                                    <span>Request</span>
                                </th>

                                <th>
                                    <span>Order</span>
                                </th>

                                <th>
                                    <span>Customer</span>
                                </th>

                                <th>
                                    <span>Amount</span>
                                </th>

                                <th>
                                    <span>Reason</span>
                                </th>

                                <th>
                                    <span>Status</span>
                                </th>

                                <th>
                                    <span>Requested</span>
                                </th>

                                <th>
                                    <span>Action</span>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($refundRequests as $refundRequest)
                                @php
                                    $order = $refundRequest->order;
                                    $requester = $refundRequest->requester;

                                    $statusClass = match ($refundRequest->status) {
                                        'pending' => 'pending',
                                        'approved' => 'approved',
                                        'rejected' => 'rejected',
                                        default => 'default',
                                    };

                                    $statusLabel = ucfirst($refundRequest->status);

                                    $customerName = trim(
                                        ($requester?->first_name ?? $order?->first_name ?? '')
                                        . ' '
                                        . ($requester?->last_name ?? $order?->last_name ?? '')
                                    );

                                    if ($customerName === '') {
                                        $customerName = $requester?->name
                                            ?? $order?->email
                                            ?? 'Unknown customer';
                                    }
                                @endphp

                                <tr data-refund-request-row>
                                    <td data-label="Request">
                                        <div class="refund-request-reference">
                                                <span class="refund-request-reference__icon">
                                                    <i class="fa-light fa-rotate-left"></i>
                                                </span>

                                            <div class="refund-request-reference__content">
                                                <strong>
                                                    #{{ $refundRequest->id }}
                                                </strong>

                                                <span>
                                                        Refund Request
                                                    </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td data-label="Order">
                                        @if($order)
                                            <a
                                                href="{{ route('admin-ecommerce-payment-show', ['order' => $order]) }}"
                                                class="refund-request-order"
                                            >
                                                <strong>
                                                    {{ $order->order_number }}
                                                </strong>

                                                <i class="fa-light fa-arrow-up-right-from-square"></i>
                                            </a>
                                        @else
                                            <span class="refund-requests-muted">
                                                    Order unavailable
                                                </span>
                                        @endif
                                    </td>

                                    <td data-label="Customer">
                                        <div class="refund-request-customer">
                                                <span class="refund-request-customer__avatar">
                                                    {{ strtoupper(mb_substr($customerName, 0, 1)) }}
                                                </span>

                                            <div class="refund-request-customer__content">
                                                <strong>
                                                    {{ $customerName }}
                                                </strong>

                                                @if($order?->email)
                                                    <span>
                                                            {{ $order->email }}
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td data-label="Amount">
                                        <div class="refund-request-amount">
                                            <strong>
                                                {{ number_format((float) $refundRequest->amount, 2) }}
                                            </strong>

                                            @if($refundRequest->hasDeduction())
                                                <span>
                                                        -
                                                        {{ number_format((float) $refundRequest->deduction_amount, 2) }}
                                                        deduction
                                                    </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td data-label="Reason">
                                        <div class="refund-request-reason">
                                            <strong>
                                                {{ \Illuminate\Support\Str::limit(
                                                    $refundRequest->reason ?: 'No reason provided',
                                                    42
                                                ) }}
                                            </strong>

                                            @if($refundRequest->message)
                                                <span>
                                                        {{ \Illuminate\Support\Str::limit(
                                                            $refundRequest->message,
                                                            50
                                                        ) }}
                                                    </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td data-label="Status">
                                            <span
                                                class="refund-request-status refund-request-status--{{ $statusClass }}"
                                            >
                                                <i class="fa-light fa-circle"></i>
                                                {{ $statusLabel }}
                                            </span>
                                    </td>

                                    <td data-label="Requested">
                                        <div class="refund-request-date">
                                            <strong>
                                                {{ $refundRequest->created_at?->format('M d, Y') }}
                                            </strong>

                                            <span>
                                                    {{ $refundRequest->created_at?->format('h:i A') }}
                                                </span>
                                        </div>
                                    </td>

                                    <td data-label="Action">
                                        <div class="refund-request-actions">
                                            <a
                                                href="{{ route(
                                                        'admin-ecommerce-payment-refund-request-show',
                                                        ['refundRequest' => $refundRequest]
                                                    ) }}"
                                                class="refund-request-action"
                                                title="View refund request"
                                                aria-label="View refund request"
                                            >
                                                <i class="fa-light fa-eye"></i>
                                            </a>

                                            @if($refundRequest->isPending())
                                                <a
                                                    href="{{ route(
                                                            'admin-ecommerce-payment-refund-request-show',
                                                            ['refundRequest' => $refundRequest]
                                                        ) }}"
                                                    class="refund-request-action refund-request-action--review"
                                                    title="Review request"
                                                    aria-label="Review request"
                                                >
                                                    <i class="fa-light fa-arrow-right"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="refund-requests-empty">
                            <div class="refund-requests-empty__icon">
                                <i class="fa-light fa-rotate-left"></i>
                            </div>

                            <h3>No refund requests found</h3>

                            @if(request()->filled('search') || request()->filled('status'))
                                <p>
                                    No refund requests match your current filters.
                                </p>

                                <a
                                    href="{{ route('admin-ecommerce-payment-refund-requests') }}"
                                    class="refund-requests-button refund-requests-button--secondary"
                                >
                                    <i class="fa-light fa-arrow-rotate-left"></i>
                                    <span>Reset Filters</span>
                                </a>
                            @else
                                <p>
                                    There are no refund requests to review right now.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Pagination --}}
                @if($refundRequests->hasPages())
                    <div class="refund-requests-pagination">
                        <div class="refund-requests-pagination__summary">
                            Showing
                            <strong>{{ $refundRequests->firstItem() }}</strong>
                            to
                            <strong>{{ $refundRequests->lastItem() }}</strong>
                            of
                            <strong>{{ $refundRequests->total() }}</strong>
                            requests
                        </div>

                        <div class="refund-requests-pagination__links">
                            {{ $refundRequests->onEachSide(1)->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            'use strict';

            const page = document.querySelector(
                '.ecommerce-refund-requests-page'
            );

            if (!page) {
                return;
            }

            const filterForm = page.querySelector(
                '[data-refund-filter]'
            );

            if (!filterForm) {
                return;
            }

            const searchInput = filterForm.querySelector(
                'input[name="search"]'
            );

            const statusSelect = filterForm.querySelector(
                'select[name="status"]'
            );

            /*
             * Submit filter form when Enter is pressed in search.
             */
            searchInput?.addEventListener('keydown', (event) => {
                if (event.key !== 'Enter') {
                    return;
                }

                event.preventDefault();
                filterForm.submit();
            });

            /*
             * Prevent accidental double submissions.
             */
            filterForm.addEventListener('submit', () => {
                const submitButton = filterForm.querySelector(
                    'button[type="submit"]'
                );

                if (!submitButton) {
                    return;
                }

                submitButton.disabled = true;
                submitButton.classList.add('is-loading');

                const icon = submitButton.querySelector('i');

                if (icon) {
                    icon.className = 'fa-light fa-spinner';
                }
            });

            /*
             * Automatically focus the search field when
             * a search filter is already active.
             */
            if (
                searchInput
                && searchInput.value.trim() !== ''
                && document.activeElement !== searchInput
            ) {
                searchInput.focus();
            }

            /*
             * Keyboard shortcut:
             * "/" focuses the refund request search field.
             */
            document.addEventListener('keydown', (event) => {
                if (
                    event.key !== '/'
                    || event.ctrlKey
                    || event.metaKey
                    || event.altKey
                ) {
                    return;
                }

                const activeElement = document.activeElement;

                if (
                    activeElement instanceof HTMLInputElement
                    || activeElement instanceof HTMLTextAreaElement
                    || activeElement instanceof HTMLSelectElement
                    || activeElement?.isContentEditable
                ) {
                    return;
                }

                event.preventDefault();
                searchInput?.focus();
            });

            /*
             * Highlight the row when the user hovers it.
             * Kept scoped to this page only.
             */
            const rows = page.querySelectorAll(
                '[data-refund-request-row]'
            );

            rows.forEach((row) => {
                row.addEventListener('mouseenter', () => {
                    row.classList.add('is-hovered');
                });

                row.addEventListener('mouseleave', () => {
                    row.classList.remove('is-hovered');
                });
            });
        })();
    </script>
@endpush
