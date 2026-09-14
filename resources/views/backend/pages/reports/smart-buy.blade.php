@extends('backend.layouts.backend')

@section('title', 'Smart Buy Report')

@section('content')
    <div class="smart-buy-report-page">
        <div class="smart-buy-report-page__header">
            <div class="smart-buy-report-page__heading">
                <div class="smart-buy-report-page__breadcrumb">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>

                    <span>/</span>

                    <span>Smart Buy Report</span>
                </div>

                <h1 class="smart-buy-report-page__title">
                    Smart Buy Report
                </h1>

                <p class="smart-buy-report-page__subtitle">
                    Monitor Smart Buy requests, quotes, payments and
                    overall financial performance.
                </p>
            </div>

            <a
                href="{{ route('smart-buy') }}"
                class="smart-buy-report-page__back"
            >
                <i class="ri-arrow-left-line"></i>

                <span>Back to Requests</span>
            </a>
        </div>

        <div class="smart-buy-report-page__filters">
            <form
                action="{{ route('reports.smart-buy') }}"
                method="GET"
                class="smart-buy-report-page__filter-form"
                data-report-filter
            >
                <div class="smart-buy-report-page__filter-group">
                    <label for="report-date-from">
                        From
                    </label>

                    <input
                        type="date"
                        id="report-date-from"
                        name="date_from"
                        value="{{ $dateFrom?->format('Y-m-d') }}"
                    >
                </div>

                <div class="smart-buy-report-page__filter-group">
                    <label for="report-date-to">
                        To
                    </label>

                    <input
                        type="date"
                        id="report-date-to"
                        name="date_to"
                        value="{{ $dateTo?->format('Y-m-d') }}"
                    >
                </div>

                <button
                    type="submit"
                    class="smart-buy-report-page__filter-button"
                >
                    <i class="ri-filter-3-line"></i>

                    <span>Apply Filter</span>
                </button>

                <a
                    href="{{ route('reports.smart-buy') }}"
                    class="smart-buy-report-page__reset-button"
                >
                    <i class="ri-refresh-line"></i>

                    <span>Reset</span>
                </a>
            </form>

            <div class="smart-buy-report-page__quick-filters">
                <button
                    type="button"
                    class="smart-buy-report-page__quick-filter"
                    data-period="today"
                >
                    <i class="ri-calendar-check-line"></i>

                    <span>Today</span>
                </button>

                <button
                    type="button"
                    class="smart-buy-report-page__quick-filter"
                    data-period="yesterday"
                >
                    <i class="ri-calendar-line"></i>

                    <span>Yesterday</span>
                </button>

                <button
                    type="button"
                    class="smart-buy-report-page__quick-filter"
                    data-period="7"
                >
                    <i class="ri-calendar-2-line"></i>

                    <span>Last 7 Days</span>
                </button>

                <button
                    type="button"
                    class="smart-buy-report-page__quick-filter"
                    data-period="30"
                >
                    <i class="ri-calendar-schedule-line"></i>

                    <span>Last 30 Days</span>
                </button>

                <button
                    type="button"
                    class="smart-buy-report-page__quick-filter"
                    data-period="month"
                >
                    <i class="ri-calendar-month-line"></i>

                    <span>This Month</span>
                </button>
            </div>
        </div>

        <div class="smart-buy-report-page__section">
            <div class="smart-buy-report-page__section-header">
                <div>
                    <h2>Request Overview</h2>

                    <p>
                        Summary of Smart Buy request activity.
                    </p>
                </div>
            </div>

            <div class="smart-buy-report-page__metrics">
                <div class="smart-buy-report-page__metric-card">
                    <div class="smart-buy-report-page__metric-icon">
                        <i class="ri-shopping-bag-3-line"></i>
                    </div>

                    <div class="smart-buy-report-page__metric-content">
                        <span>Total Requests</span>

                        <strong>
                            {{ number_format(
                                $report['requests']['total']
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__metric-card">
                    <div class="smart-buy-report-page__metric-icon">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>

                    <div class="smart-buy-report-page__metric-content">
                        <span>Completed</span>

                        <strong>
                            {{ number_format(
                                $report['requests']['completed']
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__metric-card">
                    <div class="smart-buy-report-page__metric-icon">
                        <i class="ri-time-line"></i>
                    </div>

                    <div class="smart-buy-report-page__metric-content">
                        <span>Pending</span>

                        <strong>
                            {{ number_format(
                                $report['requests']['pending']
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__metric-card">
                    <div class="smart-buy-report-page__metric-icon">
                        <i class="ri-loader-4-line"></i>
                    </div>

                    <div class="smart-buy-report-page__metric-content">
                        <span>Processing</span>

                        <strong>
                            {{ number_format(
                                $report['requests']['processing']
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__metric-card">
                    <div class="smart-buy-report-page__metric-icon">
                        <i class="ri-close-circle-line"></i>
                    </div>

                    <div class="smart-buy-report-page__metric-content">
                        <span>Cancelled</span>

                        <strong>
                            {{ number_format(
                                $report['requests']['cancelled']
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__metric-card">
                    <div class="smart-buy-report-page__metric-icon">
                        <i class="ri-percent-line"></i>
                    </div>

                    <div class="smart-buy-report-page__metric-content">
                        <span>Completion Rate</span>

                        <strong>
                            {{ number_format(
                                $report['performance']['completion_rate'],
                                2
                            ) }}%
                        </strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="smart-buy-report-page__section">
            <div class="smart-buy-report-page__section-header">
                <div>
                    <h2>Financial Overview</h2>

                    <p>
                        Quote, payment and outstanding financial summary.
                    </p>
                </div>
            </div>

            <div class="smart-buy-report-page__financial-grid">
                <div class="smart-buy-report-page__financial-card">
                    <div class="smart-buy-report-page__financial-icon">
                        <i class="ri-file-list-3-line"></i>
                    </div>

                    <div>
                        <span>Requested Value</span>

                        <strong>
                            ${{ number_format(
                                $report['financial']['requested_value'],
                                2
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__financial-card">
                    <div class="smart-buy-report-page__financial-icon">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>

                    <div>
                        <span>Accepted Value</span>

                        <strong>
                            ${{ number_format(
                                $report['financial']['accepted_value'],
                                2
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__financial-card">
                    <div class="smart-buy-report-page__financial-icon">
                        <i class="ri-wallet-3-line"></i>
                    </div>

                    <div>
                        <span>Total Paid</span>

                        <strong>
                            ${{ number_format(
                                $report['financial']['paid_amount'],
                                2
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__financial-card">
                    <div class="smart-buy-report-page__financial-icon">
                        <i class="ri-hourglass-line"></i>
                    </div>

                    <div>
                        <span>Outstanding</span>

                        <strong>
                            ${{ number_format(
                                $report['financial']['outstanding_amount'],
                                2
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__financial-card">
                    <div class="smart-buy-report-page__financial-icon">
                        <i class="ri-refund-2-line"></i>
                    </div>

                    <div>
                        <span>Refunded</span>

                        <strong>
                            ${{ number_format(
                                $report['financial']['refunded_amount'],
                                2
                            ) }}
                        </strong>
                    </div>
                </div>

                <div class="smart-buy-report-page__financial-card">
                    <div class="smart-buy-report-page__financial-icon">
                        <i class="ri-bar-chart-2-line"></i>
                    </div>

                    <div>
                        <span>Average Request Value</span>

                        <strong>
                            ${{ number_format(
                                $report['performance']['average_request_value'],
                                2
                            ) }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="smart-buy-report-page__section">
            <div class="smart-buy-report-page__section-header">
                <div>
                    <h2>Daily Report</h2>

                    <p>
                        Daily breakdown of Smart Buy requests and financial
                        activity for the selected period.
                    </p>
                </div>

                <div class="smart-buy-report-page__section-actions">
                    <div class="smart-buy-report-page__section-meta">
                        <i class="ri-calendar-line"></i>

                        <span>
                            {{ number_format(count($dailyRows)) }} day(s)
                        </span>
                    </div>

                    <a
                        href="{{ route(
                            'reports.smart-buy.export',
                            request()->only(['date_from', 'date_to'])
                        ) }}"
                        class="smart-buy-report-page__export-button"
                    >
                        <i class="ri-download-2-line"></i>

                        <span>Export CSV</span>
                    </a>
                </div>
            </div>

            <div class="smart-buy-report-page__table-wrapper">
                @if (count($dailyRows) > 0)
                    <table class="smart-buy-report-page__table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Requests</th>
                            <th>Completed</th>
                            <th>Pending</th>
                            <th>Processing</th>
                            <th>Cancelled</th>
                            <th>Accepted Value</th>
                            <th>Paid</th>
                            <th>Outstanding</th>
                            <th>Refunded</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($dailyRows as $row)
                            <tr>
                                <td>
                                    {{ \Carbon\CarbonImmutable::parse(
                                        $row['date']
                                    )->format('M d, Y') }}
                                </td>

                                <td>
                                    {{ number_format(
                                        $row['requests']
                                    ) }}
                                </td>

                                <td>
                                    {{ number_format(
                                        $row['completed']
                                    ) }}
                                </td>

                                <td>
                                    {{ number_format(
                                        $row['pending']
                                    ) }}
                                </td>

                                <td>
                                    {{ number_format(
                                        $row['processing']
                                    ) }}
                                </td>

                                <td>
                                    {{ number_format(
                                        $row['cancelled']
                                    ) }}
                                </td>

                                <td>
                                    ${{ number_format(
                                        (float) $row['accepted_value'],
                                        2
                                    ) }}
                                </td>

                                <td>
                                    ${{ number_format(
                                        (float) $row['paid_amount'],
                                        2
                                    ) }}
                                </td>

                                <td>
                                    ${{ number_format(
                                        (float) $row['outstanding_amount'],
                                        2
                                    ) }}
                                </td>

                                <td>
                                    ${{ number_format(
                                        (float) $row['refunded_amount'],
                                        2
                                    ) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="smart-buy-report-page__empty">
                        <div class="smart-buy-report-page__empty-icon">
                            <i class="ri-file-chart-line"></i>
                        </div>

                        <h3>
                            No report data available
                        </h3>

                        <p>
                            There are no Smart Buy requests for the selected
                            date range.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="smart-buy-report-page__columns">
            <div class="smart-buy-report-page__panel">
                <div class="smart-buy-report-page__panel-header">
                    <div>
                        <h2>Request Status</h2>

                        <p>
                            Current request distribution.
                        </p>
                    </div>
                </div>

                <div class="smart-buy-report-page__status-list">
                    @forelse (
                        $report['requests']['status_counts']
                        as $status => $count
                    )
                        <div class="smart-buy-report-page__status-item">
                            <div class="smart-buy-report-page__status-name">
                                <span
                                    class="smart-buy-report-page__status-dot
                                    smart-buy-report-page__status-dot--{{ $status }}"
                                ></span>

                                <span>
                                    {{ str($status)
                                        ->replace('_', ' ')
                                        ->title() }}
                                </span>
                            </div>

                            <strong>
                                {{ number_format($count) }}
                            </strong>
                        </div>
                    @empty
                        <div class="smart-buy-report-page__empty">
                            <i class="ri-inbox-line"></i>

                            <span>
                                No request data available.
                            </span>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="smart-buy-report-page__panel">
                <div class="smart-buy-report-page__panel-header">
                    <div>
                        <h2>Payment Overview</h2>

                        <p>
                            Smart Buy payment activity.
                        </p>
                    </div>
                </div>

                <div class="smart-buy-report-page__payment-list">
                    <div class="smart-buy-report-page__payment-item">
                        <span>Total Payments</span>

                        <strong>
                            {{ number_format(
                                $report['payments']['total']
                            ) }}
                        </strong>
                    </div>

                    <div class="smart-buy-report-page__payment-item">
                        <span>Completed</span>

                        <strong>
                            {{ number_format(
                                $report['payments']['completed']
                            ) }}
                        </strong>
                    </div>

                    <div class="smart-buy-report-page__payment-item">
                        <span>Pending</span>

                        <strong>
                            {{ number_format(
                                $report['payments']['pending']
                            ) }}
                        </strong>
                    </div>

                    <div class="smart-buy-report-page__payment-item">
                        <span>Processing</span>

                        <strong>
                            {{ number_format(
                                $report['payments']['processing']
                            ) }}
                        </strong>
                    </div>

                    <div class="smart-buy-report-page__payment-item">
                        <span>Failed</span>

                        <strong>
                            {{ number_format(
                                $report['payments']['failed']
                            ) }}
                        </strong>
                    </div>

                    <div class="smart-buy-report-page__payment-item">
                        <span>Cancelled</span>

                        <strong>
                            {{ number_format(
                                $report['payments']['cancelled']
                            ) }}
                        </strong>
                    </div>

                    <div class="smart-buy-report-page__payment-item">
                        <span>Refunded</span>

                        <strong>
                            {{ number_format(
                                $report['payments']['refunded']
                            ) }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="smart-buy-report-page__section">
            <div class="smart-buy-report-page__section-header">
                <div>
                    <h2>Performance</h2>

                    <p>
                        Key Smart Buy performance indicators.
                    </p>
                </div>
            </div>

            <div class="smart-buy-report-page__performance-grid">
                <div class="smart-buy-report-page__performance-card">
                    <div class="smart-buy-report-page__performance-heading">
                        <span>Completion Rate</span>

                        <i class="ri-checkbox-circle-line"></i>
                    </div>

                    <div class="smart-buy-report-page__progress">
                        <div
                            class="smart-buy-report-page__progress-bar"
                            style="width: {{ min(
                                100,
                                max(
                                    0,
                                    $report['performance']['completion_rate']
                                )
                            ) }}%;"
                        ></div>
                    </div>

                    <strong>
                        {{ number_format(
                            $report['performance']['completion_rate'],
                            2
                        ) }}%
                    </strong>
                </div>

                <div class="smart-buy-report-page__performance-card">
                    <div class="smart-buy-report-page__performance-heading">
                        <span>Payment Collection Rate</span>

                        <i class="ri-wallet-3-line"></i>
                    </div>

                    <div class="smart-buy-report-page__progress">
                        <div
                            class="smart-buy-report-page__progress-bar"
                            style="width: {{ min(
                                100,
                                max(
                                    0,
                                    $report['performance']['payment_collection_rate']
                                )
                            ) }}%;"
                        ></div>
                    </div>

                    <strong>
                        {{ number_format(
                            $report['performance']['payment_collection_rate'],
                            2
                        ) }}%
                    </strong>
                </div>

                <div class="smart-buy-report-page__performance-card">
                    <div class="smart-buy-report-page__performance-heading">
                        <span>Cancellation Rate</span>

                        <i class="ri-close-circle-line"></i>
                    </div>

                    <div class="smart-buy-report-page__progress">
                        <div
                            class="smart-buy-report-page__progress-bar"
                            style="width: {{ min(
                                100,
                                max(
                                    0,
                                    $report['performance']['cancellation_rate']
                                )
                            ) }}%;"
                        ></div>
                    </div>

                    <strong>
                        {{ number_format(
                            $report['performance']['cancellation_rate'],
                            2
                        ) }}%
                    </strong>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector(
                '.smart-buy-report-page'
            );

            if (!page) {
                return;
            }

            const form = page.querySelector(
                '[data-report-filter]'
            );

            const fromInput = page.querySelector(
                '#report-date-from'
            );

            const toInput = page.querySelector(
                '#report-date-to'
            );

            const quickFilters = page.querySelectorAll(
                '[data-period]'
            );

            if (!form || !fromInput || !toInput) {
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

                fromInput.value = formatDate(fromDate);
                toInput.value = formatDate(toDate);

                form.submit();
            };

            quickFilters.forEach((button) => {
                button.addEventListener('click', () => {
                    const period = button.dataset.period;

                    if (!period) {
                        return;
                    }

                    submitPeriod(period);
                });
            });

            form.addEventListener('submit', (event) => {
                if (
                    fromInput.value
                    && toInput.value
                    && fromInput.value > toInput.value
                ) {
                    event.preventDefault();

                    window.alert(
                        'The start date cannot be later than the end date.'
                    );
                }
            });
        });
    </script>
@endpush
