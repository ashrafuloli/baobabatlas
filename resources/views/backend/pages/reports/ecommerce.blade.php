@extends('backend.layouts.backend')

@section('title', 'E-commerce Report')

@section('content')
    <div class="ecommerce-report-page">
        <div class="ecommerce-report-page__header">
            <div class="ecommerce-report-page__heading">
                <span class="ecommerce-report-page__eyebrow">
                    Sales Analytics
                </span>

                <h1 class="ecommerce-report-page__title">
                    E-commerce Report
                </h1>

                <p class="ecommerce-report-page__description">
                    Track orders, sales, products, and categories across
                    your selected date range.
                </p>
            </div>
        </div>

        {{-- Date Filter --}}
        <section class="ecommerce-report-page__filters">
            <div class="ecommerce-report-page__section-heading">
                <div>
                    <span class="ecommerce-report-page__section-label">
                        Report Period
                    </span>

                    <h2 class="ecommerce-report-page__section-title">
                        Date Filter
                    </h2>
                </div>
            </div>

            <form
                method="GET"
                action="{{ route('reports.ecommerce') }}"
                class="ecommerce-report-page__filter-form"
                data-ecommerce-report-form
            >
                <div class="ecommerce-report-page__quick-filters">
                    <button
                        type="button"
                        class="ecommerce-report-page__quick-filter"
                        data-period="today"
                    >
                        Today
                    </button>

                    <button
                        type="button"
                        class="ecommerce-report-page__quick-filter"
                        data-period="yesterday"
                    >
                        Yesterday
                    </button>

                    <button
                        type="button"
                        class="ecommerce-report-page__quick-filter"
                        data-period="7"
                    >
                        Last 7 Days
                    </button>

                    <button
                        type="button"
                        class="ecommerce-report-page__quick-filter"
                        data-period="30"
                    >
                        Last 30 Days
                    </button>

                    <button
                        type="button"
                        class="ecommerce-report-page__quick-filter"
                        data-period="month"
                    >
                        This Month
                    </button>
                </div>

                <div class="ecommerce-report-page__custom-filter">
                    <div class="ecommerce-report-page__field">
                        <label for="ecommerce-date-from">
                            From
                        </label>

                        <div class="ecommerce-report-page__input">
                            <i class="ri-calendar-line"></i>

                            <input
                                id="ecommerce-date-from"
                                type="date"
                                name="date_from"
                                value="{{ $dateFrom->format('Y-m-d') }}"
                            >
                        </div>
                    </div>

                    <div class="ecommerce-report-page__field">
                        <label for="ecommerce-date-to">
                            To
                        </label>

                        <div class="ecommerce-report-page__input">
                            <i class="ri-calendar-line"></i>

                            <input
                                id="ecommerce-date-to"
                                type="date"
                                name="date_to"
                                value="{{ $dateTo->format('Y-m-d') }}"
                            >
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="ecommerce-report-page__apply"
                    >
                        <i class="ri-filter-3-line"></i>
                        <span>Apply Filter</span>
                    </button>

                    <a
                        href="{{ route('reports.ecommerce') }}"
                        class="ecommerce-report-page__reset"
                    >
                        <i class="ri-refresh-line"></i>
                        <span>Reset</span>
                    </a>
                </div>
            </form>
        </section>

        {{-- Summary --}}
        <section class="ecommerce-report-page__summary">
            <div class="ecommerce-report-page__section-heading">
                <div>
                    <span class="ecommerce-report-page__section-label">
                        Overview
                    </span>

                    <h2 class="ecommerce-report-page__section-title">
                        Summary
                    </h2>
                </div>

                <span class="ecommerce-report-page__date-range">
                    {{ $dateFrom->format('M d, Y') }}
                    -
                    {{ $dateTo->format('M d, Y') }}
                </span>
            </div>

            <div class="ecommerce-report-page__summary-grid">
                <article class="ecommerce-report-page__summary-card">
                    <div class="ecommerce-report-page__summary-icon">
                        <i class="ri-shopping-bag-3-line"></i>
                    </div>

                    <div class="ecommerce-report-page__summary-content">
                        <span>Total Orders</span>

                        <strong>
                            {{ number_format(
                                $report['summary']['total_orders']
                            ) }}
                        </strong>
                    </div>
                </article>

                <article class="ecommerce-report-page__summary-card">
                    <div class="ecommerce-report-page__summary-icon">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>

                    <div class="ecommerce-report-page__summary-content">
                        <span>Total Sales</span>

                        <strong>
                            ${{ number_format(
                                (float) $report['summary']['total_sales'],
                                2
                            ) }}
                        </strong>
                    </div>
                </article>

                <article class="ecommerce-report-page__summary-card">
                    <div class="ecommerce-report-page__summary-icon">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>

                    <div class="ecommerce-report-page__summary-content">
                        <span>Paid</span>

                        <strong>
                            ${{ number_format(
                                (float) $report['summary']['paid_amount'],
                                2
                            ) }}
                        </strong>
                    </div>
                </article>

                <article class="ecommerce-report-page__summary-card">
                    <div class="ecommerce-report-page__summary-icon">
                        <i class="ri-time-line"></i>
                    </div>

                    <div class="ecommerce-report-page__summary-content">
                        <span>Outstanding</span>

                        <strong>
                            ${{ number_format(
                                (float) $report['summary']['outstanding_amount'],
                                2
                            ) }}
                        </strong>
                    </div>
                </article>

                <article class="ecommerce-report-page__summary-card">
                    <div class="ecommerce-report-page__summary-icon">
                        <i class="ri-refund-2-line"></i>
                    </div>

                    <div class="ecommerce-report-page__summary-content">
                        <span>Refunded</span>

                        <strong>
                            ${{ number_format(
                                (float) $report['summary']['refunded_amount'],
                                2
                            ) }}
                        </strong>
                    </div>
                </article>

                <article class="ecommerce-report-page__summary-card">
                    <div class="ecommerce-report-page__summary-icon">
                        <i class="ri-bar-chart-box-line"></i>
                    </div>

                    <div class="ecommerce-report-page__summary-content">
                        <span>Average Order Value</span>

                        <strong>
                            ${{ number_format(
                                (float) $report['summary']['average_order_value'],
                                2
                            ) }}
                        </strong>
                    </div>
                </article>
            </div>
        </section>

        {{-- Daily Sales --}}
        <section class="ecommerce-report-page__report-section">
            <div class="ecommerce-report-page__section-heading">
                <div>
            <span class="ecommerce-report-page__section-label">
                Performance
            </span>

                    <h2 class="ecommerce-report-page__section-title">
                        Daily Sales Report
                    </h2>
                </div>

                <a
                    href="{{ route('reports.ecommerce.export.daily', [
                'date_from' => $dateFrom->format('Y-m-d'),
                'date_to' => $dateTo->format('Y-m-d'),
                'status' => $status,
            ]) }}"
                    class="ecommerce-report-page__section-export"
                >
                    <i class="ri-download-2-line"></i>
                    <span>Export CSV</span>
                </a>
            </div>

            {{-- Status Filters --}}
            <div class="ecommerce-report-page__status-filters">
                <a
                    href="{{ route('reports.ecommerce', [
                'date_from' => $dateFrom->format('Y-m-d'),
                'date_to' => $dateTo->format('Y-m-d'),
            ]) }}"
                    class="
                ecommerce-report-page__status-filter
                {{ $status === null ? 'is-active' : '' }}
            "
                >
                    All
                </a>

                <a
                    href="{{ route('reports.ecommerce', [
                'date_from' => $dateFrom->format('Y-m-d'),
                'date_to' => $dateTo->format('Y-m-d'),
                'status' => 'completed',
            ]) }}"
                    class="
                ecommerce-report-page__status-filter
                {{ $status === 'completed' ? 'is-active' : '' }}
            "
                >
                    Completed
                </a>

                <a
                    href="{{ route('reports.ecommerce', [
                'date_from' => $dateFrom->format('Y-m-d'),
                'date_to' => $dateTo->format('Y-m-d'),
                'status' => 'pending',
            ]) }}"
                    class="
                ecommerce-report-page__status-filter
                {{ $status === 'pending' ? 'is-active' : '' }}
            "
                >
                    Pending
                </a>

                <a
                    href="{{ route('reports.ecommerce', [
                'date_from' => $dateFrom->format('Y-m-d'),
                'date_to' => $dateTo->format('Y-m-d'),
                'status' => 'processing',
            ]) }}"
                    class="
                ecommerce-report-page__status-filter
                {{ $status === 'processing' ? 'is-active' : '' }}
            "
                >
                    Processing
                </a>

                <a
                    href="{{ route('reports.ecommerce', [
                'date_from' => $dateFrom->format('Y-m-d'),
                'date_to' => $dateTo->format('Y-m-d'),
                'status' => 'cancelled',
            ]) }}"
                    class="
                ecommerce-report-page__status-filter
                {{ $status === 'cancelled' ? 'is-active' : '' }}
            "
                >
                    Cancelled
                </a>
            </div>

            <div class="ecommerce-report-page__table-card">
                <div class="ecommerce-report-page__table-wrapper">
                    <table class="ecommerce-report-page__table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order</th>
                            <th>Sales</th>
                            <th>Paid</th>
                            <th>Outstanding</th>
                            <th>Refunded</th>
                            <th>Print</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($report['daily_sales'] as $row)
                            <tr>
                                {{-- Date --}}
                                <td>
                            <span
                                class="ecommerce-report-page__date"
                            >
                                {{ \Carbon\CarbonImmutable::parse(
                                    $row['date']
                                )->format('M d, Y') }}
                            </span>
                                </td>

                                {{-- Order --}}
                                <td>
                                    <a
                                        href="{{ route(
                                    'admin-order-details',
                                    ['order' => $row['order_id']]
                                ) }}"
                                        class="ecommerce-report-page__order-link"
                                        title="View {{ $row['order_number'] }}"
                                    >
                                        {{ $row['order_number'] }}
                                    </a>
                                </td>

                                {{-- Sales --}}
                                <td>
                                    <strong>
                                        ${{ number_format(
                                    (float) $row['sales'],
                                    2
                                ) }}
                                    </strong>
                                </td>

                                {{-- Paid --}}
                                <td>
                                    ${{ number_format(
                                (float) $row['paid_amount'],
                                2
                            ) }}
                                </td>

                                {{-- Outstanding --}}
                                <td>
                                    ${{ number_format(
                                (float) $row['outstanding_amount'],
                                2
                            ) }}
                                </td>

                                {{-- Refunded --}}
                                <td>
                                    ${{ number_format(
                                (float) $row['refunded_amount'],
                                2
                            ) }}
                                </td>

                                {{-- Print --}}
                                <td>
                                    <button
                                        type="button"
                                        class="ecommerce-report-page__print-button"
                                        data-print-order
                                        data-print-url="{{ route(
                                    'admin-orders.print',
                                    ['order' => $row['order_id']]
                                ) }}"
                                        title="Print {{ $row['order_number'] }}"
                                    >
                                        <i class="ri-printer-line"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="7"
                                    class="ecommerce-report-page__empty"
                                >
                                    <i class="ri-bar-chart-2-line"></i>

                                    <strong>
                                        No sales data found
                                    </strong>

                                    <span>
                                There are no orders for the
                                selected filters.
                            </span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Product Sales --}}
        <section class="ecommerce-report-page__report-section">
            <div class="ecommerce-report-page__section-heading">
                <div>
                    <span class="ecommerce-report-page__section-label">
                        Products
                    </span>

                    <h2 class="ecommerce-report-page__section-title">
                        Product Sales
                    </h2>
                </div>

                <a
                    href="{{ route('reports.ecommerce.export.products', [
                        'date_from' => $dateFrom->format('Y-m-d'),
                        'date_to' => $dateTo->format('Y-m-d'),
                        'status' => $status,
                    ]) }}"
                    class="ecommerce-report-page__section-export"
                >
                    <i class="ri-download-2-line"></i>
                    <span>Export CSV</span>
                </a>
            </div>

            <div class="ecommerce-report-page__table-card">
                <div class="ecommerce-report-page__table-wrapper">
                    <table class="ecommerce-report-page__table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Orders</th>
                            <th>Units Sold</th>
                            <th>Revenue</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($report['product_sales'] as $row)
                            <tr>
                                <td>
                                    <span
                                        class="ecommerce-report-page__product-name"
                                    >
                                        {{ $row['product_name'] }}
                                    </span>
                                </td>

                                <td>
                                    {{ number_format($row['orders']) }}
                                </td>

                                <td>
                                    {{ number_format($row['units_sold']) }}
                                </td>

                                <td>
                                    <strong>
                                        ${{ number_format(
                                            (float) $row['revenue'],
                                            2
                                        ) }}
                                    </strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="4"
                                    class="ecommerce-report-page__empty"
                                >
                                    <i class="ri-shopping-bag-line"></i>

                                    <strong>
                                        No product sales
                                    </strong>

                                    <span>
                                        No product sales found for
                                        this period.
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Category Sales --}}
        <section class="ecommerce-report-page__report-section">
            <div class="ecommerce-report-page__section-heading">
                <div>
                    <span class="ecommerce-report-page__section-label">
                        Categories
                    </span>

                    <h2 class="ecommerce-report-page__section-title">
                        Category Sales
                    </h2>
                </div>

                <a
                    href="{{ route('reports.ecommerce.export.categories', [
                        'date_from' => $dateFrom->format('Y-m-d'),
                        'date_to' => $dateTo->format('Y-m-d'),
                        'status' => $status,
                    ]) }}"
                    class="ecommerce-report-page__section-export"
                >
                    <i class="ri-download-2-line"></i>
                    <span>Export CSV</span>
                </a>
            </div>

            <div class="ecommerce-report-page__table-card">
                <div class="ecommerce-report-page__table-wrapper">
                    <table class="ecommerce-report-page__table">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Orders</th>
                            <th>Units Sold</th>
                            <th>Revenue</th>
                            <th>Share</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($report['category_sales'] as $row)
                            <tr>
                                <td>
                                    <span
                                        class="ecommerce-report-page__product-name"
                                    >
                                        {{ $row['category_name'] }}
                                    </span>
                                </td>

                                <td>
                                    {{ number_format($row['orders']) }}
                                </td>

                                <td>
                                    {{ number_format($row['units_sold']) }}
                                </td>

                                <td>
                                    <strong>
                                        ${{ number_format(
                                            (float) $row['revenue'],
                                            2
                                        ) }}
                                    </strong>
                                </td>

                                <td>
                                    <span
                                        class="ecommerce-report-page__percentage"
                                    >
                                        {{ number_format(
                                            (float) $row['sales_percentage'],
                                            2
                                        ) }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="ecommerce-report-page__empty"
                                >
                                    <i class="ri-price-tag-3-line"></i>

                                    <strong>
                                        No category sales
                                    </strong>

                                    <span>
                                        No category sales found for
                                        this period.
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script>
        (() => {
            const page = document.querySelector(
                '.ecommerce-report-page'
            );

            if (!page) {
                return;
            }

            const form = page.querySelector(
                '[data-ecommerce-report-form]'
            );

            if (!form) {
                return;
            }

            const fromInput = form.querySelector(
                'input[name="date_from"]'
            );

            const toInput = form.querySelector(
                'input[name="date_to"]'
            );

            const quickFilters = form.querySelectorAll(
                '[data-period]'
            );

            if (!fromInput || !toInput) {
                return;
            }

            const formatDate = (date) => {
                const year = date.getFullYear();

                const month = String(
                    date.getMonth() + 1
                ).padStart(2, '0');

                const day = String(
                    date.getDate()
                ).padStart(2, '0');

                return `${year}-${month}-${day}`;
            };

            const submitPeriod = (period) => {
                const today = new Date();

                let fromDate = new Date(today);
                let toDate = new Date(today);

                if (period === 'yesterday') {
                    fromDate.setDate(
                        today.getDate() - 1
                    );

                    toDate = new Date(fromDate);
                }

                if (period === '7') {
                    fromDate.setDate(
                        today.getDate() - 6
                    );
                }

                if (period === '30') {
                    fromDate.setDate(
                        today.getDate() - 29
                    );
                }

                if (period === 'month') {
                    fromDate = new Date(
                        today.getFullYear(),
                        today.getMonth(),
                        1
                    );
                }

                fromInput.value = formatDate(
                    fromDate
                );

                toInput.value = formatDate(
                    toDate
                );

                form.submit();
            };

            quickFilters.forEach((button) => {
                button.addEventListener(
                    'click',
                    () => {
                        const period = button.dataset.period;

                        if (!period) {
                            return;
                        }

                        submitPeriod(period);
                    }
                );
            });

            /*
             * Open the existing admin order details page
             * and trigger the browser print dialog.
             */
            const printButtons = page.querySelectorAll(
                '[data-print-order]'
            );

            printButtons.forEach((button) => {
                button.addEventListener(
                    'click',
                    () => {
                        const url = button.dataset.printUrl;

                        if (!url) {
                            return;
                        }

                        const printWindow = window.open(
                            url,
                            '_blank'
                        );

                        if (!printWindow) {
                            return;
                        }

                        printWindow.addEventListener(
                            'load',
                            () => {
                                printWindow.focus();
                                printWindow.print();
                            }
                        );
                    }
                );
            });
        })();
    </script>
@endsection
