<div class="dashboard-sidebar">

    {{-- ================================================
        SIDEBAR LOGO
    ================================================= --}}
    <div class="sidebar-logo">

        <a href="{{ route('home') }}">
            <img
                src="{{ setting('website_logo') ? asset(setting('website_logo')) : asset('logo.png') }}"
                alt="{{ setting('website_name', config('app.name')) }}"
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

                    <a href="{{ auth()->user()->roles()->where('slug', 'admin')->exists()
                        ? route('admin-dashboard')
                        : route('dashboard') }}">

                        <i class="ri-dashboard-line"></i>

                        <span>
                            Dashboard
                        </span>

                    </a>

                </li>

            @endif

            <li class="{{ request()->routeIs('global-tracking') ? 'active' : '' }}">
                <a href="{{ route('global-tracking') }}">
                    <i class="ri-map-pin-2-line"></i>
                    <span>Tracking</span>
                </a>
            </li>

        </ul>

        {{-- ============================================
            SMART BUY - CUSTOMER
        ============================================= --}}
        @if(
            !auth()->user()->roles()->where('slug', 'admin')->exists() &&
            (
                auth()->user()->hasPermission('my-smart-buy') ||
                auth()->user()->hasPermission('my-smart-buy-create')
            )
        )

            <p class="menu-title">
                Smart Buy
            </p>

            <ul>


                {{-- MY REQUESTS --}}
                @if(auth()->user()->hasPermission('my-smart-buy'))

                    <li class="{{ request()->routeIs(
                        'my-smart-buy',
                        'my-smart-buy.details',
                        'my-smart-buy.confirmation',
                        'my-smart-buy.quote',
                        'my-smart-buy.quote.accept',
                        'my-smart-buy.quote.reject',
                        'my-smart-buy.payment',
                        'my-smart-buy.payment.store',
                        'my-smart-buy.payment.success',
                        'my-smart-buy.payment.cancel',
                        'my-smart-buy.tracking'
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
                @if(auth()->user()->hasPermission('my-smart-buy-create'))

                    <li class="{{ request()->routeIs(
                        'my-smart-buy.create'
                    ) ? 'active' : '' }}">

                        <a href="{{ route('my-smart-buy.create') }}">

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
            MAIN
        ============================================= --}}
        <p class="menu-title">
            Ecommerce
        </p>

        @php
            $headerCart = auth()->check()
                ? auth()->user()->cart
                : \App\Models\Cart::query()
                    ->where('session_id', session()->getId())
                    ->first();

            $headerCartCount =
                $headerCart?->totalQuantity() ?? 0;
        @endphp

        <ul>

            <li>
                <a href="{{ route('my-account') }}">
                    <i class="ri-user-3-line"></i>
                    <span>My Account</span>
                </a>
            </li>

            <li>
                <a href="{{ route('my-cart') }}">
                    <i class="ri-shopping-bag-3-line"></i>
                    <span>Cart ({{ $headerCartCount }})</span>
                </a>
            </li>

            <li>
                <a href="{{ route('my-orders') }}">
                    <i class="ri-file-list-3-line"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li>
                <a href="{{ route('my-wishlist') }}">
                    <i class="ri-heart-3-line"></i>
                    <span>Wishlist</span>
                </a>
            </li>

        </ul>


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
                    auth()->user()->hasPermission('view-ecommerce-payments') ||
                    auth()->user()->hasPermission('view-ecommerce-shipments')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'admin-products*',
                        'admin-categories*',
                        'admin-brands*',
                        'admin-inventory*',
                        'admin-attributes*',
                        'admin-coupons*',
                        'admin-orders*',
                        'admin-refunds*',
                        'admin-order-details',
                        'admin-order-status',
                        'admin-order-cancel',
                        'admin-ecommerce-payments',
                        'admin-ecommerce-payment-refund-requests',
                        'admin-ecommerce-payment-refund-request-show',
                        'admin-ecommerce-payment-show',
                        'ecommerce-shipments*',
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

                                <li class="{{ request()->routeIs('admin-products*') ? 'active' : '' }}">

                                    <a href="{{ route('admin-products') }}">

                                        <span>
                                            Products
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- CATEGORIES --}}
                            @if(auth()->user()->hasPermission('view-categories'))

                                <li class="{{ request()->routeIs( 'admin-categories*' ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-categories') }}">

                                        <span>
                                            Categories
                                        </span>

                                    </a>

                                </li>

                            @endif

                            {{-- Brands --}}
                            @if(auth()->user()->hasPermission('view-brands'))

                                <li class="{{ request()->routeIs('admin-brands*') ? 'active' : '' }}">

                                    <a href="{{ route('admin-brands') }}">

                                        <span>
                                            Brands
                                        </span>

                                    </a>

                                </li>

                            @endif

                            {{-- Attributes --}}
                            @if(auth()->user()->hasPermission('view-attributes'))

                                <li class="{{ request()->routeIs('admin-attributes*') ? 'active' : '' }}">

                                    <a href="{{ route('admin-attributes') }}">

                                        <span>
                                            Attributes
                                        </span>

                                    </a>

                                </li>

                            @endif

                            {{-- Coupons --}}
                            @if(auth()->user()->hasPermission('view-coupons'))

                                <li class="{{ request()->routeIs('admin-coupons*') ? 'active' : '' }}">

                                    <a href="{{ route('admin-coupons') }}">

                                        <span>
                                            Coupons
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- INVENTORY --}}
                            @if(auth()->user()->hasPermission('view-inventory'))

                                <li class="{{ request()->routeIs(
                                    'admin-inventory*',
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
                                    'admin-orders*',
                                    'admin-order-details'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-orders') }}">

                                        <span>
                                            Orders
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- Refund --}}
                            @if(auth()->user()->hasPermission('view-orders'))

                                <li class="{{ request()->routeIs(
                                    'admin-refunds*'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('admin-refunds') }}">

                                        <span>
                                            Refund
                                        </span>

                                    </a>

                                </li>

                            @endif


                            {{-- Payments --}}
                            @if(auth()->user()->hasPermission('view-ecommerce-payments'))

                                <li class="{{ request()->routeIs(
                                    'admin-ecommerce-payments',
                                    'admin-ecommerce-payment-refund-requests',
                                    'admin-ecommerce-payment-refund-request-show',
                                    'admin-ecommerce-payment-show',
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
                                    'ecommerce-shipments*',
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
                    auth()->user()->hasPermission('smart-buy') ||
                    auth()->user()->hasPermission('smart-buy-details') ||
                    auth()->user()->hasPermission('smart-buy-status') ||
                    auth()->user()->hasPermission('smart-buy-quote') ||
                    auth()->user()->hasPermission('smart-buy-quote-edit') ||
                    auth()->user()->hasPermission('smart-buy-payment') ||
                    auth()->user()->hasPermission('smart-buy-shipment')
                )

                    <li class="has-submenu {{ request()->routeIs('smart-buy*') ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-global-line"></i>

                            <span>
                                Smart Buy
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">


                            {{-- ALL REQUESTS --}}
                            @if(auth()->user()->hasPermission('smart-buy'))

                                <li class="{{ request()->routeIs(
                                    'smart-buy',
                                    'smart-buy.details',
                                    'smart-buy.status.update',
                                    'smart-buy.quote.create',
                                    'smart-buy.quote.store',
                                    'smart-buy.quote.show',
                                    'smart-buy.quote.edit',
                                    'smart-buy.quote.update',
                                    'smart-buy.payment.store',
                                    'smart-buy.payment.update',
                                    'smart-buy.shipment',
                                    'smart-buy.shipment.store',
                                    'smart-buy.shipment.update'
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('smart-buy') }}">

                                        <span>
                                            Requests
                                        </span>

                                    </a>

                                </li>

                                <li class="{{ request()->routeIs(
                                    'smart-buy.payments',
                                ) ? 'active' : '' }}">

                                    <a href="{{ route('smart-buy.payments') }}">

                                        <span>
                                            Payments
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
                    REPORTS
                ========================================= --}}
                @if(
                    auth()->user()->hasPermission('view-reports') ||
                    auth()->user()->hasPermission('view-ecommerce-reports') ||
                    auth()->user()->hasPermission('view-smart-buy-reports')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'reports',
                        'reports.ecommerce',
                        'reports.smart-buy'
                    ) ? 'active open' : '' }}">

                        <a href="javascript:void(0);">

                            <i class="ri-bar-chart-2-line"></i>

                            <span>
                                Reports
                            </span>

                            <i class="ri-arrow-down-s-line submenu-arrow"></i>

                        </a>

                        <ul class="submenu">

                            @if(auth()->user()->hasPermission('view-ecommerce-reports'))

                                <li class="{{ request()->routeIs('reports.ecommerce')
                                    ? 'active'
                                    : '' }}">

                                    <a href="{{ route('reports.ecommerce') }}">

                                        <span>
                                            Ecommerce
                                        </span>

                                    </a>

                                </li>

                            @endif


                            @if(auth()->user()->hasPermission('view-smart-buy-reports'))

                                <li class="{{ request()->routeIs('reports.smart-buy')
                                    ? 'active'
                                    : '' }}">

                                    <a href="{{ route('reports.smart-buy') }}">

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
                    auth()->user()->hasPermission('view-ecommerce-settings')
                )

                    <li class="has-submenu {{ request()->routeIs(
                        'settings',
                        'settings-ecommerce'
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

                                <li class="{{ request()->routeIs('settings')
                                    ? 'active'
                                    : '' }}">

                                    <a href="{{ route('settings') }}">

                                        <span>
                                            General
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
