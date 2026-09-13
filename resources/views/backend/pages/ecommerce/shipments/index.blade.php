@extends('backend.layouts.backend')

@section('title', 'Shipments')

@section('content')
    <div class="shipments-page">
        <div class="shipments-page__container">

            {{-- Page Header --}}
            <div class="shipments-page__header">
                <div class="shipments-page__header-content">
                    <div class="shipments-page__title-area">
                        <div class="shipments-page__title-icon">
                            <i class="ri-truck-line"></i>
                        </div>

                        <div>
                            <h1 class="shipments-page__title">
                                Shipments
                            </h1>

                            <p class="shipments-page__subtitle">
                                Manage and track all order shipments.
                            </p>
                        </div>
                    </div>

                    <div class="shipments-page__header-actions">
                        <a
                            href="{{ route('admin-orders') }}"
                            class="shipments-page__secondary-btn"
                        >
                            <i class="ri-shopping-bag-3-line"></i>
                            <span>Orders</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Statistics --}}
            <div class="shipments-page__stats">

                <div class="shipments-page__stat-card">
                    <div class="shipments-page__stat-icon shipments-page__stat-icon--total">
                        <i class="ri-truck-line"></i>
                    </div>

                    <div class="shipments-page__stat-content">
                    <span class="shipments-page__stat-label">
                        Total Shipments
                    </span>

                        <strong class="shipments-page__stat-value">
                            {{ number_format($totalShipments) }}
                        </strong>
                    </div>
                </div>

                <div class="shipments-page__stat-card">
                    <div class="shipments-page__stat-icon shipments-page__stat-icon--pending">
                        <i class="ri-time-line"></i>
                    </div>

                    <div class="shipments-page__stat-content">
                    <span class="shipments-page__stat-label">
                        Pending
                    </span>

                        <strong class="shipments-page__stat-value">
                            {{ number_format($pendingShipments) }}
                        </strong>
                    </div>
                </div>

                <div class="shipments-page__stat-card">
                    <div class="shipments-page__stat-icon shipments-page__stat-icon--processing">
                        <i class="ri-loader-4-line"></i>
                    </div>

                    <div class="shipments-page__stat-content">
                    <span class="shipments-page__stat-label">
                        Processing
                    </span>

                        <strong class="shipments-page__stat-value">
                            {{ number_format($processingShipments) }}
                        </strong>
                    </div>
                </div>

                <div class="shipments-page__stat-card">
                    <div class="shipments-page__stat-icon shipments-page__stat-icon--shipped">
                        <i class="ri-send-plane-line"></i>
                    </div>

                    <div class="shipments-page__stat-content">
                    <span class="shipments-page__stat-label">
                        Shipped
                    </span>

                        <strong class="shipments-page__stat-value">
                            {{ number_format($shippedShipments) }}
                        </strong>
                    </div>
                </div>

                <div class="shipments-page__stat-card">
                    <div class="shipments-page__stat-icon shipments-page__stat-icon--delivered">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>

                    <div class="shipments-page__stat-content">
                    <span class="shipments-page__stat-label">
                        Delivered
                    </span>

                        <strong class="shipments-page__stat-value">
                            {{ number_format($deliveredShipments) }}
                        </strong>
                    </div>
                </div>

            </div>

            {{-- Main Card --}}
            <div class="shipments-page__card">

                {{-- Toolbar --}}
                <div class="shipments-page__toolbar">
                    <form
                        action="{{ route('ecommerce-shipments') }}"
                        method="GET"
                        class="shipments-page__filters"
                        data-shipment-filters
                    >
                        {{-- Search --}}
                        <div class="shipments-page__search">
                            <i class="ri-search-line"></i>

                            <input
                                type="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search shipments..."
                                aria-label="Search shipments"
                            >

                            @if($search !== '')
                                <button
                                    type="button"
                                    class="shipments-page__search-clear"
                                    data-clear-search
                                    aria-label="Clear search"
                                >
                                    <i class="ri-close-line"></i>
                                </button>
                            @endif
                        </div>

                        {{-- Shipment Status --}}
                        <div class="shipments-page__filter">
                            <select
                                name="status"
                                aria-label="Shipment status"
                                data-auto-submit
                            >
                                <option value="">
                                    All Shipment Status
                                </option>

                                @foreach($shipmentStatuses as $shipmentStatus)
                                    <option
                                        value="{{ $shipmentStatus }}"
                                        @selected($status === $shipmentStatus)
                                    >
                                        {{ ucwords(str_replace('_', ' ', $shipmentStatus)) }}
                                    </option>
                                @endforeach
                            </select>

                            <i class="ri-arrow-down-s-line"></i>
                        </div>

                        {{-- Delivery Status --}}
                        <div class="shipments-page__filter">
                            <select
                                name="delivery_status"
                                aria-label="Delivery status"
                                data-auto-submit
                            >
                                <option value="">
                                    All Delivery Status
                                </option>

                                @foreach($deliveryStatuses as $deliveryStatusOption)
                                    <option
                                        value="{{ $deliveryStatusOption }}"
                                        @selected($deliveryStatus === $deliveryStatusOption)
                                    >
                                        {{ ucwords(str_replace('_', ' ', $deliveryStatusOption)) }}
                                    </option>
                                @endforeach
                            </select>

                            <i class="ri-arrow-down-s-line"></i>
                        </div>

                        <button
                            type="submit"
                            class="shipments-page__filter-btn"
                        >
                            <i class="ri-filter-3-line"></i>
                            <span>Filter</span>
                        </button>

                        @if($search !== '' || $status !== '' || $deliveryStatus !== '')
                            <a
                                href="{{ route('ecommerce-shipments') }}"
                                class="shipments-page__reset-btn"
                            >
                                <i class="ri-refresh-line"></i>
                                <span>Reset</span>
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="shipments-page__table-wrap">
                    <table class="shipments-page__table">
                        <thead>
                        <tr>
                            <th>
                                Shipment
                            </th>

                            <th>
                                Order
                            </th>

                            <th>
                                Customer
                            </th>

                            <th style="width: 200px;">
                                Carrier
                            </th>

                            <th>
                                Tracking
                            </th>

                            <th>
                                Shipment Status
                            </th>

                            <th>
                                Delivery Status
                            </th>

                            <th>
                                Created
                            </th>

                            <th class="shipments-page__table-action-heading">
                                Action
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($shipments as $shipment)
                            @php
                                $shipmentStatusClass = match ($shipment->status) {
                                    \App\Models\Shipment::STATUS_PENDING => 'pending',
                                    \App\Models\Shipment::STATUS_PROCESSING => 'processing',
                                    \App\Models\Shipment::STATUS_SHIPPED => 'shipped',
                                    \App\Models\Shipment::STATUS_CANCELLED => 'cancelled',
                                    default => 'pending',
                                };

                                $deliveryStatusClass = match ($shipment->delivery_status) {
                                    \App\Models\Shipment::DELIVERY_STATUS_PENDING => 'pending',
                                    \App\Models\Shipment::DELIVERY_STATUS_IN_TRANSIT => 'in-transit',
                                    \App\Models\Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY => 'out-for-delivery',
                                    \App\Models\Shipment::DELIVERY_STATUS_DELIVERED => 'delivered',
                                    \App\Models\Shipment::DELIVERY_STATUS_FAILED => 'failed',
                                    default => 'pending',
                                };
                            @endphp

                            <tr>
                                {{-- Shipment --}}
                                <td>
                                    <div class="shipments-page__shipment-cell">
                                        <div class="shipments-page__shipment-icon">
                                            <i class="ri-truck-line"></i>
                                        </div>

                                        <div class="shipments-page__shipment-info">
                                            <strong>
                                                Shipment #{{ $shipment->id }}
                                            </strong>

                                            <span>
                                                {{ $shipment->created_at?->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Order --}}
                                <td>
                                    @if($shipment->order)
                                        <a
                                            href="{{ route('admin-order-details', ['order' => $shipment->order->id]) }}"
                                            class="shipments-page__order-link"
                                        >
                                            #{{ $shipment->order->order_number }}
                                        </a>
                                    @else
                                        <span class="shipments-page__muted">
                                            —
                                        </span>
                                    @endif
                                </td>

                                {{-- Customer --}}
                                <td>
                                    @if($shipment->order)
                                        <div class="shipments-page__customer">
                                            <div class="shipments-page__avatar">
                                                {{ strtoupper(
                                                    substr((string) $shipment->order->first_name, 0, 1)
                                                    . substr((string) $shipment->order->last_name, 0, 1)
                                                ) }}
                                            </div>

                                            <div class="shipments-page__customer-info">
                                                <strong>
                                                    {{ $shipment->order->first_name }}
                                                    {{ $shipment->order->last_name }}
                                                </strong>

                                                <span>
                                                    {{ $shipment->order->email }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="shipments-page__muted">
                                            —
                                        </span>
                                    @endif
                                </td>

                                {{-- Carrier --}}
                                <td style="width: 200px">
                                    @if($shipment->carrier)
                                        <span class="shipments-page__carrier">
                                            {{ $shipment->carrier }}
                                        </span>
                                    @else
                                        <span class="shipments-page__muted">
                                            Not assigned
                                        </span>
                                    @endif
                                </td>

                                {{-- Tracking --}}
                                <td>
                                    @if($shipment->tracking_number)
                                        <span class="shipments-page__tracking">
                                            <i class="ri-barcode-line"></i>
                                            {{ $shipment->tracking_number }}
                                        </span>
                                    @else
                                        <span class="shipments-page__muted">
                                            Not available
                                        </span>
                                    @endif
                                </td>

                                {{-- Shipment Status --}}
                                <td>
                                    <span class="shipments-page__status shipments-page__status--{{ $shipmentStatusClass }}">
                                        @switch($shipment->status)
                                            @case(\App\Models\Shipment::STATUS_PENDING)
                                                <i class="ri-time-line"></i>
                                                @break

                                            @case(\App\Models\Shipment::STATUS_PROCESSING)
                                                <i class="ri-loader-4-line"></i>
                                                @break

                                            @case(\App\Models\Shipment::STATUS_SHIPPED)
                                                <i class="ri-send-plane-line"></i>
                                                @break

                                            @case(\App\Models\Shipment::STATUS_CANCELLED)
                                                <i class="ri-close-circle-line"></i>
                                                @break

                                            @default
                                                <i class="ri-information-line"></i>
                                        @endswitch

                                        {{ ucwords(str_replace('_', ' ', $shipment->status)) }}
                                    </span>
                                </td>

                                {{-- Delivery Status --}}
                                <td>
                                    <span class="shipments-page__status shipments-page__status--{{ $deliveryStatusClass }}">
                                        @switch($shipment->delivery_status)
                                            @case(\App\Models\Shipment::DELIVERY_STATUS_PENDING)
                                                <i class="ri-time-line"></i>
                                                @break

                                            @case(\App\Models\Shipment::DELIVERY_STATUS_IN_TRANSIT)
                                                <i class="ri-route-line"></i>
                                                @break

                                            @case(\App\Models\Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY)
                                                <i class="ri-e-bike-2-line"></i>
                                                @break

                                            @case(\App\Models\Shipment::DELIVERY_STATUS_DELIVERED)
                                                <i class="ri-checkbox-circle-line"></i>
                                                @break

                                            @case(\App\Models\Shipment::DELIVERY_STATUS_FAILED)
                                                <i class="ri-error-warning-line"></i>
                                                @break

                                            @default
                                                <i class="ri-information-line"></i>
                                        @endswitch

                                        {{ ucwords(str_replace('_', ' ', $shipment->delivery_status)) }}
                                    </span>
                                </td>

                                {{-- Created --}}
                                <td>
                                    <span class="shipments-page__date">
                                        {{ $shipment->created_at?->format('M d, Y') }}
                                    </span>
                                </td>

                                {{-- Action --}}
                                <td>
                                    <div class="shipments-page__action">
                                        <a
                                            href="{{ route('ecommerce-shipments.show', ['shipment' => $shipment->id]) }}"
                                            class="shipments-page__action-btn"
                                            title="View Shipment"
                                            aria-label="View Shipment"
                                        >
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="9"
                                    class="shipments-page__empty-cell"
                                >
                                    <div class="shipments-page__empty">
                                        <div class="shipments-page__empty-icon">
                                            <i class="ri-truck-line"></i>
                                        </div>

                                        <h3>
                                            No shipments found
                                        </h3>

                                        <p>
                                            @if($search !== '' || $status !== '' || $deliveryStatus !== '')
                                                No shipments match your current filters.
                                            @else
                                                There are no shipments available yet.
                                            @endif
                                        </p>

                                        @if($search !== '' || $status !== '' || $deliveryStatus !== '')
                                            <a
                                                href="{{ route('ecommerce-shipments') }}"
                                                class="shipments-page__empty-btn"
                                            >
                                                <i class="ri-refresh-line"></i>
                                                Clear Filters
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
                @if($shipments->hasPages())
                    <div class="shipments-page__pagination">
                        <div class="shipments-page__pagination-info">
                            Showing
                            <strong>
                                {{ $shipments->firstItem() ?? 0 }}
                            </strong>
                            to
                            <strong>
                                {{ $shipments->lastItem() ?? 0 }}
                            </strong>
                            of
                            <strong>
                                {{ $shipments->total() }}
                            </strong>
                            shipments
                        </div>

                        <div class="shipments-page__pagination-links">
                            {{ $shipments->links() }}
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const shipmentsPage = document.querySelector(
                '.shipments-page'
            );

            if (!shipmentsPage) {
                return;
            }

            const filterForm = shipmentsPage.querySelector(
                '[data-shipment-filters]'
            );

            const searchInput = shipmentsPage.querySelector(
                'input[name="search"]'
            );

            const clearSearchButton = shipmentsPage.querySelector(
                '[data-clear-search]'
            );

            const autoSubmitFields = shipmentsPage.querySelectorAll(
                '[data-auto-submit]'
            );

            if (clearSearchButton && searchInput) {
                clearSearchButton.addEventListener(
                    'click',
                    function () {
                        searchInput.value = '';

                        if (filterForm) {
                            filterForm.submit();
                        }
                    }
                );
            }

            autoSubmitFields.forEach(function (field) {
                field.addEventListener(
                    'change',
                    function () {
                        if (filterForm) {
                            filterForm.submit();
                        }
                    }
                );
            });

            if (filterForm && searchInput) {
                searchInput.addEventListener(
                    'keydown',
                    function (event) {
                        if (event.key === 'Enter') {
                            event.preventDefault();
                            filterForm.submit();
                        }
                    }
                );
            }
        });
    </script>
@endpush
