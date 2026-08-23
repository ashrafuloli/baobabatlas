@extends('backend.layouts.backend')

@section('title', 'Edit Smart Buy Quote')

@section('content')

    <div class="smart-buy-quote-edit-page">

        {{-- ==========================================================
        | Header
        =========================================================== --}}
        <div class="smart-buy-quote-edit-page__header">

            <div class="smart-buy-quote-edit-page__heading">

                <div class="smart-buy-quote-edit-page__icon">
                    <i class="ri-edit-line"></i>
                </div>

                <div>

                    <span class="smart-buy-quote-edit-page__eyebrow">
                        Smart Buy Quote
                    </span>

                    <h1>
                        Edit Quote
                    </h1>

                    <p>
                        Update pricing for request
                        <strong>
                            {{ $smartBuy->request_number }}
                        </strong>
                    </p>

                </div>

            </div>


            <a
                href="{{ route('smart-buy.details', $smartBuy->id) }}"
                class="smart-buy-quote-edit-page__view-request"
            >
                <i class="ri-eye-line"></i>

                <span>
                    View Request
                </span>
            </a>

        </div>


        {{-- ==========================================================
        | Validation Errors
        =========================================================== --}}
        @if ($errors->any())

            <div class="smart-buy-quote-edit-page__alert">

                <div class="smart-buy-quote-edit-page__alert-icon">
                    <i class="ri-error-warning-line"></i>
                </div>


                <div class="smart-buy-quote-edit-page__alert-content">

                    <strong>
                        Please review the highlighted fields.
                    </strong>


                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- ==========================================================
        | Request Information
        =========================================================== --}}
        <div class="smart-buy-quote-edit-page__request-info">

            <div class="smart-buy-quote-edit-page__info-item">

                <div class="smart-buy-quote-edit-page__info-icon">
                    <i class="ri-hashtag"></i>
                </div>

                <div>

                    <span>
                        Request Number
                    </span>

                    <strong>
                        {{ $smartBuy->request_number }}
                    </strong>

                </div>

            </div>


            <div class="smart-buy-quote-edit-page__info-item">

                <div class="smart-buy-quote-edit-page__info-icon">
                    <i class="ri-user-line"></i>
                </div>

                <div>

                    <span>
                        Customer
                    </span>

                    <strong>
                        {{ $smartBuy->first_name }}
                        {{ $smartBuy->last_name }}
                    </strong>

                </div>

            </div>


            <div class="smart-buy-quote-edit-page__info-item">

                <div class="smart-buy-quote-edit-page__info-icon">
                    <i class="ri-map-pin-line"></i>
                </div>

                <div>

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


            <div class="smart-buy-quote-edit-page__info-item">

                <div class="smart-buy-quote-edit-page__info-icon">
                    <i class="ri-calendar-line"></i>
                </div>

                <div>

                    <span>
                        Submitted
                    </span>

                    <strong>
                        {{ $smartBuy->created_at?->format('M d, Y') }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ==========================================================
        | Quote Form
        =========================================================== --}}
        <form
            action="{{ route('smart-buy.quote.update', $quote->id) }}"
            method="POST"
            class="smart-buy-quote-edit-page__form"
        >

            @csrf

            @method('PUT')


            <div class="smart-buy-quote-edit-page__layout">


                {{-- ==================================================
                | Main Content
                =================================================== --}}
                <div class="smart-buy-quote-edit-page__main">


                    {{-- Product Pricing --}}
                    <div class="smart-buy-quote-edit-page__card">

                        <div class="smart-buy-quote-edit-page__card-header">

                            <div class="smart-buy-quote-edit-page__card-title">

                                <div class="smart-buy-quote-edit-page__card-icon">
                                    <i class="ri-shopping-bag-3-line"></i>
                                </div>

                                <div>

                                    <h2>
                                        Product Pricing
                                    </h2>

                                    <p>
                                        Update the unit price for each requested product.
                                    </p>

                                </div>

                            </div>


                            <span class="smart-buy-quote-edit-page__product-count">

                                {{ $quote->quoteItems->count() }}

                                {{ $quote->quoteItems->count() === 1 ? 'Product' : 'Products' }}

                            </span>

                        </div>


                        <div class="smart-buy-quote-edit-page__products">

                            @forelse ($quote->quoteItems as $index => $quoteItem)

                                @php

                                    $item =
                                        $quoteItem->smartBuyItem;

                                    $productName =
                                        old(
                                            'items.' . $index . '.product_name',
                                            $quoteItem->product_name
                                        );

                                    $unitPrice =
                                        old(
                                            'items.' . $index . '.unit_price',
                                            $quoteItem->unit_price
                                        );

                                    $quantity =
                                        old(
                                            'items.' . $index . '.quantity',
                                            $quoteItem->quantity
                                        );

                                    $itemNotes =
                                        old(
                                            'items.' . $index . '.notes',
                                            $quoteItem->notes
                                        );

                                @endphp


                                <div
                                    class="smart-buy-quote-edit-page__product"
                                    data-product
                                >


                                    {{-- Quote Item ID --}}
                                    <input
                                        type="hidden"
                                        name="items[{{ $index }}][id]"
                                        value="{{ $quoteItem->id }}"
                                    >


                                    {{-- Smart Buy Item ID --}}
                                    <input
                                        type="hidden"
                                        name="items[{{ $index }}][smart_buy_item_id]"
                                        value="{{ $quoteItem->smart_buy_item_id }}"
                                    >


                                    {{-- Required Product Name --}}
                                    <input
                                        type="hidden"
                                        name="items[{{ $index }}][product_name]"
                                        value="{{ $productName }}"
                                    >


                                    {{-- Quantity --}}
                                    <input
                                        type="hidden"
                                        name="items[{{ $index }}][quantity]"
                                        value="{{ $quantity }}"
                                        data-quantity
                                    >


                                    <div class="smart-buy-quote-edit-page__product-top">


                                        {{-- Product Information --}}
                                        <div class="smart-buy-quote-edit-page__product-details">


                                            <div class="smart-buy-quote-edit-page__product-image">

                                                @if ($item && !empty($item->product_image))

                                                    <img
                                                        src="{{ asset($item->product_image) }}"
                                                        alt="{{ $productName }}"
                                                    >

                                                @else

                                                    <div class="smart-buy-quote-edit-page__image-placeholder">
                                                        <i class="ri-image-line"></i>
                                                    </div>

                                                @endif

                                            </div>


                                            <div class="smart-buy-quote-edit-page__product-content">

                                                <h3>
                                                    {{ $productName }}
                                                </h3>


                                                @if ($item && !empty($item->product_url))

                                                    <a
                                                        href="{{ $item->product_url }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="smart-buy-quote-edit-page__product-link"
                                                    >
                                                        <span>
                                                            View Product
                                                        </span>

                                                        <i class="ri-external-link-line"></i>
                                                    </a>

                                                @endif


                                                <div class="smart-buy-quote-edit-page__product-meta">


                                                    {{-- Quantity --}}
                                                    <span>

                                                        <i class="ri-stack-line"></i>

                                                        Qty:

                                                        <strong>
                                                            {{ $quantity }}
                                                        </strong>

                                                    </span>


                                                    {{-- Size --}}
                                                    @if ($item && !empty($item->size))

                                                        <span>

                                                            <i class="ri-ruler-line"></i>

                                                            Size:

                                                            <strong>
                                                                {{ $item->size }}
                                                            </strong>

                                                        </span>

                                                    @endif


                                                    {{-- Color --}}
                                                    @if ($item && !empty($item->color))

                                                        <span>

                                                            <i class="ri-palette-line"></i>

                                                            Color:

                                                            <strong>
                                                                {{ $item->color }}
                                                            </strong>

                                                        </span>

                                                    @endif


                                                    {{-- Original Request Note --}}
                                                    @if ($item && !empty($item->notes))

                                                        <span class="smart-buy-quote-edit-page__request-note">

                                                            <i class="ri-sticky-note-line"></i>

                                                            {{ $item->notes }}

                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>


                                        {{-- Product Price --}}
                                        <div class="smart-buy-quote-edit-page__product-pricing">

                                            <div class="smart-buy-quote-edit-page__price-field">

                                                <label
                                                    for="item-price-{{ $quoteItem->id }}"
                                                >
                                                    Unit Price
                                                </label>


                                                <div
                                                    class="smart-buy-quote-edit-page__currency-input
                                                    @error('items.' . $index . '.unit_price') is-invalid @enderror"
                                                >

                                                    <span>
                                                        $
                                                    </span>


                                                    <input
                                                        type="number"
                                                        id="item-price-{{ $quoteItem->id }}"
                                                        name="items[{{ $index }}][unit_price]"
                                                        value="{{ $unitPrice }}"
                                                        min="0"
                                                        step="0.01"
                                                        required
                                                        placeholder="0.00"
                                                        class="quote-unit-price"
                                                        data-unit-price
                                                    >

                                                </div>


                                                @error('items.' . $index . '.unit_price')

                                                <span class="smart-buy-quote-edit-page__field-error">

                                                        <i class="ri-error-warning-line"></i>

                                                        {{ $message }}

                                                    </span>

                                                @enderror

                                            </div>


                                            <div class="smart-buy-quote-edit-page__item-total">

                                                <span>
                                                    Item Total
                                                </span>

                                                <strong data-item-total>
                                                    $0.00
                                                </strong>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Item Notes --}}
                                    <div class="smart-buy-quote-edit-page__item-notes">

                                        <label
                                            for="item-notes-{{ $quoteItem->id }}"
                                        >

                                            <i class="ri-sticky-note-line"></i>

                                            Item Notes

                                        </label>


                                        <textarea
                                            id="item-notes-{{ $quoteItem->id }}"
                                            name="items[{{ $index }}][notes]"
                                            rows="3"
                                            placeholder="Add an optional note for this item..."
                                        >{{ $itemNotes }}</textarea>

                                    </div>

                                </div>

                            @empty

                                <div class="smart-buy-quote-edit-page__empty-state">

                                    <div class="smart-buy-quote-edit-page__empty-icon">
                                        <i class="ri-shopping-bag-line"></i>
                                    </div>

                                    <strong>
                                        No products found
                                    </strong>

                                    <p>
                                        This quote does not contain any items.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>


                    {{-- ==================================================
                    | Additional Costs
                    =================================================== --}}
                    <div class="smart-buy-quote-edit-page__card">

                        <div class="smart-buy-quote-edit-page__card-header">

                            <div class="smart-buy-quote-edit-page__card-title">

                                <div class="smart-buy-quote-edit-page__card-icon">
                                    <i class="ri-money-dollar-circle-line"></i>
                                </div>

                                <div>

                                    <h2>
                                        Additional Costs
                                    </h2>

                                    <p>
                                        Update service and shipping amounts.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="smart-buy-quote-edit-page__cost-grid">


                            {{-- Service Fee --}}
                            <div class="smart-buy-quote-edit-page__form-group">

                                <label for="service-fee">
                                    Service Fee
                                </label>


                                <div class="smart-buy-quote-edit-page__currency-input">

                                    <span>
                                        $
                                    </span>


                                    <input
                                        type="number"
                                        id="service-fee"
                                        name="service_fee"
                                        value="{{ old('service_fee', $quote->service_fee) }}"
                                        min="0"
                                        step="0.01"
                                        data-service-fee
                                    >

                                </div>

                            </div>


                            {{-- Shipping Fee --}}
                            <div class="smart-buy-quote-edit-page__form-group">

                                <label for="shipping-fee">
                                    Shipping Fee
                                </label>


                                <div class="smart-buy-quote-edit-page__currency-input">

                                    <span>
                                        $
                                    </span>


                                    <input
                                        type="number"
                                        id="shipping-fee"
                                        name="shipping_fee"
                                        value="{{ old('shipping_fee', $quote->shipping_fee) }}"
                                        min="0"
                                        step="0.01"
                                        data-shipping-fee
                                    >

                                </div>

                            </div>


                            {{-- Valid Until --}}
                            <div class="smart-buy-quote-edit-page__form-group">

                                <label for="expires-at">
                                    Valid Until
                                </label>


                                <div class="smart-buy-quote-edit-page__date-input">

                                    <input
                                        type="date"
                                        id="expires-at"
                                        name="expires_at"
                                        value="{{ old(
                                            'expires_at',
                                            $quote->expires_at
                                                ? \Carbon\Carbon::parse($quote->expires_at)->format('Y-m-d')
                                                : ''
                                        ) }}"
                                    >

                                    <i class="ri-calendar-line"></i>

                                </div>

                            </div>

                        </div>


                        {{-- Quote Notes --}}
                        <div class="smart-buy-quote-edit-page__notes-group">

                            <label for="quote-notes">
                                Quote Notes
                            </label>


                            <textarea
                                id="quote-notes"
                                name="notes"
                                rows="6"
                                placeholder="Add notes or instructions for the customer..."
                            >{{ old('notes', $quote->notes) }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                | Sidebar
                =================================================== --}}
                <aside class="smart-buy-quote-edit-page__sidebar">

                    <div class="smart-buy-quote-edit-page__summary-card">


                        <div class="smart-buy-quote-edit-page__summary-header">

                            <div>

                                <span>
                                    Pricing
                                </span>

                                <h2>
                                    Quote Summary
                                </h2>

                            </div>


                            <div class="smart-buy-quote-edit-page__summary-icon">
                                <i class="ri-file-list-3-line"></i>
                            </div>

                        </div>


                        <div class="smart-buy-quote-edit-page__summary-body">

                            <div class="smart-buy-quote-edit-page__summary-row">

                                <span>
                                    Product Subtotal
                                </span>

                                <strong data-product-subtotal>
                                    $0.00
                                </strong>

                            </div>


                            <div class="smart-buy-quote-edit-page__summary-row">

                                <span>
                                    Service Fee
                                </span>

                                <strong data-summary-service>
                                    $0.00
                                </strong>

                            </div>


                            <div class="smart-buy-quote-edit-page__summary-row">

                                <span>
                                    Shipping Fee
                                </span>

                                <strong data-summary-shipping>
                                    $0.00
                                </strong>

                            </div>

                        </div>


                        <div class="smart-buy-quote-edit-page__summary-total">

                            <span>
                                Total Quote Amount
                            </span>

                            <strong data-grand-total>
                                $0.00
                            </strong>

                        </div>


                        <div class="smart-buy-quote-edit-page__actions">

                            <a
                                href="{{ route('smart-buy.details', $smartBuy->id) }}"
                                class="smart-buy-quote-edit-page__cancel-btn"
                            >

                                <i class="ri-close-line"></i>

                                <span>
                                    Cancel
                                </span>

                            </a>


                            <button
                                type="submit"
                                class="smart-buy-quote-edit-page__submit-btn"
                            >

                                <i class="ri-save-line"></i>

                                <span>
                                    Update Quote
                                </span>

                            </button>

                        </div>

                    </div>

                </aside>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>
        (function () {

            const initSmartBuyQuoteEditPage = function () {

                const quotePage =
                    document.querySelector(
                        '.smart-buy-quote-edit-page'
                    );


                if (!quotePage) {
                    return;
                }


                const products =
                    quotePage.querySelectorAll(
                        '[data-product]'
                    );


                const serviceFeeInput =
                    quotePage.querySelector(
                        '[data-service-fee]'
                    );


                const shippingFeeInput =
                    quotePage.querySelector(
                        '[data-shipping-fee]'
                    );


                const productSubtotalElement =
                    quotePage.querySelector(
                        '[data-product-subtotal]'
                    );


                const summaryServiceElement =
                    quotePage.querySelector(
                        '[data-summary-service]'
                    );


                const summaryShippingElement =
                    quotePage.querySelector(
                        '[data-summary-shipping]'
                    );


                const grandTotalElement =
                    quotePage.querySelector(
                        '[data-grand-total]'
                    );


                const getNumber = function (value) {

                    const number =
                        parseFloat(value);


                    if (!Number.isFinite(number)) {
                        return 0;
                    }


                    return Math.max(
                        number,
                        0
                    );

                };


                const formatCurrency = function (amount) {

                    return '$' +
                        getNumber(amount)
                            .toLocaleString(
                                'en-US',
                                {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2,
                                }
                            );

                };


                const calculateQuote = function () {

                    let productSubtotal = 0;


                    products.forEach(
                        function (product) {

                            const priceInput =
                                product.querySelector(
                                    '[data-unit-price]'
                                );


                            const quantityInput =
                                product.querySelector(
                                    '[data-quantity]'
                                );


                            const itemTotalElement =
                                product.querySelector(
                                    '[data-item-total]'
                                );


                            const price =
                                getNumber(
                                    priceInput
                                        ? priceInput.value
                                        : 0
                                );


                            const quantity =
                                getNumber(
                                    quantityInput
                                        ? quantityInput.value
                                        : 0
                                );


                            const itemTotal =
                                price * quantity;


                            productSubtotal +=
                                itemTotal;


                            if (itemTotalElement) {

                                itemTotalElement.textContent =
                                    formatCurrency(
                                        itemTotal
                                    );

                            }

                        }
                    );


                    const serviceFee =
                        getNumber(
                            serviceFeeInput
                                ? serviceFeeInput.value
                                : 0
                        );


                    const shippingFee =
                        getNumber(
                            shippingFeeInput
                                ? shippingFeeInput.value
                                : 0
                        );


                    const grandTotal =
                        productSubtotal
                        +
                        serviceFee
                        +
                        shippingFee;


                    if (productSubtotalElement) {

                        productSubtotalElement.textContent =
                            formatCurrency(
                                productSubtotal
                            );

                    }


                    if (summaryServiceElement) {

                        summaryServiceElement.textContent =
                            formatCurrency(
                                serviceFee
                            );

                    }


                    if (summaryShippingElement) {

                        summaryShippingElement.textContent =
                            formatCurrency(
                                shippingFee
                            );

                    }


                    if (grandTotalElement) {

                        grandTotalElement.textContent =
                            formatCurrency(
                                grandTotal
                            );

                    }

                };


                quotePage.addEventListener(
                    'input',
                    function (event) {

                        if (
                            event.target.matches(
                                '[data-unit-price], [data-service-fee], [data-shipping-fee]'
                            )
                        ) {

                            calculateQuote();

                        }

                    }
                );


                quotePage.addEventListener(
                    'change',
                    function (event) {

                        if (
                            event.target.matches(
                                '[data-unit-price], [data-service-fee], [data-shipping-fee]'
                            )
                        ) {

                            calculateQuote();

                        }

                    }
                );


                calculateQuote();


                setTimeout(
                    calculateQuote,
                    100
                );


                setTimeout(
                    calculateQuote,
                    500
                );

            };


            if (
                document.readyState === 'loading'
            ) {

                document.addEventListener(
                    'DOMContentLoaded',
                    initSmartBuyQuoteEditPage
                );

            } else {

                initSmartBuyQuoteEditPage();

            }

        })();
    </script>

@endpush
