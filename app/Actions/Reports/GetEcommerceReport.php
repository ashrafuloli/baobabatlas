<?php

declare(strict_types=1);

namespace App\Actions\Reports;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Refund;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class GetEcommerceReport
{
    /**
     * Generate the ecommerce report.
     *
     * @return array<string, mixed>
     */
    public function execute(
        ?CarbonImmutable $dateFrom = null,
        ?CarbonImmutable $dateTo = null,
        ?string $status = null,
    ): array {
        $orderQuery = $this->getOrderQuery(
            $dateFrom,
            $dateTo,
            $status,
        );

        return [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'status' => $status,
            'summary' => $this->getSummary(
                clone $orderQuery,
            ),
            'daily_sales' => $this->getDailySales(
                clone $orderQuery,
            ),
            'product_sales' => $this->getProductSales(
                clone $orderQuery,
            ),
            'category_sales' => $this->getCategorySales(
                clone $orderQuery,
            ),
        ];
    }

    /**
     * Build the base order query.
     */
    private function getOrderQuery(
        ?CarbonImmutable $dateFrom,
        ?CarbonImmutable $dateTo,
        ?string $status = null,
    ): Builder {
        $query = Order::query();

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

        if ($status !== null && $status !== '') {
            $query->where(
                'status',
                $status,
            );
        }

        return $query;
    }

    /**
     * Generate summary metrics.
     *
     * @return array<string, int|float>
     */
    private function getSummary(
        Builder $orderQuery,
    ): array {
        $orders = $orderQuery->get([
            'id',
            'total',
            'payment_status',
        ]);

        if ($orders->isEmpty()) {
            return [
                'total_orders' => 0,
                'total_sales' => 0.0,
                'paid_amount' => 0.0,
                'outstanding_amount' => 0.0,
                'refunded_amount' => 0.0,
                'average_order_value' => 0.0,
            ];
        }

        $orderIds = $orders
            ->pluck('id')
            ->map(
                static fn (mixed $id): int => (int) $id,
            )
            ->all();

        $totalOrders = $orders->count();

        $totalSales = (float) $orders->sum(
            static fn (Order $order): float =>
            (float) $order->total,
        );

        $paidAmount = (float) $orders
            ->filter(
                static fn (Order $order): bool =>
                    $order->payment_status
                    === Order::PAYMENT_STATUS_PAID,
            )
            ->sum(
                static fn (Order $order): float =>
                (float) $order->total,
            );

        $refundedAmount = $this->getRefundedAmount(
            $orderIds,
        );

        $outstandingAmount = max(
            0.0,
            $totalSales - $paidAmount,
        );

        return [
            'total_orders' => $totalOrders,
            'total_sales' => round(
                $totalSales,
                2,
            ),
            'paid_amount' => round(
                $paidAmount,
                2,
            ),
            'outstanding_amount' => round(
                $outstandingAmount,
                2,
            ),
            'refunded_amount' => round(
                $refundedAmount,
                2,
            ),
            'average_order_value' => $totalOrders > 0
                ? round(
                    $totalSales / $totalOrders,
                    2,
                )
                : 0.0,
        ];
    }

    /**
     * Generate individual order sales rows.
     *
     * Each order is represented by one row.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getDailySales(
        Builder $orderQuery,
    ): array {
        $orders = $orderQuery
            ->orderBy('created_at')
            ->orderBy('id')
            ->get([
                'id',
                'order_number',
                'status',
                'payment_status',
                'total',
                'created_at',
            ]);

        if ($orders->isEmpty()) {
            return [];
        }

        $orderIds = $orders
            ->pluck('id')
            ->map(
                static fn (mixed $id): int => (int) $id,
            )
            ->all();

        $refunds = Refund::query()
            ->whereIn(
                'order_id',
                $orderIds,
            )
            ->where(
                'status',
                Refund::STATUS_SUCCEEDED,
            )
            ->get([
                'order_id',
                'amount',
            ])
            ->groupBy('order_id');

        $rows = [];

        foreach ($orders as $order) {
            $sales = (float) $order->total;

            $paid = $order->payment_status
            === Order::PAYMENT_STATUS_PAID
                ? $sales
                : 0.0;

            $outstanding = max(
                0.0,
                $sales - $paid,
            );

            $refunded = (float) $refunds
                ->get(
                    $order->id,
                    collect(),
                )
                ->sum(
                    static fn (Refund $refund): float =>
                    (float) $refund->amount,
                );

            $rows[] = [
                'date' => $order->created_at->toDateString(),
                'order_id' => (int) $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'sales' => round(
                    $sales,
                    2,
                ),
                'paid_amount' => round(
                    $paid,
                    2,
                ),
                'outstanding_amount' => round(
                    $outstanding,
                    2,
                ),
                'refunded_amount' => round(
                    $refunded,
                    2,
                ),
            ];
        }

        return $rows;
    }

    /**
     * Generate product sales report.
     *
     * @return array<int, array<string, int|float|string|null>>
     */
    private function getProductSales(
        Builder $orderQuery,
    ): array {
        $orderIds = $orderQuery->pluck('id');

        if ($orderIds->isEmpty()) {
            return [];
        }

        return OrderItem::query()
            ->whereIn(
                'order_id',
                $orderIds,
            )
            ->select([
                'product_id',
                'product_name',
                DB::raw(
                    'COUNT(DISTINCT order_id) as orders',
                ),
                DB::raw(
                    'SUM(quantity) as units_sold',
                ),
                DB::raw(
                    'SUM(line_total) as revenue',
                ),
            ])
            ->groupBy(
                'product_id',
                'product_name',
            )
            ->orderByDesc('revenue')
            ->get()
            ->map(
                static function (
                    OrderItem $item,
                ): array {
                    return [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'orders' => (int) $item->orders,
                        'units_sold' => (int) $item->units_sold,
                        'revenue' => round(
                            (float) $item->revenue,
                            2,
                        ),
                    ];
                },
            )
            ->values()
            ->all();
    }

