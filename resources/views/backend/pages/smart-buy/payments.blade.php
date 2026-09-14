@extends('backend.layouts.backend')

@section('title', 'Smart Buy Payments')

@section('content')
    <div class="smart-buy-payments-page">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-header__content">
                <div class="page-header__breadcrumb">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>

                    <span>/</span>

                    <a href="{{ route('smart-buy') }}">
                        Smart Buy
                    </a>

                    <span>/</span>

                    <span>Payments</span>
                </div>

                <h1 class="page-header__title">
                    Smart Buy Payments
                </h1>

                <p class="page-header__description">
                    Manage and review all payments recorded for Smart Buy requests.
                </p>
            </div>

            <div class="page-header__action">
                <a
                    href="{{ route('smart-buy') }}"
                    class="back-button"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>All Requests</span>
                </a>
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="payment-summary">

            <div class="summary-card">
                <div class="summary-card__icon">
                    <i class="fa-solid fa-wallet"></i>
                </div>

                <div class="summary-card__content">
                    <span class="summary-card__label">
                        Total Payments
                    </span>

                    <strong class="summary-card__value">
                        {{ $payments->total() }}
                    </strong>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-card__icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div class="summary-card__content">
                    <span class="summary-card__label">
                        Current Page
                    </span>

                    <strong class="summary-card__value">
                        {{ $payments->count() }}
                    </strong>
                </div>
            </div>

        </div>

        {{-- Payments Card --}}
        <div class="payments-card">

            <div class="payments-card__header">
                <div>
                    <h2 class="payments-card__title">
                        Payment Records
                    </h2>

                    <p class="payments-card__subtitle">
                        All Smart Buy payment transactions
                    </p>
                </div>

                <div class="payments-card__tools">
                    <div class="payment-search">
                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="search"
                            id="paymentSearch"
                            placeholder="Search payments..."
                            autocomplete="off"
                        >
                    </div>
                </div>
            </div>

            <div class="payments-table-wrapper">

                <table class="payments-table">
                    <thead>
                    <tr>
                        <th>Payment</th>
                        <th>Smart Buy</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Gateway</th>
                        <th>Status</th>
                        <th>Paid At</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody id="paymentsTableBody">

                    @forelse ($payments as $payment)
                        <tr class="payment-row">

                            {{-- Payment --}}
                            <td>
                                <div class="payment-number">
                                        <span class="payment-number__icon">
                                            <i class="fa-solid fa-receipt"></i>
                                        </span>

                                    <div>
                                        <strong>
                                            {{ $payment->payment_number }}
                                        </strong>

                                        <span>
                                                #{{ $payment->id }}
                                            </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Smart Buy --}}
                            <td>
                                @if ($payment->smartBuyRequest)
                                    <a
                                        href="{{ route(
                                                'smart-buy.details',
                                                $payment->smartBuyRequest
                                            ) }}"
                                        class="smart-buy-link"
                                    >
                                        Smart Buy #{{ $payment->smartBuyRequest->id }}
                                    </a>
                                @else
                                    <span class="muted-text">
                                            —
                                        </span>
                                @endif
                            </td>

                            {{-- Amount --}}
                            <td>
                                <div class="payment-amount">
                                    <strong>
                                        {{ strtoupper($payment->currency ?? '$') }}
                                        {{ number_format((float) $payment->amount, 2) }}
                                    </strong>
                                </div>
                            </td>

                            {{-- Method --}}
                            <td>
                                    <span class="table-text">
                                        {{ $payment->payment_method ?: '—' }}
                                    </span>
                            </td>

                            {{-- Gateway --}}
                            <td>
                                    <span class="gateway-badge">
                                        {{ $payment->payment_gateway ?: 'Manual' }}
                                    </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                @php
                                    $statusClass = match ($payment->status) {
                                        'completed' => 'is-success',
                                        'processing' => 'is-info',
                                        'pending' => 'is-warning',
                                        'failed' => 'is-danger',
                                        'cancelled' => 'is-muted',
                                        'refunded' => 'is-refunded',
                                        default => 'is-muted',
                                    };
                                @endphp

                                <span class="status-badge {{ $statusClass }}">
                                        <span class="status-badge__dot"></span>

                                        {{ ucfirst($payment->status) }}
                                    </span>
                            </td>

                            {{-- Paid At --}}
                            <td>
                                <div class="date-column">
                                    @if ($payment->paid_at)
                                        <strong>
                                            {{ $payment->paid_at->format('M d, Y') }}
                                        </strong>

                                        <span>
                                                {{ $payment->paid_at->format('h:i A') }}
                                            </span>
                                    @else
                                        <span class="muted-text">
                                                Not paid
                                            </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Action --}}
                            <td>
                                @if ($payment->smartBuyRequest)
                                    <a
                                        href="{{ route(
                                                'smart-buy.details',
                                                $payment->smartBuyRequest
                                            ) }}"
                                        class="table-action"
                                        title="View Smart Buy"
                                    >
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                @endif
                            </td>

                        </tr>
                    @empty

                        <tr class="empty-row">
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-state__icon">
                                        <i class="fa-solid fa-wallet"></i>
                                    </div>

                                    <h3>
                                        No payments found
                                    </h3>

                                    <p>
                                        There are no Smart Buy payment records yet.
                                    </p>

                                    <a
                                        href="{{ route('smart-buy') }}"
                                        class="empty-state__button"
                                    >
                                        View Smart Buy Requests
                                    </a>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                    </tbody>
                </table>

            </div>

            {{-- Pagination --}}
            @if ($payments->hasPages())
                <div class="payments-card__footer">
                    {{ $payments->links() }}
                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector(
                '.smart-buy-payments-page'
            );

            if (!page) {
                return;
            }

            const searchInput = page.querySelector('#paymentSearch');
            const rows = page.querySelectorAll('.payment-row');

            if (!searchInput || !rows.length) {
                return;
            }

            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value
                    .trim()
                    .toLowerCase();

                rows.forEach((row) => {
                    const searchableText = row.textContent
                        .toLowerCase();

                    row.hidden = (
                        searchTerm !== ''
                        && !searchableText.includes(searchTerm)
                    );
                });
            });
        });
    </script>
@endpush
