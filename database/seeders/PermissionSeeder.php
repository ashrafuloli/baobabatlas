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
                'description' => 'Allow users to view their profile.',
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
            |
            | Used for customer payment access and central
            | admin payment management.
            |
            */

            [
                'name' => 'View Payments',
                'slug' => 'view-payments',
                'description' => 'Allow viewing payments.',
            ],


            /*
            |--------------------------------------------------------------------------
            | ECOMMERCE - CUSTOMER
            |--------------------------------------------------------------------------
            |
            | Customer Ecommerce workflow:
            |
            | Shop
            |   ↓
            | Product Details
            |   ↓
            | Cart
            |   ↓
            | Checkout
            |   ↓
            | Payment
            |   ↓
            | Orders
            |   ↓
            | Shipment
            |   ↓
            | Tracking
            |
            */


            /*
            |--------------------------------------------------------------------------
            | Products
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
            | Categories
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
            | Cart
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
                'description' => 'Allow users to add, update and remove cart items.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Orders
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
                'description' => 'Allow users to view ecommerce order details.',
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
            | Ecommerce Payments
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
                'description' => 'Allow managing ecommerce payments and payment status.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Ecommerce Shipments
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
                'description' => 'Allow managing ecommerce shipment information and status.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Ecommerce Tracking
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Ecommerce Tracking',
                'slug' => 'view-ecommerce-tracking',
                'description' => 'Allow users to view ecommerce shipment tracking.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Ecommerce Inventory
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
                'description' => 'Allow updating ecommerce inventory and stock quantities.',
            ],

            [
                'name' => 'View Low Stock',
                'slug' => 'view-low-stock',
                'description' => 'Allow viewing low-stock products.',
            ],

            [
                'name' => 'View Out Of Stock',
                'slug' => 'view-out-of-stock',
                'description' => 'Allow viewing out-of-stock products.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Ecommerce Reports
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Ecommerce Reports',
                'slug' => 'view-ecommerce-reports',
                'description' => 'Allow viewing ecommerce reports and analytics.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Ecommerce Settings
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
            | SMART BUY
            |--------------------------------------------------------------------------
            |
            | Customer:
            |
            |   View Smart Buy
            |   Create Smart Buy
            |   View Details
            |   View Quote
            |   Accept Quote
            |   View Payment
            |   View Tracking
            |
            | Admin:
            |
            |   View
            |   Edit
            |   Delete
            |   Manage Quote
            |   Manage Payment
            |   Manage Purchase
            |   Manage Shipment
            |   Update Status
            |
            */


            /*
            |--------------------------------------------------------------------------
            | Smart Buy - Customer
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Smart Buy',
                'slug' => 'view-smart-buy',
                'description' => 'Allow viewing Smart Buy requests.',
            ],

            [
                'name' => 'Create Smart Buy',
                'slug' => 'create-smart-buy',
                'description' => 'Allow creating new Smart Buy requests.',
            ],

            [
                'name' => 'View Smart Buy Details',
                'slug' => 'view-smart-buy-details',
                'description' => 'Allow viewing Smart Buy request details.',
            ],

            [
                'name' => 'View Smart Buy Quote',
                'slug' => 'view-smart-buy-quote',
                'description' => 'Allow customers to view Smart Buy quotes.',
            ],

            [
                'name' => 'Accept Smart Buy Quote',
                'slug' => 'accept-smart-buy-quote',
                'description' => 'Allow customers to accept Smart Buy quotes.',
            ],

            [
                'name' => 'View Smart Buy Payment',
                'slug' => 'view-smart-buy-payment',
                'description' => 'Allow viewing Smart Buy payment pages and payment information.',
            ],

            [
                'name' => 'View Smart Buy Tracking',
                'slug' => 'view-smart-buy-tracking',
                'description' => 'Allow viewing Smart Buy shipment tracking.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Smart Buy - Admin
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'Edit Smart Buy',
                'slug' => 'edit-smart-buy',
                'description' => 'Allow editing Smart Buy requests.',
            ],

            [
                'name' => 'Delete Smart Buy',
                'slug' => 'delete-smart-buy',
                'description' => 'Allow deleting Smart Buy requests.',
            ],

            [
                'name' => 'Manage Smart Buy Quote',
                'slug' => 'manage-smart-buy-quote',
                'description' => 'Allow administrators to create, update and send Smart Buy quotes.',
            ],

            [
                'name' => 'Create Smart Buy Quote',
                'slug' => 'create-smart-buy-quote',
                'description' => 'Allow administrators to prepare Smart Buy quotes.',
            ],

            [
                'name' => 'Manage Smart Buy Payment',
                'slug' => 'manage-smart-buy-payment',
                'description' => 'Allow managing Smart Buy payments and payment status.',
            ],

            [
                'name' => 'Manage Smart Buy Purchase',
                'slug' => 'manage-smart-buy-purchase',
                'description' => 'Allow managing Smart Buy product purchasing and purchase status.',
            ],

            [
                'name' => 'Purchase Smart Buy',
                'slug' => 'purchase-smart-buy',
                'description' => 'Allow administrators to purchase products for Smart Buy requests.',
            ],

            [
                'name' => 'Manage Smart Buy Shipment',
                'slug' => 'manage-smart-buy-shipment',
                'description' => 'Allow managing shipment information for Smart Buy orders.',
            ],

            [
                'name' => 'Create Smart Buy Shipment',
                'slug' => 'create-smart-buy-shipment',
                'description' => 'Allow administrators to create Smart Buy shipments.',
            ],

            [
                'name' => 'Update Smart Buy Status',
                'slug' => 'update-smart-buy-status',
                'description' => 'Allow updating Smart Buy request and order statuses.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Smart Buy Reports
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Smart Buy Reports',
                'slug' => 'view-smart-buy-reports',
                'description' => 'Allow viewing Smart Buy reports and analytics.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Smart Buy Settings
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Smart Buy Settings',
                'slug' => 'view-smart-buy-settings',
                'description' => 'Allow viewing Smart Buy settings.',
            ],

            [
                'name' => 'Edit Smart Buy Settings',
                'slug' => 'edit-smart-buy-settings',
                'description' => 'Allow editing Smart Buy settings.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Central Payments
            |--------------------------------------------------------------------------
            |
            | Admin payment management:
            |
            |   All Payments
            |   Ecommerce Payments
            |   Smart Buy Payments
            |   Failed Payments
            |   Payment Details
            |
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
                'description' => 'Allow viewing Smart Buy payments from the central payment management area.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Reports
            |--------------------------------------------------------------------------
            |
            | Central reports:
            |
            |   Overview
            |   Ecommerce
            |   Smart Buy
            |
            */

            [
                'name' => 'View Reports',
                'slug' => 'view-reports',
                'description' => 'Allow viewing the central reports overview.',
            ],

            [
                'name' => 'View Smart Buy Reports',
                'slug' => 'view-smart-buy-reports',
                'description' => 'Allow viewing Smart Buy reports and analytics.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            |
            | Currently protected by role:admin.
            | Permissions are prepared for future permission-based access.
            |
            */

            [
                'name' => 'View Users',
                'slug' => 'view-users',
                'description' => 'Allow viewing registered users and their account information.',
            ],

            [
                'name' => 'Create Users',
                'slug' => 'create-users',
                'description' => 'Allow creating new user accounts.',
            ],

            [
                'name' => 'Edit Users',
                'slug' => 'edit-users',
                'description' => 'Allow editing user accounts.',
            ],

            [
                'name' => 'Delete Users',
                'slug' => 'delete-users',
                'description' => 'Allow deleting user accounts.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Roles
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
                'description' => 'Allow creating new roles.',
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


            /*
            |--------------------------------------------------------------------------
            | Role Permissions
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'Manage Role Permissions',
                'slug' => 'manage-role-permissions',
                'description' => 'Allow managing permissions assigned to roles.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Permissions
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
                'description' => 'Allow creating new permissions.',
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
            | Services
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
                'description' => 'Allow creating new services.',
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
            | Clients
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Clients',
                'slug' => 'view-clients',
                'description' => 'Allow viewing service clients.',
            ],

            [
                'name' => 'Create Clients',
                'slug' => 'create-clients',
                'description' => 'Allow creating new clients.',
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
            | Notifications
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'View Notifications',
                'slug' => 'view-notifications',
                'description' => 'Allow viewing user notifications.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Settings
            |--------------------------------------------------------------------------
            |
            | Settings:
            |
            |   General
            |   Ecommerce
            |   Smart Buy
            |   Audit Logs
            |
            */


            /*
            |--------------------------------------------------------------------------
            | General Settings
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
                'description' => 'Allow editing general system settings.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Company Profile
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | Security Settings
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | Audit Logs
            |--------------------------------------------------------------------------
            */

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
