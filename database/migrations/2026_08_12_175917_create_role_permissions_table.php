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
        | Role Permissions
        |--------------------------------------------------------------------------
        |
        | Connects roles with permissions.
        |
        | A role can have multiple permissions.
        | A permission can belong to multiple roles.
        |
        */

        Schema::create('role_permissions', function (Blueprint $table) {

            $table->id();


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
            | Permission
            |--------------------------------------------------------------------------
            */

            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Assignments
            |--------------------------------------------------------------------------
            |
            | A role cannot have the same permission assigned twice.
            |
            */

            $table->unique([
                'role_id',
                'permission_id',
            ]);

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
