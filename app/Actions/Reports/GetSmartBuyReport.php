<?php

declare(strict_types=1);

namespace App\Actions\Reports;

use App\Models\SmartBuyPayment;
use App\Models\SmartBuyQuote;
use App\Models\SmartBuyRequest;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class GetSmartBuyReport
{
    /**
     * Get the Smart Buy report.
     *
     * @return array<string, mixed>
     */
    public function execute(
        ?CarbonImmutable $dateFrom = null,
        ?CarbonImmutable $dateTo = null,
    ): array {
        $requestQuery = SmartBuyRequest::query();

        $this->applyDateFilter(
            $requestQuery,
            $dateFrom,
            $dateTo,
        );

        $totalRequests = (clone $requestQuery)->count();

        $requestStatusCounts = (clone $requestQuery)
            ->select('status')
            ->selectRaw('COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->map(
                static fn (mixed $count): int => (int) $count,
            )
            ->all();

        $requestIds = (clone $requestQuery)
            ->select('id');

        $quoteMetrics = $this->getQuoteMetrics(
            $requestQuery,
        );

        $paymentMetrics = $this->getPaymentMetrics(
            $requestIds,
        );

        $outstandingAmount = max(
            0,
            round(
                $quoteMetrics['accepted_value']
                - $paymentMetrics['completed_amount'],
                2,
            ),
        );

        $completedRequests = $requestStatusCounts[
        SmartBuyRequest::STATUS_COMPLETED
        ] ?? 0;

        $pendingRequests = $requestStatusCounts[
        SmartBuyRequest::STATUS_PENDING
        ] ?? 0;

        $processingRequests =
            ($requestStatusCounts[
            SmartBuyRequest::STATUS_QUOTE_SENT
            ] ?? 0)
            + ($requestStatusCounts[
            SmartBuyRequest::STATUS_QUOTE_ACCEPTED
            ] ?? 0)
            + ($requestStatusCounts[
            SmartBuyRequest::STATUS_PAYMENT_COMPLETED
            ] ?? 0)
            + ($requestStatusCounts[
            SmartBuyRequest::STATUS_PRODUCT_PURCHASED
            ] ?? 0)
            + ($requestStatusCounts[
            SmartBuyRequest::STATUS_IN_TRANSIT
            ] ?? 0);

        $cancelledRequests = $requestStatusCounts[
        SmartBuyRequest::STATUS_CANCELLED
        ] ?? 0;

        $completionRate = $totalRequests > 0
            ? round(
                ($completedRequests / $totalRequests) * 100,
                2,
            )
            : 0.0;

        $paymentCollectionRate =
            $quoteMetrics['accepted_value'] > 0
                ? round(
                (
                    $paymentMetrics['completed_amount']
                    / $quoteMetrics['accepted_value']
                ) * 100,
                2,
            )
                : 0.0;

        $cancellationRate = $totalRequests > 0
            ? round(
                ($cancelledRequests / $totalRequests) * 100,
                2,
            )
            : 0.0;

        $averageRequestValue = $totalRequests > 0
            ? round(
                $quoteMetrics['total_value']
                / $totalRequests,
                2,
            )
            : 0.0;

        $dailyRows = $this->getDailyRows(
            $requestQuery,
        );

        return [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,

            'requests' => [
                'total' => $totalRequests,
                'completed' => $completedRequests,
                'pending' => $pendingRequests,
                'processing' => $processingRequests,
                'cancelled' => $cancelledRequests,
                'status_counts' => $requestStatusCounts,
            ],

            'quotes' => [
                'total_value' => $quoteMetrics['total_value'],
                'accepted_value' => $quoteMetrics['accepted_value'],
            ],

            'payments' => [
                'total' => $paymentMetrics['total'],
                'completed' => $paymentMetrics['completed'],
                'pending' => $paymentMetrics['pending'],
                'processing' => $paymentMetrics['processing'],
                'failed' => $paymentMetrics['failed'],
                'cancelled' => $paymentMetrics['cancelled'],
                'refunded' => $paymentMetrics['refunded'],
                'total_amount' => $paymentMetrics['total_amount'],
                'completed_amount' => $paymentMetrics['completed_amount'],
                'refunded_amount' => $paymentMetrics['refunded_amount'],
            ],

            'financial' => [
                'requested_value' => $quoteMetrics['total_value'],
                'accepted_value' => $quoteMetrics['accepted_value'],
                'paid_amount' => $paymentMetrics['completed_amount'],
                'outstanding_amount' => $outstandingAmount,
                'refunded_amount' => $paymentMetrics['refunded_amount'],
            ],

            'performance' => [
                'completion_rate' => $completionRate,
                'payment_collection_rate' => $paymentCollectionRate,
                'cancellation_rate' => $cancellationRate,
                'average_request_value' => $averageRequestValue,
            ],

            'rows' => $dailyRows,
        ];
    }

    /**
     * Apply the selected date range to Smart Buy requests.
     */
    private function applyDateFilter(
        Builder $query,
        ?CarbonImmutable $dateFrom,
        ?CarbonImmutable $dateTo,
    ): void {
        if ($dateFrom !== null) {
            $query->where(
                'created_at',
                '>=',
                $dateFrom->startOfDay(),
            );
        }

        if ($dateTo !== null) {
            $query->where(
                'created_at',
                '<=',
                $dateTo->endOfDay(),
            );
        }
    }

    /**
     * Get quote-related report metrics.
     *
     * @return array{
     *     total_value: float,
     *     accepted_value: float
     * }
     */
    private function getQuoteMetrics(
        Builder $requestQuery,
    ): array {
        $requestsWithLatestQuote = (clone $requestQuery)
            ->select('smart_buy_requests.id')
            ->selectSub(
                SmartBuyQuote::query()
                    ->select('total_amount')
                    ->whereColumn(
                        'smart_buy_request_id',
                        'smart_buy_requests.id',
                    )
                    ->latest('id')
                    ->limit(1),
                'latest_quote_total',
            )
            ->selectSub(
                SmartBuyQuote::query()
                    ->select('status')
                    ->whereColumn(
                        'smart_buy_request_id',
                        'smart_buy_requests.id',
                    )
                    ->latest('id')
                    ->limit(1),
                'latest_quote_status',
            );

        $metrics = DB::query()
            ->fromSub(
                $requestsWithLatestQuote,
                'report_requests',
            )
            ->selectRaw(
                'COALESCE(SUM(latest_quote_total), 0) as total_value',
            )
            ->selectRaw(
                'COALESCE(
                    SUM(
                        CASE
                            WHEN latest_quote_status = ?
                            THEN latest_quote_total
                            ELSE 0
                        END
                    ),
                    0
                ) as accepted_value',
                [SmartBuyQuote::STATUS_ACCEPTED],
            )
            ->first();

        return [
            'total_value' => round(
                (float) ($metrics->total_value ?? 0),
                2,
            ),
            'accepted_value' => round(
                (float) ($metrics->accepted_value ?? 0),
                2,
            ),
        ];
    }

    /**
     * Get payment-related report metrics.
     *
     * @return array<string, int|float>
     */
    private function getPaymentMetrics(
        Builder $requestIds,
    ): array {
        $paymentQuery = SmartBuyPayment::query()
            ->whereIn(
                'smart_buy_request_id',
                $requestIds,
            );

        $statusCounts = (clone $paymentQuery)
            ->select('status')
            ->selectRaw('COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->map(
                static fn (mixed $count): int => (int) $count,
            )
            ->all();

        $totalAmount = (float) (
        (clone $paymentQuery)->sum('amount')
        );

        $completedAmount = (float) (
        (clone $paymentQuery)
            ->where(
                'status',
                SmartBuyPayment::STATUS_COMPLETED,
            )
            ->sum('amount')
        );

        $refundedAmount = (float) (
        (clone $paymentQuery)
            ->where(
                'status',
                SmartBuyPayment::STATUS_REFUNDED,
            )
            ->sum('amount')
        );

        return [
            'total' => array_sum($statusCounts),

            'completed' => $statusCounts[
                SmartBuyPayment::STATUS_COMPLETED
                ] ?? 0,

            'pending' => $statusCounts[
                SmartBuyPayment::STATUS_PENDING
                ] ?? 0,

            'processing' => $statusCounts[
                SmartBuyPayment::STATUS_PROCESSING
                ] ?? 0,

            'failed' => $statusCounts[
                SmartBuyPayment::STATUS_FAILED
                ] ?? 0,

            'cancelled' => $statusCounts[
                SmartBuyPayment::STATUS_CANCELLED
                ] ?? 0,

            'refunded' => $statusCounts[
                SmartBuyPayment::STATUS_REFUNDED
                ] ?? 0,

            'total_amount' => round(
                $totalAmount,
                2,
            ),

            'completed_amount' => round(
                $completedAmount,
                2,
            ),

            'refunded_amount' => round(
                $refundedAmount,
                2,
            ),
        ];
    }

    /**
     * Get daily Smart Buy report rows.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getDailyRows(Builder $requestQuery): array
    {
        $requests = (clone $requestQuery)
            ->select([
                'smart_buy_requests.id',
                'smart_buy_requests.status',
                'smart_buy_requests.created_at',
            ])
            ->orderBy('smart_buy_requests.created_at')
            ->get();

        if ($requests->isEmpty()) {
            return [];
        }

        $requestIds = $requests
            ->pluck('id')
            ->values();

        $latestQuotes = SmartBuyQuote::query()
            ->select([
                'smart_buy_quotes.id',
                'smart_buy_quotes.smart_buy_request_id',
                'smart_buy_quotes.total_amount',
                'smart_buy_quotes.status',
            ])
            ->whereIn(
                'smart_buy_quotes.smart_buy_request_id',
                $requestIds,
            )
            ->whereIn(
                'smart_buy_quotes.id',
                function (QueryBuilder $query) use (
                    $requestIds
                ): void {
                    $query
                        ->selectRaw(
                            'MAX(smart_buy_quotes.id)',
                        )
                        ->from('smart_buy_quotes')
                        ->whereIn(
                            'smart_buy_quotes.smart_buy_request_id',
                            $requestIds,
                        )
                        ->groupBy(
                            'smart_buy_quotes.smart_buy_request_id',
                        );
                },
            )
            ->get()
            ->keyBy('smart_buy_request_id');

        $payments = SmartBuyPayment::query()
            ->whereIn(
                'smart_buy_request_id',
                $requestIds,
            )
            ->get([
                'smart_buy_request_id',
                'amount',
                'status',
            ]);

        $paymentsByRequest = $payments->groupBy(
            'smart_buy_request_id',
        );

        $rows = [];

        foreach ($requests as $request) {
            $date = $request->created_at->format('Y-m-d');

            if (! isset($rows[$date])) {
                $rows[$date] = [
                    'date' => $date,
                    'requests' => 0,
                    'completed' => 0,
                    'pending' => 0,
                    'processing' => 0,
                    'cancelled' => 0,
                    'accepted_value' => 0.0,
                    'paid_amount' => 0.0,
                    'outstanding_amount' => 0.0,
                    'refunded_amount' => 0.0,
                ];
            }

            $rows[$date]['requests']++;

            if (
                $request->status ===
                SmartBuyRequest::STATUS_COMPLETED
            ) {
                $rows[$date]['completed']++;
            }

            if (
                $request->status ===
                SmartBuyRequest::STATUS_PENDING
            ) {
                $rows[$date]['pending']++;
            }

            if (in_array(
                $request->status,
                [
                    SmartBuyRequest::STATUS_QUOTE_SENT,
                    SmartBuyRequest::STATUS_QUOTE_ACCEPTED,
                    SmartBuyRequest::STATUS_PAYMENT_COMPLETED,
                    SmartBuyRequest::STATUS_PRODUCT_PURCHASED,
                    SmartBuyRequest::STATUS_IN_TRANSIT,
                ],
                true,
            )) {
                $rows[$date]['processing']++;
            }

            if (
                $request->status ===
                SmartBuyRequest::STATUS_CANCELLED
            ) {
                $rows[$date]['cancelled']++;
            }

            $quote = $latestQuotes->get($request->id);

            $acceptedValue = 0.0;

            if (
                $quote !== null
                && $quote->status ===
                SmartBuyQuote::STATUS_ACCEPTED
            ) {
                $acceptedValue = (float) $quote->total_amount;

                $rows[$date]['accepted_value'] +=
                    $acceptedValue;
            }

            $requestPayments = $paymentsByRequest->get(
                $request->id,
                collect(),
            );

            $paidAmount = (float) $requestPayments
                ->where(
                    'status',
                    SmartBuyPayment::STATUS_COMPLETED,
                )
                ->sum('amount');

            $refundedAmount = (float) $requestPayments
                ->where(
                    'status',
                    SmartBuyPayment::STATUS_REFUNDED,
                )
                ->sum('amount');

            $rows[$date]['paid_amount'] += $paidAmount;

            $rows[$date]['refunded_amount'] +=
                $refundedAmount;

            $rows[$date]['outstanding_amount'] += max(
                0,
                $acceptedValue - $paidAmount,
            );
        }

        return array_values($rows);
    }

    /**
     * Paginate the generated daily report rows.
     *
     * @param array<int, array<string, mixed>> $rows
     */
    private function paginateRows(
        array $rows,
        int $perPage,
        int $page,
    ): LengthAwarePaginator {
        $perPage = max(1, $perPage);
        $page = max(1, $page);

        $collection = new Collection($rows);

        $items = $collection
            ->forPage(
                $page,
                $perPage,
            )
            ->values();

        return new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ],
        );
    }
}
