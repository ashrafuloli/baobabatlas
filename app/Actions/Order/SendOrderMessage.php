<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Models\Order;
use App\Models\OrderMessage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class SendOrderMessage
{
    /**
     * Send a message regarding an order.
     *
     * @param array{
     *     order_item_id?: int|null,
     *     message: string
     * } $data
     */
    public function execute(
        Order $order,
        User $user,
        array $data
    ): OrderMessage {
        return DB::transaction(function () use (
            $order,
            $user,
            $data
        ): OrderMessage {
            $order->loadMissing('items');

            if ($order->user_id !== $user->id) {
                throw new \DomainException(
                    'You are not authorized to message about this order.'
                );
            }

            $orderItemId = $data['order_item_id'] ?? null;

            if ($orderItemId !== null) {
                $orderItemExists = $order->items
                    ->contains(
                        fn ($item): bool => $item->id === $orderItemId
                    );

                if (! $orderItemExists) {
                    throw new \DomainException(
                        'The selected order item does not belong to this order.'
                    );
                }
            }

            return OrderMessage::query()->create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'order_item_id' => $orderItemId,
                'message' => trim((string) $data['message']),
            ]);
        });
    }
}
