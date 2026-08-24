<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Get Roles
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::where(
            'slug',
            'admin'
        )->firstOrFail();

        $clientRole = Role::where(
            'slug',
            'client'
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Admin User
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone' => null,
                'address' => null,
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Assign Admin Role
        |--------------------------------------------------------------------------
        */

        $admin->roles()->sync([
            $adminRole->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Admin Gets All Permissions
        |--------------------------------------------------------------------------
        */

        $allPermissionIds = Permission::pluck('id')
            ->toArray();

        $adminRole->permissions()->sync(
            $allPermissionIds
        );


        /*
        |--------------------------------------------------------------------------
        | Client User
        |--------------------------------------------------------------------------
        */

        $client = User::updateOrCreate(
            [
                'email' => 'client@gmail.com',
            ],
            [
                'first_name' => 'Demo',
                'last_name' => 'Client',
                'phone' => null,
                'address' => null,
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Assign Client Role
        |--------------------------------------------------------------------------
        */

        $client->roles()->sync([
            $clientRole->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Client Permissions
        |--------------------------------------------------------------------------
        |
        | Only customer-facing permissions are assigned.
        | Admin-only permissions are excluded.
        |
        */

        $clientPermissions = [

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            'view-dashboard',


            /*
            |--------------------------------------------------------------------------
            | Profile
            |--------------------------------------------------------------------------
            */

            'view-profile',


            /*
            |--------------------------------------------------------------------------
            | Notifications
            |--------------------------------------------------------------------------
            */

            'view-notifications',


            /*
            |--------------------------------------------------------------------------
            | Services
            |--------------------------------------------------------------------------
            */

            'view-services',
            'view-service-details',


            /*
            |--------------------------------------------------------------------------
            | Service Requests
            |--------------------------------------------------------------------------
            */

            'view-requests',
            'create-requests',
            'view-request-details',


            /*
            |--------------------------------------------------------------------------
            | Ecommerce - Products & Categories
            |--------------------------------------------------------------------------
            */

            'view-products',
            'view-categories',


            /*
            |--------------------------------------------------------------------------
            | Ecommerce - Cart
            |--------------------------------------------------------------------------
            */

            'view-cart',
            'manage-cart',


            /*
            |--------------------------------------------------------------------------
            | Ecommerce - Orders
            |--------------------------------------------------------------------------
            */

            'create-order',
            'view-orders',
            'view-order-details',


            /*
            |--------------------------------------------------------------------------
            | Ecommerce - Payments
            |--------------------------------------------------------------------------
            */

            'view-payments',
            'view-ecommerce-payments',


            /*
            |--------------------------------------------------------------------------
            | Ecommerce - Shipments
            |--------------------------------------------------------------------------
            */

            'view-ecommerce-shipments',
            'view-ecommerce-shipment-details',


            /*
            |--------------------------------------------------------------------------
            | Ecommerce - Tracking
            |--------------------------------------------------------------------------
            */

            'view-ecommerce-tracking',


            /*
            |--------------------------------------------------------------------------
            | General Shipments
            |--------------------------------------------------------------------------
            */

            'view-shipments',
            'view-shipment-details',


            /*
            |--------------------------------------------------------------------------
            | General Tracking
            |--------------------------------------------------------------------------
            */

            'view-tracking',
            'view-tracking-details',


            /*
            |--------------------------------------------------------------------------
            | Invoices
            |--------------------------------------------------------------------------
            */

            'view-invoices',


            /*
            |--------------------------------------------------------------------------
            | Smart Buy - Customer
            |--------------------------------------------------------------------------
            |
            | These permissions exactly match PermissionSeeder
            | and web.php middleware.
            |
            */

            /*
            | My Smart Buy List
            */

            'my-smart-buy',


            /*
            | Smart Buy Details
            */

            'my-smart-buy-details',


            /*
            | Create Smart Buy
            */

            'my-smart-buy-create',


            /*
            | Smart Buy Confirmation
            */

            'my-smart-buy-confirmation',


            /*
            | Smart Buy Quote
            |
            | Allows viewing, accepting and rejecting quotes.
            */

            'my-smart-buy-quote',


            /*
            | Smart Buy Payment
            |
            | Allows viewing and submitting Smart Buy payments.
            */

            'my-smart-buy-payment',


            /*
            | Smart Buy Tracking
            */

            'my-smart-buy-tracking',

        ];


        /*
        |--------------------------------------------------------------------------
        | Remove Duplicate Permissions
        |--------------------------------------------------------------------------
        */

        $clientPermissions = array_values(
            array_unique(
                $clientPermissions
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Get Client Permission IDs
        |--------------------------------------------------------------------------
        */

        $clientPermissionIds = Permission::whereIn(
            'slug',
            $clientPermissions
        )
            ->pluck('id')
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Assign Permissions To Client Role
        |--------------------------------------------------------------------------
        */

        $clientRole->permissions()->sync(
            $clientPermissionIds
        );
    }
}
