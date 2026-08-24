<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SmartBuyController;
use App\Http\Controllers\Backend\SmartBuyPaymentController;
use App\Http\Controllers\Backend\SmartBuyQuoteController;
use App\Http\Controllers\Backend\SmartBuyShipmentController;
use App\Http\Controllers\Backend\TrackingController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Customer\MySmartBuyController;
use App\Http\Controllers\Customer\MySmartBuyPaymentController;
use App\Http\Controllers\Customer\MySmartBuyQuoteController;
use App\Http\Controllers\Customer\MySmartBuyTrackingController;
use App\Http\Controllers\Frontend\FrontendTrackingController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Front-End Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'frontend.pages.home.index')->name('home');


/*
|--------------------------------------------------------------------------
| Shop
|--------------------------------------------------------------------------
*/

Route::view('/shop', 'frontend.pages.shop.index')->name('shop');

Route::view(
    '/shop/{product}',
    'frontend.pages.shop.details'
)->name('product-details');


/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

Route::view(
    '/categories',
    'frontend.pages.categories.index'
)->name('categories');

Route::view(
    '/categories/{category}',
    'frontend.pages.categories.details'
)->name('category-details');


/*
|--------------------------------------------------------------------------
| Smart Buy
|--------------------------------------------------------------------------
*/

Route::view(
    '/smart-buy',
    'frontend.pages.smart-buy.index'
)->name('smart-buy-public');


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

