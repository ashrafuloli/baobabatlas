<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'slug',
    ];


    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    |
    | A role can belong to many users.
    |
    */

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_roles'
        )->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | A role can have many permissions.
    |
    */

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions'
        )->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | Check Permission
    |--------------------------------------------------------------------------
    |
    | Check whether this role has a specific permission.
    |
    | Example:
    |
    | $role->hasPermission('view-reports');
    |
    */

    public function hasPermission(string $permission): bool
    {
        $permission = trim($permission);


        if ($permission === '') {
            return false;
        }


        return $this->permissions()
            ->where(
                'slug',
                $permission
            )
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | Assign Permission
    |--------------------------------------------------------------------------
    |
    | Adds a permission without removing existing permissions.
    |
    */

    public function assignPermission(
        string|Permission $permission
    ): self {

        $permissionModel = $permission instanceof Permission
            ? $permission
            : Permission::where(
                'slug',
                $permission
            )->firstOrFail();


        $this->permissions()->syncWithoutDetaching([
            $permissionModel->id,
        ]);


        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Remove Permission
    |--------------------------------------------------------------------------
    */

    public function removePermission(
        string|Permission $permission
    ): self {

        $permissionModel = $permission instanceof Permission
            ? $permission
            : Permission::where(
                'slug',
                $permission
            )->first();


        if ($permissionModel) {

            $this->permissions()->detach(
                $permissionModel->id
            );
        }


        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Sync Permissions
    |--------------------------------------------------------------------------
    |
    | Replaces all current permissions with the given permissions.
    |
    */

    public function syncPermissions(
        array $permissions
    ): self {

        $permissions = collect($permissions)
            ->map(
                fn ($permission) => trim($permission)
            )
            ->filter()
            ->unique()
            ->values()
            ->toArray();


        $permissionIds = Permission::whereIn(
            'slug',
            $permissions
        )
            ->pluck('id')
            ->toArray();


        $this->permissions()->sync(
            $permissionIds
        );


        return $this;
    }
}
