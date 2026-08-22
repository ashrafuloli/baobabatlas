@extends('backend.layouts.backend')

@section('title', 'Payment Details')

@section('content')

    <div class="page-content payment-details-page">

        {{-- ==================================================
            PAGE HEADER
        ================================================== --}}
        <div class="page-header">

            <div class="page-header-content">

            <span class="page-subtitle">
                Payment Management
            </span>

                <h1>
                    Payment Details
                </h1>

                <p>
                    View complete information about this payment transaction.
                </p>

            </div>


            <div class="page-header-actions">

                <a
                    href="{{ route('payments') }}"
                    class="btn btn-outline"
                >
                    <i class="fa-regular fa-arrow-left"></i>

                    <span>
                    All Payments
                </span>
                </a>

            </div>

        </div>


        {{-- ==================================================
            PAYMENT SUMMARY
        ================================================== --}}
        <div class="payment-summary-card">

            <div class="payment-summary-main">

                <div class="payment-status-icon success">

                    <i class="fa-regular fa-circle-check"></i>

                </div>


                <div class="payment-summary-content">

                <span class="summary-label">
                    Payment Transaction
                </span>

                    <h2>
                        #PAY-10482
                    </h2>

                    <p>
                        Payment completed successfully
                    </p>

                </div>

            </div>


            <div class="payment-summary-meta">

            <span class="payment-status success">
                Paid
            </span>

                <span class="payment-date">
                Aug 17, 2026
            </span>

            </div>

        </div>


        {{-- ==================================================
            PAYMENT INFORMATION
        ================================================== --}}
        <div class="details-grid">


            {{-- ==================================================
                TRANSACTION INFORMATION
            ================================================== --}}
            <div class="details-card">

                <div class="details-card-header">

                    <div>

                        <h2>
                            Transaction Information
                        </h2>

                        <p>
                            Basic payment transaction details.
                        </p>

                    </div>

                </div>


                <div class="details-list">

                    <div class="detail-item">

                    <span class="detail-label">
                        Transaction ID
                    </span>

                        <strong class="detail-value">
                            #PAY-10482
                        </strong>

                    </div>


                    <div class="detail-item">

                    <span class="detail-label">
                        Payment Type
                    </span>

                        <span class="payment-type ecommerce">
                        Ecommerce
                    </span>

                    </div>


                    <div class="detail-item">

                    <span class="detail-label">
                        Payment Status
                    </span>

                        <span class="payment-status success">
                        Paid
                    </span>

                    </div>


                    <div class="detail-item">

                    <span class="detail-label">
                        Transaction Date
                    </span>

                        <strong class="detail-value">
                            Aug 17, 2026
                        </strong>

                    </div>


                    <div class="detail-item">

                    <span class="detail-label">
                        Transaction Time
                    </span>

                        <strong class="detail-value">
                            10:42 AM
                        </strong>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                CUSTOMER INFORMATION
            ================================================== --}}
            <div class="details-card">

                <div class="details-card-header">

                    <div>

                        <h2>
                            Customer Information
                        </h2>

                        <p>
                            Customer associated with this payment.
                        </p>

                    </div>

                </div>


                <div class="customer-profile">

                    <div class="customer-avatar large">
                        JD
                    </div>


                    <div class="customer-profile-info">

                        <h3>
                            John Doe
                        </h3>

                        <p>
                            john@example.com
                        </p>

                        <span>
                        Customer ID: #CUS-10284
                    </span>

                    </div>

                </div>


                <div class="customer-contact-list">

                    <div class="contact-item">

                        <i class="fa-regular fa-phone"></i>

                        <span>
                        +1 (555) 123-4567
                    </span>

                    </div>


                    <div class="contact-item">

                        <i class="fa-regular fa-location-dot"></i>

                        <span>
                        New York, United States
                    </span>

                    </div>

                </div>

            </div>


        </div>


        {{-- ==================================================
            PAYMENT & ORDER DETAILS
        ================================================== --}}
        <div class="details-grid">


            {{-- ==================================================
                PAYMENT DETAILS
            ================================================== --}}
            <div class="details-card">

                <div class="details-card-header">

                    <div>

                        <h2>
                            Payment Details
                        </h2>

                        <p>
                            Payment amount and payment method.
                        </p>

                    </div>

                </div>


                <div class="amount-highlight">

                <span>
                    Total Amount
                </span>

                    <strong>
                        $249.00
                    </strong>

                </div>


                <div class="details-list">

                    <div class="detail-item">

                    <span class="detail-label">
                        Payment Method
                    </span>

                        <div class="payment-method">

                            <i class="fa-brands fa-cc-visa"></i>

                            <span>
                            Visa **** 4242
                        </span>

                        </div>

                    </div>


                    <div class="detail-item">

                    <span class="detail-label">
                        Currency
                    </span>

                        <strong class="detail-value">
                            USD
                        </strong>

                    </div>


                    <div class="detail-item">

                    <span class="detail-label">
                        Processing Fee
                    </span>

                        <strong class="detail-value">
                            $7.47
                        </strong>

                    </div>


                    <div class="detail-item">

                    <span class="detail-label">
                        Net Amount
                    </span>

                        <strong class="detail-value">
                            $241.53
                        </strong>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                ORDER / REQUEST INFORMATION
            ================================================== --}}
            <div class="details-card">

                <div class="details-card-header">

                    <div>

                        <h2>
                            Related Order
                        </h2>

                        <p>
                            Order connected with this transaction.
                        </p>

                    </div>

                </div>


                <div class="related-order">

                    <div class="order-icon">

                        <i class="fa-regular fa-cart-shopping"></i>

                    </div>


                    <div class="order-content">

                    <span>
                        Order
                    </span>

                        <strong>
                            #ORD-20841
                        </strong>

                        <p>
                            3 products
                        </p>

                    </div>


                    <a
                        href="#"
                        class="view-order-btn"
                    >
                        View Order

                        <i class="fa-regular fa-arrow-right"></i>
                    </a>

                </div>


                <div class="details-list">

                    <div class="detail-item">

                <span class="detail-label">
                    Order Date
                </span>

                        <strong class="detail-value">
                            Aug 17, 2026
                        </strong>

                    </div>


                    <div class="detail-item">

                <span class="detail-label">
                    Order Status
                </span>

                        <span class="order-status">
                    Processing
                </span>

                    </div>

                </div>
            </div>


        </div>


        {{-- ==================================================
            PAYMENT TIMELINE
        ================================================== --}}
        <div class="details-card payment-timeline-card">

            <div class="details-card-header">

                <div>

                    <h2>
                        Payment Timeline
                    </h2>

                    <p>
                        History of this payment transaction.
                    </p>

                </div>

            </div>


            <div class="payment-timeline">


                <div class="timeline-item completed">

                    <div class="timeline-icon">

                        <i class="fa-regular fa-circle-check"></i>

                    </div>


                    <div class="timeline-content">

                        <strong>
                            Payment Completed
                        </strong>

                        <p>
                            Payment was successfully processed.
                        </p>

                        <span>
                        Aug 17, 2026 · 10:42 AM
                    </span>

                    </div>

                </div>


                <div class="timeline-item completed">

                    <div class="timeline-icon">

                        <i class="fa-regular fa-shield-check"></i>

                    </div>


                    <div class="timeline-content">

                        <strong>
                            Payment Verified
                        </strong>

                        <p>
                            Payment transaction was verified successfully.
                        </p>

                        <span>
                        Aug 17, 2026 · 10:42 AM
                    </span>

                    </div>

                </div>


                <div class="timeline-item completed">

                    <div class="timeline-icon">

                        <i class="fa-regular fa-credit-card"></i>

                    </div>


                    <div class="timeline-content">

                        <strong>
                            Payment Initiated
                        </strong>

                        <p>
                            Customer initiated the payment.
                        </p>

                        <span>
                        Aug 17, 2026 · 10:41 AM
                    </span>

                    </div>

                </div>

            </div>

        </div>


    </div>

@endsection
