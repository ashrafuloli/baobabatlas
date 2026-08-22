@extends('backend.layouts.backend')

@section('title', 'Payments')

@section('content')

    <div class="customer-account-payments-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-account-payments-breadcrumb">

            <a href="{{ route('profile') }}">
                Account
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Payments
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-account-payments-header">

            <div>

            <span class="customer-account-payments-header__eyebrow">
                Account
            </span>

                <h1>
                    Payments
                </h1>

                <p>
                    View your payment history and manage your saved payment methods.
                </p>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- SUMMARY CARDS --}}
        {{-- ================================================================ --}}

        <div class="customer-account-payments-stats">

            <div class="customer-account-payments-stat">

                <div class="customer-account-payments-stat__icon">
                    <i class="ri-bank-card-line"></i>
                </div>

                <div>

                <span>
                    Total Spent
                </span>

                    <strong>
                        $1,248.50
                    </strong>

                </div>

            </div>


            <div class="customer-account-payments-stat">

                <div class="customer-account-payments-stat__icon">
                    <i class="ri-checkbox-circle-line"></i>
                </div>

                <div>

                <span>
                    Successful Payments
                </span>

                    <strong>
                        24
                    </strong>

                </div>

            </div>


            <div class="customer-account-payments-stat">

                <div class="customer-account-payments-stat__icon">
                    <i class="ri-refund-2-line"></i>
                </div>

                <div>

                <span>
                    Refunded
                </span>

                    <strong>
                        $120.00
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- MAIN GRID --}}
        {{-- ================================================================ --}}

        <div class="customer-account-payments-layout">


            {{-- ============================================================ --}}
            {{-- PAYMENT HISTORY --}}
            {{-- ============================================================ --}}

            <section class="customer-account-payments-card payment-history-card">

                <div class="customer-account-payments-card__header">

                    <div>

                    <span>
                        Transactions
                    </span>

                        <h2>
                            Payment History
                        </h2>

                    </div>


                    <div class="customer-account-payments-filter">

                        <select id="payment-status-filter">

                            <option value="all">
                                All Payments
                            </option>

                            <option value="paid">
                                Paid
                            </option>

                            <option value="pending">
                                Pending
                            </option>

                            <option value="failed">
                                Failed
                            </option>

                            <option value="refunded">
                                Refunded
                            </option>

                        </select>

                        <i class="ri-arrow-down-s-line"></i>

                    </div>

                </div>


                {{-- DESKTOP TABLE --}}

                <div class="customer-account-payments-table-wrap">

                    <table class="customer-account-payments-table">

                        <thead>

                        <tr>

                            <th>
                                Transaction
                            </th>

                            <th>
                                Order
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Method
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                        </thead>


                        <tbody>


                        {{-- PAYMENT 1 --}}

                        <tr data-payment-status="paid">

                            <td>

                                <div class="payment-transaction">

                                    <div class="payment-transaction__icon">
                                        <i class="ri-bank-card-line"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            #TXN-84921
                                        </strong>

                                        <span>
                                            Payment completed
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1048) }}"
                                    class="payment-order-link"
                                >
                                    #ORD-1048
                                </a>

                            </td>


                            <td>
                                Aug 16, 2026
                            </td>


                            <td>

                                <div class="payment-method">

                                    <i class="ri-visa-line"></i>

                                    <span>
                                        Visa •••• 4242
                                    </span>

                                </div>

                            </td>


                            <td>

                                <strong class="payment-amount">
                                    $104.97
                                </strong>

                            </td>


                            <td>

                                <span class="payment-status paid">
                                    Paid
                                </span>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1048) }}"
                                    class="payment-view-btn"
                                >
                                    View
                                </a>

                            </td>

                        </tr>


                        {{-- PAYMENT 2 --}}

                        <tr data-payment-status="paid">

                            <td>

                                <div class="payment-transaction">

                                    <div class="payment-transaction__icon">
                                        <i class="ri-bank-card-line"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            #TXN-84762
                                        </strong>

                                        <span>
                                            Payment completed
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1042) }}"
                                    class="payment-order-link"
                                >
                                    #ORD-1042
                                </a>

                            </td>


                            <td>
                                Aug 12, 2026
                            </td>


                            <td>

                                <div class="payment-method">

                                    <i class="ri-paypal-line"></i>

                                    <span>
                                        PayPal
                                    </span>

                                </div>

                            </td>


                            <td>

                                <strong class="payment-amount">
                                    $86.50
                                </strong>

                            </td>


                            <td>

                                <span class="payment-status paid">
                                    Paid
                                </span>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1042) }}"
                                    class="payment-view-btn"
                                >
                                    View
                                </a>

                            </td>

                        </tr>


                        {{-- PAYMENT 3 --}}

                        <tr data-payment-status="refunded">

                            <td>

                                <div class="payment-transaction">

                                    <div class="payment-transaction__icon">
                                        <i class="ri-refund-2-line"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            #TXN-84210
                                        </strong>

                                        <span>
                                            Payment refunded
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1035) }}"
                                    class="payment-order-link"
                                >
                                    #ORD-1035
                                </a>

                            </td>


                            <td>
                                Aug 05, 2026
                            </td>


                            <td>

                                <div class="payment-method">

                                    <i class="ri-mastercard-line"></i>

                                    <span>
                                        Mastercard •••• 8891
                                    </span>

                                </div>

                            </td>


                            <td>

                                <strong class="payment-amount">
                                    $120.00
                                </strong>

                            </td>


                            <td>

                                <span class="payment-status refunded">
                                    Refunded
                                </span>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1035) }}"
                                    class="payment-view-btn"
                                >
                                    View
                                </a>

                            </td>

                        </tr>


                        {{-- PAYMENT 4 --}}

                        <tr data-payment-status="pending">

                            <td>

                                <div class="payment-transaction">

                                    <div class="payment-transaction__icon">
                                        <i class="ri-time-line"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            #TXN-83954
                                        </strong>

                                        <span>
                                            Payment processing
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1029) }}"
                                    class="payment-order-link"
                                >
                                    #ORD-1029
                                </a>

                            </td>


                            <td>
                                Jul 29, 2026
                            </td>


                            <td>

                                <div class="payment-method">

                                    <i class="ri-bank-card-line"></i>

                                    <span>
                                        Visa •••• 1122
                                    </span>

                                </div>

                            </td>


                            <td>

                                <strong class="payment-amount">
                                    $59.99
                                </strong>

                            </td>


                            <td>

                                <span class="payment-status pending">
                                    Pending
                                </span>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1029) }}"
                                    class="payment-view-btn"
                                >
                                    View
                                </a>

                            </td>

                        </tr>


                        {{-- PAYMENT 5 --}}

                        <tr data-payment-status="failed">

                            <td>

                                <div class="payment-transaction">

                                    <div class="payment-transaction__icon">
                                        <i class="ri-close-circle-line"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            #TXN-83721
                                        </strong>

                                        <span>
                                            Payment failed
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1023) }}"
                                    class="payment-order-link"
                                >
                                    #ORD-1023
                                </a>

                            </td>


                            <td>
                                Jul 24, 2026
                            </td>


                            <td>

                                <div class="payment-method">

                                    <i class="ri-bank-card-line"></i>

                                    <span>
                                        Visa •••• 7712
                                    </span>

                                </div>

                            </td>


                            <td>

                                <strong class="payment-amount">
                                    $45.00
                                </strong>

                            </td>


                            <td>

                                <span class="payment-status failed">
                                    Failed
                                </span>

                            </td>


                            <td>

                                <a
                                    href="{{ route('order-details', 1023) }}"
                                    class="payment-view-btn"
                                >
                                    View
                                </a>

                            </td>

                        </tr>


                        </tbody>

                    </table>

                </div>


                {{-- MOBILE PAYMENT LIST --}}

                <div class="customer-account-payments-mobile-list">


                    <article
                        class="mobile-payment-item"
                        data-payment-status="paid"
                    >

                        <div class="mobile-payment-item__top">

                            <div class="payment-transaction">

                                <div class="payment-transaction__icon">
                                    <i class="ri-bank-card-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        #TXN-84921
                                    </strong>

                                    <span>
                                    Aug 16, 2026
                                </span>

                                </div>

                            </div>


                            <strong class="payment-amount">
                                $104.97
                            </strong>

                        </div>


                        <div class="mobile-payment-item__bottom">

                        <span>
                            Order #ORD-1048
                        </span>

                            <span class="payment-status paid">
                            Paid
                        </span>

                        </div>


                        <a
                            href="{{ route('order-details', 1048) }}"
                            class="mobile-payment-view"
                        >
                            View Order
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </article>


                    <article
                        class="mobile-payment-item"
                        data-payment-status="paid"
                    >

                        <div class="mobile-payment-item__top">

                            <div class="payment-transaction">

                                <div class="payment-transaction__icon">
                                    <i class="ri-paypal-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        #TXN-84762
                                    </strong>

                                    <span>
                                    Aug 12, 2026
                                </span>

                                </div>

                            </div>


                            <strong class="payment-amount">
                                $86.50
                            </strong>

                        </div>


                        <div class="mobile-payment-item__bottom">

                        <span>
                            Order #ORD-1042
                        </span>

                            <span class="payment-status paid">
                            Paid
                        </span>

                        </div>


                        <a
                            href="{{ route('order-details', 1042) }}"
                            class="mobile-payment-view"
                        >
                            View Order
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </article>


                    <article
                        class="mobile-payment-item"
                        data-payment-status="refunded"
                    >

                        <div class="mobile-payment-item__top">

                            <div class="payment-transaction">

                                <div class="payment-transaction__icon">
                                    <i class="ri-refund-2-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        #TXN-84210
                                    </strong>

                                    <span>
                                    Aug 05, 2026
                                </span>

                                </div>

                            </div>


                            <strong class="payment-amount">
                                $120.00
                            </strong>

                        </div>


                        <div class="mobile-payment-item__bottom">

                        <span>
                            Order #ORD-1035
                        </span>

                            <span class="payment-status refunded">
                            Refunded
                        </span>

                        </div>


                        <a
                            href="{{ route('order-details', 1035) }}"
                            class="mobile-payment-view"
                        >
                            View Order
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </article>


                    <article
                        class="mobile-payment-item"
                        data-payment-status="pending"
                    >

                        <div class="mobile-payment-item__top">

                            <div class="payment-transaction">

                                <div class="payment-transaction__icon">
                                    <i class="ri-time-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        #TXN-83954
                                    </strong>

                                    <span>
                                    Jul 29, 2026
                                </span>

                                </div>

                            </div>


                            <strong class="payment-amount">
                                $59.99
                            </strong>

                        </div>


                        <div class="mobile-payment-item__bottom">

                        <span>
                            Order #ORD-1029
                        </span>

                            <span class="payment-status pending">
                            Pending
                        </span>

                        </div>


                        <a
                            href="{{ route('order-details', 1029) }}"
                            class="mobile-payment-view"
                        >
                            View Order
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </article>


                    <article
                        class="mobile-payment-item"
                        data-payment-status="failed"
                    >

                        <div class="mobile-payment-item__top">

                            <div class="payment-transaction">

                                <div class="payment-transaction__icon">
                                    <i class="ri-close-circle-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        #TXN-83721
                                    </strong>

                                    <span>
                                    Jul 24, 2026
                                </span>

                                </div>

                            </div>


                            <strong class="payment-amount">
                                $45.00
                            </strong>

                        </div>


                        <div class="mobile-payment-item__bottom">

                        <span>
                            Order #ORD-1023
                        </span>

                            <span class="payment-status failed">
                            Failed
                        </span>

                        </div>


                        <a
                            href="{{ route('order-details', 1023) }}"
                            class="mobile-payment-view"
                        >
                            View Order
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </article>

                </div>


                {{-- PAGINATION --}}

                <div class="customer-account-payments-pagination">

                <span>
                    Showing 1–5 of 24 payments
                </span>

                    <div>

                        <button
                            type="button"
                            disabled
                        >
                            <i class="ri-arrow-left-s-line"></i>
                        </button>

                        <button
                            type="button"
                            class="active"
                        >
                            1
                        </button>

                        <button type="button">
                            2
                        </button>

                        <button type="button">
                            3
                        </button>

                        <span>
                        ...
                    </span>

                        <button type="button">
                            5
                        </button>

                        <button type="button">
                            <i class="ri-arrow-right-s-line"></i>
                        </button>

                    </div>

                </div>

            </section>


            {{-- ============================================================ --}}
            {{-- SIDEBAR --}}
            {{-- ============================================================ --}}

            <aside class="customer-account-payments-sidebar">


                {{-- ======================================================== --}}
                {{-- SAVED PAYMENT METHODS --}}
                {{-- ======================================================== --}}

                <section class="customer-account-payments-card saved-methods-card">

                    <div class="customer-account-payments-card__header">

                        <div>

                        <span>
                            Payment Methods
                        </span>

                            <h2>
                                Saved Methods
                            </h2>

                        </div>

                        <button
                            type="button"
                            class="payment-add-btn"
                            id="add-payment-method"
                        >

                            <i class="ri-add-line"></i>

                        </button>

                    </div>


                    {{-- CARD 1 --}}

                    <div class="saved-payment-method">

                        <div class="saved-payment-method__brand visa">
                            VISA
                        </div>

                        <div class="saved-payment-method__info">

                            <strong>
                                Visa ending in 4242
                            </strong>

                            <span>
                            Expires 08/28
                        </span>

                        </div>


                        <div class="saved-payment-method__actions">

                        <span class="default-badge">
                            Default
                        </span>

                            <button
                                type="button"
                                title="More options"
                            >
                                <i class="ri-more-2-fill"></i>
                            </button>

                        </div>

                    </div>


                    {{-- CARD 2 --}}

                    <div class="saved-payment-method">

                        <div class="saved-payment-method__brand mastercard">
                            MC
                        </div>

                        <div class="saved-payment-method__info">

                            <strong>
                                Mastercard ending in 8891
                            </strong>

                            <span>
                            Expires 11/27
                        </span>

                        </div>


                        <div class="saved-payment-method__actions">

                            <button
                                type="button"
                                title="More options"
                            >
                                <i class="ri-more-2-fill"></i>
                            </button>

                        </div>

                    </div>


                    {{-- ADD METHOD --}}

                    <button
                        type="button"
                        class="saved-payment-add"
                        id="add-payment-method-bottom"
                    >

                        <i class="ri-add-circle-line"></i>

                        <span>
                        Add Payment Method
                    </span>

                    </button>

                </section>


                {{-- ======================================================== --}}
                {{-- PAYMENT SECURITY --}}
                {{-- ======================================================== --}}

                <section class="customer-account-payments-security">

                    <div class="customer-account-payments-security__icon">

                        <i class="ri-shield-check-line"></i>

                    </div>


                    <div>

                        <strong>
                            Secure Payments
                        </strong>

                        <p>
                            Your payment information is encrypted and securely
                            stored. We never share your card details.
                        </p>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- NEED HELP --}}
                {{-- ======================================================== --}}

                <section class="customer-account-payments-help">

                    <div class="customer-account-payments-help__icon">

                        <i class="ri-customer-service-2-line"></i>

                    </div>


                    <div>

                        <strong>
                            Need Help?
                        </strong>

                        <p>
                            Have a question about a payment or refund?
                        </p>

                        <a href="#">
                            Contact Support
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>

                </section>

            </aside>

        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- ADD PAYMENT METHOD MODAL --}}
    {{-- ================================================================ --}}

    <div
        class="customer-account-payment-modal"
        id="payment-method-modal"
        aria-hidden="true"
    >

        <div class="customer-account-payment-modal__overlay"></div>


        <div class="customer-account-payment-modal__content">

            <div class="customer-account-payment-modal__header">

                <div>

                <span>
                    Payment Method
                </span>

                    <h2>
                        Add New Card
                    </h2>

                </div>


                <button
                    type="button"
                    id="close-payment-modal"
                    class="customer-account-payment-modal__close"
                >

                    <i class="ri-close-line"></i>

                </button>

            </div>


            <form
                class="customer-account-payment-modal__form"
                id="payment-method-form"
            >

                <div class="modal-form-group">

                    <label for="new-card-name">
                        Cardholder Name
                    </label>

                    <input
                        type="text"
                        id="new-card-name"
                        placeholder="John Doe"
                    >

                </div>


                <div class="modal-form-group">

                    <label for="new-card-number">
                        Card Number
                    </label>

                    <input
                        type="text"
                        id="new-card-number"
                        placeholder="1234 5678 9012 3456"
                        maxlength="19"
                        inputmode="numeric"
                    >

                </div>


                <div class="modal-form-grid">

                    <div class="modal-form-group">

                        <label for="new-card-expiry">
                            Expiry
                        </label>

                        <input
                            type="text"
                            id="new-card-expiry"
                            placeholder="MM / YY"
                            maxlength="7"
                            inputmode="numeric"
                        >

                    </div>


                    <div class="modal-form-group">

                        <label for="new-card-cvv">
                            CVV
                        </label>

                        <input
                            type="password"
                            id="new-card-cvv"
                            placeholder="•••"
                            maxlength="4"
                            inputmode="numeric"
                        >

                    </div>

                </div>


                <label class="modal-checkbox">

                    <input
                        type="checkbox"
                        checked
                    >

                    <span>
                    Set as default payment method
                </span>

                </label>


                <div class="customer-account-payment-modal__actions">

                    <button
                        type="button"
                        id="cancel-payment-modal"
                        class="modal-cancel-btn"
                    >
                        Cancel
                    </button>


                    <button
                        type="submit"
                        class="modal-save-btn"
                    >

                        <i class="ri-lock-2-line"></i>

                        Save Card

                    </button>

                </div>

            </form>

        </div>

    </div>


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {


                /*
                |--------------------------------------------------------------------------
                | PAYMENT STATUS FILTER
                |--------------------------------------------------------------------------
                */

                const statusFilter =
                    document.querySelector(
                        '#payment-status-filter'
                    );


                const desktopRows =
                    document.querySelectorAll(
                        '.customer-account-payments-table tbody tr'
                    );


                const mobileItems =
                    document.querySelectorAll(
                        '.mobile-payment-item'
                    );


                if (statusFilter) {

                    statusFilter.addEventListener(
                        'change',
                        function () {

                            const selected =
                                statusFilter.value;


                            desktopRows.forEach(
                                function (row) {

                                    const status =
                                        row.dataset.paymentStatus;


                                    row.style.display =
                                        selected === 'all' ||
                                        status === selected
                                            ? ''
                                            : 'none';

                                }
                            );


                            mobileItems.forEach(
                                function (item) {

                                    const status =
                                        item.dataset.paymentStatus;


                                    item.style.display =
                                        selected === 'all' ||
                                        status === selected
                                            ? ''
                                            : 'none';

                                }
                            );

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | PAYMENT METHOD MODAL
                |--------------------------------------------------------------------------
                */

                const modal =
                    document.querySelector(
                        '#payment-method-modal'
                    );


                const openButtons =
                    document.querySelectorAll(
                        '#add-payment-method, #add-payment-method-bottom'
                    );


                const closeButton =
                    document.querySelector(
                        '#close-payment-modal'
                    );


                const cancelButton =
                    document.querySelector(
                        '#cancel-payment-modal'
                    );


                function openModal() {

                    if (!modal) {
                        return;
                    }


                    modal.classList.add('active');

                    modal.setAttribute(
                        'aria-hidden',
                        'false'
                    );


                    document.body.classList.add(
                        'payment-modal-open'
                    );

                }


                function closeModal() {

                    if (!modal) {
                        return;
                    }


                    modal.classList.remove('active');

                    modal.setAttribute(
                        'aria-hidden',
                        'true'
                    );


                    document.body.classList.remove(
                        'payment-modal-open'
                    );

                }


                openButtons.forEach(
                    function (button) {

                        button.addEventListener(
                            'click',
                            openModal
                        );

                    }
                );


                if (closeButton) {

                    closeButton.addEventListener(
                        'click',
                        closeModal
                    );

                }


                if (cancelButton) {

                    cancelButton.addEventListener(
                        'click',
                        closeModal
                    );

                }


                if (modal) {

                    const overlay =
                        modal.querySelector(
                            '.customer-account-payment-modal__overlay'
                        );


                    if (overlay) {

                        overlay.addEventListener(
                            'click',
                            closeModal
                        );

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | ESCAPE
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Escape' &&
                            modal &&
                            modal.classList.contains('active')
                        ) {

                            closeModal();

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | CARD NUMBER FORMAT
                |--------------------------------------------------------------------------
                */

                const cardNumber =
                    document.querySelector(
                        '#new-card-number'
                    );


                if (cardNumber) {

                    cardNumber.addEventListener(
                        'input',
                        function () {

                            let value =
                                cardNumber.value
                                    .replace(/\D/g, '')
                                    .substring(0, 16);


                            const groups =
                                value.match(/.{1,4}/g);


                            cardNumber.value =
                                groups
                                    ? groups.join(' ')
                                    : '';

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | EXPIRY FORMAT
                |--------------------------------------------------------------------------
                */

                const expiry =
                    document.querySelector(
                        '#new-card-expiry'
                    );


                if (expiry) {

                    expiry.addEventListener(
                        'input',
                        function () {

                            let value =
                                expiry.value
                                    .replace(/\D/g, '')
                                    .substring(0, 4);


                            if (value.length > 2) {

                                value =
                                    value.substring(0, 2)
                                    + ' / '
                                    + value.substring(2);

                            }


                            expiry.value =
                                value;

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | FORM DEMO SUBMIT
                |--------------------------------------------------------------------------
                */

                const paymentForm =
                    document.querySelector(
                        '#payment-method-form'
                    );


                if (paymentForm) {

                    paymentForm.addEventListener(
                        'submit',
                        function (event) {

                            event.preventDefault();

                            closeModal();

                        }
                    );

                }

            });

        </script>

    @endpush

@endsection
