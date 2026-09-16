<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Backend\AdminOrderController;
use App\Http\Controllers\Backend\AdminRefundController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\EcommercePaymentController;
use App\Http\Controllers\Backend\EcommerceReportController;
use App\Http\Controllers\Backend\GeneralSettingsController;
use App\Http\Controllers\Backend\InventoryController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ShipmentController;
use App\Http\Controllers\Backend\SmartBuyController;
use App\Http\Controllers\Backend\SmartBuyPaymentController;
use App\Http\Controllers\Backend\SmartBuyQuoteController;
use App\Http\Controllers\Backend\SmartBuyReportController;
use App\Http\Controllers\Backend\SmartBuyShipmentController;
use App\Http\Controllers\Backend\TrackingController;
use App\Http\Controllers\Backend\UserAddressController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Customer\MySmartBuyController;
use App\Http\Controllers\Customer\MySmartBuyPaymentController;
use App\Http\Controllers\Customer\MySmartBuyQuoteController;
use App\Http\Controllers\Customer\MySmartBuyTrackingController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendTrackingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MarketplaceController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\RefundRequestController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Front-End Routes
|--------------------------------------------------------------------------
*/

Route::middleware('maintenance')->group(function (): void {

    Route::get('/', [HomeController::class, 'index'])->name('home');


    /*
    |--------------------------------------------------------------------------
    | Shop
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/shop',
        [MarketplaceController::class, 'index'],
    )->name('shop');

    Route::get(
        '/shop/{product:slug}',
        [MarketplaceController::class, 'show'],
    )->name('shop.details');


    /*
    |--------------------------------------------------------------------------
    | Cart
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/cart',
        [CartController::class, 'index'],
    )->name('my-cart');

    Route::post(
        '/cart/items',
        [CartController::class, 'store'],
    )->name('cart.items.store');

    Route::patch(
        '/cart/items/{cartItem}',
        [CartController::class, 'update'],
    )->name('cart.items.update');

    Route::delete(
        '/cart/items/{cartItem}',
        [CartController::class, 'destroy'],
    )->name('cart.items.destroy');

    Route::delete(
        '/cart',
        [CartController::class, 'clear'],
    )->name('cart.clear');

    Route::post(
        '/cart/coupon',
        [CartController::class, 'applyCoupon']
    )->name('cart.coupon.apply');

    Route::delete(
        '/cart/coupon',
        [CartController::class, 'removeCoupon']
    )->name('cart.coupon.remove');


    /*
    |--------------------------------------------------------------------------
    | Frontend Authenticated Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function (): void {

        Route::view(
            '/my-account',
            'frontend.pages.shop.my-account',
        )->name('my-account');

        Route::get(
            '/my-orders',
            [OrderController::class, 'index'],
        )->name('my-orders');

        Route::get(
            '/my-orders/{order:order_number}',
            [OrderController::class, 'show'],
        )->name('my-orders.show');

        Route::get(
            '/orders/{order}/payment',
            [OrderController::class, 'payment']
        )
            ->name('my-order.payment');

        Route::patch(
            '/orders/{order}/cancel',
            [OrderController::class, 'cancel']
        )
            ->name('my-order.cancel');

        Route::post(
            '/my-orders/{order}/refund-request',
            [RefundRequestController::class, 'store']
        )->name('my-order.refund-request');

        Route::get('/my-wishlist', [
            WishlistController::class, 'index',
        ])->name('my-wishlist');

        Route::post('/my-wishlist/{product}/add', [
            WishlistController::class, 'add',
        ])->name('wishlist.add');

        Route::delete('/my-wishlist/{product}', [
            WishlistController::class, 'remove',
        ])->name('wishlist.remove');

        Route::post('/my-wishlist/{product}/toggle', [
            WishlistController::class, 'toggle',
        ])->name('wishlist.toggle');


        /*
        |--------------------------------------------------------------------------
        | Frontend Checkout
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/checkout',
            [CheckoutController::class, 'index'],
        )->name('checkout');

        Route::post(
            '/checkout/payment',
            [CheckoutController::class, 'payment'],
        )->name('checkout.payment');

        Route::get(
            '/checkout/success',
            [CheckoutController::class, 'success'],
        )->name('checkout.success');

    });


    /*
    |--------------------------------------------------------------------------
    | About
    |--------------------------------------------------------------------------
    */

    Route::view(
        '/about',
        'frontend.pages.about.index'
    )->name('about');


    /*
    |--------------------------------------------------------------------------
    | Service
    |--------------------------------------------------------------------------
    */

    Route::view(
        '/service',
        'frontend.pages.service.index'
    )->name('service');


    /*
    |--------------------------------------------------------------------------
    | Track Shipment
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/tracking',
        [FrontendTrackingController::class, 'index']
    )->name('tracking');

    Route::post(
        '/tracking',
        [FrontendTrackingController::class, 'search']
    )->name('tracking.search');


    /*
    |--------------------------------------------------------------------------
    | Partners
    |--------------------------------------------------------------------------
    */

    Route::view(
        '/partners',
        'frontend.pages.partners.index'
    )->name('partners');


    /*
    |--------------------------------------------------------------------------
    | Contact
    |--------------------------------------------------------------------------
    */

    Route::view(
        '/contact',
        'frontend.pages.contact.index'
    )->name('contact');


    /*
    |--------------------------------------------------------------------------
    | Guest Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('guest')->group(function (): void {

        /*
        |--------------------------------------------------------------------------
        | Login
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/login',
            [LoginController::class, 'showLogin']
        )->name('login');

        Route::post(
            '/login',
            [LoginController::class, 'login']
        )->name('login.submit');


        /*
        |--------------------------------------------------------------------------
        | Registration
        |--------------------------------------------------------------------------
        */

        Route::middleware('registration')->group(function (): void {
            Route::get(
                '/register',
                [RegisterController::class, 'showRegister']
            )->name('register');

            Route::post(
                '/register',
                [RegisterController::class, 'register']
            )->name('register.submit');
        });


        /*
        |--------------------------------------------------------------------------
        | Forgot Password
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/forgot-password',
            'backend.pages.auth.forgot-password'
        )->name('forgot-password');


        /*
        |--------------------------------------------------------------------------
        | Reset Password
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/reset-password/{token}',
            'backend.pages.auth.reset-password'
        )->name('password.reset');

    });

});


/*
|--------------------------------------------------------------------------
| Stripe Webhook
|--------------------------------------------------------------------------
|
| Stripe webhook MUST NOT be affected by maintenance mode.
|
*/

Route::post(
    '/stripe/webhook',
    [StripeWebhookController::class, 'handle'],
)->name('stripe.webhook');


/*
|--------------------------------------------------------------------------
| Authenticated Portal Routes
|--------------------------------------------------------------------------
|
| Portal/Admin MUST remain accessible during maintenance mode.
|
*/

Route::middleware('auth')
    ->prefix('portal')
    ->group(function (): void {

        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/logout',
            [LoginController::class, 'logout']
        )->name('logout');


        /*
        |--------------------------------------------------------------------------
        | Email Verification
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/verify-email',
            [RegisterController::class, 'showVerificationNotice']
        )->name('verification.notice');

        Route::get(
            '/verify-email/{id}/{hash}',
            [RegisterController::class, 'verifyEmail']
        )
            ->middleware('signed')
            ->name('verification.verify');

        Route::post(
            '/verify-email/resend',
            [RegisterController::class, 'resendVerificationEmail']
        )
            ->middleware('throttle:6,1')
            ->name('verification.send');

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'customer'],
        )
            ->middleware([
                'auth',
                'permission:view-dashboard',
            ])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/admin/dashboard',
            [DashboardController::class, 'admin'],
        )
            ->middleware([
                'auth',
                'role:admin',
            ])
            ->name('admin-dashboard');


        /*
        |--------------------------------------------------------------------------
        | Tracking
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/tracking',
            [TrackingController::class, 'index']
        )->name('global-tracking');

        Route::post(
            '/tracking/search',
            [TrackingController::class, 'search']
        )->name('global-tracking.search');


        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::prefix('profile')
            ->middleware('permission:view-profile')
            ->group(function (): void {

                Route::get(
                    '/',
                    [ProfileController::class, 'index']
                )->name('profile');

                Route::put(
                    '/',
                    [ProfileController::class, 'update']
                )->name('profile.update');


                /*
                |--------------------------------------------------------------------------
                | User Addresses
                |--------------------------------------------------------------------------
                */

                Route::post(
                    '/addresses',
                    [UserAddressController::class, 'store']
                )->name('profile.addresses.store');

                Route::put(
                    '/addresses/{address}',
                    [UserAddressController::class, 'update']
                )->name('profile.addresses.update');

                Route::delete(
                    '/addresses/{address}',
                    [UserAddressController::class, 'destroy']
                )->name('profile.addresses.destroy');

                Route::patch(
                    '/addresses/{address}/default',
                    [UserAddressController::class, 'setDefault']
                )->name('profile.addresses.default');

            });


        /*
        |--------------------------------------------------------------------------
        | SMART BUY - CUSTOMER
        |--------------------------------------------------------------------------
        */

        Route::prefix('my-smart-buy')
            ->group(function (): void {

                Route::get(
                    '/',
                    [MySmartBuyController::class, 'index']
                )
                    ->middleware('permission:my-smart-buy')
                    ->name('my-smart-buy');

                Route::get(
                    '/create',
                    [MySmartBuyController::class, 'create']
                )
                    ->middleware('permission:my-smart-buy-create')
                    ->name('my-smart-buy.create');

                Route::post(
                    '/store',
                    [MySmartBuyController::class, 'store']
                )
                    ->middleware('permission:my-smart-buy-create')
                    ->name('my-smart-buy.store');

                Route::get(
                    '/{smartBuy}/quote',
                    [MySmartBuyQuoteController::class, 'show']
                )
                    ->middleware('permission:my-smart-buy-quote')
                    ->name('my-smart-buy.quote');

                Route::post(
                    '/{smartBuy}/quote/accept',
                    [MySmartBuyQuoteController::class, 'accept']
                )
                    ->middleware('permission:my-smart-buy-quote')
                    ->name('my-smart-buy.quote.accept');

                Route::post(
                    '/{smartBuy}/quote/reject',
                    [MySmartBuyQuoteController::class, 'reject']
                )
                    ->middleware('permission:my-smart-buy-quote')
                    ->name('my-smart-buy.quote.reject');

                Route::post(
                    '/{smartBuy}/quote/request-extension',
                    [MySmartBuyQuoteController::class, 'requestExtension']
                )
                    ->middleware('permission:my-smart-buy-quote')
                    ->name('my-smart-buy.quote.request-extension');

                Route::get(
                    '/{smartBuy}/payment',
                    [MySmartBuyPaymentController::class, 'show']
                )
                    ->middleware('permission:my-smart-buy-payment')
                    ->name('my-smart-buy.payment');

                Route::post(
                    '/{smartBuy}/payment',
                    [MySmartBuyPaymentController::class, 'store']
                )
                    ->middleware('permission:my-smart-buy-payment')
                    ->name('my-smart-buy.payment.store');

                Route::get(
                    '/{smartBuy}/payment/success',
                    [MySmartBuyPaymentController::class, 'success']
                )
                    ->middleware('permission:my-smart-buy-payment')
                    ->name('my-smart-buy.payment.success');

                Route::get(
                    '/{smartBuy}/payment/cancel',
                    [MySmartBuyPaymentController::class, 'cancel']
                )
                    ->middleware('permission:my-smart-buy-payment')
                    ->name('my-smart-buy.payment.cancel');

                Route::get(
                    '/{smartBuy}/tracking',
                    [MySmartBuyTrackingController::class, 'show']
                )
                    ->middleware('permission:my-smart-buy-tracking')
                    ->name('my-smart-buy.tracking');

                Route::get(
                    '/{id}',
                    [MySmartBuyController::class, 'details']
                )
                    ->middleware('permission:my-smart-buy-details')
                    ->name('my-smart-buy.details');

            });


        /*
        |--------------------------------------------------------------------------
        | SMART BUY - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::prefix('smart-buy')
            ->group(function (): void {

                Route::get(
                    '/',
                    [SmartBuyController::class, 'index']
                )
                    ->middleware('permission:smart-buy')
                    ->name('smart-buy');

                Route::get(
                    '/{smartBuy}',
                    [SmartBuyController::class, 'show']
                )
                    ->middleware('permission:smart-buy-details')
                    ->name('smart-buy.details');

                Route::put(
                    '/{smartBuy}/status',
                    [SmartBuyController::class, 'updateStatus']
                )
                    ->middleware('permission:smart-buy-status')
                    ->name('smart-buy.status.update');

                Route::get(
                    '/{smartBuy}/quote/create',
                    [SmartBuyQuoteController::class, 'create']
                )
                    ->middleware('permission:smart-buy-quote')
                    ->name('smart-buy.quote.create');

                Route::post(
                    '/{smartBuy}/quote',
                    [SmartBuyQuoteController::class, 'store']
                )
                    ->middleware('permission:smart-buy-quote')
                    ->name('smart-buy.quote.store');

                Route::get(
                    '/quote/{quote}',
                    [SmartBuyQuoteController::class, 'show']
                )
                    ->middleware('permission:smart-buy-quote')
                    ->name('smart-buy.quote.show');

                Route::get(
                    '/quote/{quote}/edit',
                    [SmartBuyQuoteController::class, 'edit']
                )
                    ->middleware('permission:smart-buy-quote-edit')
                    ->name('smart-buy.quote.edit');

                Route::put(
                    '/quote/{quote}',
                    [SmartBuyQuoteController::class, 'update']
                )
                    ->middleware('permission:smart-buy-quote-edit')
                    ->name('smart-buy.quote.update');

                Route::post(
                    '/{smartBuy}/payment',
                    [SmartBuyPaymentController::class, 'store']
                )
                    ->middleware('permission:smart-buy-payment')
                    ->name('smart-buy.payment.store');

                Route::put(
                    '/payment/{payment}',
                    [SmartBuyPaymentController::class, 'update']
                )
                    ->middleware('permission:smart-buy-payment')
                    ->name('smart-buy.payment.update');

                Route::get('/smart-buy/payments', [
                    SmartBuyPaymentController::class,
                    'index',
                ])->name('smart-buy.payments');

                Route::get(
                    '/{smartBuy}/shipment/create',
                    [SmartBuyShipmentController::class, 'create']
                )
                    ->middleware('permission:manage-smart-buy-shipment')
                    ->name('smart-buy.shipment.create');

                Route::post(
                    '/{smartBuy}/shipment',
                    [SmartBuyShipmentController::class, 'store']
                )
                    ->middleware('permission:manage-smart-buy-shipment')
                    ->name('smart-buy.shipment.store');

                Route::get(
                    '/shipment/{shipment}/edit',
                    [SmartBuyShipmentController::class, 'edit']
                )
                    ->middleware('permission:manage-smart-buy-shipment')
                    ->name('smart-buy.shipment.edit');

                Route::put(
                    '/shipment/{shipment}',
                    [SmartBuyShipmentController::class, 'update']
                )
                    ->middleware('permission:manage-smart-buy-shipment')
                    ->name('smart-buy.shipment.update');

            });


        /*
        |--------------------------------------------------------------------------
        | ACCOUNT
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/account/payments',
            'backend.pages.account.payments'
        )
            ->middleware('permission:view-payments')
            ->name('account.payments');


        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/notifications',
            'backend.pages.notifications.index'
        )
            ->middleware('permission:view-notifications')
            ->name('notifications');


        /*
        |--------------------------------------------------------------------------
        | ADMIN PANEL
        |--------------------------------------------------------------------------
        */

        Route::middleware('role:admin')
            ->group(function (): void {

                Route::resource(
                    'users',
                    UserController::class
                )->names([
                    'index' => 'users',
                    'create' => 'user-create',
                    'store' => 'user-store',
                    'show' => 'user-details',
                    'edit' => 'user-edit',
                    'update' => 'user-update',
                    'destroy' => 'user-destroy',
                ]);

                Route::resource(
                    'roles',
                    RoleController::class
                )->names([
                    'index' => 'roles',
                    'create' => 'role-create',
                    'store' => 'role-store',
                    'show' => 'role-details',
                    'edit' => 'role-edit',
                    'update' => 'role-update',
                    'destroy' => 'role-destroy',
                ]);

                Route::get(
                    '/roles/{role}/permissions',
                    [RoleController::class, 'permissions']
                )->name('role-permissions');

                Route::put(
                    '/roles/{role}/permissions',
                    [RoleController::class, 'updatePermissions']
                )->name('role-permissions.update');

                Route::resource(
                    'permissions',
                    PermissionController::class
                )->names([
                    'index' => 'permissions',
                    'create' => 'permission-create',
                    'store' => 'permission-store',
                    'show' => 'permission-details',
                    'edit' => 'permission-edit',
                    'update' => 'permission-update',
                    'destroy' => 'permission-destroy',
                ]);


                /*
                |--------------------------------------------------------------------------
                | ECOMMERCE MANAGEMENT
                |--------------------------------------------------------------------------
                */

                Route::prefix('ecommerce')
                    ->group(function (): void {

                        /*
                        |--------------------------------------------------------------------------
                        | Products
                        |--------------------------------------------------------------------------
                        */

                        Route::resource(
                            'admin-products',
                            ProductController::class,
                        )
                            ->parameters([
                                'admin-products' => 'product',
                            ])
                            ->names([
                                'index' => 'admin-products',
                                'create' => 'admin-products.create',
                                'store' => 'admin-products.store',
                                'show' => 'admin-products.show',
                                'edit' => 'admin-products.edit',
                                'update' => 'admin-products.update',
                                'destroy' => 'admin-products.destroy',
                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Categories
                        |--------------------------------------------------------------------------
                        */

                        Route::resource(
                            'admin-categories',
                            CategoryController::class
                        )
                            ->parameters([
                                'admin-categories' => 'category',
                            ])
                            ->names([
                                'index' => 'admin-categories',
                                'create' => 'admin-categories.create',
                                'store' => 'admin-categories.store',
                                'show' => 'admin-categories.show',
                                'edit' => 'admin-categories.edit',
                                'update' => 'admin-categories.update',
                                'destroy' => 'admin-categories.destroy',
                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Brands
                        |--------------------------------------------------------------------------
                        */

                        Route::resource(
                            'admin-brands',
                            BrandController::class,
                        )
                            ->parameters([
                                'admin-brands' => 'brand',
                            ])
                            ->names([
                                'index' => 'admin-brands',
                                'create' => 'admin-brands.create',
                                'store' => 'admin-brands.store',
                                'show' => 'admin-brands.show',
                                'edit' => 'admin-brands.edit',
                                'update' => 'admin-brands.update',
                                'destroy' => 'admin-brands.destroy',
                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Attributes
                        |--------------------------------------------------------------------------
                        */

                        Route::resource(
                            'admin-attributes',
                            AttributeController::class,
                        )
                            ->parameters([
                                'admin-attributes' => 'attribute',
                            ])
                            ->names([
                                'index' => 'admin-attributes',
                                'create' => 'admin-attributes.create',
                                'store' => 'admin-attributes.store',
                                'show' => 'admin-attributes.show',
                                'edit' => 'admin-attributes.edit',
                                'update' => 'admin-attributes.update',
                                'destroy' => 'admin-attributes.destroy',
                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Coupons / Promo Codes
                        |--------------------------------------------------------------------------
                        */

                        Route::resource(
                            'admin-coupons',
                            CouponController::class,
                        )
                            ->parameters([
                                'admin-coupons' => 'coupon',
                            ])
                            ->names([
                                'index' => 'admin-coupons',
                                'create' => 'admin-coupons.create',
                                'store' => 'admin-coupons.store',
                                'show' => 'admin-coupons.show',
                                'edit' => 'admin-coupons.edit',
                                'update' => 'admin-coupons.update',
                                'destroy' => 'admin-coupons.destroy',
                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Inventory
                        |--------------------------------------------------------------------------
                        */

                        Route::prefix('inventory')
                            ->controller(InventoryController::class)
                            ->group(function (): void {
                                Route::get(
                                    '/',
                                    'index',
                                )->name('admin-inventory');

                                Route::get(
                                    '/low-stock',
                                    'lowStock',
                                )->name('admin-inventory-low-stock');

                                Route::get(
                                    '/out-of-stock',
                                    'outOfStock',
                                )->name('admin-inventory-out-of-stock');

                                Route::get(
                                    '/product/{product}/edit',
                                    'editProduct',
                                )->name('admin-inventory-product-edit');

                                Route::put(
                                    '/product/{product}',
                                    'updateProduct',
                                )->name('admin-inventory-product-update');

                                Route::get(
                                    '/variant/{variant}/edit',
                                    'editVariant',
                                )->name('admin-inventory-variant-edit');

                                Route::put(
                                    '/variant/{variant}',
                                    'updateVariant',
                                )->name('admin-inventory-variant-update');
                            });


                        /*
                        |--------------------------------------------------------------------------
                        | Orders
                        |--------------------------------------------------------------------------
                        */

                        Route::get(
                            '/admin-orders',
                            [AdminOrderController::class, 'index'],
                        )
                            ->middleware('permission:view-orders')
                            ->name('admin-orders');

                        Route::get(
                            '/admin-orders/{order}',
                            [AdminOrderController::class, 'show'],
                        )
                            ->middleware('permission:view-order-details')
                            ->name('admin-order-details');

                        Route::get(
                            '/admin-orders/{order}/print',
                            [AdminOrderController::class, 'print'],
                        )
                            ->middleware('permission:view-order-details')
                            ->name('admin-orders.print');

                        Route::patch(
                            '/admin-orders/{order}/status',
                            [AdminOrderController::class, 'updateStatus'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('admin-order-status');

                        Route::post(
                            '/admin-orders/{order}/cancel',
                            [AdminOrderController::class, 'cancel'],
                        )
                            ->middleware('permission:cancel-orders')
                            ->name('admin-order-cancel');

                        /*
                        |--------------------------------------------------------------------------
                        | Order Refunds
                        |--------------------------------------------------------------------------
                        */

                        Route::get(
                            '/admin-refund-requests',
                            [AdminRefundController::class, 'index'],
                        )
                            ->middleware('permission:view-orders')
                            ->name('admin-refunds');

                        Route::get(
                            '/admin-refund-requests/{refundRequest}',
                            [AdminRefundController::class, 'show'],
                        )
                            ->middleware('permission:view-order-details')
                            ->name('admin-refunds.show');

                        Route::patch(
                            '/admin-refund-requests/{refundRequest}/approve',
                            [AdminRefundController::class, 'approve'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('admin-refunds.approve');

                        Route::patch(
                            '/admin-refund-requests/{refundRequest}/reject',
                            [AdminRefundController::class, 'reject'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('admin-refunds.reject');

                        Route::post(
                            '/admin-refund-requests/{refundRequest}/process',
                            [AdminRefundController::class, 'refund'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('admin-refunds.process');

                        Route::patch(
                            '/admin-refund-requests/{refundRequest}/deduction',
                            [AdminRefundController::class, 'updateDeduction'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('admin-refunds.deduction');


                        /*
                        |--------------------------------------------------------------------------
                        | Ecommerce Payments
                        |--------------------------------------------------------------------------
                        */

                        Route::prefix('payments')
                            ->controller(EcommercePaymentController::class)
                            ->group(function (): void {
                                /*
                                |--------------------------------------------------------------------------
                                | Payment Overview
                                |--------------------------------------------------------------------------
                                */

                                Route::get(
                                    '/',
                                    'index',
                                )->name('admin-ecommerce-payments');


                                /*
                                |--------------------------------------------------------------------------
                                | Refund Requests
                                |--------------------------------------------------------------------------
                                */

                                Route::get(
                                    '/refund-requests',
                                    'refundRequests',
                                )->name('admin-ecommerce-payment-refund-requests');

                                Route::get(
                                    '/refund-requests/{refundRequest}',
                                    'showRefundRequest',
                                )->name('admin-ecommerce-payment-refund-request-show');

                                Route::put(
                                    '/refund-requests/{refundRequest}/approve',
                                    'approveRefund',
                                )->name('admin-ecommerce-payment-refund-approve');

                                Route::put(
                                    '/refund-requests/{refundRequest}/reject',
                                    'rejectRefund',
                                )->name('admin-ecommerce-payment-refund-reject');


                                /*
                                |--------------------------------------------------------------------------
                                | Payment Details
                                |--------------------------------------------------------------------------
                                */

                                Route::get(
                                    '/{order}',
                                    'show',
                                )->name('admin-ecommerce-payment-show');
                            });


                        /*
                        |--------------------------------------------------------------------------
                        | Ecommerce Shipments
                        |--------------------------------------------------------------------------
                        */

                        Route::get(
                            '/ecommerce-shipments',
                            [ShipmentController::class, 'index'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('ecommerce-shipments');

                        Route::get(
                            '/ecommerce-shipments/create/{order}',
                            [ShipmentController::class, 'create'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('ecommerce-shipments.create');

                        Route::post(
                            '/ecommerce-shipments',
                            [ShipmentController::class, 'store'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('ecommerce-shipments.store');

                        Route::get(
                            '/ecommerce-shipments/{shipment}',
                            [ShipmentController::class, 'show'],
                        )
                            ->middleware('permission:view-orders')
                            ->name('ecommerce-shipments.show');

                        Route::patch(
                            '/ecommerce-shipments/{shipment}/status',
                            [ShipmentController::class, 'updateStatus'],
                        )
                            ->middleware('permission:update-orders')
                            ->name('ecommerce-shipments.update-status');

                    });


                /*
                |--------------------------------------------------------------------------
                | CENTRAL REPORTS
                |--------------------------------------------------------------------------
                */

                Route::prefix('reports')
                    ->group(function (): void {

                        Route::get(
                            '/ecommerce',
                            [
                                EcommerceReportController::class,
                                'index',
                            ],
                        )
                            ->middleware('permission:view-ecommerce-reports')
                            ->name('reports.ecommerce');

                        Route::get(
                            '/ecommerce/export/daily',
                            [
                                EcommerceReportController::class,
                                'exportDaily',
                            ],
                        )
                            ->middleware('permission:view-ecommerce-reports')
                            ->name('reports.ecommerce.export.daily');

                        Route::get(
                            '/ecommerce/export/products',
                            [
                                EcommerceReportController::class,
                                'exportProducts',
                            ],
                        )
                            ->middleware('permission:view-ecommerce-reports')
                            ->name('reports.ecommerce.export.products');

                        Route::get(
                            '/ecommerce/export/categories',
                            [
                                EcommerceReportController::class,
                                'exportCategories',
                            ],
                        )
                            ->middleware('permission:view-ecommerce-reports')
                            ->name('reports.ecommerce.export.categories');

                        Route::get('/smart-buy', [
                            SmartBuyReportController::class, 'index',
                        ])
                            ->middleware('permission:view-smart-buy-reports')
                            ->name('reports.smart-buy');

                        Route::get('/smart-buy/reports/export', [
                            SmartBuyReportController::class,
                            'export',
                        ])->name('reports.smart-buy.export');

                    });


                /*
                |--------------------------------------------------------------------------
                | Settings
                |--------------------------------------------------------------------------
                */

                Route::prefix('settings')
                    ->group(function (): void {

                        Route::get(
                            '/',
                            [GeneralSettingsController::class, 'index']
                        )
                            ->middleware('permission:view-settings')
                            ->name('settings');

                        Route::put(
                            '/',
                            [GeneralSettingsController::class, 'update']
                        )
                            ->middleware('permission:update-settings')
                            ->name('settings.update');

                        Route::get(
                            '/audit-logs',
                            function () {
                                return view(
                                    'backend.pages.settings.audit-logs.index'
                                );
                            }
                        )
                            ->middleware('permission:view-audit-logs')
                            ->name('settings-audit-logs');

                        Route::get(
                            '/audit-logs/{auditLog}',
                            function ($auditLog) {
                                return view(
                                    'backend.pages.settings.audit-logs.details',
                                    compact('auditLog')
                                );
                            }
                        )
                            ->middleware('permission:view-audit-log-details')
                            ->name('settings-audit-log-details');

                    });

            });

    });
