@extends('backend.layouts.backend')

@section('title', 'Smart Buy Payment')

@section('content')

    <div class="smart-buy-payment-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}
        <div class="smart-buy-payment-page__header">

            <div class="smart-buy-payment-page__heading">

                <div class="smart-buy-payment-page__heading-icon">
                    <i class="ri-secure-payment-line"></i>
                </div>

                <div>

                    <span class="smart-buy-payment-page__eyebrow">
                        Smart Buy
                    </span>

                    <h1>
                        Complete Payment
                    </h1>

                    <p>
                        Review your quote and complete the next step for
                        <strong>
                            {{ $smartBuy->request_number }}
                        </strong>
                    </p>

                </div>

            </div>


            <a
                href="{{ route('my-smart-buy.quote', $smartBuy->id) }}"
                class="smart-buy-payment-page__back-btn"
            >
                <i class="ri-arrow-left-line"></i>

                <span>
                    Back to Quote
                </span>
            </a>

        </div>


        {{-- ==========================================================
        | Alerts
        =========================================================== --}}
        @if (session('success'))

            <div class="smart-buy-payment-page__alert smart-buy-payment-page__alert--success">

                <div class="smart-buy-payment-page__alert-icon">
                    <i class="ri-checkbox-circle-line"></i>
                </div>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        @if (session('error'))

            <div class="smart-buy-payment-page__alert smart-buy-payment-page__alert--error">

                <div class="smart-buy-payment-page__alert-icon">
                    <i class="ri-error-warning-line"></i>
                </div>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- ==========================================================
        | Payment Content
        =========================================================== --}}
        <div class="smart-buy-payment-page__layout">


            {{-- ======================================================
            | Main Content
            ======================================================= --}}
            <div class="smart-buy-payment-page__main">


                {{-- Request Information --}}
                <div class="smart-buy-payment-page__card">

                    <div class="smart-buy-payment-page__card-header">

                        <div class="smart-buy-payment-page__card-title">

                            <div class="smart-buy-payment-page__card-icon">
                                <i class="ri-file-list-3-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Request Information
                                </h2>

                                <p>
                                    Details about your Smart Buy request.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="smart-buy-payment-page__info-grid">


                        <div class="smart-buy-payment-page__info-item">

                            <span>
                                Request Number
                            </span>

                            <strong>
                                {{ $smartBuy->request_number }}
                            </strong>

                        </div>


                        <div class="smart-buy-payment-page__info-item">

                            <span>
                                Quote Number
                            </span>

                            <strong>
                                {{ $quote->quote_number }}
                            </strong>

                        </div>


                        <div class="smart-buy-payment-page__info-item">

                            <span>
                                Customer
                            </span>

                            <strong>
                                {{ $smartBuy->first_name }}
                                {{ $smartBuy->last_name }}
                            </strong>

                        </div>


                        <div class="smart-buy-payment-page__info-item">

                            <span>
                                Destination
                            </span>

                            <strong>

                                @if ($smartBuy->city)
                                    {{ $smartBuy->city }}
                                @endif

                                @if ($smartBuy->country)

                                    {{ $smartBuy->city ? ',' : '' }}

                                    {{ $countries[$smartBuy->country] ?? $smartBuy->country }}

                                @endif

                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Products --}}
                <div class="smart-buy-payment-page__card">

                    <div class="smart-buy-payment-page__card-header">

                        <div class="smart-buy-payment-page__card-title">

                            <div class="smart-buy-payment-page__card-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Quote Items
                                </h2>

                                <p>
                                    Review the products included in your quote.
                                </p>

                            </div>

                        </div>


                        <span class="smart-buy-payment-page__item-count">

                            {{ $quote->quoteItems->count() }}

                            {{ $quote->quoteItems->count() === 1 ? 'Item' : 'Items' }}

                        </span>

                    </div>


                    <div class="smart-buy-payment-page__items">

                        @forelse ($quote->quoteItems as $item)

                            <div class="smart-buy-payment-page__item">


                                <div class="smart-buy-payment-page__item-left">


                                    <div class="smart-buy-payment-page__item-image">

                                        @if (
                                            $item->smartBuyItem &&
                                            !empty($item->smartBuyItem->product_image)
                                        )

                                            <img
                                                src="{{ asset( $item->smartBuyItem->product_image) }}"
                                                alt="{{ $item->product_name }}"
                                            >

                                        @else

                                            <div class="smart-buy-payment-page__image-placeholder">

                                                <i class="ri-image-line"></i>

                                            </div>

                                        @endif

                                    </div>


                                    <div class="smart-buy-payment-page__item-content">

                                        <h3>
                                            {{ $item->product_name }}
                                        </h3>


                                        <div class="smart-buy-payment-page__item-meta">

                                            <span>

                                                <i class="ri-stack-line"></i>

                                                Qty:

                                                <strong>
                                                    {{ $item->quantity }}
                                                </strong>

                                            </span>


                                            <span>

                                                <i class="ri-price-tag-3-line"></i>

                                                Unit Price:

                                                <strong>
                                                    ${{ number_format($item->unit_price, 2) }}
                                                </strong>

                                            </span>

                                        </div>


                                        @if (!empty($item->notes))

                                            <div class="smart-buy-payment-page__item-note">

                                                <i class="ri-sticky-note-line"></i>

                                                <span>
                                                    {{ $item->notes }}
                                                </span>

                                            </div>

                                        @endif

                                    </div>

                                </div>


                                <div class="smart-buy-payment-page__item-total">

                                    <span>
                                        Item Total
                                    </span>

                                    <strong>
                                        ${{ number_format($item->total_price, 2) }}
                                    </strong>

                                </div>

                            </div>

                        @empty

                            <div class="smart-buy-payment-page__empty-state">

                                <div class="smart-buy-payment-page__empty-icon">
                                    <i class="ri-shopping-bag-line"></i>
                                </div>

                                <strong>
                                    No items found
                                </strong>

                                <p>
                                    No products are available for this quote.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- Payment Notice --}}
                <div class="smart-buy-payment-page__notice">

                    <div class="smart-buy-payment-page__notice-icon">
                        <i class="ri-shield-check-line"></i>
                    </div>

                    <div>

                        <h3>
                            Secure Payment
                        </h3>

                        <p>
                            Your Smart Buy request will move forward after the required payment is completed.
                        </p>

                    </div>

                </div>

            </div>


            {{-- ======================================================
            | Sidebar
            ======================================================= --}}
            <aside class="smart-buy-payment-page__sidebar">


                <div class="smart-buy-payment-page__summary-card">


                    <div class="smart-buy-payment-page__summary-header">

                        <div>

                            <span>
                                Payment Summary
                            </span>

                            <h2>
                                Amount Due
                            </h2>

                        </div>


                        <div class="smart-buy-payment-page__summary-icon">
                            <i class="ri-wallet-3-line"></i>
                        </div>

                    </div>


                    <div class="smart-buy-payment-page__summary-body">


                        <div class="smart-buy-payment-page__summary-row">

                            <span>
                                Product Total
                            </span>

                            <strong>
                                ${{ number_format($quote->product_total, 2) }}
                            </strong>

                        </div>


                        <div class="smart-buy-payment-page__summary-row">

                            <span>
                                Service Fee
                            </span>

                            <strong>
                                ${{ number_format($quote->service_fee, 2) }}
                            </strong>

                        </div>


                        <div class="smart-buy-payment-page__summary-row">

                            <span>
                                Shipping Fee
                            </span>

                            <strong>
                                ${{ number_format($quote->shipping_fee, 2) }}
                            </strong>

                        </div>

                    </div>


                    <div class="smart-buy-payment-page__total">

                        <span>
                            Total Amount
                        </span>

                        <strong>
                            ${{ number_format($quote->total_amount, 2) }}
                        </strong>

                    </div>


                    <div class="smart-buy-payment-page__payment-info">

                        <div class="smart-buy-payment-page__payment-info-icon">
                            <i class="ri-information-line"></i>
                        </div>

                        <p>
                            Please review all quote details before proceeding.
                        </p>

                    </div>


                    {{-- Payment Form --}}
                    <form
                        action="{{ route('my-smart-buy.payment.store', $smartBuy->id) }}"
                        method="POST"
                        class="smart-buy-payment-page__payment-form"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="payment_method"
                            value="card"
                        >


                        <button
                            type="submit"
                            class="smart-buy-payment-page__pay-btn"
                        >

                            <i class="ri-secure-payment-line"></i>

                            <span>
                                Proceed to Payment
                            </span>

                        </button>

                    </form>


                    <a
                        href="{{ route('my-smart-buy.quote', $smartBuy->id) }}"
                        class="smart-buy-payment-page__quote-link"
                    >

                        <i class="ri-file-list-3-line"></i>

                        <span>
                            Review Quote
                        </span>

                    </a>

                </div>


                {{-- Help Card --}}
                <div class="smart-buy-payment-page__help-card">

                    <div class="smart-buy-payment-page__help-icon">
                        <i class="ri-customer-service-2-line"></i>
                    </div>

                    <div>

                        <h3>
                            Need Help?
                        </h3>

                        <p>
                            Contact support if you have questions about your quote or payment.
                        </p>

                    </div>

                </div>

            </aside>

        </div>

    </div>

@endsection
