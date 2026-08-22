@extends('backend.layouts.backend')

@section('title', 'Payment Successful')

@section('content')

    <div class="customer-payment-success-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-payment-success-breadcrumb">

            <a href="{{ route('orders') }}">
                My Orders
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Payment Successful
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- SUCCESS CARD --}}
        {{-- ================================================================ --}}

        <section class="customer-payment-success-card">

            <div class="customer-payment-success-card__icon">
                <i class="ri-check-line"></i>
            </div>


            <span class="customer-payment-success-card__eyebrow">
            Order Confirmed
        </span>


            <h1>
                Payment Successful!
            </h1>


            <p class="customer-payment-success-card__description">
                Thank you for your purchase. Your payment has been processed
                successfully and your order is now being prepared.
            </p>


            {{-- ============================================================ --}}
            {{-- ORDER INFORMATION --}}
            {{-- ============================================================ --}}

            <div class="customer-payment-success-order">

                <div>

                <span>
                    Order Number
                </span>

                    <strong>
                        #ORD-2026-005
                    </strong>

                </div>


                <div>

                <span>
                    Total Paid
                </span>

                    <strong>
                        $74.98
                    </strong>

                </div>


                <div>

                <span>
                    Payment Method
                </span>

                    <strong>
                        Visa •••• 4242
                    </strong>

                </div>


                <div>

                <span>
                    Order Date
                </span>

                    <strong>
                        Aug 16, 2026
                    </strong>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- CONFIRMATION MESSAGE --}}
            {{-- ============================================================ --}}

            <div class="customer-payment-success-confirmation">

                <div class="customer-payment-success-confirmation__icon">
                    <i class="ri-mail-check-line"></i>
                </div>

                <div>

                    <strong>
                        Confirmation is on its way
                    </strong>

                    <p>
                        We've sent your order confirmation and receipt to
                        the email address associated with your account.
                    </p>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- DELIVERY INFO --}}
            {{-- ============================================================ --}}

            <div class="customer-payment-success-delivery">

                <div class="customer-payment-success-delivery__icon">
                    <i class="ri-truck-line"></i>
                </div>


                <div>

                <span>
                    Estimated Delivery
                </span>

                    <strong>
                        Aug 18 – Aug 20, 2026
                    </strong>

                    <p>
                        Standard Shipping
                    </p>

                </div>


                <a
                    href="{{ route('ecommerce-tracking', ['order' => 1]) }}"
                    class="customer-payment-success-delivery__link"
                >
                    Track Order
                    <i class="ri-arrow-right-line"></i>
                </a>

            </div>


            {{-- ============================================================ --}}
            {{-- ACTIONS --}}
            {{-- ============================================================ --}}

            <div class="customer-payment-success-actions">

                <a
                    href="{{ route('order-details', ['order' => 1]) }}"
                    class="customer-payment-success-btn primary"
                >
                    <i class="ri-file-list-3-line"></i>
                    View Order
                </a>


                <a
                    href="{{ route('orders') }}"
                    class="customer-payment-success-btn"
                >
                    <i class="ri-shopping-bag-line"></i>
                    My Orders
                </a>

            </div>


            <a
                href="{{ route('customer-shop') }}"
                class="customer-payment-success-continue"
            >
                Continue Shopping
                <i class="ri-arrow-right-line"></i>
            </a>

        </section>


        {{-- ================================================================ --}}
        {{-- WHAT'S NEXT --}}
        {{-- ================================================================ --}}

        <section class="customer-payment-success-next">

            <div class="customer-payment-success-next__header">

                <div>

                <span>
                    What's Next
                </span>

                    <h2>
                        Your Order Journey
                    </h2>

                </div>

            </div>


            <div class="customer-payment-success-next__steps">


                {{-- STEP 1 --}}

                <div class="customer-payment-success-next__step completed">

                    <div class="customer-payment-success-next__number">
                        <i class="ri-check-line"></i>
                    </div>

                    <div>

                        <strong>
                            Order Confirmed
                        </strong>

                        <p>
                            Your payment has been received successfully.
                        </p>

                    </div>

                </div>


                {{-- STEP 2 --}}

                <div class="customer-payment-success-next__step active">

                    <div class="customer-payment-success-next__number">
                        <i class="ri-box-3-line"></i>
                    </div>

                    <div>

                        <strong>
                            Preparing Your Order
                        </strong>

                        <p>
                            Our team will prepare your items for shipment.
                        </p>

                    </div>

                </div>


                {{-- STEP 3 --}}

                <div class="customer-payment-success-next__step">

                    <div class="customer-payment-success-next__number">
                        <i class="ri-truck-line"></i>
                    </div>

                    <div>

                        <strong>
                            Shipped
                        </strong>

                        <p>
                            You'll receive tracking information when your order ships.
                        </p>

                    </div>

                </div>


                {{-- STEP 4 --}}

                <div class="customer-payment-success-next__step">

                    <div class="customer-payment-success-next__number">
                        <i class="ri-home-5-line"></i>
                    </div>

                    <div>

                        <strong>
                            Delivered
                        </strong>

                        <p>
                            Your order will arrive at your delivery address.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- ================================================================ --}}
        {{-- SUPPORT --}}
        {{-- ================================================================ --}}

        <section class="customer-payment-success-support">

            <div class="customer-payment-success-support__icon">
                <i class="ri-customer-service-2-line"></i>
            </div>


            <div>

                <h2>
                    Need Help With Your Order?
                </h2>

                <p>
                    Our support team is here if you have any questions about your order.
                </p>

            </div>


            <a href="#">
                Contact Support
                <i class="ri-arrow-right-line"></i>
            </a>

        </section>

    </div>

@endsection
