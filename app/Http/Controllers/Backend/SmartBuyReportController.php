<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Actions\Reports\GetSmartBuyReport;
use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class SmartBuyReportController extends Controller
{
    public function __construct(
        private readonly GetSmartBuyReport $getSmartBuyReport,
    ) {
    }

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'date_from' => [
                'nullable',
                'date',
            ],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);

        /*
         * Default report range is today.
         *
         * If the user selects a custom date range,
         * the selected dates will be used instead.
         */
        $today = CarbonImmutable::today();

        $dateFrom = $this->resolveDate(
            $validated['date_from'] ?? null,
        ) ?? $today;

        $dateTo = $this->resolveDate(
            $validated['date_to'] ?? null,
        ) ?? $today;

        $report = $this->getSmartBuyReport->execute(
            $dateFrom,
            $dateTo,
        );

        $dailyRows = $report['rows'];

        return view(
            'backend.pages.reports.smart-buy',
            [
                'report' => $report,
                'dailyRows' => $dailyRows,
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ],
        );
    }

    public function export(Request $request): StreamedResponse
    {
        $validated = $request->validate([
            'date_from' => [
                'nullable',
                'date',
            ],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);

        $today = CarbonImmutable::today();

        $dateFrom = $this->resolveDate(
            $validated['date_from'] ?? null,
        ) ?? $today;

        $dateTo = $this->resolveDate(
            $validated['date_to'] ?? null,
        ) ?? $today;

        $report = $this->getSmartBuyReport->execute(
            $dateFrom,
            $dateTo,
        );

        $filename = sprintf(
            'smart-buy-report-%s.csv',
            now()->format('Y-m-d-His'),
        );

        return response()->streamDownload(
            static function () use ($report): void {
                $handle = fopen('php://output', 'wb');

                if ($handle === false) {
                    return;
                }

                fputcsv($handle, [
                    'Date',
                    'Requests',
                    'Completed',
                    'Pending',
                    'Processing',
                    'Cancelled',
                    'Accepted Value',
                    'Paid',
                    'Outstanding',
                    'Refunded',
                ]);

                foreach ($report['rows'] as $row) {
                    fputcsv($handle, [
                        $row['date'],
                        $row['requests'],
                        $row['completed'],
                        $row['pending'],
                        $row['processing'],
                        $row['cancelled'],
                        '$' . number_format(
                            (float) $row['accepted_value'],
                            2,
                            '.',
                            ',',
                        ),
                        '$' . number_format(
                            (float) $row['paid_amount'],
                            2,
                            '.',
                            ',',
                        ),
                        '$' . number_format(
                            (float) $row['outstanding_amount'],
                            2,
                            '.',
                            ',',
                        ),
                        '$' . number_format(
                            (float) $row['refunded_amount'],
                            2,
                            '.',
                            ',',
                        ),
                    ]);
                }

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' .
                    $filename .
                    '"',
            ],
        );
    }

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
