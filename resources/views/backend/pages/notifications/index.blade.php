@extends('backend.layouts.backend')

@section('title', 'Notifications')

@section('content')

    <div class="customer-notifications-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-notifications-breadcrumb">

            <a href="{{ route('profile') }}">
                Account
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Notifications
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-notifications-header">

            <div>

            <span class="customer-notifications-header__eyebrow">
                Account
            </span>

                <h1>
                    Notifications
                </h1>

                <p>
                    Stay updated with your orders, payments, shipments, and account activity.
                </p>

            </div>


            <button
                type="button"
                class="notifications-mark-all"
                id="mark-all-read"
            >
                <i class="ri-check-double-line"></i>
                Mark all as read
            </button>

        </div>


        {{-- ================================================================ --}}
        {{-- SUMMARY --}}
        {{-- ================================================================ --}}

        <div class="customer-notifications-summary">

            <div class="notification-summary-card">

                <div class="notification-summary-card__icon">
                    <i class="ri-notification-3-line"></i>
                </div>

                <div>

                <span>
                    Total Notifications
                </span>

                    <strong>
                        18
                    </strong>

                </div>

            </div>


            <div class="notification-summary-card">

                <div class="notification-summary-card__icon">
                    <i class="ri-mail-unread-line"></i>
                </div>

                <div>

                <span>
                    Unread
                </span>

                    <strong>
                        5
                    </strong>

                </div>

            </div>


            <div class="notification-summary-card">

                <div class="notification-summary-card__icon">
                    <i class="ri-shopping-bag-3-line"></i>
                </div>

                <div>

                <span>
                    Order Updates
                </span>

                    <strong>
                        8
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- NOTIFICATION LAYOUT --}}
        {{-- ================================================================ --}}

        <div class="customer-notifications-layout">


            {{-- ============================================================ --}}
            {{-- NOTIFICATIONS --}}
            {{-- ============================================================ --}}

            <section class="customer-notifications-card">


                {{-- HEADER --}}

                <div class="customer-notifications-card__header">

                    <div>

                    <span>
                        Activity
                    </span>

                        <h2>
                            Your Notifications
                        </h2>

                    </div>


                    <div class="notifications-filter">

                        <select id="notification-filter">

                            <option value="all">
                                All
                            </option>

                            <option value="unread">
                                Unread
                            </option>

                            <option value="orders">
                                Orders
                            </option>

                            <option value="payments">
                                Payments
                            </option>

                            <option value="shipments">
                                Shipments
                            </option>

                            <option value="account">
                                Account
                            </option>

                        </select>

                        <i class="ri-arrow-down-s-line"></i>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- TODAY --}}
                {{-- ======================================================== --}}

                <div class="notification-group">

                    <div class="notification-group__title">
                        Today
                    </div>


                    {{-- Notification 1 --}}

                    <article
                        class="notification-item unread"
                        data-type="orders"
                        data-status="unread"
                    >

                        <div class="notification-item__icon order">
                            <i class="ri-shopping-bag-3-line"></i>
                        </div>


                        <div class="notification-item__content">

                            <div class="notification-item__top">

                                <h3>
                                    Your order has been confirmed
                                </h3>

                                <span>
                                10 min ago
                            </span>

                            </div>


                            <p>
                                Order #ORD-1048 has been confirmed and is now being prepared.
                            </p>


                            <a
                                href="{{ route('order-details', 1048) }}"
                                class="notification-action"
                            >
                                View Order
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>


                        <button
                            type="button"
                            class="notification-more"
                            title="More options"
                        >
                            <i class="ri-more-2-fill"></i>
                        </button>

                    </article>


                    {{-- Notification 2 --}}

                    <article
                        class="notification-item unread"
                        data-type="shipments"
                        data-status="unread"
                    >

                        <div class="notification-item__icon shipment">
                            <i class="ri-truck-line"></i>
                        </div>


                        <div class="notification-item__content">

                            <div class="notification-item__top">

                                <h3>
                                    Your package is on the way
                                </h3>

                                <span>
                                1 hour ago
                            </span>

                            </div>


                            <p>
                                Order #ORD-1042 has been shipped. You can now track your package.
                            </p>


                            <a
                                href="{{ route('ecommerce-tracking', 1042) }}"
                                class="notification-action"
                            >
                                Track Shipment
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>


                        <button
                            type="button"
                            class="notification-more"
                            title="More options"
                        >
                            <i class="ri-more-2-fill"></i>
                        </button>

                    </article>


                    {{-- Notification 3 --}}

                    <article
                        class="notification-item"
                        data-type="payments"
                        data-status="read"
                    >

                        <div class="notification-item__icon payment">
                            <i class="ri-bank-card-line"></i>
                        </div>


                        <div class="notification-item__content">

                            <div class="notification-item__top">

                                <h3>
                                    Payment received
                                </h3>

                                <span>
                                3 hours ago
                            </span>

                            </div>


                            <p>
                                Your payment of $104.97 for order #ORD-1048 was successfully processed.
                            </p>


                            <a
                                href="{{ route('account.payments') }}"
                                class="notification-action"
                            >
                                View Payments
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>


                        <button
                            type="button"
                            class="notification-more"
                            title="More options"
                        >
                            <i class="ri-more-2-fill"></i>
                        </button>

                    </article>

                </div>


                {{-- ======================================================== --}}
                {{-- YESTERDAY --}}
                {{-- ======================================================== --}}

                <div class="notification-group">

                    <div class="notification-group__title">
                        Yesterday
                    </div>


                    {{-- Notification 4 --}}

                    <article
                        class="notification-item unread"
                        data-type="orders"
                        data-status="unread"
                    >

                        <div class="notification-item__icon order">
                            <i class="ri-checkbox-circle-line"></i>
                        </div>


                        <div class="notification-item__content">

                            <div class="notification-item__top">

                                <h3>
                                    Order delivered successfully
                                </h3>

                                <span>
                                Yesterday
                            </span>

                            </div>


                            <p>
                                Your order #ORD-1035 has been delivered. We hope you enjoy your purchase.
                            </p>


                            <a
                                href="{{ route('order-details', 1035) }}"
                                class="notification-action"
                            >
                                View Order
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>


                        <button
                            type="button"
                            class="notification-more"
                            title="More options"
                        >
                            <i class="ri-more-2-fill"></i>
                        </button>

                    </article>


                    {{-- Notification 5 --}}

                    <article
                        class="notification-item"
                        data-type="account"
                        data-status="read"
                    >

                        <div class="notification-item__icon account">
                            <i class="ri-user-settings-line"></i>
                        </div>


                        <div class="notification-item__content">

                            <div class="notification-item__top">

                                <h3>
                                    Profile information updated
                                </h3>

                                <span>
                                Yesterday
                            </span>

                            </div>


                            <p>
                                Your account profile information was successfully updated.
                            </p>


                            <a
                                href="{{ route('profile') }}"
                                class="notification-action"
                            >
                                View Profile
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>


                        <button
                            type="button"
                            class="notification-more"
                            title="More options"
                        >
                            <i class="ri-more-2-fill"></i>
                        </button>

                    </article>

                </div>


                {{-- ======================================================== --}}
                {{-- EARLIER --}}
                {{-- ======================================================== --}}

                <div class="notification-group">

                    <div class="notification-group__title">
                        Earlier
                    </div>


                    {{-- Notification 6 --}}

                    <article
                        class="notification-item"
                        data-type="payments"
                        data-status="read"
                    >

                        <div class="notification-item__icon payment">
                            <i class="ri-refund-2-line"></i>
                        </div>


                        <div class="notification-item__content">

                            <div class="notification-item__top">

                                <h3>
                                    Refund completed
                                </h3>

                                <span>
                                Aug 12, 2026
                            </span>

                            </div>


                            <p>
                                Your refund of $120.00 for order #ORD-1035 has been completed.
                            </p>


                            <a
                                href="{{ route('account.payments') }}"
                                class="notification-action"
                            >
                                View Payment
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>


                        <button
                            type="button"
                            class="notification-more"
                            title="More options"
                        >
                            <i class="ri-more-2-fill"></i>
                        </button>

                    </article>


                    {{-- Notification 7 --}}

                    <article
                        class="notification-item"
                        data-type="orders"
                        data-status="read"
                    >

                        <div class="notification-item__icon order">
                            <i class="ri-shopping-cart-line"></i>
                        </div>


                        <div class="notification-item__content">

                            <div class="notification-item__top">

                                <h3>
                                    Order placed successfully
                                </h3>

                                <span>
                                Aug 10, 2026
                            </span>

                            </div>


                            <p>
                                Your order #ORD-1029 has been placed successfully.
                            </p>


                            <a
                                href="{{ route('order-details', 1029) }}"
                                class="notification-action"
                            >
                                View Order
                                <i class="ri-arrow-right-line"></i>
                            </a>

                        </div>


                        <button
                            type="button"
                            class="notification-more"
                            title="More options"
                        >
                            <i class="ri-more-2-fill"></i>
                        </button>

                    </article>

                </div>


                {{-- ======================================================== --}}
                {{-- PAGINATION --}}
                {{-- ======================================================== --}}

                <div class="customer-notifications-pagination">

                <span>
                    Showing 1–7 of 18 notifications
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

            <aside class="customer-notifications-sidebar">


                {{-- ======================================================== --}}
                {{-- NOTIFICATION SETTINGS --}}
                {{-- ======================================================== --}}

                <section class="customer-notifications-card notification-settings">

                    <div class="customer-notifications-card__header">

                        <div>

                        <span>
                            Preferences
                        </span>

                            <h2>
                                Notification Settings
                            </h2>

                        </div>

                        <i class="ri-settings-3-line"></i>

                    </div>


                    <div class="notification-setting">

                        <div>

                            <strong>
                                Order Updates
                            </strong>

                            <span>
                            Orders, confirmations and status
                        </span>

                        </div>

                        <label class="notification-switch">

                            <input
                                type="checkbox"
                                checked
                            >

                            <span></span>

                        </label>

                    </div>


                    <div class="notification-setting">

                        <div>

                            <strong>
                                Payment Updates
                            </strong>

                            <span>
                            Payments, refunds and invoices
                        </span>

                        </div>

                        <label class="notification-switch">

                            <input
                                type="checkbox"
                                checked
                            >

                            <span></span>

                        </label>

                    </div>


                    <div class="notification-setting">

                        <div>

                            <strong>
                                Shipment Updates
                            </strong>

                            <span>
                            Shipping and tracking updates
                        </span>

                        </div>

                        <label class="notification-switch">

                            <input
                                type="checkbox"
                                checked
                            >

                            <span></span>

                        </label>

                    </div>


                    <div class="notification-setting">

                        <div>

                            <strong>
                                Account Activity
                            </strong>

                            <span>
                            Security and profile activity
                        </span>

                        </div>

                        <label class="notification-switch">

                            <input
                                type="checkbox"
                                checked
                            >

                            <span></span>

                        </label>

                    </div>


                    <div class="notification-setting">

                        <div>

                            <strong>
                                Promotional
                            </strong>

                            <span>
                            Offers and special promotions
                        </span>

                        </div>

                        <label class="notification-switch">

                            <input
                                type="checkbox"
                            >

                            <span></span>

                        </label>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- NOTIFICATION INFO --}}
                {{-- ======================================================== --}}

                <section class="notification-info-box">

                    <div class="notification-info-box__icon">
                        <i class="ri-information-line"></i>
                    </div>


                    <div>

                        <strong>
                            Stay informed
                        </strong>

                        <p>
                            You can manage which notifications you receive from your account preferences.
                        </p>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- SUPPORT --}}
                {{-- ======================================================== --}}

                <section class="notification-help-box">

                    <div class="notification-help-box__icon">
                        <i class="ri-customer-service-2-line"></i>
                    </div>


                    <div>

                        <strong>
                            Need Help?
                        </strong>

                        <p>
                            Having an issue with your notifications?
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


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {


                /*
                |--------------------------------------------------------------------------
                | FILTER
                |--------------------------------------------------------------------------
                */

                const filter =
                    document.querySelector(
                        '#notification-filter'
                    );


                const notifications =
                    document.querySelectorAll(
                        '.notification-item'
                    );


                if (filter) {

                    filter.addEventListener(
                        'change',
                        function () {

                            const value =
                                filter.value;


                            notifications.forEach(
                                function (notification) {

                                    const type =
                                        notification.dataset.type;

                                    const status =
                                        notification.dataset.status;


                                    let show = true;


                                    if (value === 'unread') {

                                        show =
                                            status === 'unread';

                                    }


                                    if (
                                        [
                                            'orders',
                                            'payments',
                                            'shipments',
                                            'account'
                                        ].includes(value)
                                    ) {

                                        show =
                                            type === value;

                                    }


                                    notification.style.display =
                                        show
                                            ? ''
                                            : 'none';

                                }
                            );

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | MARK ALL AS READ
                |--------------------------------------------------------------------------
                */

                const markAllButton =
                    document.querySelector(
                        '#mark-all-read'
                    );


                if (markAllButton) {

                    markAllButton.addEventListener(
                        'click',
                        function () {

                            notifications.forEach(
                                function (notification) {

                                    notification.classList.remove(
                                        'unread'
                                    );

                                    notification.dataset.status =
                                        'read';

                                }
                            );


                            markAllButton.classList.add(
                                'completed'
                            );


                            markAllButton.innerHTML = `
                    <i class="ri-check-line"></i>
                    All notifications read
                `;

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | INDIVIDUAL NOTIFICATION
                |--------------------------------------------------------------------------
                */

                notifications.forEach(
                    function (notification) {

                        notification.addEventListener(
                            'click',
                            function (event) {

                                if (
                                    event.target.closest(
                                        '.notification-action'
                                    ) ||
                                    event.target.closest(
                                        '.notification-more'
                                    )
                                ) {
                                    return;
                                }


                                notification.classList.remove(
                                    'unread'
                                );

                                notification.dataset.status =
                                    'read';

                            }
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | MORE BUTTON
                |--------------------------------------------------------------------------
                */

                const moreButtons =
                    document.querySelectorAll(
                        '.notification-more'
                    );


                moreButtons.forEach(
                    function (button) {

                        button.addEventListener(
                            'click',
                            function (event) {

                                event.stopPropagation();


                                const notification =
                                    button.closest(
                                        '.notification-item'
                                    );


                                if (!notification) {
                                    return;
                                }


                                notification.classList.remove(
                                    'unread'
                                );

                                notification.dataset.status =
                                    'read';

                            }
                        );

                    }
                );

            });

        </script>

    @endpush

@endsection
