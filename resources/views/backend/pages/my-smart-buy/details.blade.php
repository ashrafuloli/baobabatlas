@extends('backend.layouts.backend')

@section('content')

    <div class="smart-buy-details-page">

        {{--======================================================
            Page Header
        =======================================================--}}
        <div class="page-header">

            <div class="page-header-content">

                <div>

                    <a
                        href="{{ route('smart-buy') }}"
                        class="back-link"
                    >
                        <i class="ri-arrow-left-line"></i>

                        <span>
                            Back to My Smart Buy
                        </span>
                    </a>

                    <div class="page-title-wrapper">

                        <div class="page-icon">
                            <i class="ri-shopping-bag-3-line"></i>
                        </div>

                        <div>

                            <span class="page-eyebrow">
                                My Smart Buy
                            </span>

                            <h1 class="page-title">
                                Request Details
                            </h1>

                            <p class="page-description">
                                Review your Smart Buy request and order progress.
                            </p>

                        </div>

                    </div>

                </div>


                <span class="status-badge status-in-transit">
                    <span class="status-dot"></span>

                    In Transit
                </span>

            </div>

        </div>



        {{--======================================================
            Request Overview
        =======================================================--}}
        <div class="request-overview">

            <div class="overview-item">

                <span>
                    Request ID
                </span>

                <strong>
                    SB-2026-00128
                </strong>

            </div>


            <div class="overview-item">

                <span>
                    Submitted
                </span>

                <strong>
                    Aug 15, 2026
                </strong>

            </div>


            <div class="overview-item">

                <span>
                    Service
                </span>

                <strong>
                    Smart Buy
                </strong>

            </div>


            <div class="overview-item">

                <span>
                    Current Status
                </span>

                <strong class="status-text">
                    In Transit
                </strong>

            </div>

        </div>



        {{--======================================================
            Main Layout
        =======================================================--}}
        <div class="details-layout">


            {{--==================================================
                Main Content
            ===================================================--}}
            <div class="details-main">


                {{--================================================
                    Request Progress
                =================================================--}}
                <div class="details-card progress-card">

                    <div class="card-header">

                        <div>

                            <h2>
                                Request Progress
                            </h2>

                            <p>
                                Track the progress of your Smart Buy request.
                            </p>

                        </div>

                    </div>


                    <div class="progress-steps">


                        <div class="progress-step completed">

                            <div class="progress-icon">
                                <i class="ri-check-line"></i>
                            </div>

                            <div class="progress-content">

                                <strong>
                                    Request Submitted
                                </strong>

                                <span>
                                    Aug 15, 2026
                                </span>

                            </div>

                        </div>


                        <div class="progress-line completed"></div>


                        <div class="progress-step completed">

                            <div class="progress-icon">
                                <i class="ri-file-list-3-line"></i>
                            </div>

                            <div class="progress-content">

                                <strong>
                                    Quote Approved
                                </strong>

                                <span>
                                    Aug 16, 2026
                                </span>

                            </div>

                        </div>


                        <div class="progress-line completed"></div>


                        <div class="progress-step completed">

                            <div class="progress-icon">
                                <i class="ri-bank-card-line"></i>
                            </div>

                            <div class="progress-content">

                                <strong>
                                    Payment Completed
                                </strong>

                                <span>
                                    Aug 16, 2026
                                </span>

                            </div>

                        </div>


                        <div class="progress-line completed"></div>


                        <div class="progress-step completed">

                            <div class="progress-icon">
                                <i class="ri-shopping-cart-2-line"></i>
                            </div>

                            <div class="progress-content">

                                <strong>
                                    Product Purchased
                                </strong>

                                <span>
                                    Aug 17, 2026
                                </span>

                            </div>

                        </div>


                        <div class="progress-line completed"></div>


                        <div class="progress-step active">

                            <div class="progress-icon">
                                <i class="ri-truck-line"></i>
                            </div>

                            <div class="progress-content">

                                <strong>
                                    In Transit
                                </strong>

                                <span>
                                    Aug 17, 2026
                                </span>

                            </div>

                        </div>


                        <div class="progress-line"></div>


                        <div class="progress-step">

                            <div class="progress-icon">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>

                            <div class="progress-content">

                                <strong>
                                    Completed
                                </strong>

                                <span>
                                    Pending
                                </span>

                            </div>

                        </div>

                    </div>

                </div>



                {{--================================================
                    Product Details
                =================================================--}}
                <div class="details-card product-details-card">

                    <div class="card-header">

                        <div>

                            <h2>
                                Product Details
                            </h2>

                            <p>
                                Products requested through Smart Buy.
                            </p>

                        </div>

                    </div>


                    {{-- Product Item 01 --}}
                    <div class="product-request-item">

                        <div class="product-request-header">

                            <div class="product-request-title">

                                <div class="product-icon">

                                    <i class="ri-shopping-bag-3-line"></i>

                                </div>


                                <div>

                                    <span class="product-label">
                                        Item 01
                                    </span>

                                    <h3>
                                        MacBook Pro 14-inch
                                    </h3>

                                    <p>
                                        Apple MacBook Pro 14-inch with M-series chip,
                                        16GB RAM and 512GB storage.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="product-meta-grid">

                            <div class="product-meta">

                                <span>
                                    Quantity
                                </span>

                                <strong>
                                    1 Unit
                                </strong>

                            </div>


                            <div class="product-meta">

                                <span>
                                    Size
                                </span>

                                <strong>
                                    14-inch
                                </strong>

                            </div>


                            <div class="product-meta">

                                <span>
                                    Color
                                </span>

                                <strong>
                                    Space Black
                                </strong>

                            </div>

                        </div>


                        <div class="product-link">

                            <i class="ri-link"></i>

                            <div>

                                <span>
                                    Product URL
                                </span>

                                <a
                                    href="#"
                                    target="_blank"
                                >
                                    View Product
                                    <i class="ri-external-link-line"></i>
                                </a>

                            </div>

                        </div>


                        <div class="product-notes">

                            <span>
                                Additional Notes
                            </span>

                            <p>
                                Please make sure the product is brand new and
                                matches the requested specifications.
                            </p>

                        </div>

                    </div>



                    {{-- Product Item 02 Example --}}
                    <div class="product-request-item">

                        <div class="product-request-header">

                            <div class="product-request-title">

                                <div class="product-icon">

                                    <i class="ri-shopping-bag-3-line"></i>

                                </div>


                                <div>

                                    <span class="product-label">
                                        Item 02
                                    </span>

                                    <h3>
                                        Apple AirPods Pro
                                    </h3>

                                    <p>
                                        Wireless earbuds with active noise cancellation.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="product-meta-grid">

                            <div class="product-meta">

                                <span>
                                    Quantity
                                </span>

                                <strong>
                                    2 Units
                                </strong>

                            </div>


                            <div class="product-meta">

                                <span>
                                    Size
                                </span>

                                <strong>
                                    N/A
                                </strong>

                            </div>


                            <div class="product-meta">

                                <span>
                                    Color
                                </span>

                                <strong>
                                    White
                                </strong>

                            </div>

                        </div>


                        <div class="product-link">

                            <i class="ri-link"></i>

                            <div>

                                <span>
                                    Product URL
                                </span>

                                <a
                                    href="#"
                                    target="_blank"
                                >
                                    View Product
                                    <i class="ri-external-link-line"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>



                {{--================================================
                    Quote
                =================================================--}}
                <div class="details-card quote-card">

                    <div class="card-header">

                        <div>

                            <h2>
                                Quote
                            </h2>

                            <p>
                                Approved quote for your Smart Buy request.
                            </p>

                        </div>


                        <span class="card-status success">
                            <i class="ri-check-line"></i>

                            Accepted
                        </span>

                    </div>


                    <div class="quote-details">

                        <div class="quote-row">

                            <span>
                                Product Cost
                            </span>

                            <strong>
                                $1,850.00
                            </strong>

                        </div>


                        <div class="quote-row">

                            <span>
                                Service Fee
                            </span>

                            <strong>
                                $100.00
                            </strong>

                        </div>


                        <div class="quote-row">

                            <span>
                                Estimated Shipping
                            </span>

                            <strong>
                                $150.00
                            </strong>

                        </div>


                        <div class="quote-row total">

                            <span>
                                Total
                            </span>

                            <strong>
                                $2,100.00
                            </strong>

                        </div>

                    </div>


                    <div class="quote-footer">

                        <a
                            href="#"
                            class="outline-action-button"
                        >
                            <span>
                                View Full Quote
                            </span>

                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>

                </div>



                {{--================================================
                    Payment
                =================================================--}}
                <div class="details-card payment-card">

                    <div class="card-header">

                        <div>

                            <h2>
                                Payment
                            </h2>

                            <p>
                                Payment information for this request.
                            </p>

                        </div>


                        <span class="card-status success">
                            <i class="ri-check-line"></i>

                            Paid
                        </span>

                    </div>


                    <div class="payment-content">

                        <div class="payment-icon">

                            <i class="ri-shield-check-line"></i>

                        </div>


                        <div class="payment-info">

                            <strong>
                                Payment Completed
                            </strong>

                            <span>
                                Aug 16, 2026 · 11:18 AM
                            </span>

                        </div>


                        <div class="payment-amount">

                            <span>
                                Amount Paid
                            </span>

                            <strong>
                                $2,100.00
                            </strong>

                        </div>

                    </div>

                </div>



                {{--================================================
                    Shipment
                =================================================--}}
                <div class="details-card shipment-card">

                    <div class="card-header">

                        <div>

                            <h2>
                                Shipment
                            </h2>

                            <p>
                                Current shipment information.
                            </p>

                        </div>


                        <span class="card-status active">
                            <i class="ri-truck-line"></i>

                            In Transit
                        </span>

                    </div>


                    <div class="tracking-number-row">

                        <div>

                            <span>
                                Tracking Number
                            </span>

                            <strong>
                                DHL-7849236510
                            </strong>

                        </div>


                        <button
                            type="button"
                            class="copy-button"
                        >
                            <i class="ri-file-copy-line"></i>

                            <span>
                                Copy
                            </span>
                        </button>

                    </div>


                    <div class="shipment-grid">

                        <div class="shipment-info">

                            <span>
                                Carrier
                            </span>

                            <strong>
                                DHL Express
                            </strong>

                        </div>


                        <div class="shipment-info">

                            <span>
                                Shipping Method
                            </span>

                            <strong>
                                Express
                            </strong>

                        </div>


                        <div class="shipment-info">

                            <span>
                                Shipped On
                            </span>

                            <strong>
                                Aug 17, 2026
                            </strong>

                        </div>


                        <div class="shipment-info">

                            <span>
                                Estimated Delivery
                            </span>

                            <strong>
                                Aug 26, 2026
                            </strong>

                        </div>

                    </div>


                    <div class="shipment-footer">

                        <a
                            href="#"
                            class="track-button"
                        >
                            <i class="ri-map-pin-line"></i>

                            <span>
                                Track Shipment
                            </span>
                        </a>

                    </div>

                </div>



                {{--================================================
                    Delivery Information
                =================================================--}}
                <div class="details-card delivery-card">

                    <div class="card-header">

                        <div>

                            <h2>
                                Delivery Information
                            </h2>

                            <p>
                                Your requested delivery destination.
                            </p>

                        </div>

                    </div>


                    <div class="delivery-content">


                        <div class="delivery-customer">

                            <div class="delivery-icon">

                                <i class="ri-map-pin-line"></i>

                            </div>


                            <div>

                                <strong>
                                    John Doe
                                </strong>

                                <span>
                                    +224 620 00 00 00
                                </span>

                            </div>

                        </div>


                        <div class="delivery-details-grid">


                            <div class="delivery-detail">

                                <span>
                                    Country
                                </span>

                                <strong>
                                    Guinea
                                </strong>

                            </div>


                            <div class="delivery-detail">

                                <span>
                                    City
                                </span>

                                <strong>
                                    Conakry
                                </strong>

                            </div>


                            <div class="delivery-detail">

                                <span>
                                    ZIP / Postal Code
                                </span>

                                <strong>
                                    001
                                </strong>

                            </div>


                            <div class="delivery-detail full-width">

                                <span>
                                    Delivery Address
                                </span>

                                <strong>
                                    24 Rue de Paris, Kaloum,
                                    Conakry, Guinea
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{--==================================================
                Sidebar
            ===================================================--}}
            <aside class="details-sidebar">


                {{--==============================================
                    Quick Actions
                ==============================================--}}
                <div class="sidebar-card quick-actions-card">

                    <div class="sidebar-card-header">

                        <h3>
                            Quick Actions
                        </h3>

                    </div>


                    <div class="quick-actions">


                        {{-- Existing Link --}}
                        <a
                            href="#"
                            class="quick-action primary"
                        >

                            <span class="quick-action-icon">
                                <i class="ri-map-pin-line"></i>
                            </span>

                            <span>
                                Track Shipment
                            </span>

                            <i class="ri-arrow-right-s-line action-arrow"></i>

                        </a>


                        {{-- Existing Link --}}
                        <a
                            href="#"
                            class="quick-action"
                        >

                            <span class="quick-action-icon">
                                <i class="ri-file-list-3-line"></i>
                            </span>

                            <span>
                                View Quote
                            </span>

                            <i class="ri-arrow-right-s-line action-arrow"></i>

                        </a>


                        {{-- Existing Link --}}
                        <a
                            href="#"
                            class="quick-action"
                        >

                            <span class="quick-action-icon">
                                <i class="ri-bank-card-line"></i>
                            </span>

                            <span>
                                Payment Details
                            </span>

                            <i class="ri-arrow-right-s-line action-arrow"></i>

                        </a>

                    </div>

                </div>



                {{--==============================================
                    Request Information
                ==============================================--}}
                <div class="sidebar-card request-information-card">

                    <div class="sidebar-card-header">

                        <h3>
                            Request Information
                        </h3>

                    </div>


                    <div class="request-information-list">


                        <div class="request-information-item">

                            <span>
                                Request ID
                            </span>

                            <strong>
                                SB-2026-00128
                            </strong>

                        </div>


                        <div class="request-information-item">

                            <span>
                                Created
                            </span>

                            <strong>
                                Aug 15, 2026
                            </strong>

                        </div>


                        <div class="request-information-item">

                            <span>
                                Last Updated
                            </span>

                            <strong>
                                Aug 17, 2026
                            </strong>

                        </div>


                        <div class="request-information-item">

                            <span>
                                Status
                            </span>

                            <strong class="status-text">
                                In Transit
                            </strong>

                        </div>

                    </div>

                </div>



                {{--==============================================
                    Need Help
                ==============================================--}}
                <div class="support-card">

                    <div class="support-icon">

                        <i class="ri-customer-service-2-line"></i>

                    </div>


                    <div>

                        <strong>
                            Need Help?
                        </strong>

                        <p>
                            Have a question about your
                            Smart Buy request?
                        </p>

                        <a href="#">
                            Contact Support
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>

                </div>

            </aside>

        </div>

    </div>


    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const copyButton =
                    document.querySelector(
                        '.copy-button'
                    );

                if (!copyButton) {
                    return;
                }


                copyButton.addEventListener(
                    'click',
                    function () {

                        const trackingNumber =
                            document
                                .querySelector(
                                    '.tracking-number-row strong'
                                )
                                ?.textContent
                                .trim();


                        if (!trackingNumber) {
                            return;
                        }


                        navigator.clipboard
                            .writeText(
                                trackingNumber
                            )
                            .then(
                                function () {

                                    const originalText =
                                        copyButton.innerHTML;


                                    copyButton.innerHTML =
                                        '<i class="ri-check-line"></i><span>Copied</span>';


                                    setTimeout(
                                        function () {

                                            copyButton.innerHTML =
                                                originalText;

                                        },
                                        2000
                                    );

                                }
                            );

                    }
                );

            }
        );

    </script>

@endsection
