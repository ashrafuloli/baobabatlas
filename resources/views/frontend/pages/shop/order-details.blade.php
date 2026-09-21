@extends('frontend.layouts.frontend')

@section('title', 'Order Details')

@section('contents')

    @php
        /*
        |--------------------------------------------------------------------------
        | Order Status
        |--------------------------------------------------------------------------
        */

        $orderStatus = $order->status;

        $shipment = $order->shipment;

        $shipmentStatus = $shipment?->status;

        $deliveryStatus = $shipment?->delivery_status;


        /*
        |--------------------------------------------------------------------------
        | Customer-Facing Status
        |--------------------------------------------------------------------------
        */

        $status = match (true) {

            $orderStatus === \App\Models\Order::STATUS_FAILED
                => 'failed',

            $orderStatus === \App\Models\Order::STATUS_CANCELLED
                => 'cancelled',

            $deliveryStatus === \App\Models\Shipment::DELIVERY_STATUS_DELIVERED
                => 'delivered',

            $orderStatus === \App\Models\Order::STATUS_COMPLETED
                => 'completed',

            $orderStatus === \App\Models\Order::STATUS_DELIVERED
                => 'delivered',

            $deliveryStatus === \App\Models\Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY
                => 'out_for_delivery',

            $orderStatus === \App\Models\Order::STATUS_OUT_FOR_DELIVERY
                => 'out_for_delivery',

            $deliveryStatus === \App\Models\Shipment::DELIVERY_STATUS_IN_TRANSIT
                => 'in_transit',

            $orderStatus === \App\Models\Order::STATUS_IN_TRANSIT
                => 'in_transit',

            $orderStatus === \App\Models\Order::STATUS_SHIPPED
                => 'shipped',

            $shipmentStatus === \App\Models\Order::SHIPMENT_STATUS_SHIPPED
                => 'shipped',

            $orderStatus === \App\Models\Order::STATUS_PROCESSING
                => 'processing',

            $shipmentStatus === \App\Models\Order::SHIPMENT_STATUS_PREPARING
                => 'processing',

            $orderStatus === \App\Models\Order::STATUS_PAID
                => 'paid',

            default
                => 'pending',
        };


        /*
        |--------------------------------------------------------------------------
        | Status Label
        |--------------------------------------------------------------------------
        */

        $statusLabel = match ($status) {

            'paid' =>
                'Paid',

            'processing' =>
                'Processing',

            'shipped' =>
                'Shipped',

            'in_transit' =>
                'In Transit',

            'out_for_delivery' =>
                'Out for Delivery',

            'delivered' =>
                'Delivered',

            'completed' =>
                'Completed',

            'cancelled' =>
                'Cancelled',

            'failed' =>
                'Failed',

            default =>
                'Pending',
        };


        /*
        |--------------------------------------------------------------------------
        | Status Icon
        |--------------------------------------------------------------------------
        */

        $statusIcon = match ($status) {

            'paid' =>
                'ri-checkbox-circle-line',

            'processing' =>
                'ri-loader-4-line',

            'shipped' =>
                'ri-box-3-line',

            'in_transit' =>
                'ri-truck-line',

            'out_for_delivery' =>
                'ri-map-pin-time-line',

            'delivered' =>
                'ri-checkbox-circle-fill',

            'completed' =>
                'ri-checkbox-circle-fill',

            'cancelled' =>
                'ri-close-circle-line',

            'failed' =>
                'ri-error-warning-line',

            default =>
                'ri-time-line',
        };


        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        $canContinuePayment =
            $orderStatus === \App\Models\Order::STATUS_PENDING
            && $order->payment_status
                === \App\Models\Order::PAYMENT_STATUS_PENDING;


        /*
        |--------------------------------------------------------------------------
        | Cancel
        |--------------------------------------------------------------------------
        */

        $canCancelOrder =
            $orderStatus === \App\Models\Order::STATUS_PENDING
            && $order->payment_status
                === \App\Models\Order::PAYMENT_STATUS_PENDING;


        /*
        |--------------------------------------------------------------------------
        | Refund Eligibility
        |--------------------------------------------------------------------------
        */

        $canRequestRefund =
            $order->payment_status
                === \App\Models\Order::PAYMENT_STATUS_PAID
            && in_array(
                $orderStatus,
                [
                    \App\Models\Order::STATUS_PAID,
                    \App\Models\Order::STATUS_PROCESSING,
                    \App\Models\Order::STATUS_SHIPPED,
                    \App\Models\Order::STATUS_IN_TRANSIT,
                    \App\Models\Order::STATUS_OUT_FOR_DELIVERY,
                    \App\Models\Order::STATUS_DELIVERED,
                    \App\Models\Order::STATUS_COMPLETED,
                ],
                true,
            );


        /*
        |--------------------------------------------------------------------------
        | Refund Amount
        |--------------------------------------------------------------------------
        |
        | Shipping is non-refundable.
        |
        */

        $refundAmount = max(
            0,
            round(
                (float) $order->total
                - (float) $order->shipping,
                2,
            ),
        );


        /*
        |--------------------------------------------------------------------------
        | Latest Refund Request
        |--------------------------------------------------------------------------
        */

        $latestRefundRequest = $order->refundRequests
            ->sortByDesc('created_at')
            ->first();

        $latestRefundStatus = $latestRefundRequest?->status;


        /*
        |--------------------------------------------------------------------------
        | Successful Refund
        |--------------------------------------------------------------------------
        */

        $hasSuccessfulRefund = $order->refunds->contains(
            fn ($refund): bool =>
                $refund->status
                === \App\Models\Refund::STATUS_SUCCEEDED,
        );


        $isRefunded =
            $hasSuccessfulRefund
            || $order->payment_status
                === \App\Models\Order::PAYMENT_STATUS_REFUNDED;


        /*
        |--------------------------------------------------------------------------
        | Refund Request State
        |--------------------------------------------------------------------------
        */

        $hasPendingRefundRequest =
            $latestRefundStatus
            === \App\Models\RefundRequest::STATUS_PENDING;

        $hasApprovedRefundRequest =
            $latestRefundStatus
            === \App\Models\RefundRequest::STATUS_APPROVED;

        $hasRejectedRefundRequest =
            $latestRefundStatus
            === \App\Models\RefundRequest::STATUS_REJECTED;


        /*
        |--------------------------------------------------------------------------
        | New Refund Request Eligibility
        |--------------------------------------------------------------------------
        */

        $canSubmitNewRefundRequest =
            $canRequestRefund
            && ! $isRefunded
            && ! $hasPendingRefundRequest
            && ! $hasApprovedRefundRequest;


        /*
        |--------------------------------------------------------------------------
        | Delivery Information
        |--------------------------------------------------------------------------
        */

        $hasShipment = $shipment !== null;

        $trackingNumber = $shipment?->tracking_number;

        $carrier = $shipment?->carrier;

        $trackingUrl = $shipment?->tracking_url;

        $estimatedDeliveryAt =
            $shipment?->estimated_delivery_at;

        $deliveredAt =
            $shipment?->delivered_at;


        /*
        |--------------------------------------------------------------------------
        | Delivery Status Label
        |--------------------------------------------------------------------------
        */

        $deliveryStatusLabel = match ($deliveryStatus) {

            \App\Models\Shipment::DELIVERY_STATUS_IN_TRANSIT
                => 'In Transit',

            \App\Models\Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY
                => 'Out for Delivery',

            \App\Models\Shipment::DELIVERY_STATUS_DELIVERED
                => 'Delivered',

            \App\Models\Shipment::DELIVERY_STATUS_FAILED
                => 'Delivery Failed',

            default =>
                null,
        };
    @endphp


    <div class="order-details-page">

        <div class="container">

            {{-- =========================================================
                BREADCRUMB
            ========================================================== --}}
            <div class="order-details-page__breadcrumb">

                <a href="{{ route('shop') }}">
                    Shop
                </a>

                <i class="ri-arrow-right-s-line"></i>

                <a href="{{ route('my-orders') }}">
                    My Orders
                </a>

                <i class="ri-arrow-right-s-line"></i>

                <span>
                    Order #{{ $order->order_number }}
                </span>

            </div>


            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <div class="order-details-page__header">

                <div class="order-details-page__header-content">

                    <a
                        href="{{ route('my-orders') }}"
                        class="order-details-page__back"
                    >
                        <i class="ri-arrow-left-line"></i>

                        Back to My Orders
                    </a>

                    <span class="order-details-page__eyebrow">
                        ORDER DETAILS
                    </span>

                    <h1 class="order-details-page__title">
                        Order #{{ $order->order_number }}
                    </h1>

                    <p class="order-details-page__subtitle">
                        Placed on
                        {{ $order->created_at->format('F j, Y') }}
                    </p>

                </div>


                <span
                    class="order-details-page__status order-details-page__status--{{ $status }}"
                >

                    <i class="{{ $statusIcon }}"></i>

                    {{ $statusLabel }}

                </span>

            </div>


            {{-- =========================================================
                PAYMENT ACTIONS
            ========================================================== --}}
            @if($canContinuePayment || $canCancelOrder)

                <section class="order-details-page__payment-actions">

                    <div class="order-details-page__payment-actions-content">

                        <div class="order-details-page__payment-actions-icon">
                            <i class="ri-bank-card-line"></i>
                        </div>

                        <div>

                            <span class="order-details-page__section-label">
                                PAYMENT REQUIRED
                            </span>

                            <h2>
                                Complete your payment
                            </h2>

                            <p>
                                Your order has been placed but payment is
                                still pending. Complete the payment to
                                confirm your order.
                            </p>

                        </div>

                    </div>


                    <div class="order-details-page__payment-actions-buttons">

                        @if($canContinuePayment)

                            <a
                                href="{{ route(
                                    'my-order.payment',
                                    $order
                                ) }}"
                                class="order-details-page__continue-payment"
                            >

                                <i class="ri-bank-card-line"></i>

                                Continue to Payment

                            </a>

                        @endif


                        @if($canCancelOrder)

                            <form
                                action="{{ route(
                                    'my-order.cancel',
                                    $order
                                ) }}"
                                method="POST"
                                class="order-details-page__cancel-form"
                                data-cancel-order
                            >

                                @csrf

                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="order-details-page__cancel-order"
                                >

                                    <i class="ri-close-circle-line"></i>

                                    Cancel Order

                                </button>

                            </form>

                        @endif

                    </div>

                </section>

            @endif


            {{-- =========================================================
                MAIN GRID
            ========================================================== --}}
            <div class="order-details-page__grid">


                {{-- =====================================================
                    MAIN CONTENT
                ====================================================== --}}
                <div class="order-details-page__main">


                    {{-- =================================================
                        ORDER ITEMS
                    ================================================== --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    ORDER ITEMS
                                </span>

                                @php
                                    $totalItemQuantity =
                                        $order->items->sum('quantity');
                                @endphp

                                <h2>
                                    {{ $totalItemQuantity }}

                                    {{ $totalItemQuantity === 1
                                        ? 'Item'
                                        : 'Items'
                                    }}
                                </h2>

                            </div>

                        </div>


                        <div class="order-details-page__items">

                            @foreach($order->items as $item)

                                @php
                                    /*
                                    |--------------------------------------------------------------------------
                                    | Product Type
                                    |--------------------------------------------------------------------------
                                    */

                                    $isVariableItem =
                                        $item->variant_id !== null;

                                    $isSimpleItem =
                                        $item->variant_id === null;


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Variant Attributes
                                    |--------------------------------------------------------------------------
                                    */

                                    $attributes = [];

                                    if (
                                        $isVariableItem
                                        && $item->variant?->values
                                    ) {

                                        foreach (
                                            $item->variant->values
                                            as $variantValue
                                        ) {

                                            $attributeName =
                                                $variantValue
                                                    ->attribute
                                                    ?->name;

                                            $valueName =
                                                $variantValue
                                                    ->attributeValue
                                                    ?->name;


                                            if (
                                                filled($attributeName)
                                                && filled($valueName)
                                            ) {

                                                $attributes[] =
                                                    $attributeName
                                                    . ': '
                                                    . $valueName;

                                            }

                                        }

                                    }


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Image
                                    |--------------------------------------------------------------------------
                                    */

                                    $image =
                                        filled($item->image)
                                            ? trim(
                                                (string) $item->image
                                            )
                                            : null;


                                    $imageUrl = null;


                                    if ($image) {

                                        if (
                                            str_starts_with(
                                                $image,
                                                'http://'
                                            )
                                            || str_starts_with(
                                                $image,
                                                'https://'
                                            )
                                            || str_starts_with(
                                                $image,
                                                '//'
                                            )
                                        ) {

                                            $imageUrl = $image;

                                        } else {

                                            $imageUrl = asset(
                                                ltrim(
                                                    $image,
                                                    '/'
                                                )
                                            );

                                        }

                                    }
                                @endphp


                                <div
                                    class="order-details-page__item"
                                    data-product-type="{{ $isVariableItem ? 'variable' : 'simple' }}"
                                    data-variant-id="{{ $item->variant_id ?? '' }}"
                                >


                                    {{-- IMAGE --}}
                                    <div class="order-details-page__item-image">

                                        @if($imageUrl)

                                            <img
                                                src="{{ $imageUrl }}"
                                                alt="{{ $item->product_name }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <span>
                                                No Image
                                            </span>

                                        @endif

                                    </div>


                                    {{-- INFO --}}
                                    <div class="order-details-page__item-info">

                                        <h3>
                                            {{ $item->product_name }}
                                        </h3>


                                        @if(count($attributes))

                                            <div class="order-details-page__item-attributes">

                                                @foreach($attributes as $attribute)

                                                    <span>
                                                        {{ $attribute }}
                                                    </span>

                                                @endforeach

                                            </div>

                                        @endif


                                        <span class="order-details-page__item-quantity">
                                            Quantity:
                                            {{ $item->quantity }}
                                        </span>


                                        @if(filled($item->sku))

                                            <span class="order-details-page__item-sku">
                                                SKU:
                                                {{ $item->sku }}
                                            </span>

                                        @endif


                                        @if($isVariableItem)

                                            <span class="order-details-page__item-type">
                                                Variant Product
                                            </span>

                                        @endif

                                    </div>


                                    {{-- PRICE --}}
                                    <div class="order-details-page__item-price">

                                        <strong>
                                            ${{ number_format(
                                                (float) $item->line_total,
                                                2
                                            ) }}
                                        </strong>


                                        @if($item->quantity > 1)

                                            <span>
                                                ${{ number_format(
                                                    (float) $item->unit_price,
                                                    2
                                                ) }}
                                                each
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </section>


                    {{-- =================================================
                        DELIVERY TRACKING
                    ================================================== --}}
                    @if($hasShipment)

                        <section class="order-details-page__card">

                            <div class="order-details-page__card-header">

                                <div>

                                    <span class="order-details-page__section-label">
                                        DELIVERY
                                    </span>

                                    <h2>
                                        Shipping & Tracking
                                    </h2>

                                </div>

                                <i class="ri-truck-line"></i>

                            </div>


                            <div class="order-details-page__delivery">

                                @if($deliveryStatusLabel)

                                    <div class="order-details-page__delivery-status">

                                        <span>
                                            Delivery Status
                                        </span>

                                        <strong>
                                            {{ $deliveryStatusLabel }}
                                        </strong>

                                    </div>

                                @endif


                                @if(filled($carrier))

                                    <div class="order-details-page__delivery-row">

                                        <span>
                                            Carrier
                                        </span>

                                        <strong>
                                            {{ $carrier }}
                                        </strong>

                                    </div>

                                @endif


                                @if(filled($trackingNumber))

                                    <div class="order-details-page__delivery-row">

                                        <span>
                                            Tracking Number
                                        </span>

                                        <strong>
                                            {{ $trackingNumber }}
                                        </strong>

                                    </div>

                                @endif


                                @if($estimatedDeliveryAt)

                                    <div class="order-details-page__delivery-row">

                                        <span>
                                            Estimated Delivery
                                        </span>

                                        <strong>
                                            {{ $estimatedDeliveryAt->format('M j, Y') }}
                                        </strong>

                                    </div>

                                @endif


                                @if($deliveredAt)

                                    <div class="order-details-page__delivery-row">

                                        <span>
                                            Delivered On
                                        </span>

                                        <strong>
                                            {{ $deliveredAt->format(
                                                'M j, Y h:i A'
                                            ) }}
                                        </strong>

                                    </div>

                                @endif


                                @if(
                                    filled($trackingUrl)
                                    && filled($trackingNumber)
                                )

                                    <div class="order-details-page__delivery-action">

                                        <a
                                            href="{{ $trackingUrl }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >

                                            <i class="ri-external-link-line"></i>

                                            Track Shipment

                                        </a>

                                    </div>

                                @endif

                            </div>

                        </section>

                    @endif


                    {{-- =================================================
                        REFUND
                    ================================================== --}}
                    @if($canRequestRefund)

                        <section
                            class="
                                order-details-page__card
                                order-details-page__refund-card
                            "
                        >

                            <div class="order-details-page__refund-content">

                                <div
                                    class="
                                        order-details-page__refund-icon
                                        @if($isRefunded)
                                            order-details-page__refund-icon--success
                                        @elseif($hasApprovedRefundRequest)
                                            order-details-page__refund-icon--approved
                                        @elseif($hasPendingRefundRequest)
                                            order-details-page__refund-icon--pending
                                        @elseif($hasRejectedRefundRequest)
                                            order-details-page__refund-icon--rejected
                                        @endif
                                    "
                                >

                                    @if($isRefunded)

                                        <i class="ri-checkbox-circle-line"></i>

                                    @elseif($hasApprovedRefundRequest)

                                        <i class="ri-checkbox-circle-line"></i>

                                    @elseif($hasPendingRefundRequest)

                                        <i class="ri-time-line"></i>

                                    @elseif($hasRejectedRefundRequest)

                                        <i class="ri-close-circle-line"></i>

                                    @else

                                        <i class="ri-refund-2-line"></i>

                                    @endif

                                </div>


                                <div class="order-details-page__refund-info">

                                    <span class="order-details-page__section-label">
                                        REFUND
                                    </span>


                                    @if($isRefunded)

                                        <h2>
                                            Your order has been refunded
                                        </h2>

                                        <p>
                                            Your refund has been successfully
                                            processed. The refundable amount
                                            has been returned through the
                                            original payment method.
                                        </p>

                                    @elseif($hasApprovedRefundRequest)

                                        <h2>
                                            Refund request approved
                                        </h2>

                                        <p>
                                            Your refund request has been
                                            approved by our team. The actual
                                            refund is now being processed.
                                        </p>

                                    @elseif($hasPendingRefundRequest)

                                        <h2>
                                            Refund request is under review
                                        </h2>

                                        <p>
                                            Your refund request has been
                                            submitted successfully. Our team
                                            will review your request and
                                            update its status.
                                        </p>

                                    @elseif($hasRejectedRefundRequest)

                                        <h2>
                                            Refund request was rejected
                                        </h2>

                                        <p>
                                            Your previous refund request was
                                            not approved. You can review the
                                            reason below and submit a new
                                            request if necessary.
                                        </p>

                                    @else

                                        <h2>
                                            Need a refund?
                                        </h2>

                                        <p>
                                            You can request a refund for this
                                            entire order. Shipping charges are
                                            non-refundable.
                                        </p>

                                    @endif


                                    <div class="order-details-page__refund-amount">

                                        <span>
                                            Refundable amount
                                        </span>

                                        <strong>
                                            ${{ number_format(
                                                $refundAmount,
                                                2
                                            ) }}
                                        </strong>

                                    </div>


                                    @if((float) $order->shipping > 0)

                                        <small>
                                            Shipping charge of
                                            ${{ number_format(
                                                (float) $order->shipping,
                                                2
                                            ) }}
                                            is excluded from the refund.
                                        </small>

                                    @endif


                                    {{-- Rejected Request --}}
                                    @if(
                                        $hasRejectedRefundRequest
                                        && $latestRefundRequest
                                    )

                                        <div
                                            class="
                                                order-details-page__refund-rejected
                                            "
                                        >

                                            <div
                                                class="
                                                    order-details-page__refund-rejected-heading
                                                "
                                            >

                                                <i class="ri-information-line"></i>

                                                <span>
                                                    Previous Request
                                                </span>

                                            </div>


                                            <div
                                                class="
                                                    order-details-page__refund-rejected-details
                                                "
                                            >

                                                @if(
                                                    filled(
                                                        $latestRefundRequest->reason
                                                    )
                                                )

                                                    <div>

                                                        <span>
                                                            Reason
                                                        </span>

                                                        <strong>
                                                            {{ $latestRefundRequest->reason }}
                                                        </strong>

                                                    </div>

                                                @endif


                                                @if(
                                                    filled(
                                                        $latestRefundRequest->admin_note
                                                    )
                                                )

                                                    <div>

                                                        <span>
                                                            Admin Note
                                                        </span>

                                                        <p>
                                                            {{ $latestRefundRequest->admin_note }}
                                                        </p>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    @endif


                                    {{-- Approved Request --}}
                                    @if(
                                        $hasApprovedRefundRequest
                                        && $latestRefundRequest
                                    )

                                        <div
                                            class="
                                                order-details-page__refund-approved
                                            "
                                        >

                                            <div
                                                class="
                                                    order-details-page__refund-approved-heading
                                                "
                                            >

                                                <i class="ri-checkbox-circle-line"></i>

                                                <span>
                                                    Approved Request
                                                </span>

                                            </div>


                                            <div
                                                class="
                                                    order-details-page__refund-approved-details
                                                "
                                            >

                                                @if(
                                                    $latestRefundRequest->approver
                                                )

                                                    <div>

                                                        <span>
                                                            Approved By
                                                        </span>

                                                        <strong>
                                                            {{ $latestRefundRequest->approver->name }}
                                                        </strong>

                                                    </div>

                                                @endif


                                                @if(
                                                    $latestRefundRequest->approved_at
                                                )

                                                    <div>

                                                        <span>
                                                            Approved On
                                                        </span>

                                                        <strong>
                                                            {{ $latestRefundRequest->approved_at->format(
                                                                'M d, Y h:i A'
                                                            ) }}
                                                        </strong>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    @endif

                                </div>

                            </div>


                            {{-- Refund Action --}}
                            <div class="order-details-page__refund-action">

                                @if($isRefunded)

                                    <span
                                        class="
                                            order-details-page__refund-status
                                            order-details-page__refund-status--success
                                        "
                                    >

                                        <i class="ri-checkbox-circle-line"></i>

                                        Refunded

                                    </span>

                                @elseif($hasPendingRefundRequest)

                                    <span
                                        class="
                                            order-details-page__refund-status
                                            order-details-page__refund-status--pending
                                        "
                                    >

                                        <i class="ri-time-line"></i>

                                        Refund Request Pending

                                    </span>

                                @elseif($hasApprovedRefundRequest)

                                    <span
                                        class="
                                            order-details-page__refund-status
                                            order-details-page__refund-status--approved
                                        "
                                    >

                                        <i class="ri-checkbox-circle-line"></i>

                                        Refund Approved

                                    </span>

                                @elseif($hasRejectedRefundRequest)

                                    <div
                                        class="
                                            order-details-page__refund-action-group
                                        "
                                    >

                                        <span
                                            class="
                                                order-details-page__refund-status
                                                order-details-page__refund-status--rejected
                                            "
                                        >

                                            <i class="ri-close-circle-line"></i>

                                            Request Rejected

                                        </span>


                                        @if($canSubmitNewRefundRequest)

                                            <button
                                                type="button"
                                                class="
                                                    order-details-page__refund-button
                                                "
                                                data-refund-order
                                                data-order-number="{{ $order->order_number }}"
                                                data-refund-amount="{{ number_format(
                                                    $refundAmount,
                                                    2,
                                                    '.',
                                                    ''
                                                ) }}"
                                            >

                                                <i class="ri-refresh-line"></i>

                                                Request Again

                                            </button>

                                        @endif

                                    </div>

                                @elseif($canSubmitNewRefundRequest)

                                    <button
                                        type="button"
                                        class="
                                            order-details-page__refund-button
                                        "
                                        data-refund-order
                                        data-order-number="{{ $order->order_number }}"
                                        data-refund-amount="{{ number_format(
                                            $refundAmount,
                                            2,
                                            '.',
                                            ''
                                        ) }}"
                                    >

                                        <i class="ri-refund-2-line"></i>

                                        Request Refund

                                    </button>

                                @endif

                            </div>

                        </section>

                    @endif


                    {{-- =================================================
                        SHIPPING ADDRESS
                    ================================================== --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    SHIPPING
                                </span>

                                <h2>
                                    Delivery Address
                                </h2>

                            </div>

                            <i class="ri-map-pin-line"></i>

                        </div>


                        <div class="order-details-page__address">

                            <strong>
                                {{ $order->first_name }}
                                {{ $order->last_name }}
                            </strong>

                            <span>
                                {{ $order->address }}
                            </span>


                            @if(filled($order->apartment))

                                <span>
                                    {{ $order->apartment }}
                                </span>

                            @endif


                            <span>

                                {{ $order->city }}

                                @if(filled($order->state))
                                    , {{ $order->state }}
                                @endif

                                {{ $order->postal_code }}

                            </span>


                            <span>
                                {{ $order->country }}
                            </span>


                            @if(filled($order->phone))

                                <span>
                                    {{ $order->phone }}
                                </span>

                            @endif

                        </div>

                    </section>

                </div>


                {{-- =====================================================
                    SIDEBAR
                ====================================================== --}}
                <aside class="order-details-page__sidebar">


                    {{-- =================================================
                        ORDER SUMMARY
                    ================================================== --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    SUMMARY
                                </span>

                                <h2>
                                    Order Total
                                </h2>

                            </div>

                        </div>


                        <div class="order-details-page__summary">

                            <div>

                                <span>
                                    Subtotal
                                </span>

                                <strong>
                                    ${{ number_format(
                                        (float) $order->subtotal,
                                        2
                                    ) }}
                                </strong>

                            </div>


                            @if((float) $order->discount > 0)

                                <div
                                    class="
                                        order-details-page__summary-discount
                                    "
                                >

                                    <span>
                                        Discount
                                    </span>

                                    <strong>
                                        -${{ number_format(
                                            (float) $order->discount,
                                            2
                                        ) }}
                                    </strong>

                                </div>

                            @endif


                            @if((float) $order->shipping > 0)

                                <div>

                                    <span>
                                        Shipping
                                    </span>

                                    <strong>
                                        ${{ number_format(
                                            (float) $order->shipping,
                                            2
                                        ) }}
                                    </strong>

                                </div>

                            @else

                                <div>

                                    <span>
                                        Shipping
                                    </span>

                                    <strong>
                                        Free
                                    </strong>

                                </div>

                            @endif


                            @if((float) $order->tax > 0)

                                <div>

                                    <span>
                                        Tax
                                    </span>

                                    <strong>
                                        ${{ number_format(
                                            (float) $order->tax,
                                            2
                                        ) }}
                                    </strong>

                                </div>

                            @endif


                            <div class="order-details-page__summary-total">

                                <span>
                                    Total
                                </span>

                                <strong>
                                    ${{ number_format(
                                        (float) $order->total,
                                        2
                                    ) }}
                                </strong>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        PAYMENT
                    ================================================== --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    PAYMENT
                                </span>

                                <h2>
                                    Payment Information
                                </h2>

                            </div>

                        </div>


                        <div class="order-details-page__payment">

                            <div>

                                <span>
                                    Payment Status
                                </span>

                                <strong
                                    class="
                                        order-details-page__payment-status
                                        order-details-page__payment-status--{{ $order->payment_status }}
                                    "
                                >
                                    {{ ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $order->payment_status
                                        )
                                    ) }}
                                </strong>

                            </div>


                            @if(filled($order->payment_gateway))

                                <div>

                                    <span>
                                        Method
                                    </span>

                                    <strong>
                                        {{ ucfirst(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $order->payment_gateway
                                            )
                                        ) }}
                                    </strong>

                                </div>

                            @endif


                            @if($order->paid_at)

                                <div>

                                    <span>
                                        Paid On
                                    </span>

                                    <strong>
                                        {{ $order->paid_at->format(
                                            'M j, Y'
                                        ) }}
                                    </strong>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- =================================================
                        CUSTOMER
                    ================================================== --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>

                                <span class="order-details-page__section-label">
                                    CUSTOMER
                                </span>

                                <h2>
                                    Contact Information
                                </h2>

                            </div>

                        </div>


                        <div class="order-details-page__contact">

                            <div>

                                <i class="ri-user-line"></i>

                                <span>
                                    {{ $order->first_name }}
                                    {{ $order->last_name }}
                                </span>

                            </div>


                            @if(filled($order->email))

                                <div>

                                    <i class="ri-mail-line"></i>

                                    <span>
                                        {{ $order->email }}
                                    </span>

                                </div>

                            @endif


                            @if(filled($order->phone))

                                <div>

                                    <i class="ri-phone-line"></i>

                                    <span>
                                        {{ $order->phone }}
                                    </span>

                                </div>

                            @endif

                        </div>

                    </section>

                </aside>

            </div>


            {{-- =========================================================
                BOTTOM CTA
            ========================================================== --}}
            <div class="order-details-page__bottom">

                <div>

                    <span>
                        Looking for something new?
                    </span>

                    <strong>
                        Explore our latest products.
                    </strong>

                </div>


                <a href="{{ route('shop') }}">

                    Continue Shopping

                    <i class="ri-arrow-right-line"></i>

                </a>

            </div>

        </div>


        {{-- =========================================================
            REFUND MODAL
        ========================================================== --}}
        <div
            class="order-details-page__refund-modal"
            data-refund-modal
            aria-hidden="true"
        >

            {{-- Overlay --}}
            <div
                class="order-details-page__refund-modal-overlay"
                data-refund-close
            ></div>


            {{-- Dialog --}}
            <div
                class="order-details-page__refund-modal-dialog"
                role="dialog"
                aria-modal="true"
                aria-labelledby="refund-modal-title"
            >

                {{-- Close --}}
                <button
                    type="button"
                    class="order-details-page__refund-modal-close"
                    data-refund-close
                    aria-label="Close refund request"
                >

                    <i class="ri-close-line"></i>

                </button>


                {{-- =================================================
                    MODAL HEADER
                ================================================== --}}
                <div class="order-details-page__refund-modal-header">

                    <span class="order-details-page__section-label">
                        REFUND REQUEST
                    </span>

                    <h2 id="refund-modal-title">
                        Request a Refund
                    </h2>

                    <p class="order-details-page__refund-modal-description">
                        Submit a refund request for your order.
                        Our team will review your request before
                        processing the refund.
                    </p>

                </div>


                {{-- =================================================
                    REFUND SUMMARY
                ================================================== --}}
                <div class="order-details-page__refund-modal-summary">

                    {{-- Order --}}
                    <div>

                        <span>
                            Order
                        </span>

                        <strong data-refund-order-number>
                            #{{ $order->order_number }}
                        </strong>

                    </div>


                    {{-- Refundable Amount --}}
                    <div>

                        <span>
                            Refundable Amount
                        </span>

                        <strong data-refund-modal-amount>
                            ${{ number_format(
                                $refundAmount,
                                2
                            ) }}
                        </strong>

                    </div>


                    {{-- Shipping --}}
                    @if((float) $order->shipping > 0)

                        <div>

                            <span>
                                Shipping Excluded
                            </span>

                            <strong>
                                ${{ number_format(
                                    (float) $order->shipping,
                                    2
                                ) }}
                            </strong>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    FULL REFUND NOTICE
                ================================================== --}}
                <div class="order-details-page__refund-notice">

                    <i class="ri-information-line"></i>

                    <div>

                        <strong>
                            Full order refund
                        </strong>

                        <p>
                            This request applies to the entire
                            refundable portion of your order.
                            Shipping charges are non-refundable.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                    REFUND FORM
                ================================================== --}}
                <form
                    action="{{ route(
                        'my-order.refund-request',
                        $order
                    ) }}"
                    method="POST"
                    data-refund-form
                >

                    @csrf


                    {{-- =================================================
                        REASON
                    ================================================== --}}
                    <div class="order-details-page__refund-field">

                        <label for="refund-reason">

                            Reason

                            <span>
                                *
                            </span>

                        </label>

                        <select
                            id="refund-reason"
                            name="reason"
                            required
                        >

                            <option value="">
                                Select a reason
                            </option>

                            <option value="wrong_item">
                                Wrong item received
                            </option>

                            <option value="damaged">
                                Item arrived damaged
                            </option>

                            <option value="defective">
                                Item is defective
                            </option>

                            <option value="not_as_described">
                                Item is not as described
                            </option>

                            <option value="changed_mind">
                                Changed my mind
                            </option>

                            <option value="other">
                                Other
                            </option>

                        </select>

                    </div>


                    {{-- =================================================
                        MESSAGE
                    ================================================== --}}
                    <div class="order-details-page__refund-field">

                        <label for="refund-message">

                            Message

                            <span>
                                (Optional)
                            </span>

                        </label>

                        <textarea
                            id="refund-message"
                            name="message"
                            rows="5"
                            maxlength="5000"
                            placeholder="Please provide additional details about your refund request..."
                        ></textarea>


                        <div class="order-details-page__refund-field-meta">

                            <span>
                                Maximum 5000 characters
                            </span>

                            <span data-refund-message-count>
                                0 / 5000
                            </span>

                        </div>

                    </div>


                    {{-- =================================================
                        FINAL CONFIRMATION
                    ================================================== --}}
                    <div class="order-details-page__refund-confirmation">

                        <i class="ri-shield-check-line"></i>

                        <p>

                            You are requesting a refund of

                            <strong>
                                ${{ number_format(
                                    $refundAmount,
                                    2
                                ) }}
                            </strong>

                            through your original payment method.

                        </p>

                    </div>


                    {{-- =================================================
                        ACTIONS
                    ================================================== --}}
                    <div class="order-details-page__refund-actions">

                        <button
                            type="button"
                            class="order-details-page__refund-cancel"
                            data-refund-close
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            class="order-details-page__refund-submit"
                            data-refund-submit
                        >

                            <i class="ri-send-plane-line"></i>

                            Submit Refund Request

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const page =
                    document.querySelector(
                        '.order-details-page'
                    );


                if (!page) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Cancel Order
                |--------------------------------------------------------------------------
                */

                const cancelForm =
                    page.querySelector(
                        '[data-cancel-order]'
                    );


                if (cancelForm) {

                    cancelForm.addEventListener(
                        'submit',
                        function () {

                            const button =
                                this.querySelector(
                                    'button[type="submit"]'
                                );


                            if (!button) {
                                return;
                            }


                            button.disabled = true;


                            button.innerHTML = `
                                <i class="ri-loader-4-line ri-spin"></i>
                                Cancelling...
                            `;

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Refund Modal
                |--------------------------------------------------------------------------
                */

                const refundModal =
                    page.querySelector(
                        '[data-refund-modal]'
                    );


                const refundButtons =
                    page.querySelectorAll(
                        '[data-refund-order]'
                    );


                const refundForm =
                    page.querySelector(
                        '[data-refund-form]'
                    );


                if (
                    !refundModal
                    || !refundButtons.length
                    || !refundForm
                ) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Refund Fields
                |--------------------------------------------------------------------------
                */

                const reasonInput =
                    refundForm.querySelector(
                        '[name="reason"]'
                    );


                const messageInput =
                    refundForm.querySelector(
                        '[name="message"]'
                    );


                const messageCounter =
                    refundForm.querySelector(
                        '[data-refund-message-count]'
                    );


                /*
                |--------------------------------------------------------------------------
                | Refund Submit Button
                |--------------------------------------------------------------------------
                */

                const submitButton =
                    refundForm.querySelector(
                        '[data-refund-submit]'
                    );


                /*
                |--------------------------------------------------------------------------
                | Open Refund Modal
                |--------------------------------------------------------------------------
                */

                function openRefundModal(button) {

                    const orderNumber =
                        button.dataset.orderNumber || '';


                    const refundAmount =
                        Number(
                            button.dataset.refundAmount || 0
                        );


                    const orderNumberElement =
                        refundModal.querySelector(
                            '[data-refund-order-number]'
                        );


                    const amountElement =
                        refundModal.querySelector(
                            '[data-refund-modal-amount]'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Order Number
                    |--------------------------------------------------------------------------
                    */

                    if (orderNumberElement) {

                        orderNumberElement.textContent =
                            `#${orderNumber}`;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Refund Amount
                    |--------------------------------------------------------------------------
                    */

                    if (amountElement) {

                        amountElement.textContent =
                            `$${refundAmount.toLocaleString(
                                'en-US',
                                {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2,
                                }
                            )}`;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Reset Form
                    |--------------------------------------------------------------------------
                    */

                    refundForm.reset();


                    /*
                    |--------------------------------------------------------------------------
                    | Reset Character Counter
                    |--------------------------------------------------------------------------
                    */

                    if (messageCounter) {

                        messageCounter.textContent =
                            '0 / 5000';

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Reset Submit Button
                    |--------------------------------------------------------------------------
                    */

                    if (submitButton) {

                        submitButton.disabled = false;

                        submitButton.innerHTML = `
                            <i class="ri-send-plane-line"></i>
                            Submit Refund Request
                        `;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Open
                    |--------------------------------------------------------------------------
                    */

                    refundModal.classList.add(
                        'is-open'
                    );


                    refundModal.setAttribute(
                        'aria-hidden',
                        'false'
                    );


                    document.body.classList.add(
                        'order-details-page--modal-open'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Focus
                    |--------------------------------------------------------------------------
                    */

                    window.setTimeout(
                        function () {

                            if (reasonInput) {
                                reasonInput.focus();
                            }

                        },
                        50
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Close Refund Modal
                |--------------------------------------------------------------------------
                */

                function closeRefundModal() {

                    refundModal.classList.remove(
                        'is-open'
                    );


                    refundModal.setAttribute(
                        'aria-hidden',
                        'true'
                    );


                    document.body.classList.remove(
                        'order-details-page--modal-open'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Refund Buttons
                |--------------------------------------------------------------------------
                */

                refundButtons.forEach(
                    function (button) {

                        button.addEventListener(
                            'click',
                            function () {

                                openRefundModal(
                                    this
                                );

                            }
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Close Buttons / Overlay
                |--------------------------------------------------------------------------
                */

                refundModal
                    .querySelectorAll(
                        '[data-refund-close]'
                    )
                    .forEach(
                        function (element) {

                            element.addEventListener(
                                'click',
                                closeRefundModal
                            );

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | Escape Key
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Escape'
                            && refundModal.classList.contains(
                                'is-open'
                            )
                        ) {

                            closeRefundModal();

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Message Character Counter
                |--------------------------------------------------------------------------
                */

                if (
                    messageInput
                    && messageCounter
                ) {

                    function updateMessageCounter() {

                        const length =
                            messageInput.value.length;


                        messageCounter.textContent =
                            `${length} / 5000`;

                    }


                    messageInput.addEventListener(
                        'input',
                        updateMessageCounter
                    );


                    updateMessageCounter();

                }


                /*
                |--------------------------------------------------------------------------
                | Refund Submit
                |--------------------------------------------------------------------------
                */

                refundForm.addEventListener(
                    'submit',
                    function (event) {

                        event.preventDefault();


                        /*
                        |--------------------------------------------------------------------------
                        | Validate Reason
                        |--------------------------------------------------------------------------
                        */

                        if (
                            !reasonInput
                            || !reasonInput.value
                        ) {

                            if (reasonInput) {
                                reasonInput.focus();
                            }


                            if (
                                window.AppToast
                                && typeof window.AppToast.fire
                                === 'function'
                            ) {

                                window.AppToast.fire({
                                    icon: 'error',
                                    title:
                                        'Please select a refund reason.',
                                });

                            }


                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Confirmation
                        |--------------------------------------------------------------------------
                        */

                        const confirmed =
                            window.confirm(
                                'Are you sure you want to submit this refund request?'
                            );


                        if (!confirmed) {
                            return;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Disable Submit Button
                        |--------------------------------------------------------------------------
                        */

                        if (submitButton) {

                            submitButton.disabled = true;


                            submitButton.innerHTML = `
                                <i class="ri-loader-4-line ri-spin"></i>
                                Submitting...
                            `;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Native Form Submit
                        |--------------------------------------------------------------------------
                        |
                        | Prevents this submit handler from firing again.
                        |
                        */

                        HTMLFormElement.prototype.submit.call(
                            refundForm
                        );

                    }
                );

            }
        );
    </script>

@endpush
