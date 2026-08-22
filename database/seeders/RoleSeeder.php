<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin Role
        |--------------------------------------------------------------------------
        */

        Role::updateOrCreate(
            [
                'slug' => 'admin',
            ],
            [
                'name' => 'Admin',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Client Role
        |--------------------------------------------------------------------------
        */

        Role::updateOrCreate(
            [
                'slug' => 'client',
            ],
            [
                'name' => 'Client',
            ]
        );
    }
}
