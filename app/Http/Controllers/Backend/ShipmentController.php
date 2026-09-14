<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Actions\Shipment\CreateShipment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ShipmentRequest;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class ShipmentController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $status = trim((string) $request->input('status'));
        $deliveryStatus = trim(
            (string) $request->input('delivery_status'),
        );

        $baseQuery = Shipment::query();

        $shipments = (clone $baseQuery)
            ->with([
                'order.user',
            ])
            ->when(
                $search !== '',
                function (Builder $query) use ($search): void {
                    $query->where(function (Builder $query) use (
                        $search,
                    ): void {
                        $query
                            ->where(
                                'tracking_number',
                                'like',
                                '%' . $search . '%',
                            )
                            ->orWhere(
                                'carrier',
                                'like',
                                '%' . $search . '%',
                            )
                            ->orWhereHas(
                                'order',
                                function (Builder $query) use (
                                    $search,
                                ): void {
                                    $query
                                        ->where(
                                            'order_number',
                                            'like',
                                            '%' . $search . '%',
                                        )
                                        ->orWhere(
                                            'first_name',
                                            'like',
                                            '%' . $search . '%',
                                        )
                                        ->orWhere(
                                            'last_name',
                                            'like',
                                            '%' . $search . '%',
                                        )
                                        ->orWhere(
                                            'email',
                                            'like',
                                            '%' . $search . '%',
                                        );
                                },
                            );
                    });
                },
            )
            ->when(
                $status !== '',
                function (Builder $query) use ($status): void {
                    $query->where('status', $status);
                },
            )
            ->when(
                $deliveryStatus !== '',
                function (Builder $query) use (
                    $deliveryStatus,
                ): void {
                    $query->where(
                        'delivery_status',
                        $deliveryStatus,
                    );
                },
            )
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $totalShipments = (clone $baseQuery)->count();

        $pendingShipments = (clone $baseQuery)
            ->where(
                'status',
                Shipment::STATUS_PENDING,
            )
            ->count();

        $processingShipments = (clone $baseQuery)
            ->where(
                'status',
                Shipment::STATUS_PROCESSING,
            )
            ->count();

        $shippedShipments = (clone $baseQuery)
            ->where(
                'status',
                Shipment::STATUS_SHIPPED,
            )
            ->count();

        $deliveredShipments = (clone $baseQuery)
            ->where(
                'delivery_status',
                Shipment::DELIVERY_STATUS_DELIVERED,
            )
            ->count();

        return view(
            'backend.pages.ecommerce.shipments.index',
            [
                'shipments' => $shipments,
                'search' => $search,
                'status' => $status,
                'deliveryStatus' => $deliveryStatus,
                'totalShipments' => $totalShipments,
                'pendingShipments' => $pendingShipments,
                'processingShipments' => $processingShipments,
                'shippedShipments' => $shippedShipments,
                'deliveredShipments' => $deliveredShipments,
                'shipmentStatuses' => [
                    Shipment::STATUS_PENDING,
                    Shipment::STATUS_PROCESSING,
                    Shipment::STATUS_SHIPPED,
                    Shipment::STATUS_CANCELLED,
                ],
                'deliveryStatuses' => [
                    Shipment::DELIVERY_STATUS_PENDING,
                    Shipment::DELIVERY_STATUS_IN_TRANSIT,
                    Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY,
                    Shipment::DELIVERY_STATUS_DELIVERED,
                    Shipment::DELIVERY_STATUS_FAILED,
                ],
            ],
        );
    }

    public function create(Order $order): View
    {
        $order->load([
            'user',
            'items',
            'shipment',
        ]);

        if (
            $order->payment_status !== Order::PAYMENT_STATUS_PAID
        ) {
            abort(
                403,
                'Shipment creation requires confirmed payment.',
            );
        }

        if ($order->shipment !== null) {
            return view(
                'backend.pages.ecommerce.shipments.details',
                [
                    'shipment' => $order->shipment,
                    'order' => $order,
                ],
            );
        }

        return view(
            'backend.pages.ecommerce.shipments.create',
            compact('order'),
        );
    }

    public function store(
        ShipmentRequest $request,
        CreateShipment $createShipment,
    ): RedirectResponse {
        $shipment = $createShipment->execute($request);

        return redirect()
            ->route(
                'admin-order-details',
                [
                    'order' => $shipment->order_id,
                ],
            )
            ->with(
                'success',
                'Shipment created successfully.',
            );
    }

    public function show(Shipment $shipment): View
    {
        $shipment->load([
            'order.user',
            'order.items.product',
            'order.items.variant.values.attribute',
        ]);

        return view(
            'backend.pages.ecommerce.shipments.details',
            [
                'shipment' => $shipment,
                'order' => $shipment->order,
            ],
        );
    }

    public function updateStatus(
        Request $request,
        Shipment $shipment,
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    Shipment::STATUS_PENDING,
                    Shipment::STATUS_PROCESSING,
                    Shipment::STATUS_SHIPPED,
                    Shipment::STATUS_CANCELLED,
                ]),
            ],

            'delivery_status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    Shipment::DELIVERY_STATUS_PENDING,
                    Shipment::DELIVERY_STATUS_IN_TRANSIT,
                    Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY,
                    Shipment::DELIVERY_STATUS_DELIVERED,
                    Shipment::DELIVERY_STATUS_FAILED,
                ]),
            ],
        ]);

        $status = $validated['status'];
        $deliveryStatus = $validated['delivery_status'];

        DB::transaction(function () use (
            $shipment,
            $status,
            $deliveryStatus,
        ): void {
            /*
             * ============================================================
             * LOCK SHIPMENT
             * ============================================================
             */

            $lockedShipment = Shipment::query()
                ->whereKey($shipment->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * ============================================================
             * LOCK RELATED ORDER
             * ============================================================
             */

            $order = Order::query()
                ->whereKey($lockedShipment->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * ============================================================
             * SHIPMENT DATA
             * ============================================================
             */

            $data = [
                'status' => $status,
                'delivery_status' => $deliveryStatus,
            ];

            /*
             * ============================================================
             * SHIPPED DATE
             * ============================================================
             */

            if (
                $status === Shipment::STATUS_SHIPPED
                && $lockedShipment->shipped_at === null
            ) {
                $data['shipped_at'] = now();
            }

            /*
             * Keep existing shipped date when moving
             * between shipment states.
             */
            if (
                $status !== Shipment::STATUS_SHIPPED
                && $status !== Shipment::STATUS_CANCELLED
                && $lockedShipment->shipped_at !== null
            ) {
                $data['shipped_at'] = $lockedShipment->shipped_at;
            }

            /*
             * ============================================================
             * DELIVERED DATE
             * ============================================================
             */

            if (
                $deliveryStatus
                === Shipment::DELIVERY_STATUS_DELIVERED
                && $lockedShipment->delivered_at === null
            ) {
                $data['delivered_at'] = now();
            }

            /*
             * Clear delivered date if delivery moves backwards.
             */
            if (
                $deliveryStatus
                !== Shipment::DELIVERY_STATUS_DELIVERED
            ) {
                $data['delivered_at'] = null;
            }

            /*
             * ============================================================
             * UPDATE SHIPMENT
             * ============================================================
             */

            $lockedShipment->update($data);

            /*
             * ============================================================
             * RESOLVE ORDER STATUS
             * ============================================================
             *
             * The shipment status and delivery status are used
             * to synchronize the related order status.
             */

            $orderStatus = $this->resolveOrderStatus(
                $status,
                $deliveryStatus,
                $order,
            );

            /*
             * ============================================================
             * UPDATE ORDER
             * ============================================================
             */

            if (
                $orderStatus !== null
                && $order->status !== $orderStatus
            ) {
                $order->update([
                    'status' => $orderStatus,
                ]);
            }
        });

        return redirect()
            ->route(
                'ecommerce-shipments.show',
                [
                    'shipment' => $shipment->id,
                ],
            )
            ->with(
                'success',
                'Shipment and order status updated successfully.',
            );
    }

    /**
     * Resolve the related order status from shipment state.
     */
    private function resolveOrderStatus(
        string $shipmentStatus,
        string $deliveryStatus,
        Order $order,
    ): ?string {
        /*
         * ============================================================
         * CANCELLED
         * ============================================================
         */

        if (
            $shipmentStatus === Shipment::STATUS_CANCELLED
        ) {
            return Order::STATUS_CANCELLED;
        }

        /*
         * ============================================================
         * DELIVERED
         * ============================================================
         *
         * Delivery completed means the order has reached
         * the delivered stage.
         */

        if (
            $deliveryStatus
            === Shipment::DELIVERY_STATUS_DELIVERED
        ) {
            return Order::STATUS_DELIVERED;
        }

        /*
         * ============================================================
         * OUT FOR DELIVERY
         * ============================================================
         */

        if (
            $deliveryStatus
            === Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY
        ) {
            return Order::STATUS_OUT_FOR_DELIVERY;
        }

        /*
         * ============================================================
         * IN TRANSIT
         * ============================================================
         */

        if (
            $deliveryStatus
            === Shipment::DELIVERY_STATUS_IN_TRANSIT
        ) {
            return Order::STATUS_IN_TRANSIT;
        }

        /*
         * ============================================================
         * DELIVERY FAILED
         * ============================================================
         *
         * Failed delivery should not mark the order as failed.
         * The shipment can still be retried or resolved.
         */

        if (
            $deliveryStatus
            === Shipment::DELIVERY_STATUS_FAILED
        ) {
            return Order::STATUS_PROCESSING;
        }

        /*
         * ============================================================
         * SHIPPED
         * ============================================================
         */

        if (
            $shipmentStatus === Shipment::STATUS_SHIPPED
        ) {
            return Order::STATUS_SHIPPED;
        }

        /*
         * ============================================================
         * SHIPMENT PROCESSING
         * ============================================================
         */

        if (
            $shipmentStatus === Shipment::STATUS_PROCESSING
        ) {
            return Order::STATUS_PROCESSING;
        }

        /*
         * ============================================================
         * SHIPMENT PENDING
         * ============================================================
         *
         * Don't move a later order state backwards.
         */

        if (
            $shipmentStatus === Shipment::STATUS_PENDING
            && $deliveryStatus === Shipment::DELIVERY_STATUS_PENDING
        ) {
            if (
                $order->status === Order::STATUS_PENDING
                || $order->status === Order::STATUS_PAID
            ) {
                return Order::STATUS_PAID;
            }
        }

        /*
         * No order status change required.
         */

        return null;
    }
}
