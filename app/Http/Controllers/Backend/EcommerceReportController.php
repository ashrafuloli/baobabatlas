<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Actions\Reports\GetEcommerceReport;
use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class EcommerceReportController extends Controller
{
    public function __construct(
        private readonly GetEcommerceReport $getEcommerceReport,
    ) {
    }

    /**
     * Display the ecommerce report.
     */
    public function index(Request $request): View
    {
        $filters = $this->validateFilters($request);

        $today = CarbonImmutable::today();

        $dateFrom = $this->resolveDate(
            $filters['date_from'] ?? null,
        ) ?? $today;

        $dateTo = $this->resolveDate(
            $filters['date_to'] ?? null,
        ) ?? $today;

        $status = $this->resolveStatus(
            $filters['status'] ?? null,
        );

        $report = $this->getEcommerceReport->execute(
            $dateFrom,
            $dateTo,
            $status,
        );

        return view(
            'backend.pages.reports.ecommerce',
            [
                'report' => $report,
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'status' => $status,
            ],
        );
    }

    /**
     * Export the daily sales report.
     */
    public function exportDaily(
        Request $request,
    ): StreamedResponse {
        $filters = $this->validateFilters($request);

        $today = CarbonImmutable::today();

        $dateFrom = $this->resolveDate(
            $filters['date_from'] ?? null,
        ) ?? $today;

        $dateTo = $this->resolveDate(
            $filters['date_to'] ?? null,
        ) ?? $today;

        $status = $this->resolveStatus(
            $filters['status'] ?? null,
        );

        $report = $this->getEcommerceReport->execute(
            $dateFrom,
            $dateTo,
            $status,
        );

        $filename = sprintf(
            'ecommerce-daily-sales-%s.csv',
            now()->format('Y-m-d-His'),
        );

        return response()->streamDownload(
            static function () use ($report): void {
                $handle = fopen(
                    'php://output',
                    'wb',
                );

                if ($handle === false) {
                    return;
                }

                fputcsv($handle, [
                    'Date',
                    'Order',
                    'Sales',
                    'Paid',
                    'Outstanding',
                    'Refunded',
                ]);

                foreach ($report['daily_sales'] as $row) {
                    fputcsv($handle, [
                        $row['date'],
                        $row['order_number'],
                        number_format(
                            (float) $row['sales'],
                            2,
                            '.',
                            '',
                        ),
                        number_format(
                            (float) $row['paid_amount'],
                            2,
                            '.',
                            '',
                        ),
                        number_format(
                            (float) $row['outstanding_amount'],
                            2,
                            '.',
                            '',
                        ),
                        number_format(
                            (float) $row['refunded_amount'],
                            2,
                            '.',
                            '',
                        ),
                    ]);
                }

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => sprintf(
                    'attachment; filename="%s"',
                    $filename,
                ),
            ],
        );
    }

    /**
     * Export product sales.
     */
    public function exportProducts(
        Request $request,
    ): StreamedResponse {
        $filters = $this->validateFilters($request);

        $today = CarbonImmutable::today();

        $dateFrom = $this->resolveDate(
            $filters['date_from'] ?? null,
        ) ?? $today;

        $dateTo = $this->resolveDate(
            $filters['date_to'] ?? null,
        ) ?? $today;

        $status = $this->resolveStatus(
            $filters['status'] ?? null,
        );

        $report = $this->getEcommerceReport->execute(
            $dateFrom,
            $dateTo,
            $status,
        );

        $filename = sprintf(
            'product-sales-report-%s.csv',
            now()->format('Y-m-d-His'),
        );

        return response()->streamDownload(
            static function () use ($report): void {
                $handle = fopen(
                    'php://output',
                    'wb',
                );

                if ($handle === false) {
                    return;
                }

                fputcsv($handle, [
                    'Product',
                    'Orders',
                    'Units Sold',
                    'Revenue',
                ]);

                foreach ($report['product_sales'] as $row) {
                    fputcsv($handle, [
                        $row['product_name'],
                        $row['orders'],
                        $row['units_sold'],
                        number_format(
                            (float) $row['revenue'],
                            2,
                            '.',
                            '',
                        ),
                    ]);
                }

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ],
        );
    }

    /**
     * Export category sales.
     */
    public function exportCategories(
        Request $request,
    ): StreamedResponse {
        $filters = $this->validateFilters($request);

        $today = CarbonImmutable::today();

        $dateFrom = $this->resolveDate(
            $filters['date_from'] ?? null,
        ) ?? $today;

        $dateTo = $this->resolveDate(
            $filters['date_to'] ?? null,
        ) ?? $today;

        $status = $this->resolveStatus(
            $filters['status'] ?? null,
        );

        $report = $this->getEcommerceReport->execute(
            $dateFrom,
            $dateTo,
            $status,
        );

        $filename = sprintf(
            'category-sales-report-%s.csv',
            now()->format('Y-m-d-His'),
        );

        return response()->streamDownload(
            static function () use ($report): void {
                $handle = fopen(
                    'php://output',
                    'wb',
                );

                if ($handle === false) {
                    return;
                }

                fputcsv($handle, [
                    'Category',
                    'Orders',
                    'Units Sold',
                    'Revenue',
                    'Sales Percentage',
                ]);

                foreach ($report['category_sales'] as $row) {
                    fputcsv($handle, [
                        $row['category_name'],
                        $row['orders'],
                        $row['units_sold'],
                        number_format(
                            (float) $row['revenue'],
                            2,
                            '.',
                            '',
                        ),
                        number_format(
                            (float) $row['sales_percentage'],
                            2,
                            '.',
                            '',
                        ) . '%',
                    ]);
                }

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ],
        );
    }

    /**
     * Validate report filters.
     *
     * @return array<string, mixed>
     */
    private function validateFilters(
        Request $request,
    ): array {
        return $request->validate([
            'date_from' => [
                'nullable',
                'date',
            ],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
            'status' => [
                'nullable',
                'string',
                'in:pending,processing,completed,cancelled',
            ],
        ]);
    }

    /**
     * Resolve report status.
     */
    private function resolveStatus(
        mixed $value,
    ): ?string {
        if (! is_string($value) || $value === '') {
            return null;
        }

        return in_array(
            $value,
            [
                'pending',
                'processing',
                'completed',
                'cancelled',
            ],
            true,
        )
            ? $value
            : null;
    }

    /**
     * Resolve a date safely.
     */
    private function resolveDate(
        mixed $value,
    ): ?CarbonImmutable {
        if (! is_string($value) || $value === '') {
            return null;
        }

        try {
            return CarbonImmutable::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }
}
