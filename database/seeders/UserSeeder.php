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
        |
        | Admin automatically receives ALL permissions.
        |
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
        | Admin Gets ALL Permissions
        |--------------------------------------------------------------------------
        |
        | RoleSeeder is not changed.
        |
        | Admin role permissions are handled here.
        |
        */

        $allPermissionIds = Permission::pluck('id')->toArray();

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
        |
        | Admin-only permissions are NOT assigned to Client.
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
            |
            | Customer can create and view their own requests.
            |
            */

            'view-requests',
            'create-requests',
            'view-request-details',


            /*
            |--------------------------------------------------------------------------
            | Ecommerce - Products
            |--------------------------------------------------------------------------
            */

            'view-products',


            /*
            |--------------------------------------------------------------------------
            | Ecommerce - Categories
            |--------------------------------------------------------------------------
            |
            | Customer can browse categories.
            |
            */

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
            |
            | Customer payment access.
            |
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
            | Customer workflow:
            |
            | My Smart Buy
            |      ↓
            | Create Request
            |      ↓
            | Request Details
            |      ↓
            | Quote
            |      ↓
            | Accept Quote
            |      ↓
            | Payment
            |      ↓
            | Tracking
            |
            */

            'view-smart-buy',

            'create-smart-buy',

            'view-smart-buy-details',

            'view-smart-buy-quote',

            'accept-smart-buy-quote',

            'view-smart-buy-payment',

            'view-smart-buy-tracking',

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
        |
        | Only permissions that already exist in the database
        | will be assigned.
        |
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
