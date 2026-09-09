@extends('frontend.layouts.frontend')

@section('title', 'Order Details')

@section('contents')

    @php
        $status = match ($order->status) {
            \App\Models\Order::STATUS_COMPLETED => 'completed',
            \App\Models\Order::STATUS_CANCELLED,
            \App\Models\Order::STATUS_FAILED => 'cancelled',
            \App\Models\Order::STATUS_PROCESSING,
            \App\Models\Order::STATUS_PAID => 'processing',
            default => 'pending',
        };

        $statusLabel = match ($status) {
            'completed' => 'Delivered',
            'processing' => 'Processing',
            'cancelled' => 'Cancelled',
            default => 'Pending',
        };

        $statusIcon = match ($status) {
            'completed' => 'ri-checkbox-circle-fill',
            'processing' => 'ri-loader-4-line',
            'cancelled' => 'ri-close-circle-line',
            default => 'ri-time-line',
        };
    @endphp


    <div class="order-details-page">

        <div class="container">

            {{-- Breadcrumb --}}
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


            {{-- Page Header --}}
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
                        Placed on {{ $order->created_at->format('F j, Y') }}
                    </p>

                </div>


                <span
                    class="order-details-page__status order-details-page__status--{{ $status }}"
                >
                    <i class="{{ $statusIcon }}"></i>
                    {{ $statusLabel }}
                </span>

            </div>


            {{-- Main Grid --}}
            <div class="order-details-page__grid">

                {{-- Left --}}
                <div class="order-details-page__main">

                    {{-- Products --}}
                    <section class="order-details-page__card">

                        <div class="order-details-page__card-header">

                            <div>
                                <span class="order-details-page__section-label">
                                    ORDER ITEMS
                                </span>

                                <h2>
                                    {{ $order->items->sum('quantity') }}
                                    {{ $order->items->sum('quantity') === 1 ? 'Item' : 'Items' }}
                                </h2>
                            </div>

                        </div>


                        <div class="order-details-page__items">

                            @foreach($order->items as $item)

                                @php
                                    $attributes = [];

                                    if ($item->variant?->values) {
                                        foreach ($item->variant->values as $value) {
                                            $attributeName = $value->attribute?->name;
                                            $valueName = $value->value ?? null;

                                            if ($attributeName && $valueName) {
                                                $attributes[] = $attributeName . ': ' . $valueName;
                                            }
                                        }
                                    }

                                    $category = $item->product?->categories?->first()?->name;
                                @endphp


                                <div class="order-details-page__item">

                                    <div class="order-details-page__item-image">

                                        @if($item->image)
                                            <img
                                                src="{{ asset($item->image) }}"
                                                alt="{{ $item->product_name }}"
                                                loading="lazy"
                                            >
                                        @else
                                            <span>
                                                No Image
                                            </span>
                                        @endif

                                    </div>


                                    <div class="order-details-page__item-info">

                                        @if($category)
                                            <span class="order-details-page__item-category">
                                                {{ $category }}
                                            </span>
                                        @endif

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
                                            Quantity: {{ $item->quantity }}
                                        </span>

                                        @if($item->sku)
                                            <span class="order-details-page__item-sku">
                                                SKU: {{ $item->sku }}
                                            </span>
                                        @endif

                                    </div>


                                    <div class="order-details-page__item-price">

                                        <strong>
                                            ${{ number_format((float) $item->line_total, 2) }}
                                        </strong>

                                        @if($item->quantity > 1)
                                            <span>
                                                ${{ number_format((float) $item->unit_price, 2) }}
                                                each
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </section>


                    {{-- Shipping Address --}}
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

                            @if($order->apartment)
                                <span>
                                    {{ $order->apartment }}
                                </span>
                            @endif

                            <span>
                                {{ $order->city }}
                                @if($order->state)
                                    , {{ $order->state }}
                                @endif
                                {{ $order->postal_code }}
                            </span>

                            <span>
                                {{ $order->country }}
                            </span>

                            <span>
                                {{ $order->phone }}
                            </span>

                        </div>

                    </section>

                </div>


                {{-- Right --}}
                <aside class="order-details-page__sidebar">

                    {{-- Order Summary --}}
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
                                    ${{ number_format((float) $order->subtotal, 2) }}
                                </strong>
                            </div>


                            @if((float) $order->discount > 0)

                                <div class="order-details-page__summary-discount">

                                    <span>
                                        Discount
                                    </span>

                                    <strong>
                                        -${{ number_format((float) $order->discount, 2) }}
                                    </strong>

                                </div>

                            @endif


                            @if((float) $order->shipping > 0)

                                <div>

                                    <span>
                                        Shipping
                                    </span>

                                    <strong>
                                        ${{ number_format((float) $order->shipping, 2) }}
                                    </strong>

                                </div>

                            @endif


                            @if((float) $order->tax > 0)

                                <div>

                                    <span>
                                        Tax
                                    </span>

                                    <strong>
                                        ${{ number_format((float) $order->tax, 2) }}
                                    </strong>

                                </div>

                            @endif


                            <div class="order-details-page__summary-total">

                                <span>
                                    Total
                                </span>

                                <strong>
                                    ${{ number_format((float) $order->total, 2) }}
                                </strong>

                            </div>

                        </div>

                    </section>


                    {{-- Payment --}}
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
                                    class="order-details-page__payment-status order-details-page__payment-status--{{ $order->payment_status }}"
                                >
                                    {{ ucfirst($order->payment_status) }}
                                </strong>

                            </div>


                            @if($order->payment_gateway)

                                <div>

                                    <span>
                                        Method
                                    </span>

                                    <strong>
                                        {{ ucfirst($order->payment_gateway) }}
                                    </strong>

                                </div>

                            @endif


                            @if($order->paid_at)

                                <div>

                                    <span>
                                        Paid On
                                    </span>

                                    <strong>
                                        {{ $order->paid_at->format('M j, Y') }}
                                    </strong>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- Customer --}}
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

                            <div>
                                <i class="ri-mail-line"></i>

                                <span>
                                    {{ $order->email }}
                                </span>
                            </div>

                            <div>
                                <i class="ri-phone-line"></i>

                                <span>
                                    {{ $order->phone }}
                                </span>
                            </div>

                        </div>

                    </section>

                </aside>

            </div>


            {{-- Bottom CTA --}}
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

    </div>

@endsection
