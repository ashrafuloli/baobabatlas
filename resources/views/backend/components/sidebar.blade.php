<div class="dashboard-sidebar">

    {{-- ================================================
        SIDEBAR LOGO
    ================================================= --}}
    <div class="sidebar-logo">

        <a href="{{ auth()->user()->roles()->where('slug', 'admin')->exists() ? route('admin-dashboard') : route('dashboard') }}">

            <img
                src="{{ asset('logo.png') }}"
                alt="Baobab Atlas"
            >

        </a>

        <div class="close-menu d-xl-none d-inline-flex">
            <i class="ri-close-line"></i>
        </div>

    </div>


    {{-- ================================================
        SIDEBAR MENU
    ================================================= --}}
    <div class="sidebar-menu">


        {{-- ============================================
            MAIN
        ============================================= --}}
        <p class="menu-title">
            Main
        </p>

        <ul>

            @if(auth()->user()->hasPermission('view-dashboard'))

                <li class="{{ request()->routeIs(
                    'dashboard',
                    'admin-dashboard'
                ) ? 'active' : '' }}">

                    <a href="{{ auth()->user()->roles()->where('slug', 'admin')->exists() ? route('admin-dashboard') : route('dashboard') }}">

                        <i class="ri-dashboard-line"></i>

                        <span>
                            Dashboard
                        </span>

                    </a>

                </li>

            @endif

        </ul>


        {{-- ============================================
            CUSTOMER ECOMMERCE
        ============================================= --}}
        @if(
            !auth()->user()->roles()->where('slug', 'admin')->exists() &&
            (
                auth()->user()->hasPermission('view-products') ||
                auth()->user()->hasPermission('view-orders') ||
                auth()->user()->hasPermission('view-cart') ||
                auth()->user()->hasPermission('create-order')
            )
        )

            <p class="menu-title">
                Ecommerce
            </p>

            <ul>


                {{-- SHOP --}}
                @if(
                    auth()->user()->hasPermission('view-products') ||
                    auth()->user()->hasPermission('view-cart') ||
                    auth()->user()->hasPermission('create-order')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'customer-shop',
                        'customer-product-details',
                        'cart',
                        'checkout',
                        'ecommerce-payment',
                        'ecommerce-payment-success',
                        'ecommerce-payment-failed'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-shopping-bag-3-line"></i>

                            <span>
                                Shop
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">


                            {{-- SHOP --}}
                            @if(auth()->user()->hasPermission('view-products'))

                                <li class="{{ request()->routeIs(
                                    'customer-shop',
                                    'customer-product-details'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('customer-shop') }}">

                                        <span>
                                            Shop
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- CART --}}
                            @if(auth()->user()->hasPermission('view-cart'))

                                <li class="{{ request()->routeIs(
                                    'cart'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('cart') }}">

                                        <span>
                                            Cart
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- CHECKOUT --}}
                            @if(auth()->user()->hasPermission('create-order'))

                                <li class="{{ request()->routeIs(
                                    'checkout',
                                    'ecommerce-payment',
                                    'ecommerce-payment-success',
                                    'ecommerce-payment-failed'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('checkout') }}">

                                        <span>
                                            Checkout
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif


                {{-- MY ORDERS --}}
                @if(auth()->user()->hasPermission('view-orders'))

                    <li class="{{ request()->routeIs(
                        'orders',
                        'order-details',
                        'ecommerce-shipment',
                        'ecommerce-tracking'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('orders') }}">

                            <i class="ri-shopping-cart-2-line"></i>

                            <span>
                                My Orders
                            </span>

                        </a>

                    </li>

                @endif


            </ul>

        @endif


        {{-- ============================================
            SMART BUY - CUSTOMER
        ============================================= --}}
        @if(
            !auth()->user()->roles()->where('slug', 'admin')->exists() &&
            (
                auth()->user()->hasPermission('view-smart-buy') ||
                auth()->user()->hasPermission('create-smart-buy')
            )
        )

            <p class="menu-title">
                Smart Buy
            </p>

            <ul>


                {{-- MY REQUESTS --}}
                @if(auth()->user()->hasPermission('view-smart-buy'))

                    <li class="{{ request()->routeIs(
                        'my-smart-buy',
                        'my-smart-buy-details',
                        'smart-buy-confirmation',
                        'my-smart-buy-quote',
                        'my-smart-buy-quote-accept',
                        'my-smart-buy-quote-reject',
                        'smart-buy-payment',
                        'smart-buy-payment-store',
                        'smart-buy-payment-success',
                        'smart-buy-payment-failed',
                        'smart-buy-tracking'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('my-smart-buy') }}">

                            <i class="ri-file-list-3-line"></i>

                            <span>
                                My Requests
                            </span>

                        </a>

                    </li>

                @endif


                {{-- START SMART BUY --}}
                @if(auth()->user()->hasPermission('create-smart-buy'))

                    <li class="{{ request()->routeIs(
                        'my-smart-buy-create'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('my-smart-buy-create') }}">

                            <i class="ri-add-circle-line"></i>

                            <span>
                                Start Smart Buy
                            </span>

                        </a>

                    </li>

                @endif


            </ul>

        @endif


        {{-- ============================================
            ACCOUNT - CUSTOMER
        ============================================= --}}
        @if(
            !auth()->user()->roles()->where('slug', 'admin')->exists() &&
            (
                auth()->user()->hasPermission('view-profile') ||
                auth()->user()->hasPermission('view-payments') ||
                auth()->user()->hasPermission('view-notifications')
            )
        )

            <p class="menu-title">
                Account
            </p>

            <ul>


                {{-- PROFILE --}}
                @if(auth()->user()->hasPermission('view-profile'))

                    <li class="{{ request()->routeIs(
                        'profile',
                        'profile.update'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('profile') }}">

                            <i class="ri-user-settings-line"></i>

                            <span>
                                Profile
                            </span>

                        </a>

                    </li>

                @endif


                {{-- PAYMENTS --}}
                @if(auth()->user()->hasPermission('view-payments'))

                    <li class="{{ request()->routeIs(
                        'account-payments'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('account-payments') }}">

                            <i class="ri-bank-card-line"></i>

                            <span>
                                Payments
                            </span>

                        </a>

                    </li>

                @endif


                {{-- NOTIFICATIONS --}}
                @if(auth()->user()->hasPermission('view-notifications'))

                    <li class="{{ request()->routeIs(
                        'notifications'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('notifications') }}">

                            <i class="ri-notification-3-line"></i>

                            <span>
                                Notifications
                            </span>

                        </a>

                    </li>

                @endif


            </ul>

        @endif


        {{-- ============================================
            ADMINISTRATION
        ============================================= --}}
        @if(auth()->user()->roles()->where('slug', 'admin')->exists())

            <p class="menu-title">
                Administration
            </p>

            <ul>


                {{-- ========================================
                    ECOMMERCE MANAGEMENT
                ========================================= --}}
                @if(
                    auth()->user()->hasPermission('view-products') ||
                    auth()->user()->hasPermission('view-categories') ||
                    auth()->user()->hasPermission('view-inventory') ||
                    auth()->user()->hasPermission('view-orders') ||
                    auth()->user()->hasPermission('view-ecommerce-shipments')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'admin-products',
                        'admin-product-create',
                        'admin-product-details',
                        'admin-product-edit',
                        'admin-categories',
                        'admin-category-create',
                        'admin-category-details',
                        'admin-category-edit',
                        'admin-inventory',
                        'admin-inventory-low-stock',
                        'admin-inventory-out-of-stock',
                        'admin-orders',
                        'admin-order-details',
                        'admin-ecommerce-payments',
                        'ecommerce-shipments',
                        'ecommerce-shipment-create',
                        'ecommerce-shipment-details'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-store-2-line"></i>

                            <span>
                                Ecommerce
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">


                            {{-- PRODUCTS --}}
                            @if(auth()->user()->hasPermission('view-products'))

                                <li class="{{ request()->routeIs(
                                    'admin-products',
                                    'admin-product-create',
                                    'admin-product-details',
                                    'admin-product-edit'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-products') }}">

                                        <span>
                                            Products
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- CATEGORIES --}}
                            @if(auth()->user()->hasPermission('view-categories'))

                                <li class="{{ request()->routeIs(
                                    'admin-categories',
                                    'admin-category-create',
                                    'admin-category-details',
                                    'admin-category-edit'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-categories') }}">

                                        <span>
                                            Categories
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- INVENTORY --}}
                            @if(auth()->user()->hasPermission('view-inventory'))

                                <li class="{{ request()->routeIs(
                                    'admin-inventory',
                                    'admin-inventory-low-stock',
                                    'admin-inventory-out-of-stock'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-inventory') }}">

                                        <span>
                                            Inventory
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- ORDERS --}}
                            @if(auth()->user()->hasPermission('view-orders'))

                                <li class="{{ request()->routeIs(
                                    'admin-orders',
                                    'admin-order-details'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-orders') }}">

                                        <span>
                                            Orders
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- ECOMMERCE PAYMENTS --}}
                            @if(auth()->user()->hasPermission('view-ecommerce-payments'))

                                <li class="{{ request()->routeIs(
                                    'admin-ecommerce-payments'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-ecommerce-payments') }}">

                                        <span>
                                            Payments
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- SHIPMENTS --}}
                            @if(auth()->user()->hasPermission('view-ecommerce-shipments'))

                                <li class="{{ request()->routeIs(
                                    'ecommerce-shipments',
                                    'ecommerce-shipment-create',
                                    'ecommerce-shipment-details'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('ecommerce-shipments') }}">

                                        <span>
                                            Shipments
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif


                {{-- ========================================
                    SMART BUY MANAGEMENT
                ========================================= --}}
                @if(
                    auth()->user()->hasPermission('view-smart-buy-admin') ||
                    auth()->user()->hasPermission('view-smart-buy-admin-details') ||
                    auth()->user()->hasPermission('create-smart-buy-quote') ||
                    auth()->user()->hasPermission('manage-smart-buy') ||
                    auth()->user()->hasPermission('manage-smart-buy-payment') ||
                    auth()->user()->hasPermission('manage-smart-buy-shipment')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'smart-buy',
                        'smart-buy.details',
                        'smart-buy.quote.show',
                        'smart-buy-purchase',
                        'smart-buy-shipment',
                        'smart-buy.quote.store',
                        'smart-buy.quote.update',
                        'smart-buy.payment.store',
                        'smart-buy.payment.update',
                        'smart-buy.shipment.store',
                        'smart-buy.shipment.update',
                        'smart-buy.status.update'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-global-line"></i>

                            <span>
                                Smart Buy
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">


                            {{-- ALL REQUESTS --}}
                            @if(auth()->user()->hasPermission('view-smart-buy-admin'))

                                <li class="{{ request()->routeIs(
                                    'smart-buy',
                                    'smart-buy.details',
                                    'smart-buy.quote.show',
                                    'smart-buy-purchase',
                                    'smart-buy-shipment'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('smart-buy') }}">

                                        <span>
                                            Requests
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif


                {{-- ========================================
                    USER MANAGEMENT
                ========================================= --}}
                @if(
                    auth()->user()->hasPermission('view-users') ||
                    auth()->user()->hasPermission('view-roles') ||
                    auth()->user()->hasPermission('view-permissions')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'users',
                        'user-create',
                        'user-store',
                        'user-details',
                        'user-edit',
                        'user-update',
                        'user-destroy',
                        'roles',
                        'role-create',
                        'role-store',
                        'role-details',
                        'role-edit',
                        'role-update',
                        'role-destroy',
                        'role-permissions',
                        'role-permissions.update',
                        'permissions',
                        'permission-create',
                        'permission-store',
                        'permission-details',
                        'permission-edit',
                        'permission-update',
                        'permission-destroy'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-group-line"></i>

                            <span>
                                Users
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">


                            {{-- USERS --}}
                            @if(auth()->user()->hasPermission('view-users'))

                                <li class="{{ request()->routeIs(
                                    'users',
                                    'user-create',
                                    'user-store',
                                    'user-details',
                                    'user-edit',
                                    'user-update',
                                    'user-destroy'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('users') }}">

                                        <span>
                                            Users
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- ROLES --}}
                            @if(auth()->user()->hasPermission('view-roles'))

                                <li class="{{ request()->routeIs(
                                    'roles',
                                    'role-create',
                                    'role-store',
                                    'role-details',
                                    'role-edit',
                                    'role-update',
                                    'role-destroy',
                                    'role-permissions',
                                    'role-permissions.update'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('roles') }}">

                                        <span>
                                            Roles
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- PERMISSIONS --}}
                            @if(auth()->user()->hasPermission('view-permissions'))

                                <li class="{{ request()->routeIs(
                                    'permissions',
                                    'permission-create',
                                    'permission-store',
                                    'permission-details',
                                    'permission-edit',
                                    'permission-update',
                                    'permission-destroy'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('permissions') }}">

                                        <span>
                                            Permissions
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif


                {{-- ========================================
                    PAYMENTS
                ========================================= --}}
                @if(
                    auth()->user()->hasPermission('view-payments') ||
                    auth()->user()->hasPermission('view-ecommerce-payments') ||
                    auth()->user()->hasPermission('view-smart-buy-payments') ||
                    auth()->user()->hasPermission('view-failed-payments')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'payments',
                        'payments-ecommerce',
                        'payments-smart-buy',
                        'payments-failed',
                        'payments-details'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-bank-card-line"></i>

                            <span>
                                Payments
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">


                            {{-- ALL PAYMENTS --}}
                            @if(auth()->user()->hasPermission('view-payments'))

                                <li class="{{ request()->routeIs(
                                    'payments',
                                    'payments-details'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('payments') }}">

                                        <span>
                                            All Payments
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- ECOMMERCE --}}
                            @if(auth()->user()->hasPermission('view-ecommerce-payments'))

                                <li class="{{ request()->routeIs(
                                    'payments-ecommerce'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('payments-ecommerce') }}">

                                        <span>
                                            Ecommerce
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- SMART BUY --}}
                            @if(auth()->user()->hasPermission('view-smart-buy-payments'))

                                <li class="{{ request()->routeIs(
                                    'payments-smart-buy'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('payments-smart-buy') }}">

                                        <span>
                                            Smart Buy
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- FAILED --}}
                            @if(auth()->user()->hasPermission('view-failed-payments'))

                                <li class="{{ request()->routeIs(
                                    'payments-failed'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('payments-failed') }}">

                                        <span>
                                            Failed
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif


                {{-- ========================================
                    REPORTS
                ========================================= --}}
                @if(
                    auth()->user()->hasPermission('view-reports') ||
                    auth()->user()->hasPermission('view-ecommerce-reports') ||
                    auth()->user()->hasPermission('view-smart-buy-reports')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'reports',
                        'reports-ecommerce',
                        'reports-smart-buy'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-bar-chart-2-line"></i>

                            <span>
                                Reports
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">


                            {{-- OVERVIEW --}}
                            @if(auth()->user()->hasPermission('view-reports'))

                                <li class="{{ request()->routeIs('reports') ? 'active' : '' }}">

                                    <a href="{{ route('reports') }}">

                                        <span>
                                            Overview
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- ECOMMERCE --}}
                            @if(auth()->user()->hasPermission('view-ecommerce-reports'))

                                <li class="{{ request()->routeIs('reports-ecommerce') ? 'active' : '' }}">

                                    <a href="{{ route('reports-ecommerce') }}">

                                        <span>
                                            Ecommerce
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- SMART BUY --}}
                            @if(auth()->user()->hasPermission('view-smart-buy-reports'))

                                <li class="{{ request()->routeIs('reports-smart-buy') ? 'active' : '' }}">

                                    <a href="{{ route('reports-smart-buy') }}">

                                        <span>
                                            Smart Buy
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif


                {{-- ========================================
                    SETTINGS
                ========================================= --}}
                @if(
                    auth()->user()->hasPermission('view-settings') ||
                    auth()->user()->hasPermission('view-ecommerce-settings') ||
                    auth()->user()->hasPermission('view-smart-buy-settings') ||
                    auth()->user()->hasPermission('view-audit-logs')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'settings',
                        'settings-ecommerce',
                        'settings-smart-buy',
                        'settings-audit-logs',
                        'settings-audit-log-details'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-settings-3-line"></i>

                            <span>
                                Settings
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">


                            {{-- GENERAL --}}
                            @if(auth()->user()->hasPermission('view-settings'))

                                <li class="{{ request()->routeIs('settings') ? 'active' : '' }}">

                                    <a href="{{ route('settings') }}">

                                        <span>
                                            General
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- ECOMMERCE --}}
                            @if(auth()->user()->hasPermission('view-ecommerce-settings'))

                                <li class="{{ request()->routeIs('settings-ecommerce') ? 'active' : '' }}">

                                    <a href="{{ route('settings-ecommerce') }}">

                                        <span>
                                            Ecommerce
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- SMART BUY --}}
                            @if(auth()->user()->hasPermission('view-smart-buy-settings'))

                                <li class="{{ request()->routeIs('settings-smart-buy') ? 'active' : '' }}">

                                    <a href="{{ route('settings-smart-buy') }}">

                                        <span>
                                            Smart Buy
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- AUDIT LOGS --}}
                            @if(auth()->user()->hasPermission('view-audit-logs'))

                                <li class="{{ request()->routeIs(
                                    'settings-audit-logs',
                                    'settings-audit-log-details'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('settings-audit-logs') }}">

                                        <span>
                                            Audit Logs
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif


                {{-- ========================================
                    ADMIN PROFILE
                ========================================= --}}
                @if(auth()->user()->hasPermission('view-profile'))

                    <li class="{{ request()->routeIs(
                        'profile',
                        'profile.update'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('profile') }}">

                            <i class="ri-user-settings-line"></i>

                            <span>
                                Profile
                            </span>

                        </a>

                    </li>

                @endif


            </ul>

        @endif

    </div>


    {{-- ================================================
        LOGOUT
    ================================================= --}}
    <div class="logout">

        <form
            action="{{ route('logout') }}"
            method="POST"
            class="logout-form"
        >

            @csrf

            <button
                type="submit"
                class="logout-btn"
            >

                <i class="ri-logout-box-r-line"></i>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</div>
