<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Refund;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class EcommerceReportSeeder extends Seeder
{
    private const DEMO_PREFIX = 'DEMO-REPORT-';

    /**
     * Seed realistic ecommerce report data.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $userIds = User::query()
                ->pluck('id')
                ->values();

            $products = Product::query()
                ->where('status', true)
                ->get([
                    'id',
                    'name',
                    'sku',
                    'price',
                    'shipping_cost',
                ]);

            if ($userIds->isEmpty()) {
                $this->command?->warn(
                    'EcommerceReportSeeder skipped: no users found.',
                );

                return;
            }

            if ($products->isEmpty()) {
                $this->command?->warn(
                    'EcommerceReportSeeder skipped: no products found.',
                );

                return;
            }

            $this->clearDemoData();

            $today = CarbonImmutable::today();

            /*
             * Create 45 orders across the last 30 days.
             *
             * This intentionally creates several orders today so
             * the default Today report has visible data.
             */
            for ($index = 1; $index <= 45; $index++) {
                $createdAt = $this->resolveCreatedAt(
                    $index,
                    $today,
                );

                $order = $this->createOrder(
                    userId: (int) $userIds->random(),
                    orderNumber: self::DEMO_PREFIX
                    . str_pad(
                        (string) $index,
                        4,
                        '0',
                        STR_PAD_LEFT,
                    ),
                    createdAt: $createdAt,
                );

                $this->createOrderItems(
                    order: $order,
                    products: $products,
                    seed: $index,
                );

                $order->refresh();

                $this->createRefundIfNeeded(
                    order: $order,
                    index: $index,
                );
            }
        });
    }

    /**
     * Remove only this seeder's demo records.
     */
    private function clearDemoData(): void
    {
        $orders = Order::query()
            ->where(
                'order_number',
                'like',
                self::DEMO_PREFIX . '%',
            )
            ->get([
                'id',
            ]);

        if ($orders->isEmpty()) {
            return;
        }

        Refund::query()
            ->whereIn(
                'order_id',
                $orders->pluck('id'),
            )
            ->delete();

        DB::table('order_items')
            ->whereIn(
                'order_id',
                $orders->pluck('id'),
            )
            ->delete();

        Order::query()
            ->whereIn(
                'id',
                $orders->pluck('id'),
            )
            ->delete();
    }

    /**
     * Resolve a realistic order date.
     */
    private function resolveCreatedAt(
        int $index,
        CarbonImmutable $today,
    ): CarbonImmutable {
        /*
         * First 5 orders are today.
         */
        if ($index <= 5) {
            return $today
                ->setTime(
                    9 + $index,
                    15,
                );
        }

        /*
         * Remaining orders are distributed across the
         * previous 29 days.
         */
        $daysAgo = (($index * 7) % 29) + 1;

        $hour = 9 + (($index * 3) % 10);
        $minute = ($index * 13) % 60;

        return $today
            ->subDays($daysAgo)
            ->setTime($hour, $minute);
    }

    /**
     * Create an order with varied statuses and payment states.
     */
    private function createOrder(
        int $userId,
        string $orderNumber,
        CarbonImmutable $createdAt,
    ): Order {
        $statusData = $this->resolveStatus(
            (int) substr($orderNumber, -4),
        );

        $order = new Order();

        $order->user_id = $userId;
        $order->order_number = $orderNumber;
        $order->status = $statusData['status'];
        $order->payment_status = $statusData['payment_status'];
        $order->refund_status = Order::REFUND_STATUS_NONE;
        $order->payment_gateway = $statusData['payment_gateway'];
        $order->stripe_checkout_session_id = null;
        $order->stripe_payment_intent_id = null;
        $order->currency = 'usd';

        /*
         * These values are updated after order items are created.
         */
        $order->subtotal = 0;
        $order->discount = $statusData['discount'];
        $order->shipping = 0;
        $order->tax = 0;
        $order->total = 0;

        $order->first_name = 'Demo';
        $order->last_name = 'Customer ' . $userId;
        $order->email = 'demo.customer.' . $userId
            . '@example.test';
        $order->phone = '+1 555 010 '
            . str_pad(
                (string) $userId,
                4,
                '0',
                STR_PAD_LEFT,
            );

        $order->country = 'United States';
        $order->address = '100 Demo Commerce Street';
        $order->apartment = null;
        $order->city = 'New York';
        $order->state = 'NY';
        $order->postal_code = '10001';
        $order->notes = 'Demo ecommerce report order.';

        if (
            $statusData['payment_status']
            === Order::PAYMENT_STATUS_PAID
        ) {
            $order->paid_at = $createdAt
                ->addMinutes(5);
        } else {
            $order->paid_at = null;
        }

        $order->created_at = $createdAt;
        $order->updated_at = $createdAt;

        $order->save();

        return $order;
    }

    /**
     * Create 1-3 order item lines.
     */
    private function createOrderItems(
        Order $order,
        \Illuminate\Database\Eloquent\Collection $products,
        int $seed,
    ): void {
        $itemCount = 1 + ($seed % 3);

        $selectedProducts = $products
            ->shuffle()
            ->take($itemCount);

        $subtotal = 0.0;
        $shipping = 0.0;

        foreach ($selectedProducts as $product) {
            $quantity = 1 + (($seed + $product->id) % 3);

            $unitPrice = (float) $product->price;

            $lineTotal = round(
                $unitPrice * $quantity,
                2,
            );

            $itemShipping = round(
                (float) $product->shipping_cost,
                2,
            );

            DB::table('order_items')->insert([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'variant_id' => null,
                'product_name' => $product->name,
                'sku' => $product->sku,
                'image' => null,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'shipping_cost' => $itemShipping,
                'line_total' => $lineTotal,
                'created_at' => $order->created_at,
                'updated_at' => $order->created_at,
            ]);

            $subtotal += $lineTotal;
            $shipping += $itemShipping;
        }

        $discount = (float) $order->discount;

        /*
         * Keep discount from exceeding subtotal.
         */
        $discount = min(
            $discount,
            $subtotal,
        );

        $tax = round(
            max(0, $subtotal - $discount) * 0.08,
            2,
        );

        $total = round(
            $subtotal
            - $discount
            + $shipping
            + $tax,
            2,
        );

        $order->update([
            'subtotal' => round($subtotal, 2),
            'shipping' => round($shipping, 2),
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    /**
     * Create successful refunds for selected completed orders.
     */
    private function createRefundIfNeeded(
        Order $order,
        int $index,
    ): void {
        /*
         * Refund roughly 1 out of every 8 demo orders.
         */
        if (
            $index % 8 !== 0
            || $order->status !== Order::STATUS_COMPLETED
            || $order->payment_status !== Order::PAYMENT_STATUS_PAID
        ) {
            return;
        }

        $refundAmount = round(
            min(
                (float) $order->total * 0.35,
                (float) $order->total,
            ),
            2,
        );

        if ($refundAmount <= 0) {
            return;
        }

        Refund::create([
            'order_id' => $order->id,
            'refund_request_id' => null,
            'stripe_refund_id' => 're_demo_'
                . $order->id,
            'stripe_idempotency_key' => 'demo_refund_'
                . $order->id,
            'amount' => $refundAmount,
            'currency' => $order->currency,
            'status' => Refund::STATUS_SUCCEEDED,
        ]);

        $order->update([
            'refund_status' => Order::REFUND_STATUS_REFUNDED,
        ]);
    }

    /**
     * Resolve varied order/payment statuses.
     *
     * @return array{
     *     status: string,
     *     payment_status: string,
     *     payment_gateway: string,
     *     discount: float
     * }
     */
    private function resolveStatus(int $index): array
    {
        return match ($index % 10) {
            0 => [
                'status' => Order::STATUS_CANCELLED,
                'payment_status' => Order::PAYMENT_STATUS_FAILED,
                'payment_gateway' => 'stripe',
                'discount' => 0.0,
            ],

            1 => [
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_STATUS_PENDING,
                'payment_gateway' => 'stripe',
                'discount' => 0.0,
            ],

            2 => [
                'status' => Order::STATUS_PROCESSING,
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'payment_gateway' => 'stripe',
                'discount' => 20.0,
            ],

            3 => [
                'status' => Order::STATUS_COMPLETED,
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'payment_gateway' => 'stripe',
                'discount' => 25.0,
            ],

            4 => [
                'status' => Order::STATUS_PAID,
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'payment_gateway' => 'stripe',
                'discount' => 10.0,
            ],

            5 => [
                'status' => Order::STATUS_PROCESSING,
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'payment_gateway' => 'paypal',
                'discount' => 15.0,
            ],

            6 => [
                'status' => Order::STATUS_COMPLETED,
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'payment_gateway' => 'paypal',
                'discount' => 30.0,
            ],

            7 => [
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_STATUS_PENDING,
                'payment_gateway' => 'paypal',
                'discount' => 0.0,
            ],

            8 => [
                'status' => Order::STATUS_COMPLETED,
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'payment_gateway' => 'stripe',
                'discount' => 35.0,
            ],

            default => [
                'status' => Order::STATUS_FAILED,
                'payment_status' => Order::PAYMENT_STATUS_FAILED,
                'payment_gateway' => 'stripe',
                'discount' => 0.0,
            ],
        };
    }
}
