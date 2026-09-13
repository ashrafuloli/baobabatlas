<?php

declare(strict_types=1);

namespace App\Actions\Shipment;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;

final class UpdateShipment
{
    /**
     * Update shipment information and synchronize the
     * related order status when appropriate.
     *
     * @param array<string, mixed> $data
     */
    public function execute(
        Shipment $shipment,
        array $data,
    ): Shipment {
        return DB::transaction(function () use (
            $shipment,
            $data,
        ): Shipment {
            $shipment = Shipment::query()
                ->whereKey($shipment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $order = Order::query()
                ->whereKey($shipment->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            $shipmentStatus = (string) (
                $data['status']
                ?? $shipment->status
            );

            $deliveryStatus = (string) (
                $data['delivery_status']
                ?? $shipment->delivery_status
            );

            $updateData = [
                'carrier' => isset($data['carrier'])
                    ? trim((string) $data['carrier'])
                    : null,

                'tracking_number' => isset($data['tracking_number'])
                    ? trim((string) $data['tracking_number'])
                    : null,

                'status' => $shipmentStatus,

                'delivery_status' => $deliveryStatus,

                'notes' => isset($data['notes'])
                    ? trim((string) $data['notes'])
                    : null,
            ];

            /*
             * =========================================================
             * Shipped Timestamp
             * =========================================================
             */

            if (
                $shipmentStatus === Shipment::STATUS_SHIPPED
                && $shipment->shipped_at === null
            ) {
                $updateData['shipped_at'] = now();
            }

            /*
             * If shipment is moved away from shipped,
             * remove the shipped timestamp.
             */
            if (
                $shipmentStatus
                !== Shipment::STATUS_SHIPPED
            ) {
                $updateData['shipped_at'] = null;
            }

            /*
             * =========================================================
             * Delivered Timestamp
             * =========================================================
             */

            if (
                $deliveryStatus
                === Shipment::DELIVERY_STATUS_DELIVERED
                && $shipment->delivered_at === null
            ) {
                $updateData['delivered_at'] = now();
            }

            /*
             * If delivery is moved away from delivered,
             * remove the delivered timestamp.
             */
            if (
                $deliveryStatus
                !== Shipment::DELIVERY_STATUS_DELIVERED
            ) {
                $updateData['delivered_at'] = null;
            }

            $shipment->update($updateData);

            /*
             * =========================================================
             * Order Status Synchronization
             * =========================================================
             *
             * Refund status has priority over normal shipment-driven
             * order status changes.
             *
             * Once a refund is requested, approved, or completed,
             * shipment updates must not overwrite the order's
             * refund-related state or cause misleading status changes.
             */

            $hasActiveRefund = in_array(
                $order->refund_status,
                [
                    Order::REFUND_STATUS_PENDING,
                    Order::REFUND_STATUS_APPROVED,
                    Order::REFUND_STATUS_REFUNDED,
                ],
                true,
            );

            if (! $hasActiveRefund) {
                $this->synchronizeOrderStatus(
                    $order,
                    $shipmentStatus,
                    $deliveryStatus,
                );
            }

            return $shipment->fresh([
                'order',
            ]);
        });
    }

    /**
     * Synchronize the normal order status with shipment progress.
     */
    private function synchronizeOrderStatus(
        Order $order,
        string $shipmentStatus,
        string $deliveryStatus,
    ): void {
        /*
         * Delivered shipment means completed order.
         */
        if (
            $deliveryStatus
            === Shipment::DELIVERY_STATUS_DELIVERED
        ) {
            $order->update([
                'status' => Order::STATUS_COMPLETED,
            ]);

            return;
        }

        /*
         * Cancelled shipment means cancelled order.
         */
        if (
            $shipmentStatus
            === Shipment::STATUS_CANCELLED
        ) {
            $order->update([
                'status' => Order::STATUS_CANCELLED,
            ]);

            return;
        }

        /*
         * Processing or shipped shipment means
         * the order is being fulfilled.
         *
         * Do not move cancelled or completed orders backwards.
         */
        if (
            in_array(
                $shipmentStatus,
                [
                    Shipment::STATUS_PROCESSING,
                    Shipment::STATUS_SHIPPED,
                ],
                true,
            )
            && ! in_array(
                $order->status,
                [
                    Order::STATUS_CANCELLED,
                    Order::STATUS_COMPLETED,
                ],
                true,
            )
        ) {
            $order->update([
                'status' => Order::STATUS_PROCESSING,
            ]);
        }
    }
}
