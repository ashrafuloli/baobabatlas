<div class="dashboard-sidebar">

    {{--==================================================
        Sidebar Logo
    ==================================================--}}
    <div class="sidebar-logo">

        <a href="{{ route('dashboard') }}">

            <img
                src="{{ asset('logo.png') }}"
                alt="Baobab Atlas"
            >

        </a>

        <div class="close-menu d-xl-none d-inline-flex">

            <i class="ri-close-line"></i>

        </div>

    </div>


    {{--==================================================
        Sidebar Menu
    ==================================================--}}
    <div class="sidebar-menu">


        {{--================================================
            MAIN
        =================================================--}}
        <p class="menu-title">
            Main
        </p>

        <ul>

            {{-- Dashboard --}}
            @if(auth()->user()->hasPermission('view-dashboard'))

                <li class="{{ request()->routeIs(
                    'dashboard',
                    'admin-dashboard'
                ) ? 'active' : '' }}">

                    <a href="{{ route('dashboard') }}">

                        <i class="ri-dashboard-line"></i>

                        <span>
                            Dashboard
                        </span>

                    </a>

                </li>

            @endif

        </ul>



        {{--================================================
            CUSTOMER ECOMMERCE
        =================================================--}}
        @if(
            !auth()->user()->isAdmin() &&
            (
                auth()->user()->hasPermission('view-products') ||
                auth()->user()->hasPermission('view-orders')
            )
        )

            <p class="menu-title">
                Ecommerce
            </p>

            <ul>


                {{--================================================
                    Shop
                =================================================--}}
                @if(auth()->user()->hasPermission('view-products'))

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


                            {{-- Shop --}}
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


                            {{-- Cart --}}
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


                            {{-- Checkout --}}
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



                {{--================================================
                    My Orders
                =================================================--}}
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



        {{--================================================
            SMART BUY
            Customer Only
        =================================================--}}
        @if(
            !auth()->user()->isAdmin() &&
            (
                auth()->user()->hasPermission('view-smart-buy') ||
                auth()->user()->hasPermission('create-smart-buy')
            )
        )

            <p class="menu-title">
                Smart Buy
            </p>

            <ul>


                {{--================================================
                    My Smart Buy Requests
                =================================================--}}
                @if(auth()->user()->hasPermission('view-smart-buy'))

                    <li class="{{ request()->routeIs(
                        'my-smart-buy',
                        'my-smart-buy-details',
                        'smart-buy-confirmation',
                        'smart-buy-quote',
                        'smart-buy-payment',
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



                {{--================================================
                    Start Smart Buy
                =================================================--}}
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



        {{--================================================
            ACCOUNT
            Admin + Customer
        =================================================--}}
        @if(
            auth()->user()->hasPermission('view-profile') ||
            (
                !auth()->user()->isAdmin() &&
                (
                    auth()->user()->hasPermission('view-payments') ||
                    auth()->user()->hasPermission('view-notifications')
                )
            )
        )

            <p class="menu-title">
                Account
            </p>

            <ul>


                {{--================================================
                    Profile
                    Admin + Customer
                =================================================--}}
                @if(auth()->user()->hasPermission('view-profile'))

                    <li class="{{ request()->routeIs(
                        'profile'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('profile') }}">

                            <i class="ri-user-settings-line"></i>

                            <span>
                                Profile
                            </span>

                        </a>

                    </li>

                @endif



                {{--================================================
                    Customer Payments
                =================================================--}}
                @if(
                    !auth()->user()->isAdmin() &&
                    auth()->user()->hasPermission('view-payments')
                )

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



                {{--================================================
                    Customer Notifications
                =================================================--}}
                @if(
                    !auth()->user()->isAdmin() &&
                    auth()->user()->hasPermission('view-notifications')
                )

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



        {{--================================================
            ADMINISTRATION
        =================================================--}}
        @if(auth()->user()->isAdmin())

            <p class="menu-title">
                Administration
            </p>

            <ul>


                {{--================================================
                    Ecommerce Management
                =================================================--}}
                @if(
                    auth()->user()->hasPermission('view-products') ||
                    auth()->user()->hasPermission('view-categories') ||
                    auth()->user()->hasPermission('view-orders') ||
                    auth()->user()->hasPermission('view-inventory') ||
                    auth()->user()->hasPermission('view-ecommerce-shipments')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'admin-products',
                        'admin-product-*',
                        'admin-categories',
                        'admin-category-*',
                        'admin-inventory',
                        'admin-inventory-low-stock',
                        'admin-inventory-out-of-stock',
                        'admin-orders',
                        'admin-order-details',
                        'ecommerce-shipments',
                        'ecommerce-shipment-*'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-store-2-line"></i>

                            <span>
                                Ecommerce
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>


                        <ul class="submenu">


                            {{-- Products --}}
                            @if(auth()->user()->hasPermission('view-products'))

                                <li class="{{ request()->routeIs(
                                    'admin-products',
                                    'admin-product-*'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-products') }}">

                                        <span>
                                            Products
                                        </span>

                                    </a>

                                </li>

                            @endif



                            {{-- Categories --}}
                            @if(auth()->user()->hasPermission('view-categories'))

                                <li class="{{ request()->routeIs(
                                    'admin-categories',
                                    'admin-category-*'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-categories') }}">

                                        <span>
                                            Categories
                                        </span>

                                    </a>

                                </li>

                            @endif



                            {{-- Inventory --}}
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



                            {{-- Orders --}}
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



                            {{-- Shipments --}}
                            @if(auth()->user()->hasPermission(
                                'view-ecommerce-shipments'
                            ))

                                <li class="{{ request()->routeIs(
                                    'ecommerce-shipments',
                                    'ecommerce-shipment-*'
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



                {{--================================================
                    Smart Buy Management
                =================================================--}}
                @if(
                    auth()->user()->hasPermission('view-smart-buy') ||
                    auth()->user()->hasPermission('edit-smart-buy') ||
                    auth()->user()->hasPermission('manage-smart-buy-quote')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'smart-buy',
                        'smart-buy-details',
                        'smart-buy-edit',
                        'smart-buy-admin-quote',
                        'smart-buy-purchase',
                        'smart-buy-shipment',
                        'smart-buy-admin-payments'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-global-line"></i>

                            <span>
                                Smart Buy
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>


                        <ul class="submenu">


                            {{-- Requests --}}
                            @if(auth()->user()->hasPermission('view-smart-buy'))

                                <li class="{{ request()->routeIs(
                                    'smart-buy',
                                    'smart-buy-details',
                                    'smart-buy-edit',
                                    'smart-buy-admin-quote',
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



                            {{-- Payments --}}
                            @if(auth()->user()->hasPermission(
                                'view-smart-buy-payment'
                            ))

                                <li class="{{ request()->routeIs(
                                    'smart-buy-admin-payments'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('smart-buy-admin-payments') }}">

                                        <span>
                                            Payments
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif



                {{--================================================
                    User Management
                =================================================--}}
                @if(
                    auth()->user()->hasPermission('view-users') ||
                    auth()->user()->hasPermission('view-roles') ||
                    auth()->user()->hasPermission('view-permissions')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'users*',
                        'user-*',
                        'roles*',
                        'role-*',
                        'permissions*',
                        'permission-*'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-group-line"></i>

                            <span>
                                Users
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>


                        <ul class="submenu">


                            {{-- Users --}}
                            @if(auth()->user()->hasPermission('view-users'))

                                <li class="{{ request()->routeIs(
                                    'users*',
                                    'user-*'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('users') }}">

                                        <span>
                                            Users
                                        </span>

                                    </a>

                                </li>

                            @endif



                            {{-- Roles --}}
                            @if(auth()->user()->hasPermission('view-roles'))

                                <li class="{{ request()->routeIs(
                                    'roles*',
                                    'role-*'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('roles') }}">

                                        <span>
                                            Roles
                                        </span>

                                    </a>

                                </li>

                            @endif



                            {{-- Permissions --}}
                            @if(auth()->user()->hasPermission('view-permissions'))

                                <li class="{{ request()->routeIs(
                                    'permissions*',
                                    'permission-*'
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



                {{--================================================
                    Central Payments
                =================================================--}}
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


                            {{-- All Payments --}}
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



                            {{-- Ecommerce Payments --}}
                            @if(auth()->user()->hasPermission(
                                'view-ecommerce-payments'
                            ))

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



                            {{-- Smart Buy Payments --}}
                            @if(auth()->user()->hasPermission(
                                'view-smart-buy-payments'
                            ))

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



                            {{-- Failed Payments --}}
                            @if(auth()->user()->hasPermission(
                                'view-failed-payments'
                            ))

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



                {{--================================================
                    Reports
                =================================================--}}
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


                            {{-- Overview --}}
                            @if(auth()->user()->hasPermission('view-reports'))

                                <li class="{{ request()->routeIs(
                                    'reports'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('reports') }}">

                                        <span>
                                            Overview
                                        </span>

                                    </a>

                                </li>

                            @endif



                            {{-- Ecommerce --}}
                            @if(auth()->user()->hasPermission(
                                'view-ecommerce-reports'
                            ))

                                <li class="{{ request()->routeIs(
                                    'reports-ecommerce'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('reports-ecommerce') }}">

                                        <span>
                                            Ecommerce
                                        </span>

                                    </a>

                                </li>

                            @endif



                            {{-- Smart Buy --}}
                            @if(auth()->user()->hasPermission(
                                'view-smart-buy-reports'
                            ))

                                <li class="{{ request()->routeIs(
                                    'reports-smart-buy'
                                ) ? 'active' : '' }}">

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



                {{--================================================
                    Settings
                =================================================--}}
                @if(
                    auth()->user()->hasPermission('view-settings') ||
                    auth()->user()->hasPermission('view-smart-buy-settings') ||
                    auth()->user()->hasPermission('view-audit-logs')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'settings',
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


                            {{-- General Settings --}}
                            @if(auth()->user()->hasPermission('view-settings'))

                                <li class="{{ request()->routeIs(
                                    'settings'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('settings') }}">

                                        <span>
                                            General
                                        </span>

                                    </a>

                                </li>

                            @endif



                            {{-- Smart Buy Settings --}}
                            @if(auth()->user()->hasPermission(
                                'view-smart-buy-settings'
                            ))

                                <li class="{{ request()->routeIs(
                                    'settings-smart-buy'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('settings-smart-buy') }}">

                                        <span>
                                            Smart Buy
                                        </span>

                                    </a>

                                </li>

                            @endif



                            {{-- Audit Logs --}}
                            @if(auth()->user()->hasPermission(
                                'view-audit-logs'
                            ))

                                <li class="{{ request()->routeIs(
                                    'settings-audit-logs',
                                    'settings-audit-log-details'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route(
                                        'settings-audit-logs'
                                    ) }}">

                                        <span>
                                            Audit Logs
                                        </span>

                                    </a>

                                </li>

                            @endif


                        </ul>

                    </li>

                @endif


            </ul>

        @endif

    </div>


    {{--==================================================
        Logout
    ==================================================--}}
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
