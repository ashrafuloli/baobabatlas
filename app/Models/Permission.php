<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
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
        'description',
    ];


    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    |
    | A permission can belong to many roles.
    |
    */

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions'
        )->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | Check Role
    |--------------------------------------------------------------------------
    |
    | Check whether this permission is assigned to a specific role.
    |
    | Example:
    |
    | $permission->hasRole('admin');
    |
    */

    public function hasRole(string $role): bool
    {
        $role = trim($role);


        if ($role === '') {
            return false;
        }


        return $this->roles()
            ->where(
                'slug',
                $role
            )
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | Assign Role
    |--------------------------------------------------------------------------
    |
    | Adds a role without removing existing roles.
    |
    */

    public function assignRole(
        string|Role $role
    ): self {

        $roleModel = $role instanceof Role
            ? $role
            : Role::where(
                'slug',
                $role
            )->firstOrFail();


        $this->roles()->syncWithoutDetaching([
            $roleModel->id,
        ]);


        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Remove Role
    |--------------------------------------------------------------------------
    */

    public function removeRole(
        string|Role $role
    ): self {

        $roleModel = $role instanceof Role
            ? $role
            : Role::where(
                'slug',
                $role
            )->first();


        if ($roleModel) {

            $this->roles()->detach(
                $roleModel->id
            );
        }


        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Sync Roles
    |--------------------------------------------------------------------------
    |
    | Replaces all current roles with the given roles.
    |
    */

    public function syncRoles(
        array $roles
    ): self {

        $roles = collect($roles)
            ->map(
                fn ($role) => trim($role)
            )
            ->filter()
            ->unique()
            ->values()
            ->toArray();


        $roleIds = Role::whereIn(
            'slug',
            $roles
        )
            ->pluck('id')
            ->toArray();


        $this->roles()->sync(
            $roleIds
        );


        return $this;
    }
}
