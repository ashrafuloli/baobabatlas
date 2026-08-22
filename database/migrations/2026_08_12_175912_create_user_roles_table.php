<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | User Roles
        |--------------------------------------------------------------------------
        |
        | Connects users with roles.
        |
        | A user can have multiple roles.
        |
        */

        Schema::create('user_roles', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Role
            |--------------------------------------------------------------------------
            */

            $table->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Roles
            |--------------------------------------------------------------------------
            |
            | A user cannot have the same role twice.
            |
            */

            $table->unique([
                'user_id',
                'role_id',
            ]);

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