Route::middleware('guest')->group(function () {

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

    Route::get(
        '/register',
        [RegisterController::class, 'showRegister']
    )->name('register');

    Route::post(
        '/register',
        [RegisterController::class, 'register']
    )->name('register.submit');


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


/*
|--------------------------------------------------------------------------
| Authenticated Portal Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('portal')
    ->group(function () {


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
            function () {

                $user = auth()->user();

                if ($user->roles()->where('slug', 'admin')->exists()) {
                    return redirect()->route('admin-dashboard');
                }

                return view(
                    'backend.pages.dashboard.customer'
                );

            }
        )
            ->middleware('permission:view-dashboard')
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/admin/dashboard',
            function () {
                return view(
                    'backend.pages.dashboard.admin'
                );
            }
        )
            ->middleware('role:admin')
            ->name('admin-dashboard');


        /*
        |--------------------------------------------------------------------------
        | Tracking
        |--------------------------------------------------------------------------
        */

        // Show tracking page
        Route::get(
            '/tracking',
            [TrackingController::class, 'index']
        )->name('global-tracking');


        // Search tracking
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
            ->group(function () {

                Route::get(
                    '/',
                    [ProfileController::class, 'index']
                )->name('profile');

                Route::put(
                    '/',
                    [ProfileController::class, 'update']
                )->name('profile.update');

            });


        /*
        |--------------------------------------------------------------------------
        | ECOMMERCE - CUSTOMER
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/shop',
            'backend.pages.ecommerce.customer.shop'
        )
            ->middleware('permission:view-products')
            ->name('customer-shop');


        Route::get(
            '/shop/{product}',
            function ($product) {

                return view(
                    'backend.pages.ecommerce.customer.product-details',
                    compact('product')
                );

            }
        )
            ->middleware('permission:view-products')
            ->name('customer-product-details');


        Route::view(
            '/cart',
            'backend.pages.ecommerce.customer.cart'
        )
            ->middleware('permission:view-cart')
            ->name('cart');


        Route::view(
            '/checkout',
            'backend.pages.ecommerce.customer.checkout'
        )
            ->middleware('permission:create-order')
            ->name('checkout');


        Route::view(
            '/checkout/payment',
            'backend.pages.ecommerce.customer.payment'
        )
            ->middleware('permission:view-payments')
            ->name('ecommerce-payment');


        Route::view(
            '/checkout/payment/success',
            'backend.pages.ecommerce.customer.payment-success'
        )
            ->middleware('permission:view-payments')
            ->name('ecommerce-payment-success');


        Route::view(
            '/checkout/payment/failed',
            'backend.pages.ecommerce.customer.payment-failed'
        )
            ->middleware('permission:view-payments')
            ->name('ecommerce-payment-failed');


        Route::view(
            '/orders',
            'backend.pages.ecommerce.customer.orders'
        )
            ->middleware('permission:view-orders')
            ->name('orders');


        Route::get(
            '/orders/{order}',
            function ($order) {

                return view(
                    'backend.pages.ecommerce.customer.order-details',
                    compact('order')
                );

            }
        )
            ->middleware('permission:view-order-details')
            ->name('order-details');


        Route::get(
            '/orders/{order}/shipment',
            function ($order) {

                return view(
                    'backend.pages.ecommerce.customer.shipment',
                    compact('order')
                );

            }
        )
            ->middleware('permission:view-ecommerce-shipments')
            ->name('ecommerce-shipment');


        Route::get(
            '/orders/{order}/tracking',
            function ($order) {

                return view(
                    'backend.pages.ecommerce.customer.tracking',
                    compact('order')
                );

            }
        )
            ->middleware('permission:view-ecommerce-tracking')
            ->name('ecommerce-tracking');


        /*
        |--------------------------------------------------------------------------
        | SMART BUY - CUSTOMER
        |--------------------------------------------------------------------------
        */

        Route::prefix('my-smart-buy')
            ->group(function () {

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


                // Dynamic route MUST be last
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
            ->group(function () {

                /*
                |--------------------------------------------------------------------------
                | Smart Buy Index
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/',
                    [SmartBuyController::class, 'index']
                )
                    ->middleware('permission:smart-buy')
                    ->name('smart-buy');

                /*
                |--------------------------------------------------------------------------
                | Smart Buy Details
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/{smartBuy}',
                    [SmartBuyController::class, 'show']
                )
                    ->middleware('permission:smart-buy-details')
                    ->name('smart-buy.details');

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                Route::put(
                    '/{smartBuy}/status',
                    [SmartBuyController::class, 'updateStatus']
                )
                    ->middleware('permission:smart-buy-status')
                    ->name('smart-buy.status.update');


                /*
                |--------------------------------------------------------------------------
                | Quote
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Shipment
                |--------------------------------------------------------------------------
                */

                /**
                 * Create Shipment Form
                 */
                Route::get(
                    '/{smartBuy}/shipment/create',
                    [SmartBuyShipmentController::class, 'create']
                )
                    ->middleware('permission:manage-smart-buy-shipment')
                    ->name('smart-buy.shipment.create');


                /**
                 * Store Shipment
                 */
                Route::post(
                    '/{smartBuy}/shipment',
                    [SmartBuyShipmentController::class, 'store']
                )
                    ->middleware('permission:manage-smart-buy-shipment')
                    ->name('smart-buy.shipment.store');


                /**
                 * View Shipment
                 */
                Route::get(
                    '/shipment/{shipment}',
                    [SmartBuyShipmentController::class, 'show']
                )
                    ->middleware('permission:manage-smart-buy-shipment')
                    ->name('smart-buy.shipment.show');


                /**
                 * Edit Shipment
                 */
                Route::get(
                    '/shipment/{shipment}/edit',
                    [SmartBuyShipmentController::class, 'edit']
                )
                    ->middleware('permission:manage-smart-buy-shipment')
                    ->name('smart-buy.shipment.edit');


                /**
                 * Update Shipment
                 */
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
            ->group(function () {


                /*
                |--------------------------------------------------------------------------
                | Users
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Roles
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Role Permissions
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/roles/{role}/permissions',
                    [RoleController::class, 'permissions']
                )->name('role-permissions');


                Route::put(
                    '/roles/{role}/permissions',
                    [RoleController::class, 'updatePermissions']
                )->name('role-permissions.update');


                /*
                |--------------------------------------------------------------------------
                | Permissions
                |--------------------------------------------------------------------------
                */

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
                    ->group(function () {


                        /*
                        |--------------------------------------------------------------------------
                        | Products
                        |--------------------------------------------------------------------------
                        */

                        Route::view(
                            '/products',
                            'backend.pages.ecommerce.admin.products.index'
                        )->name('admin-products');


                        Route::view(
                            '/products/create',
                            'backend.pages.ecommerce.admin.products.create'
                        )->name('admin-product-create');


                        Route::get(
                            '/products/{product}',
                            function ($product) {
                                return view(
                                    'backend.pages.ecommerce.admin.products.details',
                                    compact('product')
                                );
                            }
                        )->name('admin-product-details');


                        Route::get(
                            '/products/{product}/edit',
                            function ($product) {
                                return view(
                                    'backend.pages.ecommerce.admin.products.edit',
                                    compact('product')
                                );
                            }
                        )->name('admin-product-edit');


                        /*
                        |--------------------------------------------------------------------------
                        | Categories
                        |--------------------------------------------------------------------------
                        */

                        Route::view(
                            '/categories',
                            'backend.pages.ecommerce.admin.categories.index'
                        )->name('admin-categories');


                        Route::view(
                            '/categories/create',
                            'backend.pages.ecommerce.admin.categories.create'
                        )->name('admin-category-create');


                        Route::get(
                            '/categories/{category}',
                            function ($category) {
                                return view(
                                    'backend.pages.ecommerce.admin.categories.details',
                                    compact('category')
                                );
                            }
                        )->name('admin-category-details');


                        Route::get(
                            '/categories/{category}/edit',
                            function ($category) {
                                return view(
                                    'backend.pages.ecommerce.admin.categories.edit',
                                    compact('category')
                                );
                            }
                        )->name('admin-category-edit');


                        /*
                        |--------------------------------------------------------------------------
                        | Inventory
                        |--------------------------------------------------------------------------
                        */

                        Route::prefix('inventory')
                            ->group(function () {

                                Route::view(
                                    '/',
                                    'backend.pages.ecommerce.admin.inventory.index'
                                )->name('admin-inventory');


                                Route::view(
                                    '/low-stock',
                                    'backend.pages.ecommerce.admin.inventory.low-stock'
                                )->name('admin-inventory-low-stock');


                                Route::view(
                                    '/out-of-stock',
                                    'backend.pages.ecommerce.admin.inventory.out-of-stock'
                                )->name('admin-inventory-out-of-stock');

                            });


                        /*
                        |--------------------------------------------------------------------------
                        | Orders
                        |--------------------------------------------------------------------------
                        */

                        Route::view(
                            '/orders',
                            'backend.pages.ecommerce.admin.orders.index'
                        )->name('admin-orders');


                        Route::get(
                            '/orders/{order}',
                            function ($order) {
                                return view(
                                    'backend.pages.ecommerce.admin.orders.details',
                                    compact('order')
                                );
                            }
                        )->name('admin-order-details');


                        /*
                        |--------------------------------------------------------------------------
                        | Ecommerce Payments
                        |--------------------------------------------------------------------------
                        */

                        Route::view(
                            '/payments',
                            'backend.pages.ecommerce.admin.payments.index'
                        )->name('admin-ecommerce-payments');


                        /*
                        |--------------------------------------------------------------------------
                        | Ecommerce Shipments
                        |--------------------------------------------------------------------------
                        */

                        Route::prefix('shipments')
                            ->group(function () {

                                Route::view(
                                    '/',
                                    'backend.pages.ecommerce.admin.shipments.index'
                                )->name('ecommerce-shipments');


                                Route::get(
                                    '/create',
                                    function () {
                                        return view(
                                            'backend.pages.ecommerce.admin.shipments.create'
                                        );
                                    }
                                )->name('ecommerce-shipment-create');


                                Route::get(
                                    '/{shipment}',
                                    function ($shipment) {
                                        return view(
                                            'backend.pages.ecommerce.admin.shipments.details',
                                            compact('shipment')
                                        );
                                    }
                                )->name('ecommerce-shipment-details');

                            });

                    });


                /*
                |--------------------------------------------------------------------------
                | CENTRAL PAYMENTS
                |--------------------------------------------------------------------------
                */

                Route::prefix('payments')
                    ->group(function () {

                        Route::view(
                            '/',
                            'backend.pages.payments.index'
                        )
                            ->middleware('permission:view-payments')
                            ->name('payments');


                        Route::view(
                            '/ecommerce',
                            'backend.pages.payments.ecommerce'
                        )
                            ->middleware('permission:view-ecommerce-payments')
                            ->name('payments-ecommerce');


                        Route::view(
                            '/smart-buy',
                            'backend.pages.payments.smart-buy'
                        )
                            ->middleware('permission:view-smart-buy-payments')
                            ->name('payments-smart-buy');


                        Route::view(
                            '/failed',
                            'backend.pages.payments.failed'
                        )
                            ->middleware('permission:view-failed-payments')
                            ->name('payments-failed');


                        // Dynamic route MUST be last
                        Route::get(
                            '/{payment}',
                            function ($payment) {
                                return view(
                                    'backend.pages.payments.details',
                                    compact('payment')
                                );
                            }
                        )
                            ->middleware('permission:view-payment-details')
                            ->name('payments-details');

                    });


                /*
                |--------------------------------------------------------------------------
                | CENTRAL REPORTS
                |--------------------------------------------------------------------------
                */

                Route::prefix('reports')
                    ->group(function () {

                        Route::view(
                            '/',
                            'backend.pages.reports.index'
                        )
                            ->middleware('permission:view-reports')
                            ->name('reports');


                        Route::view(
                            '/ecommerce',
                            'backend.pages.reports.ecommerce'
                        )
                            ->middleware('permission:view-ecommerce-reports')
                            ->name('reports-ecommerce');


                        Route::view(
                            '/smart-buy',
                            'backend.pages.reports.smart-buy'
                        )
                            ->middleware('permission:view-smart-buy-reports')
                            ->name('reports-smart-buy');

                    });


                /*
                |--------------------------------------------------------------------------
                | Settings
                |--------------------------------------------------------------------------
                */

                Route::prefix('settings')
                    ->group(function () {

                        Route::get(
                            '/',
                            function () {
                                return view(
                                    'backend.pages.settings.general'
                                );
                            }
                        )
                            ->middleware('permission:view-settings')
                            ->name('settings');


                        Route::get(
                            '/ecommerce',
                            function () {
                                return view(
                                    'backend.pages.settings.ecommerce'
                                );
                            }
                        )
                            ->middleware('permission:view-ecommerce-settings')
                            ->name('settings-ecommerce');


                        Route::get(
                            '/smart-buy',
                            function () {
                                return view(
                                    'backend.pages.settings.smart-buy'
                                );
                            }
                        )
                            ->middleware('permission:view-smart-buy-settings')
                            ->name('settings-smart-buy');


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