    /**
     * Generate category sales report.
     *
     * Each product's revenue is attributed to
     * its first assigned category.
     *
     * @return array<int, array<string, int|float|string>>
     */
    private function getCategorySales(
        Builder $orderQuery,
    ): array {
        $orderIds = $orderQuery->pluck('id');

        if ($orderIds->isEmpty()) {
            return [];
        }

        $items = OrderItem::query()
            ->whereIn(
                'order_id',
                $orderIds,
            )
            ->get([
                'order_id',
                'product_id',
                'quantity',
                'line_total',
            ]);

        if ($items->isEmpty()) {
            return [];
        }

        $productIds = $items
            ->pluck('product_id')
            ->filter()
            ->unique()
            ->values();

        if ($productIds->isEmpty()) {
            return [];
        }

        $products = Product::query()
            ->with([
                'categories:id,name',
            ])
            ->whereIn(
                'id',
                $productIds,
            )
            ->get([
                'id',
            ])
            ->keyBy('id');

        $categoryData = [];

        foreach ($items as $item) {
            if ($item->product_id === null) {
                continue;
            }

            $product = $products->get(
                $item->product_id,
            );

            if ($product === null) {
                continue;
            }

            $category = $product->categories->first();

            if ($category === null) {
                continue;
            }

            $categoryId = (int) $category->id;

            if (! isset($categoryData[$categoryId])) {
                $categoryData[$categoryId] = [
                    'category_id' => $categoryId,
                    'category_name' => $category->name,
                    'order_ids' => [],
                    'units_sold' => 0,
                    'revenue' => 0.0,
                ];
            }

            $categoryData[$categoryId]['order_ids'][] =
                $item->order_id;

            $categoryData[$categoryId]['units_sold'] +=
                (int) $item->quantity;

            $categoryData[$categoryId]['revenue'] +=
                (float) $item->line_total;
        }

        if ($categoryData === []) {
            return [];
        }

        $totalRevenue = array_sum(
            array_column(
                $categoryData,
                'revenue',
            ),
        );

        $rows = [];

        foreach ($categoryData as $category) {
            $revenue = (float) $category['revenue'];

            $rows[] = [
                'category_id' => $category['category_id'],
                'category_name' => $category['category_name'],
                'orders' => count(
                    array_unique(
                        $category['order_ids'],
                    ),
                ),
                'units_sold' => $category['units_sold'],
                'revenue' => round(
                    $revenue,
                    2,
                ),
                'sales_percentage' => $totalRevenue > 0
                    ? round(
                        ($revenue / $totalRevenue) * 100,
                        2,
                    )
                    : 0.0,
            ];
        }

        usort(
            $rows,
            static fn (
                array $first,
                array $second,
            ): int => $second['revenue']
                <=> $first['revenue'],
        );

        return $rows;
    }

    /**
     * Calculate successful refund amount.
     *
     * @param array<int, int> $orderIds
     */
    private function getRefundedAmount(
        array $orderIds,
    ): float {
        if ($orderIds === []) {
            return 0.0;
        }

        return (float) Refund::query()
            ->whereIn(
                'order_id',
                $orderIds,
            )
            ->where(
                'status',
                Refund::STATUS_SUCCEEDED,
            )
            ->sum('amount');
    }
}
