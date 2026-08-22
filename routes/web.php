<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Customer\MySmartBuyController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Front-End Routes
|--------------------------------------------------------------------------
|
| Public website routes.
|
*/

Route::view(
    '/',
    'frontend.pages.home.index'
)->name('home');


/*
|--------------------------------------------------------------------------
| Shop
|--------------------------------------------------------------------------
*/

Route::view(
    '/shop',
    'frontend.pages.shop.index'
)->name('shop');


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

Route::view(
    '/tracking',
    'frontend.pages.tracking.index'
)->name('tracking');


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


                /*
                |--------------------------------------------------------------------------
                | Admin
                |--------------------------------------------------------------------------
                */

                if ($user->roles()->where('slug', 'admin')->exists()) {

                    return redirect()->route('admin-dashboard');

                }


                /*
                |--------------------------------------------------------------------------
                | Customer / Client
                |--------------------------------------------------------------------------
                */

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
        |
        | Customer ecommerce workflow:
        |
        | Shop
        |   ↓
        | Product
        |   ↓
        | Cart
        |   ↓
        | Checkout
        |   ↓
        | Payment
        |   ↓
        | Order
        |   ↓
        | Shipment
        |   ↓
        | Tracking
        |
        */


        /*
        |--------------------------------------------------------------------------
        | Shop
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/shop',
            'backend.pages.ecommerce.customer.shop'
        )
            ->middleware('permission:view-products')
            ->name('customer-shop');


        /*
        |--------------------------------------------------------------------------
        | Product Details
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Cart
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/cart',
            'backend.pages.ecommerce.customer.cart'
        )
            ->middleware('permission:view-cart')
            ->name('cart');


        /*
        |--------------------------------------------------------------------------
        | Checkout
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/checkout',
            'backend.pages.ecommerce.customer.checkout'
        )
            ->middleware('permission:create-order')
            ->name('checkout');


        /*
        |--------------------------------------------------------------------------
        | Ecommerce Payment
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/checkout/payment',
            'backend.pages.ecommerce.customer.payment'
        )
            ->middleware('permission:view-payments')
            ->name('ecommerce-payment');


        /*
        |--------------------------------------------------------------------------
        | Payment Success
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/checkout/payment/success',
            'backend.pages.ecommerce.customer.payment-success'
        )
            ->middleware('permission:view-payments')
            ->name('ecommerce-payment-success');


        /*
        |--------------------------------------------------------------------------
        | Payment Failed
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/checkout/payment/failed',
            'backend.pages.ecommerce.customer.payment-failed'
        )
            ->middleware('permission:view-payments')
            ->name('ecommerce-payment-failed');


        /*
        |--------------------------------------------------------------------------
        | My Orders
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/orders',
            'backend.pages.ecommerce.customer.orders'
        )
            ->middleware('permission:view-orders')
            ->name('orders');


        /*
        |--------------------------------------------------------------------------
        | Order Details
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Ecommerce Shipment
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Ecommerce Tracking
        |--------------------------------------------------------------------------
        */

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
        |
        | Customer workflow:
        |
        | My Smart Buy
        |     ↓
        | Create Request
        |     ↓
        | Request Submitted
        |     ↓
        | Admin Review
        |     ↓
        | Quote
        |     ↓
        | Accept Quote
        |     ↓
        | Payment
        |     ↓
        | Payment Success
        |     ↓
        | Admin Purchase
        |     ↓
        | Shipment
        |     ↓
        | Tracking
        |     ↓
        | Completed
        |
        */


        Route::prefix('my-smart-buy')
            ->group(function () {


                /*
                |--------------------------------------------------------------------------
                | My Smart Buy Requests
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/',
                    function () {

                        return view(
                            'backend.pages.my-smart-buy.my-requests'
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy')
                    ->name('my-smart-buy');


                /*
                |--------------------------------------------------------------------------
                | Create Smart Buy Request
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/create',
                    [MySmartBuyController::class, 'create']
                )
                    ->middleware('permission:create-smart-buy')
                    ->name('my-smart-buy-create');


                Route::post(
                    '/create',
                    [MySmartBuyController::class, 'store']
                )
                    ->middleware('permission:create-smart-buy')
                    ->name('my-smart-buy-store');


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Request Details
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                | Keep this dynamic route LAST.
                |
                */

                Route::get(
                    '/{id}',
                    [MySmartBuyController::class, 'details']
                )
                    ->middleware('permission:view-smart-buy-details')
                    ->name('my-smart-buy-details');


                /*
                |--------------------------------------------------------------------------
                | Request Confirmation
                |--------------------------------------------------------------------------
                |
                | Shown immediately after the customer submits
                | a Smart Buy request.
                |
                */

                Route::get(
                    '/confirmation/{smartBuy}',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.my-smart-buy.confirmation',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy-details')
                    ->name('smart-buy-confirmation');


                /*
                |--------------------------------------------------------------------------
                | Quote
                |--------------------------------------------------------------------------
                |
                | Customer can view the quote prepared by admin.
                |
                */

                Route::get(
                    '/{smartBuy}/quote',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.my-smart-buy.quote',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy-quote')
                    ->name('smart-buy-quote');


                /*
                |--------------------------------------------------------------------------
                | Accept Quote
                |--------------------------------------------------------------------------
                |
                | Customer accepts the quote and proceeds to payment.
                |
                */

                Route::post(
                    '/{smartBuy}/quote/accept',
                    function ($smartBuy) {

                        return redirect()
                            ->route(
                                'smart-buy-payment',
                                $smartBuy
                            )
                            ->with(
                                'success',
                                'Quote accepted successfully. Please complete your payment.'
                            );

                    }
                )
                    ->middleware('permission:accept-smart-buy-quote')
                    ->name('smart-buy-quote-accept');


                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/{smartBuy}/payment',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.my-smart-buy.payment',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy-payment')
                    ->name('smart-buy-payment');


                /*
                |--------------------------------------------------------------------------
                | Payment Success
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/{smartBuy}/payment/success',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.my-smart-buy.payment-success',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy-payment')
                    ->name('smart-buy-payment-success');


                /*
                |--------------------------------------------------------------------------
                | Payment Failed
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/{smartBuy}/payment/failed',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.my-smart-buy.payment-failed',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy-payment')
                    ->name('smart-buy-payment-failed');


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Tracking
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/{smartBuy}/tracking',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.my-smart-buy.tracking',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy-tracking')
                    ->name('smart-buy-tracking');

            });


        /*
        |--------------------------------------------------------------------------
        | SMART BUY MANAGEMENT - ADMIN
        |--------------------------------------------------------------------------
        |
        | Admin workflow:
        |
        | Smart Buy Requests
        |     ↓
        | Request Details
        |     ↓
        | Prepare Quote
        |     ↓
        | Customer Accepts + Pays
        |     ↓
        | Purchase Product
        |     ↓
        | Shipment
        |     ↓
        | Tracking
        |
        */


        Route::prefix('smart-buy')
            ->group(function () {


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Request List
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/',
                    function () {

                        return view(
                            'backend.pages.smart-buy.index'
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy')
                    ->name('smart-buy');


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Payments
                |--------------------------------------------------------------------------
                |
                | Module-specific Smart Buy payment page.
                |
                | Keep this BEFORE /{smartBuy}
                |
                */

                Route::view(
                    '/payments',
                    'backend.pages.smart-buy.payments'
                )
                    ->middleware('permission:view-smart-buy-payment')
                    ->name('smart-buy-admin-payments');


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Edit
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/{smartBuy}/edit',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.smart-buy.edit',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:edit-smart-buy')
                    ->name('smart-buy-edit');


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Quote
                |--------------------------------------------------------------------------
                |
                | Admin prepares and sends quote to customer.
                |
                */

                Route::get(
                    '/{smartBuy}/quote',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.smart-buy.quote',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:create-smart-buy-quote')
                    ->name('smart-buy-admin-quote');


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Purchase
                |--------------------------------------------------------------------------
                |
                | Admin purchases the requested product
                | after successful customer payment.
                |
                */

                Route::get(
                    '/{smartBuy}/purchase',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.smart-buy.purchase',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:purchase-smart-buy')
                    ->name('smart-buy-purchase');


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Shipment
                |--------------------------------------------------------------------------
                |
                | Admin creates/manages shipment after product purchase.
                |
                */

                Route::get(
                    '/{smartBuy}/shipment',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.smart-buy.shipment',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:create-smart-buy-shipment')
                    ->name('smart-buy-shipment');


                /*
                |--------------------------------------------------------------------------
                | Smart Buy Details
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                | Keep this dynamic route LAST.
                |
                */

                Route::get(
                    '/{smartBuy}',
                    function ($smartBuy) {

                        return view(
                            'backend.pages.smart-buy.details',
                            compact('smartBuy')
                        );

                    }
                )
                    ->middleware('permission:view-smart-buy-details')
                    ->name('smart-buy-details');

            });


        /*
        |--------------------------------------------------------------------------
        | ACCOUNT
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | Account Payments
        |--------------------------------------------------------------------------
        |
        | Customer payment history.
        |
        */

        Route::view(
            '/account/payments',
            'backend.pages.account.payments'
        )
            ->middleware('permission:view-payments')
            ->name('account-payments');


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
        |
        | Admin only.
        |
        */

        Route::middleware('role:admin')->group(function () {


            /*
            |--------------------------------------------------------------------------
            | USER MANAGEMENT
            |--------------------------------------------------------------------------
            */


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

            Route::prefix('ecommerce')->group(function () {


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

                Route::prefix('inventory')->group(function () {


                    /*
                    |--------------------------------------------------------------------------
                    | All Inventory
                    |--------------------------------------------------------------------------
                    */

                    Route::view(
                        '/',
                        'backend.pages.ecommerce.admin.inventory.index'
                    )->name('admin-inventory');


                    /*
                    |--------------------------------------------------------------------------
                    | Low Stock
                    |--------------------------------------------------------------------------
                    */

                    Route::view(
                        '/low-stock',
                        'backend.pages.ecommerce.admin.inventory.low-stock'
                    )->name('admin-inventory-low-stock');


                    /*
                    |--------------------------------------------------------------------------
                    | Out Of Stock
                    |--------------------------------------------------------------------------
                    */

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
                |
                | Module-specific ecommerce payment page.
                |
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

                Route::prefix('shipments')->group(function () {

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
            |
            | Admin central payment management.
            |
            | Sidebar:
            |
            | Payments
            |   ├── All Payments
            |   ├── Ecommerce Payments
            |   ├── Smart Buy Payments
            |   └── Failed Payments
            |
            */

            Route::prefix('payments')
                ->group(function () {


                    /*
                    |--------------------------------------------------------------------------
                    | All Payments
                    |--------------------------------------------------------------------------
                    */

                    Route::view(
                        '/',
                        'backend.pages.payments.index'
                    )
                        ->middleware('permission:view-payments')
                        ->name('payments');


                    /*
                    |--------------------------------------------------------------------------
                    | Ecommerce Payments
                    |--------------------------------------------------------------------------
                    */

                    Route::view(
                        '/ecommerce',
                        'backend.pages.payments.ecommerce'
                    )
                        ->middleware('permission:view-ecommerce-payments')
                        ->name('payments-ecommerce');


                    /*
                    |--------------------------------------------------------------------------
                    | Smart Buy Payments
                    |--------------------------------------------------------------------------
                    */

                    Route::view(
                        '/smart-buy',
                        'backend.pages.payments.smart-buy'
                    )
                        ->middleware('permission:view-smart-buy-payments')
                        ->name('payments-smart-buy');


                    /*
                    |--------------------------------------------------------------------------
                    | Failed Payments
                    |--------------------------------------------------------------------------
                    */

                    Route::view(
                        '/failed',
                        'backend.pages.payments.failed'
                    )
                        ->middleware('permission:view-failed-payments')
                        ->name('payments-failed');


                    /*
                    |--------------------------------------------------------------------------
                    | Payment Details
                    |--------------------------------------------------------------------------
                    |
                    | IMPORTANT:
                    | Keep this dynamic route LAST.
                    |
                    */

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
            |
            | Admin central business reports.
            |
            | Sidebar:
            |
            | Reports
            |   ├── Overview
            |   ├── Ecommerce
            |   └── Smart Buy
            |
            */

            Route::prefix('reports')
                ->group(function () {


                    /*
                    |--------------------------------------------------------------------------
                    | Reports Overview
                    |--------------------------------------------------------------------------
                    */

                    Route::view(
                        '/',
                        'backend.pages.reports.index'
                    )
                        ->middleware('permission:view-reports')
                        ->name('reports');


                    /*
                    |--------------------------------------------------------------------------
                    | Ecommerce Reports
                    |--------------------------------------------------------------------------
                    */

                    Route::view(
                        '/ecommerce',
                        'backend.pages.reports.ecommerce'
                    )
                        ->middleware('permission:view-ecommerce-reports')
                        ->name('reports-ecommerce');


                    /*
                    |--------------------------------------------------------------------------
                    | Smart Buy Reports
                    |--------------------------------------------------------------------------
                    */

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

                    /*
                    |--------------------------------------------------------------------------
                    | General Settings
                    |--------------------------------------------------------------------------
                    */

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


                    /*
                    |--------------------------------------------------------------------------
                    | Ecommerce Settings
                    |--------------------------------------------------------------------------
                    */

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


                    /*
                    |--------------------------------------------------------------------------
                    | Smart Buy Settings
                    |--------------------------------------------------------------------------
                    */

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


                    /*
                    |--------------------------------------------------------------------------
                    | Audit Logs
                    |--------------------------------------------------------------------------
                    */

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


                    /*
                    |--------------------------------------------------------------------------
                    | Audit Log Details
                    |--------------------------------------------------------------------------
                    */

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

