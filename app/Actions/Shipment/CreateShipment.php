<?php

declare(strict_types=1);

namespace App\Actions\Shipment;

use App\Http\Requests\Backend\ShipmentRequest;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class CreateShipment
{
    public function execute(
        ShipmentRequest $request,
    ): Shipment {
        return DB::transaction(function () use ($request): Shipment {
            $order = Order::query()
                ->lockForUpdate()
                ->findOrFail($request->integer('order_id'));

            if (
                $order->payment_status
                !== Order::PAYMENT_STATUS_PAID
            ) {
                throw ValidationException::withMessages([
                    'order_id' => 'A shipment can only be created after the order payment is confirmed.',
                ]);
            }

            if ($order->status === Order::STATUS_CANCELLED) {
                throw ValidationException::withMessages([
                    'order_id' => 'A shipment cannot be created for a cancelled order.',
                ]);
            }

            if ($order->status === Order::STATUS_FAILED) {
                throw ValidationException::withMessages([
                    'order_id' => 'A shipment cannot be created for a failed order.',
                ]);
            }

            if ($order->shipment()->exists()) {
                throw ValidationException::withMessages([
                    'order_id' => 'A shipment already exists for this order.',
                ]);
            }

            $status = $request->string('status')->toString();

            $shippedAt = $request->date('shipped_at');

            if (
                $status === Shipment::STATUS_SHIPPED
                && $shippedAt === null
            ) {
                $shippedAt = now();
            }

            return Shipment::query()->create([
                'order_id' => $order->id,
                'carrier' => $request->string('carrier')->toString(),
                'tracking_number' => $request
                    ->string('tracking_number')
                    ->toString(),
                'status' => $status,
                'delivery_status' => $request
                    ->string('delivery_status')
                    ->toString(),
                'shipped_at' => $shippedAt,
                'delivered_at' => $request->date('delivered_at'),
                'notes' => $request->input('notes'),
            ]);
        });
    }
}
