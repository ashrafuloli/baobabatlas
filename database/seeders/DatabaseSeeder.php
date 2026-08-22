<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            /*
            |--------------------------------------------------------------------------
            | Roles
            |--------------------------------------------------------------------------
            */

            RoleSeeder::class,


            /*
            |--------------------------------------------------------------------------
            | Permissions
            |--------------------------------------------------------------------------
            */

            PermissionSeeder::class,


            /*
            |--------------------------------------------------------------------------
            | Default Users + Role Permissions
            |--------------------------------------------------------------------------
            */

            UserSeeder::class,
        ]);
    }
}
