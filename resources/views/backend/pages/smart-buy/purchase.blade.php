@extends('backend.layouts.backend')

@section('title', 'Purchase Smart Buy Product')

@section('content')

    <div class="smart-buy-purchase-page">

        {{-- Header --}}
        <div class="smart-buy-purchase-header">

            <div>

                <a
                    href="{{ route('smart-buy.details', 1) }}"
                    class="smart-buy-purchase-back"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Request Details</span>
                </a>

                <div class="smart-buy-purchase-heading">

                    <div class="smart-buy-purchase-heading__icon">
                        <i class="ri-shopping-cart-2-line"></i>
                    </div>

                    <div>

                        <span>Smart Buy</span>

                        <h1>Purchase Product</h1>

                        <p>
                            Complete the product purchase for request SB-2026-00128.
                        </p>

                    </div>

                </div>

            </div>


            <span class="smart-buy-purchase-status">

            <i></i>

            Payment Completed

        </span>

        </div>


        <form
            id="smartBuyPurchaseForm"
            class="smart-buy-purchase-form"
            method="POST"
            action="{{ route('smart-buy-purchase', 1) }}"
        >

            @csrf


            <div class="smart-buy-purchase-layout">


                {{-- Main --}}
                <div class="smart-buy-purchase-main">


                    {{-- Product --}}
                    <section class="smart-buy-purchase-card">

                        <div class="smart-buy-purchase-card__header">

                            <div>

                                <h2>Product Information</h2>

                                <p>
                                    Product approved for purchase.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-product">

                            <div class="smart-buy-purchase-product__icon">

                                <i class="ri-shopping-bag-3-line"></i>

                            </div>


                            <div class="smart-buy-purchase-product__content">

                                <span>Product</span>

                                <h3>
                                    MacBook Pro 14-inch
                                </h3>

                                <p>
                                    Apple MacBook Pro 14-inch with M-series chip,
                                    16GB RAM and 512GB storage.
                                </p>


                                <div class="smart-buy-purchase-product__meta">

                                    <div>
                                        <span>Quantity</span>
                                        <strong>1 Unit</strong>
                                    </div>

                                    <div>
                                        <span>Condition</span>
                                        <strong>Brand New</strong>
                                    </div>

                                    <div>
                                        <span>Category</span>
                                        <strong>Electronics</strong>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- Supplier --}}
                    <section class="smart-buy-purchase-card">

                        <div class="smart-buy-purchase-card__header">

                            <div>

                                <h2>Supplier Information</h2>

                                <p>
                                    Enter the supplier information used for the purchase.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-card__body">

                            <div class="smart-buy-purchase-grid smart-buy-purchase-grid--two">

                                <div class="smart-buy-purchase-field">

                                    <label for="supplier_name">
                                        Supplier Name
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="supplier_name"
                                        name="supplier_name"
                                        placeholder="Enter supplier name"
                                        required
                                    >

                                </div>


                                <div class="smart-buy-purchase-field">

                                    <label for="supplier_contact">
                                        Supplier Contact
                                    </label>

                                    <input
                                        type="text"
                                        id="supplier_contact"
                                        name="supplier_contact"
                                        placeholder="Phone or contact person"
                                    >

                                </div>

                            </div>


                            <div class="smart-buy-purchase-grid smart-buy-purchase-grid--two">

                                <div class="smart-buy-purchase-field">

                                    <label for="supplier_email">
                                        Supplier Email
                                    </label>

                                    <input
                                        type="email"
                                        id="supplier_email"
                                        name="supplier_email"
                                        placeholder="supplier@example.com"
                                    >

                                </div>


                                <div class="smart-buy-purchase-field">

                                    <label for="supplier_url">
                                        Supplier Website
                                    </label>

                                    <input
                                        type="url"
                                        id="supplier_url"
                                        name="supplier_url"
                                        placeholder="https://example.com"
                                    >

                                </div>

                            </div>


                            <div class="smart-buy-purchase-field">

                                <label for="supplier_address">
                                    Supplier Address
                                </label>

                                <textarea
                                    id="supplier_address"
                                    name="supplier_address"
                                    rows="4"
                                    placeholder="Enter supplier address..."
                                ></textarea>

                            </div>

                        </div>

                    </section>



                    {{-- Purchase Details --}}
                    <section class="smart-buy-purchase-card">

                        <div class="smart-buy-purchase-card__header">

                            <div>

                                <h2>Purchase Details</h2>

                                <p>
                                    Record the actual product purchase.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-card__body">

                            <div class="smart-buy-purchase-grid smart-buy-purchase-grid--three">

                                <div class="smart-buy-purchase-field">

                                    <label for="purchase_date">
                                        Purchase Date
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="date"
                                        id="purchase_date"
                                        name="purchase_date"
                                        value="2026-08-16"
                                        required
                                    >

                                </div>


                                <div class="smart-buy-purchase-field">

                                    <label for="purchase_reference">
                                        Purchase Reference
                                    </label>

                                    <input
                                        type="text"
                                        id="purchase_reference"
                                        name="purchase_reference"
                                        placeholder="PO-2026-00128"
                                    >

                                </div>


                                <div class="smart-buy-purchase-field">

                                    <label for="order_number">
                                        Supplier Order Number
                                    </label>

                                    <input
                                        type="text"
                                        id="order_number"
                                        name="order_number"
                                        placeholder="Supplier order number"
                                    >

                                </div>

                            </div>


                            <div class="smart-buy-purchase-grid smart-buy-purchase-grid--two">

                                <div class="smart-buy-purchase-field">

                                    <label for="actual_product_cost">
                                        Actual Product Cost
                                        <span>*</span>
                                    </label>

                                    <div class="smart-buy-purchase-money">

                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="actual_product_cost"
                                            name="actual_product_cost"
                                            value="2200"
                                            min="0"
                                            step="0.01"
                                            required
                                        >

                                    </div>

                                </div>


                                <div class="smart-buy-purchase-field">

                                    <label for="actual_shipping_cost">
                                        Actual Shipping Cost
                                    </label>

                                    <div class="smart-buy-purchase-money">

                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="actual_shipping_cost"
                                            name="actual_shipping_cost"
                                            value="150"
                                            min="0"
                                            step="0.01"
                                        >

                                    </div>

                                </div>

                            </div>


                            <div class="smart-buy-purchase-field">

                                <label for="purchase_notes">
                                    Purchase Notes
                                </label>

                                <textarea
                                    id="purchase_notes"
                                    name="purchase_notes"
                                    rows="5"
                                    maxlength="1500"
                                    placeholder="Add purchase notes..."
                                ></textarea>

                                <div class="smart-buy-purchase-field-footer">

                                <span>
                                    Internal purchase information
                                </span>

                                    <span id="purchaseNotesCount">
                                    0 / 1500
                                </span>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- Order Documents --}}
                    <section class="smart-buy-purchase-card">

                        <div class="smart-buy-purchase-card__header">

                            <div>

                                <h2>Purchase Documents</h2>

                                <p>
                                    Upload invoices, receipts or purchase confirmations.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-card__body">

                            <label
                                for="purchase_documents"
                                class="smart-buy-purchase-upload"
                            >

                                <input
                                    type="file"
                                    id="purchase_documents"
                                    name="purchase_documents[]"
                                    accept=".jpg,.jpeg,.png,.pdf,.webp"
                                    multiple
                                >


                                <span class="smart-buy-purchase-upload__icon">

                                <i class="ri-upload-cloud-2-line"></i>

                            </span>


                                <strong>
                                    Upload Purchase Documents
                                </strong>


                                <span>
                                PDF, JPG, PNG or WEBP · Max 5MB each
                            </span>

                            </label>


                            <div
                                id="purchaseFileList"
                                class="smart-buy-purchase-file-list"
                            ></div>

                        </div>

                    </section>



                    {{-- Status --}}
                    <section class="smart-buy-purchase-card">

                        <div class="smart-buy-purchase-card__header">

                            <div>

                                <h2>Purchase Status</h2>

                                <p>
                                    Update the current purchasing status.
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-card__body">

                            <div class="smart-buy-purchase-field">

                                <label for="purchase_status">
                                    Status
                                </label>

                                <select
                                    id="purchase_status"
                                    name="purchase_status"
                                >

                                    <option value="pending">
                                        Purchase Pending
                                    </option>

                                    <option value="ordered">
                                        Order Placed
                                    </option>

                                    <option value="confirmed" selected>
                                        Purchase Confirmed
                                    </option>

                                    <option value="received">
                                        Product Received
                                    </option>

                                    <option value="cancelled">
                                        Cancelled
                                    </option>

                                </select>

                            </div>


                            <div class="smart-buy-purchase-status-note">

                                <i class="ri-information-line"></i>

                                <p>
                                    Once the product is purchased, you can continue to
                                    the shipment process and add tracking information.
                                </p>

                            </div>

                        </div>

                    </section>

                </div>



                {{-- Sidebar --}}
                <aside class="smart-buy-purchase-sidebar">


                    {{-- Payment --}}
                    <section class="smart-buy-purchase-card">

                        <div class="smart-buy-purchase-card__header">

                            <div>

                                <h2>Payment</h2>

                                <p>
                                    Customer payment status
                                </p>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-payment">

                            <div class="smart-buy-purchase-payment__status">

                            <span>
                                <i class="ri-checkbox-circle-fill"></i>
                            </span>

                                <div>

                                    <strong>
                                        Paid
                                    </strong>

                                    <small>
                                        Aug 16, 2026 · 11:18 AM
                                    </small>

                                </div>

                            </div>


                            <div class="smart-buy-purchase-payment__total">

                            <span>
                                Customer Paid
                            </span>

                                <strong>
                                    $2,450.00
                                </strong>

                            </div>

                        </div>

                    </section>



                    {{-- Purchase Summary --}}
                    <section class="smart-buy-purchase-card">

                        <div class="smart-buy-purchase-card__header">

                            <div>

                                <h2>Purchase Summary</h2>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-summary">

                            <div>

                            <span>
                                Product
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
                                Purchase Total
                            </span>

                                <strong id="summaryTotal">
                                    $2,350.00
                                </strong>

                            </div>

                        </div>

                    </section>



                    {{-- Customer --}}
                    <section class="smart-buy-purchase-card">

                        <div class="smart-buy-purchase-card__header">

                            <div>

                                <h2>Customer</h2>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-customer">

                            <div class="smart-buy-purchase-customer__avatar">
                                JD
                            </div>


                            <div>

                                <strong>
                                    John Doe
                                </strong>

                                <span>
                                john@example.com
                            </span>

                            </div>

                        </div>


                        <div class="smart-buy-purchase-destination">

                            <i class="ri-map-pin-line"></i>

                            <div>

                            <span>
                                Delivery Destination
                            </span>

                                <strong>
                                    Conakry, Guinea
                                </strong>

                            </div>

                        </div>

                    </section>



                    {{-- Next Step --}}
                    <div class="smart-buy-purchase-next">

                        <div class="smart-buy-purchase-next__icon">

                            <i class="ri-truck-line"></i>

                        </div>


                        <div>

                            <strong>
                                Next Step
                            </strong>

                            <p>
                                After confirming the purchase, create a shipment and add tracking information.
                            </p>

                        </div>

                    </div>

                </aside>

            </div>



            {{-- Footer --}}
            <div class="smart-buy-purchase-footer">

                <div>

                <span>
                    Request SB-2026-00128
                </span>

                    <small>
                        Customer payment has been completed.
                    </small>

                </div>


                <div class="smart-buy-purchase-footer__actions">

                    <a
                        href="{{ route('smart-buy.details', 1) }}"
                        class="smart-buy-purchase-cancel"
                        id="cancelPurchase"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="smart-buy-purchase-confirm"
                    >

                        <i class="ri-check-double-line"></i>

                        Confirm Purchase

                    </button>

                </div>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form =
                document.getElementById('smartBuyPurchaseForm');

            const productCost =
                document.getElementById('actual_product_cost');

            const shippingCost =
                document.getElementById('actual_shipping_cost');

            const summaryProduct =
                document.getElementById('summaryProduct');

            const summaryShipping =
                document.getElementById('summaryShipping');

            const summaryTotal =
                document.getElementById('summaryTotal');

            const purchaseNotes =
                document.getElementById('purchase_notes');

            const purchaseNotesCount =
                document.getElementById('purchaseNotesCount');

            const documents =
                document.getElementById('purchase_documents');

            const fileList =
                document.getElementById('purchaseFileList');

            const cancelPurchase =
                document.getElementById('cancelPurchase');


            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            function currency(value) {

                return '$' + (
                    Number(value) || 0
                ).toLocaleString(
                    'en-US',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Purchase Total
            |--------------------------------------------------------------------------
            */

            function updateTotal() {

                const product =
                    Number(productCost?.value) || 0;

                const shipping =
                    Number(shippingCost?.value) || 0;

                const total =
                    product + shipping;


                if (summaryProduct) {
                    summaryProduct.textContent =
                        currency(product);
                }


                if (summaryShipping) {
                    summaryShipping.textContent =
                        currency(shipping);
                }


                if (summaryTotal) {
                    summaryTotal.textContent =
                        currency(total);
                }

            }


            productCost?.addEventListener(
                'input',
                updateTotal
            );


            shippingCost?.addEventListener(
                'input',
                updateTotal
            );


            updateTotal();


            /*
            |--------------------------------------------------------------------------
            | Notes Counter
            |--------------------------------------------------------------------------
            */

            function updateNotesCounter() {

                if (
                    !purchaseNotes ||
                    !purchaseNotesCount
                ) {
                    return;
                }


                purchaseNotesCount.textContent =
                    `${purchaseNotes.value.length} / ${purchaseNotes.maxLength}`;

            }


            purchaseNotes?.addEventListener(
                'input',
                updateNotesCounter
            );


            updateNotesCounter();


            /*
            |--------------------------------------------------------------------------
            | File Preview
            |--------------------------------------------------------------------------
            */

            documents?.addEventListener(
                'change',
                function () {

                    if (!fileList) {
                        return;
                    }


                    fileList.innerHTML = '';


                    Array.from(
                        documents.files
                    ).forEach(function (file) {

                        const item =
                            document.createElement('div');

                        item.className =
                            'smart-buy-purchase-file';


                        item.innerHTML = `
                    <span class="smart-buy-purchase-file__icon">
                        <i class="ri-file-text-line"></i>
                    </span>

                    <span class="smart-buy-purchase-file__name">
                        ${file.name}
                    </span>

                    <span class="smart-buy-purchase-file__size">
                        ${(file.size / 1024 / 1024).toFixed(2)} MB
                    </span>
                `;


                        fileList.appendChild(item);

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Cancel
            |--------------------------------------------------------------------------
            */

            cancelPurchase?.addEventListener(
                'click',
                function (event) {

                    const confirmed =
                        window.confirm(
                            'Cancel this purchase process and return to request details?'
                        );


                    if (!confirmed) {
                        event.preventDefault();
                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Submit
            |--------------------------------------------------------------------------
            */

            form?.addEventListener(
                'submit',
                function (event) {

                    if (!form.checkValidity()) {

                        event.preventDefault();

                        form.reportValidity();

                        return;

                    }


                    const confirmed =
                        window.confirm(
                            'Confirm that this product has been purchased?'
                        );


                    if (!confirmed) {

                        event.preventDefault();

                        return;

                    }


                    const button =
                        form.querySelector(
                            '.smart-buy-purchase-confirm'
                        );


                    if (button) {

                        button.disabled = true;

                        button.innerHTML = `
                    <i class="ri-loader-4-line smart-buy-purchase-spin"></i>
                    Confirming...
                `;

                    }

                }
            );

        });
    </script>

@endpush
