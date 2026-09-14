<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SmartBuyItem;
use App\Models\SmartBuyPayment;
use App\Models\SmartBuyQuote;
use App\Models\SmartBuyQuoteItem;
use App\Models\SmartBuyRequest;
use App\Models\SmartBuyShipment;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class SmartBuySeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $user = User::query()->first();

            if ($user === null) {
                $user = User::factory()->create();
            }

            $admin = User::query()->first() ?? $user;

            $this->clearTestData();

            $this->createRequests(
                $user,
                $admin,
            );
        });
    }

    private function clearTestData(): void
    {
        $requestIds = SmartBuyRequest::query()
            ->where('request_number', 'like', 'SBR-TEST-%')
            ->pluck('id');

        if ($requestIds->isEmpty()) {
            return;
        }

        $quoteIds = SmartBuyQuote::query()
            ->whereIn(
                'smart_buy_request_id',
                $requestIds,
            )
            ->pluck('id');

        if ($quoteIds->isNotEmpty()) {
            SmartBuyQuoteItem::query()
                ->whereIn(
                    'smart_buy_quote_id',
                    $quoteIds,
                )
                ->delete();
        }

        SmartBuyPayment::query()
            ->whereIn(
                'smart_buy_request_id',
                $requestIds,
            )
            ->delete();

        SmartBuyShipment::query()
            ->whereIn(
                'smart_buy_request_id',
                $requestIds,
            )
            ->delete();

        SmartBuyQuote::query()
            ->whereIn(
                'smart_buy_request_id',
                $requestIds,
            )
            ->delete();

        SmartBuyItem::query()
            ->whereIn(
                'smart_buy_request_id',
                $requestIds,
            )
            ->delete();

        SmartBuyRequest::query()
            ->whereIn('id', $requestIds)
            ->delete();
    }

    private function createRequests(
        User $user,
        User $admin,
    ): void {
        $statuses = [
            SmartBuyRequest::STATUS_PENDING,
            SmartBuyRequest::STATUS_QUOTE_SENT,
            SmartBuyRequest::STATUS_QUOTE_ACCEPTED,
            SmartBuyRequest::STATUS_QUOTE_REJECTED,
            SmartBuyRequest::STATUS_PAYMENT_COMPLETED,
            SmartBuyRequest::STATUS_PRODUCT_PURCHASED,
            SmartBuyRequest::STATUS_IN_TRANSIT,
            SmartBuyRequest::STATUS_COMPLETED,
            SmartBuyRequest::STATUS_CANCELLED,
        ];

        $today = CarbonImmutable::today();

        foreach ($statuses as $index => $status) {
            $createdAt = $today
                ->subDays($index * 2)
                ->setTime(
                    10 + ($index % 6),
                    15,
                );

            $request = $this->createRequest(
                $user,
                $status,
                $index + 1,
                $createdAt,
            );

            $items = $this->createItems($request);

            $quote = $this->createQuote(
                $request,
                $items,
                $admin,
                $index,
                $createdAt,
            );

            $this->createPayment(
                $request,
                $quote,
                $index,
                $createdAt,
            );

            $this->createShipment(
                $request,
                $index,
                $createdAt,
            );
        }

        $this->createAdditionalDailyData(
            $user,
            $admin,
        );
    }

    private function createRequest(
        User $user,
        string $status,
        int $requestIndex,
        CarbonImmutable $createdAt,
    ): SmartBuyRequest {
        return SmartBuyRequest::query()->create([
            'user_id' => $user->id,
            'request_number' => $this->requestNumber(
                $requestIndex,
            ),
            'first_name' => $user->name ?? 'Test',
            'last_name' => 'Customer',
            'phone' => '+1555000' . str_pad(
                    (string) $requestIndex,
                    4,
                    '0',
                    STR_PAD_LEFT,
                ),
            'email' => $user->email,
            'country' => 'United States',
            'city' => 'New York',
            'zip_code' => '10001',
            'delivery_address' => '123 Test Street',
            'status' => $status,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);
    }

    /**
     * Create additional requests on different dates
     * to make the daily report easier to test.
     */
    private function createAdditionalDailyData(
        User $user,
        User $admin,
    ): void {
        $today = CarbonImmutable::today();

        for ($day = 0; $day < 30; $day++) {
            $date = $today
                ->subDays($day)
                ->setTime(14, 30);

            $requestsPerDay = match ($day % 5) {
                0 => 3,
                1 => 2,
                2 => 4,
                3 => 1,
                default => 2,
            };

            for ($index = 0; $index < $requestsPerDay; $index++) {
                $requestIndex = ($day * 10) + $index + 100;

                $status = match ($index % 5) {
                    0 => SmartBuyRequest::STATUS_COMPLETED,
                    1 => SmartBuyRequest::STATUS_PENDING,
                    2 => SmartBuyRequest::STATUS_QUOTE_ACCEPTED,
                    3 => SmartBuyRequest::STATUS_PAYMENT_COMPLETED,
                    default => SmartBuyRequest::STATUS_CANCELLED,
                };

                $createdAt = $date->addMinutes(
                    $index * 20,
                );

                $request = $this->createRequest(
                    $user,
                    $status,
                    $requestIndex,
                    $createdAt,
                );

                $items = $this->createItems($request);

                $quote = $this->createQuote(
                    $request,
                    $items,
                    $admin,
                    $requestIndex,
                    $createdAt,
                );

                $this->createPayment(
                    $request,
                    $quote,
                    $requestIndex,
                    $createdAt,
                );

                if (
                    in_array(
                        $status,
                        [
                            SmartBuyRequest::STATUS_PRODUCT_PURCHASED,
                            SmartBuyRequest::STATUS_IN_TRANSIT,
                            SmartBuyRequest::STATUS_COMPLETED,
                        ],
                        true
                    )
                ) {
                    $this->createShipment(
                        $request,
                        $requestIndex,
                        $createdAt,
                    );
                }
            }
        }
    }

    /**
     * Create Smart Buy items.
     *
     * @return array<int, SmartBuyItem>
     */
    private function createItems(
        SmartBuyRequest $request,
    ): array {
        $products = [
            [
                'name' => 'Apple MacBook Pro 16-inch',
                'price' => 2499.00,
            ],
            [
                'name' => 'Sony WH-1000XM6 Headphones',
                'price' => 449.00,
            ],
            [
                'name' => 'Nike Air Max Shoes',
                'price' => 189.00,
            ],
        ];

        $items = [];

        foreach ($products as $index => $product) {
            if (
                $index > 0
                && $request->id % 2 === 0
            ) {
                break;
            }

            $quantity = ($request->id % 3) + 1;

            $items[] = SmartBuyItem::query()->create([
                'smart_buy_request_id' => $request->id,
                'product_url' => 'https://example.com/product/' .
                    $request->id . '-' . $index,
                'product_name' => $product['name'],
                'quantity' => $quantity,
                'size' => $index === 2 ? '10' : null,
                'color' => $index === 2 ? 'Black' : null,
                'product_image' => null,
                'notes' => 'Test Smart Buy item.',
            ]);
        }

        return $items;
    }

    private function createQuote(
        SmartBuyRequest $request,
        array $items,
        User $admin,
        int $index,
        CarbonImmutable $createdAt,
    ): SmartBuyQuote {
        $productTotal = 0.00;

        foreach ($items as $item) {
            $unitPrice = $this->productPrice(
                $item->product_name,
            );

            $productTotal += $unitPrice * $item->quantity;
        }

        $serviceFee = 75.00;
        $shippingFee = 35.00;

        $totalAmount = $productTotal
            + $serviceFee
            + $shippingFee;

        $status = match ($request->status) {
            SmartBuyRequest::STATUS_PENDING =>
            SmartBuyQuote::STATUS_DRAFT,

            SmartBuyRequest::STATUS_QUOTE_SENT =>
            SmartBuyQuote::STATUS_SENT,

            SmartBuyRequest::STATUS_QUOTE_ACCEPTED,
            SmartBuyRequest::STATUS_PAYMENT_COMPLETED,
            SmartBuyRequest::STATUS_PRODUCT_PURCHASED,
            SmartBuyRequest::STATUS_IN_TRANSIT,
            SmartBuyRequest::STATUS_COMPLETED =>
            SmartBuyQuote::STATUS_ACCEPTED,

            SmartBuyRequest::STATUS_QUOTE_REJECTED =>
            SmartBuyQuote::STATUS_REJECTED,

            SmartBuyRequest::STATUS_CANCELLED =>
            SmartBuyQuote::STATUS_ACCEPTED,

            default =>
            SmartBuyQuote::STATUS_DRAFT,
        };

        $sentAt = in_array(
            $status,
            [
                SmartBuyQuote::STATUS_SENT,
                SmartBuyQuote::STATUS_ACCEPTED,
                SmartBuyQuote::STATUS_REJECTED,
            ],
            true
        )
            ? $createdAt->addHours(4)
            : null;

        $acceptedAt = $status ===
        SmartBuyQuote::STATUS_ACCEPTED
            ? $createdAt->addHours(8)
            : null;

        $rejectedAt = $status ===
        SmartBuyQuote::STATUS_REJECTED
            ? $createdAt->addHours(8)
            : null;

        $quote = SmartBuyQuote::query()->create([
            'smart_buy_request_id' => $request->id,
            'quote_number' => $this->quoteNumber(
                $index + 1,
            ),
            'product_total' => $productTotal,
            'service_fee' => $serviceFee,
            'shipping_fee' => $shippingFee,
            'total_amount' => $totalAmount,
            'currency' => 'USD',
            'status' => $status,
            'notes' => 'Test Smart Buy quote.',
            'sent_at' => $sentAt,
            'accepted_at' => $acceptedAt,
            'rejected_at' => $rejectedAt,
            'expires_at' => $createdAt->addDays(7),
            'created_by' => $admin->id,
            'created_at' => $createdAt->addHours(2),
            'updated_at' => $createdAt->addHours(2),
        ]);

        foreach ($items as $item) {
            $unitPrice = $this->productPrice(
                $item->product_name,
            );

            SmartBuyQuoteItem::query()->create([
                'smart_buy_quote_id' => $quote->id,
                'smart_buy_item_id' => $item->id,
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $item->quantity,
                'notes' => 'Test quote item.',
            ]);
        }

        return $quote;
    }

    private function createPayment(
        SmartBuyRequest $request,
        SmartBuyQuote $quote,
        int $index,
        CarbonImmutable $createdAt,
    ): void {
        $paymentStatus = match ($request->status) {
            SmartBuyRequest::STATUS_PAYMENT_COMPLETED,
            SmartBuyRequest::STATUS_PRODUCT_PURCHASED,
            SmartBuyRequest::STATUS_IN_TRANSIT,
            SmartBuyRequest::STATUS_COMPLETED =>
            SmartBuyPayment::STATUS_COMPLETED,

            SmartBuyRequest::STATUS_QUOTE_ACCEPTED =>
            SmartBuyPayment::STATUS_PENDING,

            SmartBuyRequest::STATUS_CANCELLED =>
            SmartBuyPayment::STATUS_CANCELLED,

            SmartBuyRequest::STATUS_QUOTE_REJECTED =>
            SmartBuyPayment::STATUS_FAILED,

            default =>
            SmartBuyPayment::STATUS_PENDING,
        };

        $amount = (float) $quote->total_amount;

        if (
            $request->status ===
            SmartBuyRequest::STATUS_COMPLETED
        ) {
            $amount = max(
                0,
                $amount - 150,
            );
        }

        $paidAt = $paymentStatus ===
        SmartBuyPayment::STATUS_COMPLETED
            ? $createdAt->addHours(12)
            : null;

        $payment = SmartBuyPayment::query()->create([
            'smart_buy_request_id' => $request->id,
            'smart_buy_quote_id' => $quote->id,
            'payment_number' => $this->paymentNumber(
                $index + 1,
            ),
            'amount' => $amount,
            'currency' => 'USD',
            'payment_method' => 'card',
            'payment_gateway' => 'stripe',
            'transaction_id' => $paymentStatus ===
            SmartBuyPayment::STATUS_COMPLETED
                ? 'txn_test_' . $request->id
                : null,
            'status' => $paymentStatus,
            'paid_at' => $paidAt,
            'notes' => 'Test Smart Buy payment.',
            'created_at' => $createdAt->addHours(14),
            'updated_at' => $createdAt->addHours(14),
        ]);

        /*
         * The database allows only one payment per request.
         *
         * So instead of creating a second refunded payment,
         * update the existing payment to refunded.
         */
        if (
            $request->status ===
            SmartBuyRequest::STATUS_COMPLETED
            && $request->id % 4 === 0
        ) {
            $payment->update([
                'status' => SmartBuyPayment::STATUS_REFUNDED,
                'transaction_id' => 'refund_test_' .
                    $request->id,
                'paid_at' => null,
                'notes' => 'Test refunded payment.',
                'updated_at' => $createdAt->addDays(1),
            ]);
        }
    }

    private function createShipment(
        SmartBuyRequest $request,
        int $index,
        CarbonImmutable $createdAt,
    ): void {
        $status = match ($request->status) {
            SmartBuyRequest::STATUS_PRODUCT_PURCHASED =>
            SmartBuyShipment::STATUS_PREPARING,

            SmartBuyRequest::STATUS_IN_TRANSIT =>
            SmartBuyShipment::STATUS_IN_TRANSIT,

            SmartBuyRequest::STATUS_COMPLETED =>
            SmartBuyShipment::STATUS_DELIVERED,

            default =>
            SmartBuyShipment::STATUS_PENDING,
        };

        $shippedAt = in_array(
            $status,
            [
                SmartBuyShipment::STATUS_SHIPPED,
                SmartBuyShipment::STATUS_IN_TRANSIT,
            ],
            true
        )
            ? $createdAt->addDays(2)
            : null;

        $deliveredAt = $status ===
        SmartBuyShipment::STATUS_DELIVERED
            ? $createdAt->addDays(6)
            : null;

        SmartBuyShipment::query()->create([
            'smart_buy_request_id' => $request->id,
            'shipment_number' => $this->shipmentNumber(
                $index + 1,
            ),
            'tracking_number' => 'TRACK' .
                str_pad(
                    (string) $request->id,
                    8,
                    '0',
                    STR_PAD_LEFT,
                ),
            'carrier' => 'UPS',
            'shipping_method' => 'Standard Shipping',
            'tracking_url' => 'https://example.com/tracking/' .
                $request->id,
            'status' => $status,
            'shipped_at' => $shippedAt,
            'estimated_delivery_at' => $createdAt->addDays(7),
            'delivered_at' => $deliveredAt,
            'country' => 'United States',
            'city' => 'New York',
            'zip_code' => '10001',
            'delivery_address' => '123 Test Street',
            'notes' => 'Test Smart Buy shipment.',
            'created_by' => $request->user_id,
            'created_at' => $createdAt->addDay(),
            'updated_at' => $createdAt->addDay(),
        ]);
    }

    private function productPrice(string $productName): float
    {
        return match ($productName) {
            'Apple MacBook Pro 16-inch' => 2499.00,
            'Sony WH-1000XM6 Headphones' => 449.00,
            default => 189.00,
        };
    }

    private function requestNumber(int $number): string
    {
        return 'SBR-TEST-' . str_pad(
                (string) $number,
                6,
                '0',
                STR_PAD_LEFT,
            );
    }

    private function quoteNumber(int $number): string
    {
        return 'SBQ-TEST-' . str_pad(
                (string) $number,
                6,
                '0',
                STR_PAD_LEFT,
            );
    }

    private function paymentNumber(int $number): string
    {
        return 'SBP-TEST-' . str_pad(
                (string) $number,
                6,
                '0',
                STR_PAD_LEFT,
            );
    }

    private function shipmentNumber(int $number): string
    {
        return 'SBS-TEST-' . str_pad(
                (string) $number,
                6,
                '0',
                STR_PAD_LEFT,
            );
    }
}
