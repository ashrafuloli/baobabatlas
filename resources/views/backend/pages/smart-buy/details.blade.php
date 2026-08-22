@extends('backend.layouts.backend')

@section('title', 'Smart Buy Details')

@section('content')

    <div class="smart-buy-details-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="smart-buy-details-header">

            <div class="smart-buy-details-header__left">

                <a
                    href="{{ route('smart-buy') }}"
                    class="smart-buy-details-back"
                >
                    <i class="ri-arrow-left-line"></i>

                    <span>
                    Back to Smart Buy
                </span>
                </a>


                <div class="smart-buy-details-title">

                    <div class="smart-buy-details-title__icon">

                        <i class="ri-shopping-bag-3-line"></i>

                    </div>


                    <div>

                    <span class="smart-buy-details-eyebrow">
                        Smart Buy Request
                    </span>

                        <h1>
                            SB-2026-00128
                        </h1>

                        <p>
                            Created Aug 16, 2026 · Request #128
                        </p>

                    </div>

                </div>

            </div>


            <div class="smart-buy-details-header__actions">

            <span class="smart-buy-details-status smart-buy-details-status--pending">

                <i></i>

                Pending Review

            </span>


                <a
                    href="{{ route('smart-buy-edit', 1) }}"
                    class="smart-buy-details-outline-btn"
                >

                    <i class="ri-edit-line"></i>

                    <span>
                    Edit Request
                </span>

                </a>


                <a
                    href="{{ route('smart-buy-admin-quote', 1) }}"
                    class="smart-buy-details-primary-btn"
                >

                    <i class="ri-file-edit-line"></i>

                    <span>
                    Prepare Quote
                </span>

                </a>

            </div>

        </div>



        {{-- ==========================================================
        | Progress
        =========================================================== --}}

        <section class="smart-buy-details-progress-card">

            <div class="smart-buy-details-progress-header">

                <div>

                <span>
                    Request Progress
                </span>

                    <strong>
                        Pending Review
                    </strong>

                </div>

                <span>
                Step 1 of 6
            </span>

            </div>


            <div class="smart-buy-details-progress">

                <div class="smart-buy-details-progress__line">

                    <span style="width: 10%;"></span>

                </div>


                <div class="smart-buy-details-progress-step smart-buy-details-progress-step--active">

                <span>
                    <i class="ri-file-list-3-line"></i>
                </span>

                    <strong>
                        Request
                    </strong>

                </div>


                <div class="smart-buy-details-progress-step">

                <span>
                    <i class="ri-file-edit-line"></i>
                </span>

                    <strong>
                        Quote
                    </strong>

                </div>


                <div class="smart-buy-details-progress-step">

                <span>
                    <i class="ri-bank-card-line"></i>
                </span>

                    <strong>
                        Payment
                    </strong>

                </div>


                <div class="smart-buy-details-progress-step">

                <span>
                    <i class="ri-shopping-cart-2-line"></i>
                </span>

                    <strong>
                        Purchase
                    </strong>

                </div>


                <div class="smart-buy-details-progress-step">

                <span>
                    <i class="ri-truck-line"></i>
                </span>

                    <strong>
                        Shipment
                    </strong>

                </div>


                <div class="smart-buy-details-progress-step">

                <span>
                    <i class="ri-checkbox-circle-line"></i>
                </span>

                    <strong>
                        Completed
                    </strong>

                </div>

            </div>

        </section>



        {{-- ==========================================================
        | Main Layout
        =========================================================== --}}

        <div class="smart-buy-details-layout">


            {{-- ======================================================
            | Main Content
            ======================================================= --}}

            <div class="smart-buy-details-main">


                {{-- ==================================================
                | Product Request
                =================================================== --}}

                <section class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                            <h2>
                                Product Request
                            </h2>

                            <p>
                                Product information provided by the customer.
                            </p>

                        </div>

                    </div>


                    <div class="smart-buy-product-details">

                        <div class="smart-buy-product-details__image">

                            <i class="ri-shopping-bag-3-line"></i>

                        </div>


                        <div class="smart-buy-product-details__content">

                            <div class="smart-buy-product-details__top">

                                <div>

                                <span>
                                    Product
                                </span>

                                    <h3>
                                        MacBook Pro 14-inch
                                    </h3>

                                </div>


                                <span class="smart-buy-product-tag">
                                Electronics
                            </span>

                            </div>


                            <p>
                                Apple MacBook Pro 14-inch with M-series chip, 16GB RAM and 512GB storage.
                                Customer requested this product from an international supplier.
                            </p>


                            <div class="smart-buy-product-meta">

                                <div>

                                <span>
                                    Quantity
                                </span>

                                    <strong>
                                        1 Unit
                                    </strong>

                                </div>


                                <div>

                                <span>
                                    Preferred Condition
                                </span>

                                    <strong>
                                        Brand New
                                    </strong>

                                </div>


                                <div>

                                <span>
                                    Preferred Source
                                </span>

                                    <strong>
                                        Official Retailer
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Delivery Information
                =================================================== --}}

                <section class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                            <h2>
                                Delivery Information
                            </h2>

                            <p>
                                Destination and shipping information provided by the customer.
                            </p>

                        </div>

                    </div>


                    <div class="smart-buy-delivery-grid">

                        <div class="smart-buy-info-item">

                        <span>
                            Recipient Name
                        </span>

                            <strong>
                                John Doe
                            </strong>

                        </div>


                        <div class="smart-buy-info-item">

                        <span>
                            Phone Number
                        </span>

                            <strong>
                                +224 620 000 000
                            </strong>

                        </div>


                        <div class="smart-buy-info-item smart-buy-info-item--full">

                        <span>
                            Delivery Address
                        </span>

                            <strong>
                                24 Rue de Paris, Conakry, Guinea
                            </strong>

                        </div>


                        <div class="smart-buy-info-item">

                        <span>
                            Country
                        </span>

                            <strong>
                                Guinea
                            </strong>

                        </div>


                        <div class="smart-buy-info-item">

                        <span>
                            City
                        </span>

                            <strong>
                                Conakry
                            </strong>

                        </div>


                        <div class="smart-buy-info-item">

                        <span>
                            Postal Code
                        </span>

                            <strong>
                                001
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Customer Notes
                =================================================== --}}

                <section class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                            <h2>
                                Customer Notes
                            </h2>

                            <p>
                                Additional information submitted with this request.
                            </p>

                        </div>

                    </div>


                    <div class="smart-buy-customer-note">

                        <i class="ri-chat-quote-line"></i>

                        <p>
                            Please make sure the product is brand new and comes with the original
                            manufacturer warranty. I would prefer the fastest available shipping option.
                        </p>

                    </div>

                </section>



                {{-- ==================================================
                | Request Timeline
                =================================================== --}}

                <section class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                            <h2>
                                Request Timeline
                            </h2>

                            <p>
                                Activity and status changes for this Smart Buy request.
                            </p>

                        </div>

                    </div>


                    <div class="smart-buy-details-timeline">


                        <div class="smart-buy-details-timeline-item smart-buy-details-timeline-item--active">

                            <div class="smart-buy-details-timeline-item__indicator">

                            <span>
                                <i class="ri-file-list-3-line"></i>
                            </span>

                            </div>


                            <div class="smart-buy-details-timeline-item__content">

                                <div>

                                    <h3>
                                        Request Submitted
                                    </h3>

                                    <time>
                                        Aug 16, 2026 · 09:42 AM
                                    </time>

                                </div>

                                <p>
                                    Customer submitted a new Smart Buy request.
                                </p>

                            </div>

                        </div>



                        <div class="smart-buy-details-timeline-item">

                            <div class="smart-buy-details-timeline-item__indicator">

                            <span>
                                <i class="ri-user-line"></i>
                            </span>

                            </div>


                            <div class="smart-buy-details-timeline-item__content">

                                <div>

                                    <h3>
                                        Request Received
                                    </h3>

                                    <time>
                                        Aug 16, 2026 · 09:43 AM
                                    </time>

                                </div>

                                <p>
                                    Request was received by the Baobab Atlas system.
                                </p>

                            </div>

                        </div>



                        <div class="smart-buy-details-timeline-item smart-buy-details-timeline-item--future">

                            <div class="smart-buy-details-timeline-item__indicator">

                            <span>
                                <i class="ri-file-edit-line"></i>
                            </span>

                            </div>


                            <div class="smart-buy-details-timeline-item__content">

                                <div>

                                    <h3>
                                        Quote Preparation
                                    </h3>

                                    <span>
                                    Waiting for admin action
                                </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            </div>



            {{-- ======================================================
            | Sidebar
            ======================================================= --}}

            <aside class="smart-buy-details-sidebar">


                {{-- ==================================================
                | Customer
                =================================================== --}}

                <section class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                            <h2>
                                Customer
                            </h2>

                        </div>

                    </div>


                    <div class="smart-buy-customer-profile">

                        <div class="smart-buy-customer-profile__avatar">
                            JD
                        </div>


                        <div>

                            <strong>
                                John Doe
                            </strong>

                            <span>
                            Customer
                        </span>

                        </div>

                    </div>


                    <div class="smart-buy-customer-contact">

                        <div>

                            <i class="ri-mail-line"></i>

                            <span>
                            john@example.com
                        </span>

                        </div>


                        <div>

                            <i class="ri-phone-line"></i>

                            <span>
                            +224 620 000 000
                        </span>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Request Summary
                =================================================== --}}

                <section class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                            <h2>
                                Request Summary
                            </h2>

                        </div>

                    </div>


                    <div class="smart-buy-summary">

                        <div>

                        <span>
                            Request ID
                        </span>

                            <strong>
                                SB-2026-00128
                            </strong>

                        </div>


                        <div>

                        <span>
                            Service
                        </span>

                            <strong>
                                Smart Buy
                            </strong>

                        </div>


                        <div>

                        <span>
                            Quantity
                        </span>

                            <strong>
                                1 Unit
                            </strong>

                        </div>


                        <div>

                        <span>
                            Estimated Product
                        </span>

                            <strong>
                                $2,200.00
                            </strong>

                        </div>


                        <div>

                        <span>
                            Shipping
                        </span>

                            <strong>
                                TBD
                            </strong>

                        </div>


                        <div class="smart-buy-summary__total">

                        <span>
                            Estimated Total
                        </span>

                            <strong>
                                $2,450.00
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Quick Actions
                =================================================== --}}

                <section class="smart-buy-details-card">

                    <div class="smart-buy-details-card__header">

                        <div>

                            <h2>
                                Quick Actions
                            </h2>

                        </div>

                    </div>


                    <div class="smart-buy-quick-actions">

                        <a
                            href="{{ route('smart-buy-admin-quote', 1) }}"
                            class="smart-buy-quick-action"
                        >

                        <span class="smart-buy-quick-action__icon">

                            <i class="ri-file-edit-line"></i>

                        </span>

                            <span>
                            Prepare Quote
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>


                        <a
                            href="{{ route('smart-buy-edit', 1) }}"
                            class="smart-buy-quick-action"
                        >

                        <span class="smart-buy-quick-action__icon">

                            <i class="ri-edit-line"></i>

                        </span>

                            <span>
                            Edit Request
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>


                        <a
                            href="{{ route('smart-buy-purchase', 1) }}"
                            class="smart-buy-quick-action"
                        >

                        <span class="smart-buy-quick-action__icon">

                            <i class="ri-shopping-cart-2-line"></i>

                        </span>

                            <span>
                            Purchase Product
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>


                        <a
                            href="{{ route('smart-buy-shipment', 1) }}"
                            class="smart-buy-quick-action"
                        >

                        <span class="smart-buy-quick-action__icon">

                            <i class="ri-truck-line"></i>

                        </span>

                            <span>
                            Manage Shipment
                        </span>

                            <i class="ri-arrow-right-s-line"></i>

                        </a>

                    </div>

                </section>



                {{-- ==================================================
                | Important Notice
                =================================================== --}}

                <div class="smart-buy-details-notice">

                    <div class="smart-buy-details-notice__icon">

                        <i class="ri-information-line"></i>

                    </div>


                    <div>

                        <strong>
                            Review Before Quoting
                        </strong>

                        <p>
                            Verify the product, quantity and destination details before preparing the customer quote.
                        </p>

                    </div>

                </div>

            </aside>

        </div>

    </div>

@endsection
