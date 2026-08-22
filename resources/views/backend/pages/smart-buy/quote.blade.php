@extends('backend.layouts.backend')

@section('title', 'Prepare Smart Buy Quote')

@section('content')

    <div class="smart-buy-quote-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="smart-buy-quote-header">

            <div>

                <a
                    href="{{ route('smart-buy-details', 1) }}"
                    class="smart-buy-quote-back"
                >
                    <i class="ri-arrow-left-line"></i>

                    <span>
                    Back to Request Details
                </span>
                </a>


                <div class="smart-buy-quote-heading">

                    <div class="smart-buy-quote-heading__icon">

                        <i class="ri-file-edit-line"></i>

                    </div>


                    <div>

                    <span>
                        Smart Buy Quote
                    </span>

                        <h1>
                            Prepare Quote
                        </h1>

                        <p>
                            Create a quote for request SB-2026-00128.
                        </p>

                    </div>

                </div>

            </div>


            <div class="smart-buy-quote-header__status">

            <span class="smart-buy-quote-status">

                <i></i>

                Pending Quote

            </span>

            </div>

        </div>



        {{-- ==========================================================
        | Main Form
        =========================================================== --}}

        <form
            id="smartBuyQuoteForm"
            class="smart-buy-quote-form"
            method="POST"
            action="{{ route('smart-buy-admin-quote', 1) }}"
        >

            @csrf


            <div class="smart-buy-quote-layout">


                {{-- ==================================================
                | Main Content
                =================================================== --}}

                <div class="smart-buy-quote-main">


                    {{-- ==================================================
                    | Request Summary
                    =================================================== --}}

                    <section class="smart-buy-quote-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Request Summary
                                </h2>

                                <p>
                                    Review the customer's request before preparing the quote.
                                </p>

                            </div>


                            <a
                                href="{{ route('smart-buy-details', 1) }}"
                                class="smart-buy-quote-view-request"
                            >

                                <i class="ri-eye-line"></i>

                                View Request

                            </a>

                        </div>


                        <div class="smart-buy-quote-request">

                            <div class="smart-buy-quote-request__product">

                                <div class="smart-buy-quote-request__icon">

                                    <i class="ri-shopping-bag-3-line"></i>

                                </div>


                                <div>

                                <span>
                                    Product
                                </span>

                                    <strong>
                                        MacBook Pro 14-inch
                                    </strong>

                                    <small>
                                        Electronics · 1 Unit · Brand New
                                    </small>

                                </div>

                            </div>


                            <div class="smart-buy-quote-request__destination">

                            <span>
                                Delivery To
                            </span>

                                <strong>
                                    Conakry, Guinea
                                </strong>

                                <small>
                                    24 Rue de Paris · 001
                                </small>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Product Cost
                    =================================================== --}}

                    <section class="smart-buy-quote-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Product Cost
                                </h2>

                                <p>
                                    Enter the product purchasing cost.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-quote-card__body">

                            <div class="smart-buy-quote-grid smart-buy-quote-grid--two">

                                <div class="smart-buy-quote-field">

                                    <label for="product_cost">

                                        Product Price

                                        <span>*</span>

                                    </label>


                                    <div class="smart-buy-quote-money-input">

                                    <span>
                                        $
                                    </span>

                                        <input
                                            type="number"
                                            id="product_cost"
                                            name="product_cost"
                                            value="2200"
                                            min="0"
                                            step="0.01"
                                            data-quote-input
                                            required
                                        >

                                    </div>

                                </div>


                                <div class="smart-buy-quote-field">

                                    <label for="quantity">

                                        Quantity

                                    </label>


                                    <input
                                        type="number"
                                        id="quantity"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        readonly
                                    >

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Shipping & Charges
                    =================================================== --}}

                    <section class="smart-buy-quote-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Shipping & Charges
                                </h2>

                                <p>
                                    Add shipping, customs and service-related charges.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-quote-card__body">


                            <div class="smart-buy-quote-charge-row">

                                <div class="smart-buy-quote-charge-info">

                                    <div class="smart-buy-quote-charge-icon">

                                        <i class="ri-truck-line"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            International Shipping
                                        </strong>

                                        <span>
                                        Supplier to destination
                                    </span>

                                    </div>

                                </div>


                                <div class="smart-buy-quote-charge-input">

                                <span>
                                    $
                                </span>

                                    <input
                                        type="number"
                                        id="shipping_cost"
                                        name="shipping_cost"
                                        value="150"
                                        min="0"
                                        step="0.01"
                                        data-quote-input
                                    >

                                </div>

                            </div>



                            <div class="smart-buy-quote-charge-row">

                                <div class="smart-buy-quote-charge-info">

                                    <div class="smart-buy-quote-charge-icon">

                                        <i class="ri-government-line"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            Customs & Duties
                                        </strong>

                                        <span>
                                        Import duties and customs charges
                                    </span>

                                    </div>

                                </div>


                                <div class="smart-buy-quote-charge-input">

                                <span>
                                    $
                                </span>

                                    <input
                                        type="number"
                                        id="customs_cost"
                                        name="customs_cost"
                                        value="50"
                                        min="0"
                                        step="0.01"
                                        data-quote-input
                                    >

                                </div>

                            </div>



                            <div class="smart-buy-quote-charge-row">

                                <div class="smart-buy-quote-charge-info">

                                    <div class="smart-buy-quote-charge-icon">

                                        <i class="ri-service-line"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            Service Fee
                                        </strong>

                                        <span>
                                        Baobab Atlas service charge
                                    </span>

                                    </div>

                                </div>


                                <div class="smart-buy-quote-charge-input">

                                <span>
                                    $
                                </span>

                                    <input
                                        type="number"
                                        id="service_fee"
                                        name="service_fee"
                                        value="50"
                                        min="0"
                                        step="0.01"
                                        data-quote-input
                                    >

                                </div>

                            </div>



                            <div class="smart-buy-quote-charge-row">

                                <div class="smart-buy-quote-charge-info">

                                    <div class="smart-buy-quote-charge-icon">

                                        <i class="ri-more-line"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            Other Charges
                                        </strong>

                                        <span>
                                        Additional handling or related charges
                                    </span>

                                    </div>

                                </div>


                                <div class="smart-buy-quote-charge-input">

                                <span>
                                    $
                                </span>

                                    <input
                                        type="number"
                                        id="other_charges"
                                        name="other_charges"
                                        value="0"
                                        min="0"
                                        step="0.01"
                                        data-quote-input
                                    >

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Discount
                    =================================================== --}}

                    <section class="smart-buy-quote-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Discount
                                </h2>

                                <p>
                                    Apply an optional discount to the quote.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-quote-card__body">

                            <div class="smart-buy-quote-grid smart-buy-quote-grid--two">

                                <div class="smart-buy-quote-field">

                                    <label for="discount_type">
                                        Discount Type
                                    </label>

                                    <select
                                        id="discount_type"
                                        name="discount_type"
                                    >

                                        <option value="fixed" selected>
                                            Fixed Amount
                                        </option>

                                        <option value="percentage">
                                            Percentage
                                        </option>

                                    </select>

                                </div>


                                <div class="smart-buy-quote-field">

                                    <label for="discount">

                                        Discount

                                    </label>


                                    <div class="smart-buy-quote-money-input">

                                    <span id="discountPrefix">
                                        $
                                    </span>

                                        <input
                                            type="number"
                                            id="discount"
                                            name="discount"
                                            value="0"
                                            min="0"
                                            step="0.01"
                                            data-quote-input
                                        >

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Customer Message
                    =================================================== --}}

                    <section class="smart-buy-quote-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Customer Message
                                </h2>

                                <p>
                                    Add a message that will be visible to the customer.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-quote-card__body">

                            <div class="smart-buy-quote-field">

                                <label for="customer_message">
                                    Message
                                </label>

                                <textarea
                                    id="customer_message"
                                    name="customer_message"
                                    rows="6"
                                    maxlength="1500"
                                    placeholder="Write a message for the customer..."
                                >Your Smart Buy request has been reviewed. Please review the quote below and proceed with the next step if everything looks good.</textarea>


                                <div class="smart-buy-quote-field-footer">

                                <span>
                                    This message will be visible to the customer.
                                </span>

                                    <span id="customerMessageCount">
                                    0 / 1500
                                </span>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Quote Terms
                    =================================================== --}}

                    <section class="smart-buy-quote-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Quote Terms
                                </h2>

                                <p>
                                    Terms and conditions related to this quote.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-quote-card__body">

                            <div class="smart-buy-quote-field">

                                <label for="quote_terms">
                                    Terms
                                </label>

                                <textarea
                                    id="quote_terms"
                                    name="quote_terms"
                                    rows="6"
                                    maxlength="2000"
                                    placeholder="Enter quote terms..."
                                >This quote is valid for 7 days. Final delivery time may vary depending on supplier availability, customs clearance and shipping conditions.</textarea>

                            </div>


                            <label class="smart-buy-quote-checkbox">

                                <input
                                    type="checkbox"
                                    name="include_terms"
                                    value="1"
                                    checked
                                >

                                <span class="smart-buy-quote-checkbox__box"></span>

                                <span>
                                Include these terms in the customer quote.
                            </span>

                            </label>

                        </div>

                    </section>

                </div>



                {{-- ==================================================
                | Sidebar
                =================================================== --}}

                <aside class="smart-buy-quote-sidebar">


                    {{-- ==================================================
                    | Quote Summary
                    =================================================== --}}

                    <section class="smart-buy-quote-card smart-buy-quote-summary-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Quote Summary
                                </h2>

                                <p>
                                    Customer payable amount
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-quote-summary">


                            <div>

                            <span>
                                Product Cost
                            </span>

                                <strong id="summaryProduct">
                                    $2,200.00
                                </strong>

                            </div>


                            <div>

                            <span>
                                Shipping
                            </span>

                                <strong id="summaryShipping">
                                    $150.00
                                </strong>

                            </div>


                            <div>

                            <span>
                                Customs & Duties
                            </span>

                                <strong id="summaryCustoms">
                                    $50.00
                                </strong>

                            </div>


                            <div>

                            <span>
                                Service Fee
                            </span>

                                <strong id="summaryService">
                                    $50.00
                                </strong>

                            </div>


                            <div>

                            <span>
                                Other Charges
                            </span>

                                <strong id="summaryOther">
                                    $0.00
                                </strong>

                            </div>


                            <div class="smart-buy-quote-summary__subtotal">

                            <span>
                                Subtotal
                            </span>

                                <strong id="summarySubtotal">
                                    $2,450.00
                                </strong>

                            </div>


                            <div>

                            <span>
                                Discount
                            </span>

                                <strong
                                    id="summaryDiscount"
                                    class="smart-buy-quote-summary__discount"
                                >
                                    -$0.00
                                </strong>

                            </div>


                            <div class="smart-buy-quote-summary__total">

                            <span>
                                Total Quote
                            </span>

                                <strong id="summaryTotal">
                                    $2,450.00
                                </strong>

                            </div>

                        </div>


                        <div class="smart-buy-quote-customer-pay">

                        <span>
                            Customer will pay
                        </span>

                            <strong id="customerPayAmount">
                                $2,450.00
                            </strong>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Request Information
                    =================================================== --}}

                    <section class="smart-buy-quote-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Request Information
                                </h2>

                            </div>

                        </div>


                        <div class="smart-buy-quote-info">

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
                                Customer
                            </span>

                                <strong>
                                    John Doe
                                </strong>

                            </div>


                            <div>

                            <span>
                                Destination
                            </span>

                                <strong>
                                    Conakry, Guinea
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

                        </div>

                    </section>



                    {{-- ==================================================
                    | Quote Validity
                    =================================================== --}}

                    <section class="smart-buy-quote-card">

                        <div class="smart-buy-quote-card__header">

                            <div>

                                <h2>
                                    Quote Validity
                                </h2>

                            </div>

                        </div>


                        <div class="smart-buy-quote-card__body">

                            <div class="smart-buy-quote-field">

                                <label for="valid_until">
                                    Valid Until
                                </label>

                                <input
                                    type="date"
                                    id="valid_until"
                                    name="valid_until"
                                    value="2026-08-23"
                                >

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Important Notice
                    =================================================== --}}

                    <div class="smart-buy-quote-notice">

                        <div class="smart-buy-quote-notice__icon">

                            <i class="ri-information-line"></i>

                        </div>


                        <div>

                            <strong>
                                Before Sending
                            </strong>

                            <p>
                                Review all charges carefully. Once sent, the customer will be able to review and accept this quote.
                            </p>

                        </div>

                    </div>

                </aside>

            </div>



            {{-- ==========================================================
            | Footer Actions
            =========================================================== --}}

            <div class="smart-buy-quote-footer">

                <div>

                <span>
                    Quote for SB-2026-00128
                </span>

                    <small>
                        Customer: John Doe
                    </small>

                </div>


                <div class="smart-buy-quote-footer__actions">

                    <a
                        href="{{ route('smart-buy-details', 1) }}"
                        class="smart-buy-quote-cancel"
                        id="cancelQuote"
                    >
                        Cancel
                    </a>


                    <button
                        type="button"
                        class="smart-buy-quote-draft"
                        id="saveQuoteDraft"
                    >

                        <i class="ri-draft-line"></i>

                        Save Draft

                    </button>


                    <button
                        type="submit"
                        class="smart-buy-quote-send"
                    >

                        <i class="ri-send-plane-line"></i>

                        Send Quote

                    </button>

                </div>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('smartBuyQuoteForm');

            const discountType = document.getElementById('discount_type');

            const discountInput = document.getElementById('discount');

            const discountPrefix = document.getElementById('discountPrefix');

            const cancelQuote = document.getElementById('cancelQuote');

            const saveDraft = document.getElementById('saveQuoteDraft');


            /*
            |--------------------------------------------------------------------------
            | Format Currency
            |--------------------------------------------------------------------------
            */

            function formatCurrency(value) {

                const amount = Number(value) || 0;

                return '$' + amount.toLocaleString(
                    'en-US',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Get Numeric Value
            |--------------------------------------------------------------------------
            */

            function getValue(id) {

                const element = document.getElementById(id);

                if (!element) {
                    return 0;
                }

                return Math.max(
                    0,
                    Number(element.value) || 0
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Calculate Quote
            |--------------------------------------------------------------------------
            */

            function calculateQuote() {

                const product = getValue('product_cost');

                const shipping = getValue('shipping_cost');

                const customs = getValue('customs_cost');

                const service = getValue('service_fee');

                const other = getValue('other_charges');

                const discountValue = getValue('discount');


                const subtotal =
                    product +
                    shipping +
                    customs +
                    service +
                    other;


                let discount = 0;


                if (
                    discountType &&
                    discountType.value === 'percentage'
                ) {

                    discount =
                        subtotal *
                        (discountValue / 100);

                } else {

                    discount = discountValue;

                }


                discount = Math.min(
                    discount,
                    subtotal
                );


                const total =
                    subtotal -
                    discount;


                document.getElementById('summaryProduct').textContent =
                    formatCurrency(product);


                document.getElementById('summaryShipping').textContent =
                    formatCurrency(shipping);


                document.getElementById('summaryCustoms').textContent =
                    formatCurrency(customs);


                document.getElementById('summaryService').textContent =
                    formatCurrency(service);


                document.getElementById('summaryOther').textContent =
                    formatCurrency(other);


                document.getElementById('summarySubtotal').textContent =
                    formatCurrency(subtotal);


                document.getElementById('summaryDiscount').textContent =
                    '-' + formatCurrency(discount);


                document.getElementById('summaryTotal').textContent =
                    formatCurrency(total);


                document.getElementById('customerPayAmount').textContent =
                    formatCurrency(total);

            }


            /*
            |--------------------------------------------------------------------------
            | Update Discount Type
            |--------------------------------------------------------------------------
            */

            function updateDiscountType() {

                if (!discountType || !discountPrefix) {
                    return;
                }


                if (discountType.value === 'percentage') {

                    discountPrefix.textContent = '%';

                    if (discountInput) {
                        discountInput.max = '100';
                    }

                } else {

                    discountPrefix.textContent = '$';

                    if (discountInput) {
                        discountInput.removeAttribute('max');
                    }

                }


                calculateQuote();

            }


            /*
            |--------------------------------------------------------------------------
            | Quote Inputs
            |--------------------------------------------------------------------------
            */

            const quoteInputs =
                document.querySelectorAll('[data-quote-input]');


            quoteInputs.forEach(function (input) {

                input.addEventListener(
                    'input',
                    calculateQuote
                );

            });


            if (discountType) {

                discountType.addEventListener(
                    'change',
                    updateDiscountType
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Character Counter
            |--------------------------------------------------------------------------
            */

            const customerMessage =
                document.getElementById('customer_message');

            const customerMessageCount =
                document.getElementById('customerMessageCount');


            function updateMessageCount() {

                if (
                    !customerMessage ||
                    !customerMessageCount
                ) {
                    return;
                }


                customerMessageCount.textContent =
                    `${customerMessage.value.length} / ${customerMessage.maxLength}`;

            }


            if (customerMessage) {

                customerMessage.addEventListener(
                    'input',
                    updateMessageCount
                );

                updateMessageCount();

            }


            /*
            |--------------------------------------------------------------------------
            | Cancel Confirmation
            |--------------------------------------------------------------------------
            */

            if (cancelQuote) {

                cancelQuote.addEventListener(
                    'click',
                    function (event) {

                        const confirmed = window.confirm(
                            'Discard this quote and return to the request details?'
                        );


                        if (!confirmed) {

                            event.preventDefault();

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Save Draft
            |--------------------------------------------------------------------------
            */

            if (saveDraft) {

                saveDraft.addEventListener(
                    'click',
                    function () {

                        const original =
                            saveDraft.innerHTML;


                        saveDraft.disabled = true;

                        saveDraft.innerHTML = `
                    <i class="ri-loader-4-line smart-buy-quote-spin"></i>
                    Saving...
                `;


                        window.setTimeout(
                            function () {

                                saveDraft.disabled = false;

                                saveDraft.innerHTML =
                                    original;

                                window.alert(
                                    'Quote draft saved successfully.'
                                );

                            },
                            700
                        );

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Form Submit
            |--------------------------------------------------------------------------
            */

            if (form) {

                form.addEventListener(
                    'submit',
                    function (event) {

                        if (!form.checkValidity()) {

                            event.preventDefault();

                            form.reportValidity();

                            return;

                        }


                        const total =
                            document.getElementById(
                                'summaryTotal'
                            ).textContent;


                        const confirmed = window.confirm(
                            `Send this quote to the customer for ${total}?`
                        );


                        if (!confirmed) {

                            event.preventDefault();

                            return;

                        }


                        const sendButton =
                            form.querySelector(
                                '.smart-buy-quote-send'
                            );


                        if (sendButton) {

                            sendButton.disabled = true;

                            sendButton.innerHTML = `
                        <i class="ri-loader-4-line smart-buy-quote-spin"></i>
                        Sending...
                    `;

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Initial Calculation
            |--------------------------------------------------------------------------
            */

            updateDiscountType();

            calculateQuote();

        });
    </script>

@endpush
