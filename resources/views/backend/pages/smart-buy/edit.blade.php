@extends('backend.layouts.backend')

@section('title', 'Edit Smart Buy Request')

@section('content')

    <div class="smart-buy-edit-page">

        {{-- ==========================================================
        | Header
        =========================================================== --}}

        <div class="smart-buy-edit-header">

            <div>

                <a
                    href="{{ route('smart-buy.details', 1) }}"
                    class="smart-buy-edit-back"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Request Details</span>
                </a>

                <div class="smart-buy-edit-heading">

                    <div class="smart-buy-edit-heading__icon">
                        <i class="ri-edit-line"></i>
                    </div>

                    <div>

                    <span>
                        Smart Buy Request
                    </span>

                        <h1>
                            Edit SB-2026-00128
                        </h1>

                        <p>
                            Update customer request information before preparing a quote.
                        </p>

                    </div>

                </div>

            </div>


            <span class="smart-buy-edit-status">
            <i></i>
            Pending Review
        </span>

        </div>



        {{-- ==========================================================
        | Form
        =========================================================== --}}

        <form
            id="smartBuyEditForm"
            class="smart-buy-edit-form"
            method="POST"
            action="{{ route('smart-buy.details', 1) }}"
        >

            @csrf


            <div class="smart-buy-edit-layout">


                {{-- ==================================================
                | Main Content
                =================================================== --}}

                <div class="smart-buy-edit-main">


                    {{-- ==================================================
                    | Product Information
                    =================================================== --}}

                    <section class="smart-buy-edit-card">

                        <div class="smart-buy-edit-card__header">

                            <div>

                                <h2>
                                    Product Information
                                </h2>

                                <p>
                                    Update the product requested by the customer.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-edit-card__body">


                            <div class="smart-buy-edit-field">

                                <label for="product_name">
                                    Product Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="product_name"
                                    name="product_name"
                                    value="MacBook Pro 14-inch"
                                    placeholder="Enter product name"
                                    required
                                >

                            </div>


                            <div class="smart-buy-edit-grid smart-buy-edit-grid--three">

                                <div class="smart-buy-edit-field">

                                    <label for="category">
                                        Category
                                        <span>*</span>
                                    </label>

                                    <select
                                        id="category"
                                        name="category"
                                        required
                                    >

                                        <option value="">
                                            Select Category
                                        </option>

                                        <option value="electronics" selected>
                                            Electronics
                                        </option>

                                        <option value="fashion">
                                            Fashion
                                        </option>

                                        <option value="home">
                                            Home & Living
                                        </option>

                                        <option value="industrial">
                                            Industrial
                                        </option>

                                        <option value="medical">
                                            Medical
                                        </option>

                                        <option value="other">
                                            Other
                                        </option>

                                    </select>

                                </div>


                                <div class="smart-buy-edit-field">

                                    <label for="quantity">
                                        Quantity
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="number"
                                        id="quantity"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        max="99999"
                                        required
                                    >

                                </div>


                                <div class="smart-buy-edit-field">

                                    <label for="condition">
                                        Condition
                                        <span>*</span>
                                    </label>

                                    <select
                                        id="condition"
                                        name="condition"
                                        required
                                    >

                                        <option value="new" selected>
                                            Brand New
                                        </option>

                                        <option value="used">
                                            Used
                                        </option>

                                        <option value="refurbished">
                                            Refurbished
                                        </option>

                                    </select>

                                </div>

                            </div>


                            <div class="smart-buy-edit-field">

                                <label for="source">
                                    Preferred Source
                                </label>

                                <select
                                    id="source"
                                    name="source"
                                >

                                    <option value="official" selected>
                                        Official Retailer
                                    </option>

                                    <option value="authorized">
                                        Authorized Seller
                                    </option>

                                    <option value="marketplace">
                                        Marketplace
                                    </option>

                                    <option value="any">
                                        Any Reliable Source
                                    </option>

                                </select>

                            </div>


                            <div class="smart-buy-edit-field">

                                <label for="product_url">
                                    Product / Reference URL
                                </label>

                                <div class="smart-buy-edit-input-icon">

                                    <i class="ri-link"></i>

                                    <input
                                        type="url"
                                        id="product_url"
                                        name="product_url"
                                        value="https://www.example.com/product/macbook-pro"
                                        placeholder="https://example.com/product"
                                    >

                                </div>

                            </div>


                            <div class="smart-buy-edit-field">

                                <label for="product_notes">
                                    Product Notes
                                </label>

                                <textarea
                                    id="product_notes"
                                    name="product_notes"
                                    rows="5"
                                    maxlength="1000"
                                    placeholder="Add product requirements or specifications..."
                                >Please make sure the product is brand new and comes with the original manufacturer warranty.</textarea>

                                <div class="smart-buy-edit-field-footer">

                                <span>
                                    Additional product requirements
                                </span>

                                    <span id="productNotesCount">
                                    0 / 1000
                                </span>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Delivery Information
                    =================================================== --}}

                    <section class="smart-buy-edit-card">

                        <div class="smart-buy-edit-card__header">

                            <div>

                                <h2>
                                    Delivery Information
                                </h2>

                                <p>
                                    Update the destination and recipient information.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-edit-card__body">


                            <div class="smart-buy-edit-grid smart-buy-edit-grid--two">

                                <div class="smart-buy-edit-field">

                                    <label for="recipient_name">
                                        Recipient Name
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="recipient_name"
                                        name="recipient_name"
                                        value="John Doe"
                                        required
                                    >

                                </div>


                                <div class="smart-buy-edit-field">

                                    <label for="phone">
                                        Phone Number
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        value="+224 620 000 000"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="smart-buy-edit-field">

                                <label for="address">
                                    Address
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="address"
                                    name="address"
                                    value="24 Rue de Paris"
                                    required
                                >

                            </div>


                            <div class="smart-buy-edit-grid smart-buy-edit-grid--three">

                                <div class="smart-buy-edit-field">

                                    <label for="country">
                                        Country
                                        <span>*</span>
                                    </label>

                                    <select
                                        id="country"
                                        name="country"
                                        required
                                    >

                                        <option value="">
                                            Select Country
                                        </option>

                                        <option value="guinea" selected>
                                            Guinea
                                        </option>

                                        <option value="senegal">
                                            Senegal
                                        </option>

                                        <option value="ivory-coast">
                                            Côte d'Ivoire
                                        </option>

                                        <option value="ghana">
                                            Ghana
                                        </option>

                                        <option value="nigeria">
                                            Nigeria
                                        </option>

                                        <option value="other">
                                            Other
                                        </option>

                                    </select>

                                </div>


                                <div class="smart-buy-edit-field">

                                    <label for="city">
                                        City
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="city"
                                        name="city"
                                        value="Conakry"
                                        required
                                    >

                                </div>


                                <div class="smart-buy-edit-field">

                                    <label for="postal_code">
                                        Postal Code
                                    </label>

                                    <input
                                        type="text"
                                        id="postal_code"
                                        name="postal_code"
                                        value="001"
                                    >

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Customer Notes
                    =================================================== --}}

                    <section class="smart-buy-edit-card">

                        <div class="smart-buy-edit-card__header">

                            <div>

                                <h2>
                                    Customer Notes
                                </h2>

                                <p>
                                    Additional information provided by the customer.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-edit-card__body">

                            <div class="smart-buy-edit-field">

                                <label for="customer_notes">
                                    Notes
                                </label>

                                <textarea
                                    id="customer_notes"
                                    name="customer_notes"
                                    rows="6"
                                    maxlength="1500"
                                    placeholder="Customer notes..."
                                >Please make sure the product is brand new and comes with the original manufacturer warranty. I would prefer the fastest available shipping option.</textarea>

                                <div class="smart-buy-edit-field-footer">

                                <span>
                                    Customer request notes
                                </span>

                                    <span id="customerNotesCount">
                                    0 / 1500
                                </span>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Admin Internal Note
                    =================================================== --}}

                    <section class="smart-buy-edit-card">

                        <div class="smart-buy-edit-card__header">

                            <div>

                                <h2>
                                    Internal Note
                                </h2>

                                <p>
                                    This note is visible to administrators only.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-edit-card__body">

                            <div class="smart-buy-edit-field">

                                <label for="admin_note">
                                    Admin Note
                                </label>

                                <textarea
                                    id="admin_note"
                                    name="admin_note"
                                    rows="5"
                                    maxlength="1000"
                                    placeholder="Write an internal note..."
                                ></textarea>

                                <div class="smart-buy-edit-field-footer">

                                <span>
                                    Internal administration note
                                </span>

                                    <span id="adminNoteCount">
                                    0 / 1000
                                </span>

                                </div>

                            </div>

                        </div>

                    </section>

                </div>



                {{-- ==================================================
                | Sidebar
                =================================================== --}}

                <aside class="smart-buy-edit-sidebar">


                    {{-- ==================================================
                    | Request Status
                    =================================================== --}}

                    <section class="smart-buy-edit-card">

                        <div class="smart-buy-edit-card__header">

                            <div>

                                <h2>
                                    Request Status
                                </h2>

                            </div>

                        </div>


                        <div class="smart-buy-edit-card__body">

                            <div class="smart-buy-edit-field">

                                <label for="status">
                                    Status
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                >

                                    <option value="pending" selected>
                                        Pending Review
                                    </option>

                                    <option value="quote">
                                        Quote Prepared
                                    </option>

                                    <option value="awaiting-payment">
                                        Awaiting Payment
                                    </option>

                                    <option value="paid">
                                        Paid
                                    </option>

                                    <option value="purchased">
                                        Purchased
                                    </option>

                                    <option value="shipment">
                                        In Shipment
                                    </option>

                                    <option value="completed">
                                        Completed
                                    </option>

                                </select>

                            </div>


                            <div class="smart-buy-edit-status-info">

                                <i class="ri-information-line"></i>

                                <p>
                                    Changing the status manually can affect the next step of the request workflow.
                                </p>

                            </div>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Request Information
                    =================================================== --}}

                    <section class="smart-buy-edit-card">

                        <div class="smart-buy-edit-card__header">

                            <div>

                                <h2>
                                    Request Information
                                </h2>

                            </div>

                        </div>


                        <div class="smart-buy-edit-summary">

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
                                Created
                            </span>

                                <strong>
                                    Aug 16, 2026
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

                        </div>

                    </section>



                    {{-- ==================================================
                    | Estimated Amount
                    =================================================== --}}

                    <section class="smart-buy-edit-card">

                        <div class="smart-buy-edit-card__header">

                            <div>

                                <h2>
                                    Estimated Amount
                                </h2>

                                <p>
                                    Reference only
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-edit-amount">

                        <span>
                            Estimated Product
                        </span>

                            <strong>
                                $2,200.00
                            </strong>

                        </div>


                        <div class="smart-buy-edit-amount">

                        <span>
                            Estimated Shipping
                        </span>

                            <strong>
                                TBD
                            </strong>

                        </div>


                        <div class="smart-buy-edit-amount smart-buy-edit-amount--total">

                        <span>
                            Estimated Total
                        </span>

                            <strong>
                                $2,450.00
                            </strong>

                        </div>

                    </section>



                    {{-- ==================================================
                    | Warning
                    =================================================== --}}

                    <div class="smart-buy-edit-warning">

                        <div class="smart-buy-edit-warning__icon">

                            <i class="ri-error-warning-line"></i>

                        </div>

                        <div>

                            <strong>
                                Before Saving
                            </strong>

                            <p>
                                Make sure the customer information and delivery details are accurate.
                            </p>

                        </div>

                    </div>

                </aside>

            </div>



            {{-- ==========================================================
            | Form Footer
            =========================================================== --}}

            <div class="smart-buy-edit-footer">

                <div>

                <span>
                    Last updated by Admin
                </span>

                    <small>
                        Aug 16, 2026 · 10:12 AM
                    </small>

                </div>


                <div class="smart-buy-edit-footer__actions">

                    <a
                        href="{{ route('smart-buy.details', 1) }}"
                        class="smart-buy-edit-cancel"
                        id="cancelEdit"
                    >
                        Cancel
                    </a>


                    <button
                        type="reset"
                        class="smart-buy-edit-reset"
                        id="resetEdit"
                    >
                        <i class="ri-refresh-line"></i>
                        Reset
                    </button>


                    <button
                        type="submit"
                        class="smart-buy-edit-save"
                    >
                        <i class="ri-save-line"></i>
                        Save Changes
                    </button>

                </div>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('smartBuyEditForm');

            const resetButton = document.getElementById('resetEdit');

            const cancelButton = document.getElementById('cancelEdit');


            /*
            |--------------------------------------------------------------------------
            | Character Counter
            |--------------------------------------------------------------------------
            */

            function setupCounter(inputId, counterId) {

                const input = document.getElementById(inputId);
                const counter = document.getElementById(counterId);

                if (!input || !counter) {
                    return;
                }

                function updateCounter() {

                    counter.textContent =
                        `${input.value.length} / ${input.maxLength}`;

                }

                input.addEventListener('input', updateCounter);

                updateCounter();
            }


            setupCounter(
                'product_notes',
                'productNotesCount'
            );


            setupCounter(
                'customer_notes',
                'customerNotesCount'
            );


            setupCounter(
                'admin_note',
                'adminNoteCount'
            );


            /*
            |--------------------------------------------------------------------------
            | Reset Confirmation
            |--------------------------------------------------------------------------
            */

            if (resetButton) {

                resetButton.addEventListener('click', function (event) {

                    const confirmed = window.confirm(
                        'Are you sure you want to reset all changes?'
                    );

                    if (!confirmed) {

                        event.preventDefault();

                        return;
                    }

                    window.setTimeout(function () {

                        setupCounter(
                            'product_notes',
                            'productNotesCount'
                        );

                        setupCounter(
                            'customer_notes',
                            'customerNotesCount'
                        );

                        setupCounter(
                            'admin_note',
                            'adminNoteCount'
                        );

                    }, 0);

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Cancel Confirmation
            |--------------------------------------------------------------------------
            */

            if (cancelButton) {

                cancelButton.addEventListener('click', function (event) {

                    const confirmed = window.confirm(
                        'Discard your changes and return to the request details?'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Form Validation
            |--------------------------------------------------------------------------
            */

            if (form) {

                form.addEventListener('submit', function (event) {

                    if (!form.checkValidity()) {

                        event.preventDefault();

                        form.reportValidity();

                        return;
                    }


                    const saveButton =
                        form.querySelector('.smart-buy-edit-save');


                    if (saveButton) {

                        saveButton.disabled = true;

                        saveButton.classList.add(
                            'smart-buy-edit-save--loading'
                        );

                        saveButton.innerHTML = `
                    <i class="ri-loader-4-line"></i>
                    Saving...
                `;

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Quantity Validation
            |--------------------------------------------------------------------------
            */

            const quantity =
                document.getElementById('quantity');

            if (quantity) {

                quantity.addEventListener('input', function () {

                    const value =
                        parseInt(this.value, 10);

                    if (Number.isNaN(value) || value < 1) {

                        this.value = 1;

                    }

                });

            }

        });
    </script>

@endpush
