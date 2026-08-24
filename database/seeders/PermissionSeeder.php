<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Dashboard',
                'slug' => 'view-dashboard',
                'description' => 'Allow access to the dashboard.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Profile
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Profile',
                'slug' => 'view-profile',
                'description' => 'Allow users to view and update their profile.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Requests
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Requests',
                'slug' => 'view-requests',
                'description' => 'Allow viewing registered requests.',
            ],

            [
                'name' => 'Create Requests',
                'slug' => 'create-requests',
                'description' => 'Allow creating new requests.',
            ],

            [
                'name' => 'View Request Details',
                'slug' => 'view-request-details',
                'description' => 'Allow viewing request details.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Shipments
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Shipments',
                'slug' => 'view-shipments',
                'description' => 'Allow viewing shipments.',
            ],

            [
                'name' => 'View Shipment Details',
                'slug' => 'view-shipment-details',
                'description' => 'Allow viewing shipment details.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Tracking
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Tracking',
                'slug' => 'view-tracking',
                'description' => 'Allow access to shipment tracking.',
            ],

            [
                'name' => 'View Tracking Details',
                'slug' => 'view-tracking-details',
                'description' => 'Allow viewing tracking details.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Invoices
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Invoices',
                'slug' => 'view-invoices',
                'description' => 'Allow viewing invoices.',
            ],


            /*
            |--------------------------------------------------------------------------
            | General Payments
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Payments',
                'slug' => 'view-payments',
                'description' => 'Allow viewing payments.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - PRODUCTS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Products',
                'slug' => 'view-products',
                'description' => 'Allow users to view ecommerce products.',
            ],

            [
                'name' => 'Create Products',
                'slug' => 'create-products',
                'description' => 'Allow creating ecommerce products.',
            ],

            [
                'name' => 'Edit Products',
                'slug' => 'edit-products',
                'description' => 'Allow editing ecommerce products.',
            ],

            [
                'name' => 'Delete Products',
                'slug' => 'delete-products',
                'description' => 'Allow deleting ecommerce products.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - CATEGORIES
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Categories',
                'slug' => 'view-categories',
                'description' => 'Allow viewing ecommerce categories.',
            ],

            [
                'name' => 'Create Categories',
                'slug' => 'create-categories',
                'description' => 'Allow creating ecommerce categories.',
            ],

            [
                'name' => 'Edit Categories',
                'slug' => 'edit-categories',
                'description' => 'Allow editing ecommerce categories.',
            ],

            [
                'name' => 'Delete Categories',
                'slug' => 'delete-categories',
                'description' => 'Allow deleting ecommerce categories.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - CART
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Cart',
                'slug' => 'view-cart',
                'description' => 'Allow users to view their shopping cart.',
            ],

            [
                'name' => 'Manage Cart',
                'slug' => 'manage-cart',
                'description' => 'Allow users to manage cart items.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - ORDERS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'Create Order',
                'slug' => 'create-order',
                'description' => 'Allow users to create ecommerce orders.',
            ],

            [
                'name' => 'View Orders',
                'slug' => 'view-orders',
                'description' => 'Allow users to view ecommerce orders.',
            ],

            [
                'name' => 'View Order Details',
                'slug' => 'view-order-details',
                'description' => 'Allow viewing ecommerce order details.',
            ],

            [
                'name' => 'Manage Orders',
                'slug' => 'manage-orders',
                'description' => 'Allow managing ecommerce orders.',
            ],

            [
                'name' => 'Update Order Status',
                'slug' => 'update-order-status',
                'description' => 'Allow updating ecommerce order statuses.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - PAYMENTS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Ecommerce Payments',
                'slug' => 'view-ecommerce-payments',
                'description' => 'Allow viewing ecommerce payment information.',
            ],

            [
                'name' => 'Manage Ecommerce Payments',
                'slug' => 'manage-ecommerce-payments',
                'description' => 'Allow managing ecommerce payments.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - SHIPMENTS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Ecommerce Shipments',
                'slug' => 'view-ecommerce-shipments',
                'description' => 'Allow viewing ecommerce shipments.',
            ],

            [
                'name' => 'Create Ecommerce Shipments',
                'slug' => 'create-ecommerce-shipments',
                'description' => 'Allow creating ecommerce shipments.',
            ],

            [
                'name' => 'View Ecommerce Shipment Details',
                'slug' => 'view-ecommerce-shipment-details',
                'description' => 'Allow viewing ecommerce shipment details.',
            ],

            [
                'name' => 'Manage Ecommerce Shipments',
                'slug' => 'manage-ecommerce-shipments',
                'description' => 'Allow managing ecommerce shipments.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - TRACKING
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Ecommerce Tracking',
                'slug' => 'view-ecommerce-tracking',
                'description' => 'Allow viewing ecommerce shipment tracking.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - INVENTORY
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Inventory',
                'slug' => 'view-inventory',
                'description' => 'Allow viewing ecommerce inventory.',
            ],

            [
                'name' => 'Manage Inventory',
                'slug' => 'manage-inventory',
                'description' => 'Allow managing ecommerce inventory.',
            ],

            [
                'name' => 'View Low Stock',
                'slug' => 'view-low-stock',
                'description' => 'Allow viewing low stock products.',
            ],

            [
                'name' => 'View Out Of Stock',
                'slug' => 'view-out-of-stock',
                'description' => 'Allow viewing out of stock products.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - REPORTS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Ecommerce Reports',
                'slug' => 'view-ecommerce-reports',
                'description' => 'Allow viewing ecommerce reports.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - SETTINGS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Ecommerce Settings',
                'slug' => 'view-ecommerce-settings',
                'description' => 'Allow viewing ecommerce settings.',
            ],

            [
                'name' => 'Edit Ecommerce Settings',
                'slug' => 'edit-ecommerce-settings',
                'description' => 'Allow editing ecommerce settings.',
            ],


            /*
            |--------------------------------------------------------------------------
            | SMART BUY - CUSTOMER
            |--------------------------------------------------------------------------
            |
            | These slugs exactly match web.php:
            |
            | my-smart-buy
            | my-smart-buy-details
            | my-smart-buy-create
            | my-smart-buy-confirmation
            | my-smart-buy-quote
            | my-smart-buy-payment
            | my-smart-buy-tracking
            |
            */

            [
                'name' => 'View My Smart Buy',
                'slug' => 'my-smart-buy',
                'description' => 'Allow customers to view their Smart Buy requests.',
            ],

            [
                'name' => 'View My Smart Buy Details',
                'slug' => 'my-smart-buy-details',
                'description' => 'Allow customers to view Smart Buy request details.',
            ],

            [
                'name' => 'Create My Smart Buy',
                'slug' => 'my-smart-buy-create',
                'description' => 'Allow customers to create Smart Buy requests.',
            ],

            [
                'name' => 'View My Smart Buy Confirmation',
                'slug' => 'my-smart-buy-confirmation',
                'description' => 'Allow customers to view Smart Buy confirmation pages.',
            ],

            [
                'name' => 'Manage My Smart Buy Quote',
                'slug' => 'my-smart-buy-quote',
                'description' => 'Allow customers to view, accept or reject Smart Buy quotes.',
            ],

            [
                'name' => 'Manage My Smart Buy Payment',
                'slug' => 'my-smart-buy-payment',
                'description' => 'Allow customers to view and manage Smart Buy payments.',
            ],

            [
                'name' => 'View My Smart Buy Tracking',
                'slug' => 'my-smart-buy-tracking',
                'description' => 'Allow customers to view Smart Buy tracking.',
            ],


            /*
            |--------------------------------------------------------------------------
            | SMART BUY - ADMIN
            |--------------------------------------------------------------------------
            |
            | These slugs exactly match web.php:
            |
            | smart-buy
            | smart-buy-details
            | smart-buy-status
            | smart-buy-quote
            | smart-buy-quote-edit
            | smart-buy-payment
            | smart-buy-shipment
            |
            */

            [
                'name' => 'View Smart Buy',
                'slug' => 'smart-buy',
                'description' => 'Allow administrators to view Smart Buy requests.',
            ],

            [
                'name' => 'View Smart Buy Details',
                'slug' => 'smart-buy-details',
                'description' => 'Allow administrators to view Smart Buy request details.',
            ],

            [
                'name' => 'Update Smart Buy Status',
                'slug' => 'smart-buy-status',
                'description' => 'Allow administrators to update Smart Buy statuses.',
            ],

            [
                'name' => 'Manage Smart Buy Quote',
                'slug' => 'smart-buy-quote',
                'description' => 'Allow administrators to create and manage Smart Buy quotes.',
            ],

            [
                'name' => 'Edit Smart Buy Quote',
                'slug' => 'smart-buy-quote-edit',
                'description' => 'Allow administrators to edit Smart Buy quotes.',
            ],

            [
                'name' => 'Manage Smart Buy Payment',
                'slug' => 'smart-buy-payment',
                'description' => 'Allow administrators to manage Smart Buy payments.',
            ],

            [
                'name' => 'Manage Smart Buy Shipment',
                'slug' => 'smart-buy-shipment',
                'description' => 'Allow administrators to manage Smart Buy shipments.',
            ],


            /*
            |--------------------------------------------------------------------------
            | CENTRAL PAYMENTS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Payment Details',
                'slug' => 'view-payment-details',
                'description' => 'Allow viewing individual payment details.',
            ],

            [
                'name' => 'View Failed Payments',
                'slug' => 'view-failed-payments',
                'description' => 'Allow viewing failed payment transactions.',
            ],

            [
                'name' => 'View Smart Buy Payments',
                'slug' => 'view-smart-buy-payments',
                'description' => 'Allow viewing Smart Buy payments.',
            ],


            /*
            |--------------------------------------------------------------------------
            | REPORTS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Reports',
                'slug' => 'view-reports',
                'description' => 'Allow viewing central reports.',
            ],

            [
                'name' => 'View Smart Buy Reports',
                'slug' => 'view-smart-buy-reports',
                'description' => 'Allow viewing Smart Buy reports.',
            ],


            /*
            |--------------------------------------------------------------------------
            | USERS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Users',
                'slug' => 'view-users',
                'description' => 'Allow viewing users.',
            ],

            [
                'name' => 'Create Users',
                'slug' => 'create-users',
                'description' => 'Allow creating users.',
            ],

            [
                'name' => 'Edit Users',
                'slug' => 'edit-users',
                'description' => 'Allow editing users.',
            ],

            [
                'name' => 'Delete Users',
                'slug' => 'delete-users',
                'description' => 'Allow deleting users.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ROLES
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Roles',
                'slug' => 'view-roles',
                'description' => 'Allow viewing roles.',
            ],

            [
                'name' => 'Create Roles',
                'slug' => 'create-roles',
                'description' => 'Allow creating roles.',
            ],

            [
                'name' => 'Edit Roles',
                'slug' => 'edit-roles',
                'description' => 'Allow editing roles.',
            ],

            [
                'name' => 'Delete Roles',
                'slug' => 'delete-roles',
                'description' => 'Allow deleting roles.',
            ],

            [
                'name' => 'Manage Role Permissions',
                'slug' => 'manage-role-permissions',
                'description' => 'Allow managing permissions assigned to roles.',
            ],


            /*
            |--------------------------------------------------------------------------
            | PERMISSIONS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Permissions',
                'slug' => 'view-permissions',
                'description' => 'Allow viewing permissions.',
            ],

            [
                'name' => 'Create Permissions',
                'slug' => 'create-permissions',
                'description' => 'Allow creating permissions.',
            ],

            [
                'name' => 'Edit Permissions',
                'slug' => 'edit-permissions',
                'description' => 'Allow editing permissions.',
            ],

            [
                'name' => 'Delete Permissions',
                'slug' => 'delete-permissions',
                'description' => 'Allow deleting permissions.',
            ],


            /*
            |--------------------------------------------------------------------------
            | SERVICES
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Services',
                'slug' => 'view-services',
                'description' => 'Allow viewing services.',
            ],

            [
                'name' => 'Create Services',
                'slug' => 'create-services',
                'description' => 'Allow creating services.',
            ],

            [
                'name' => 'View Service Details',
                'slug' => 'view-service-details',
                'description' => 'Allow viewing service details.',
            ],

            [
                'name' => 'Edit Services',
                'slug' => 'edit-services',
                'description' => 'Allow editing services.',
            ],

            [
                'name' => 'Delete Services',
                'slug' => 'delete-services',
                'description' => 'Allow deleting services.',
            ],


            /*
            |--------------------------------------------------------------------------
            | CLIENTS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Clients',
                'slug' => 'view-clients',
                'description' => 'Allow viewing clients.',
            ],

            [
                'name' => 'Create Clients',
                'slug' => 'create-clients',
                'description' => 'Allow creating clients.',
            ],

            [
                'name' => 'View Client Details',
                'slug' => 'view-client-details',
                'description' => 'Allow viewing client details.',
            ],

            [
                'name' => 'Edit Clients',
                'slug' => 'edit-clients',
                'description' => 'Allow editing clients.',
            ],

            [
                'name' => 'Delete Clients',
                'slug' => 'delete-clients',
                'description' => 'Allow deleting clients.',
            ],


            /*
            |--------------------------------------------------------------------------
            | NOTIFICATIONS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Notifications',
                'slug' => 'view-notifications',
                'description' => 'Allow viewing user notifications.',
            ],


            /*
            |--------------------------------------------------------------------------
            | SETTINGS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Settings',
                'slug' => 'view-settings',
                'description' => 'Allow access to general settings.',
            ],

            [
                'name' => 'Edit Settings',
                'slug' => 'edit-settings',
                'description' => 'Allow editing general settings.',
            ],

            [
                'name' => 'View Company Profile',
                'slug' => 'view-company-profile',
                'description' => 'Allow viewing company profile settings.',
            ],

            [
                'name' => 'Edit Company Profile',
                'slug' => 'edit-company-profile',
                'description' => 'Allow editing company profile settings.',
            ],

            [
                'name' => 'View Security Settings',
                'slug' => 'view-security-settings',
                'description' => 'Allow viewing security settings.',
            ],

            [
                'name' => 'Edit Security Settings',
                'slug' => 'edit-security-settings',
                'description' => 'Allow editing security settings.',
            ],

            [
                'name' => 'View Audit Logs',
                'slug' => 'view-audit-logs',
                'description' => 'Allow viewing system audit logs.',
            ],

            [
                'name' => 'View Audit Log Details',
                'slug' => 'view-audit-log-details',
                'description' => 'Allow viewing individual audit log details.',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Remove Duplicate Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = collect($permissions)
            ->unique('slug')
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | Create / Update Permissions
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permission) {

            Permission::updateOrCreate(
                [
                    'slug' => $permission['slug'],
                ],
                [
                    'name' => $permission['name'],
                    'description' => $permission['description'],
                ]
            );

        }
    }
}
