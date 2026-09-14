@extends('backend.layouts.backend')

@section('title', 'Refund Requests')

@section('content')
    @php
        $statusLabels = [
            \App\Models\RefundRequest::STATUS_PENDING => 'Pending',
            \App\Models\RefundRequest::STATUS_APPROVED => 'Approved',
            \App\Models\RefundRequest::STATUS_REJECTED => 'Rejected',
        ];
    @endphp

    <div class="admin-refunds-page">

        {{-- Page Header --}}
        <div class="admin-refunds-page__header">
            <div class="admin-refunds-page__header-content">

                <div>
                    <div class="admin-refunds-page__breadcrumb">
                        <span>Ecommerce</span>
                        <span>/</span>
                        <span>Refund Requests</span>
                    </div>

                    <h1 class="admin-refunds-page__title">
                        Refund Requests
                    </h1>

                    <p class="admin-refunds-page__subtitle">
                        Review and manage customer refund requests.
                    </p>
                </div>

            </div>
        </div>


        {{-- Statistics --}}
        <div class="admin-refunds-page__stats">

            {{-- Total --}}
            <div class="admin-refunds-stat-card">
                <div class="admin-refunds-stat-card__icon">
                    <i class="ri-refund-2-line"></i>
                </div>

                <div class="admin-refunds-stat-card__content">
                    <span>Total Requests</span>

                    <strong>
                        {{ number_format($stats['total']) }}
                    </strong>
                </div>
            </div>


            {{-- Pending --}}
            <div class="admin-refunds-stat-card admin-refunds-stat-card--pending">
                <div class="admin-refunds-stat-card__icon">
                    <i class="ri-time-line"></i>
                </div>

                <div class="admin-refunds-stat-card__content">
                    <span>Pending</span>

                    <strong>
                        {{ number_format($stats['pending']) }}
                    </strong>
                </div>
            </div>


            {{-- Approved --}}
            <div class="admin-refunds-stat-card admin-refunds-stat-card--approved">
                <div class="admin-refunds-stat-card__icon">
                    <i class="ri-checkbox-circle-line"></i>
                </div>

                <div class="admin-refunds-stat-card__content">
                    <span>Approved</span>

                    <strong>
                        {{ number_format($stats['approved']) }}
                    </strong>
                </div>
            </div>


            {{-- Refunded --}}
            <div class="admin-refunds-stat-card admin-refunds-stat-card--refunded">
                <div class="admin-refunds-stat-card__icon">
                    <i class="ri-bank-card-line"></i>
                </div>

                <div class="admin-refunds-stat-card__content">
                    <span>Refunded</span>

                    <strong>
                        {{ number_format($stats['refunded']) }}
                    </strong>
                </div>
            </div>


            {{-- Rejected --}}
            <div class="admin-refunds-stat-card admin-refunds-stat-card--rejected">
                <div class="admin-refunds-stat-card__icon">
                    <i class="ri-close-circle-line"></i>
                </div>

                <div class="admin-refunds-stat-card__content">
                    <span>Rejected</span>

                    <strong>
                        {{ number_format($stats['rejected']) }}
                    </strong>
                </div>
            </div>

        </div>


        {{-- Main Card --}}
        <div class="admin-refunds-page__card">

            {{-- Toolbar --}}
            <div class="admin-refunds-page__toolbar">

                <form
                    action="{{ route('admin-refunds') }}"
                    method="GET"
                    class="admin-refunds-filter"
                    data-refunds-filter
                >

                    {{-- Search --}}
                    <div class="admin-refunds-filter__search">

                        <i class="ri-search-line"></i>

                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search order, customer..."
                            autocomplete="off"
                        >

                        @if (request('search'))
                            <button
                                type="button"
                                class="admin-refunds-filter__clear"
                                data-clear-search
                                aria-label="Clear search"
                            >
                                <i class="ri-close-line"></i>
                            </button>
                        @endif

                    </div>


                    {{-- Status --}}
                    <div class="admin-refunds-filter__status">

                        <select
                            name="status"
                            data-status-filter
                        >
                            <option value="">
                                All Statuses
                            </option>

                            @foreach ($statuses as $status)
                                <option
                                    value="{{ $status }}"
                                    @selected(request('status') === $status)
                                >
                                    {{ $statusLabels[$status] ?? ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>

                        <i class="ri-arrow-down-s-line"></i>

                    </div>


                    {{-- Search Button --}}
                    <button
                        type="submit"
                        class="admin-refunds-filter__button"
                    >
                        <i class="ri-search-line"></i>

                        <span>
                            Search
                        </span>
                    </button>


                    {{-- Reset --}}
                    @if (
                        request()->filled('search')
                        || request()->filled('status')
                    )
                        <a
                            href="{{ route('admin-refunds') }}"
                            class="admin-refunds-filter__reset"
                        >
                            <i class="ri-refresh-line"></i>

                            <span>
                                Reset
                            </span>
                        </a>
                    @endif

                </form>

            </div>


            {{-- Results --}}
            <div class="admin-refunds-table-wrapper">

                <table class="admin-refunds-table">

                    <thead>
                    <tr>
                        <th>
                            Request
                        </th>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Reason
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Submitted
                        </th>

                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse ($refundRequests as $refundRequest)

                        @php
                            $order = $refundRequest->order;
                            $requestStatus = $refundRequest->status;
                            $refund = $refundRequest->refund;

                            $isRefunded = $refund
                                && $refund->status === \App\Models\Refund::STATUS_SUCCEEDED;

                            $statusClass = match ($requestStatus) {
                                \App\Models\RefundRequest::STATUS_PENDING => 'is-pending',
                                \App\Models\RefundRequest::STATUS_APPROVED => 'is-approved',
                                \App\Models\RefundRequest::STATUS_REJECTED => 'is-rejected',
                                default => 'is-default',
                            };

                            $customerName = $refundRequest->requester?->name
                                ?? $order->user?->name
                                ?? 'Customer';

                            $customerInitial = strtoupper(
                                substr($customerName, 0, 1)
                            );

                            $reason = $refundRequest->reason
                                ? ucfirst($refundRequest->reason)
                                : '—';
                        @endphp

                        <tr>

                            {{-- Request --}}
                            <td>
                                <div class="admin-refunds-request">

                                    <strong>
                                        #{{ $refundRequest->id }}
                                    </strong>

                                    <span>
                                            Refund Request
                                        </span>

                                </div>
                            </td>


                            {{-- Order --}}
                            <td>
                                <a
                                    href="{{ route(
                                            'admin-order-details',
                                            $order
                                        ) }}"
                                    class="admin-refunds-order"
                                >
                                    <strong>
                                        #{{ $order->order_number }}
                                    </strong>

                                    <span>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                </a>
                            </td>


                            {{-- Customer --}}
                            <td>
                                <div class="admin-refunds-customer">

                                    <div class="admin-refunds-customer__avatar">
                                        {{ $customerInitial }}
                                    </div>

                                    <div class="admin-refunds-customer__content">

                                        <strong>
                                            {{ $customerName }}
                                        </strong>

                                        <span>
                                                {{ $order->email }}
                                            </span>

                                    </div>

                                </div>
                            </td>


                            {{-- Amount --}}
                            <td>
                                <div class="admin-refunds-amount">

                                    <strong>
                                        {{ strtoupper($order->currency) }}
                                        {{ number_format(
                                            (float) $refundRequest->amount,
                                            2
                                        ) }}
                                    </strong>

                                    <span>
                                            Shipping excluded
                                        </span>

                                </div>
                            </td>


                            {{-- Reason --}}
                            <td>
                                <div class="admin-refunds-reason">
                                    {{ $reason }}
                                </div>
                            </td>


                            {{-- Status --}}
                            <td>
                                <div class="admin-refunds-status-wrapper">

                                        <span
                                            class="admin-refunds-status {{ $statusClass }}"
                                        >
                                            <span class="admin-refunds-status__dot"></span>

                                            {{ $statusLabels[$requestStatus] ?? ucfirst($requestStatus) }}
                                        </span>

                                    @if ($isRefunded)
                                        <span class="admin-refunds-refunded-label">
                                                <i class="ri-checkbox-circle-line"></i>

                                                <span>
                                                    Refunded
                                                </span>
                                            </span>
                                    @endif

                                </div>
                            </td>


                            {{-- Date --}}
                            <td>
                                <div class="admin-refunds-date">

                                    <strong>
                                        {{ $refundRequest->created_at?->format('M d, Y') ?? '—' }}
                                    </strong>

                                    <span>
                                            {{ $refundRequest->created_at?->format('h:i A') ?? '' }}
                                        </span>

                                </div>
                            </td>


                            {{-- Action --}}
                            <td>
                                <a
                                    href="{{ route(
                                            'admin-refunds.show',
                                            $refundRequest
                                        ) }}"
                                    class="admin-refunds-view"
                                >
                                        <span>
                                            View
                                        </span>

                                    <i class="ri-arrow-right-line"></i>
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="8"
                                class="admin-refunds-table__empty"
                            >
                                <div class="admin-refunds-empty">

                                    <div class="admin-refunds-empty__icon">
                                        <i class="ri-refund-2-line"></i>
                                    </div>

                                    <h3>
                                        No refund requests found
                                    </h3>

                                    <p>
                                        There are no refund requests
                                        matching your current filters.
                                    </p>

                                    @if (
                                        request()->filled('search')
                                        || request()->filled('status')
                                    )
                                        <a
                                            href="{{ route('admin-refunds') }}"
                                        >
                                            <i class="ri-filter-off-line"></i>

                                            <span>
                                                    Clear Filters
                                                </span>
                                        </a>
                                    @endif

                                </div>
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            {{ $refundRequests->links('backend.components.pagination') }}

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const page = document.querySelector('.admin-refunds-page');

            if (!page) {
                return;
            }

            const filterForm = page.querySelector(
                '[data-refunds-filter]'
            );

            const searchInput = page.querySelector(
                'input[name="search"]'
            );

            const statusFilter = page.querySelector(
                '[data-status-filter]'
            );

            const clearSearch = page.querySelector(
                '[data-clear-search]'
            );

            if (statusFilter && filterForm) {
                statusFilter.addEventListener('change', function () {
                    filterForm.submit();
                });
            }

            if (clearSearch && searchInput) {
                clearSearch.addEventListener('click', function () {
                    searchInput.value = '';

                    filterForm.submit();
                });
            }

            if (filterForm) {
                filterForm.addEventListener('submit', function () {
                    const submitButton = this.querySelector(
                        'button[type="submit"]'
                    );

                    if (!submitButton) {
                        return;
                    }

                    submitButton.disabled = true;

                    submitButton.setAttribute(
                        'aria-disabled',
                        'true'
                    );

                    submitButton.classList.add(
                        'is-submitting'
                    );
                });
            }
        });
    </script>
@endpush
