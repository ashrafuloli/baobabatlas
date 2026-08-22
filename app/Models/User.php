<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'profile_image',
        'password',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Hidden Attributes
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Full Name
    |--------------------------------------------------------------------------
    */

    public function getNameAttribute(): string
    {
        return trim(
            $this->first_name . ' ' . ($this->last_name ?? '')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    |
    | A user can have multiple roles.
    |
    */

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles'
        )->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | Check Role
    |--------------------------------------------------------------------------
    |
    | Examples:
    |
    | hasRole('admin')
    | hasRole(['admin', 'staff'])
    |
    */

    public function hasRole(string|array $roles): bool
    {
        $roles = is_array($roles)
            ? $roles
            : [$roles];

        $roles = collect($roles)
            ->map(fn ($role) => trim($role))
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        if (empty($roles)) {
            return false;
        }

        return $this->roles()
            ->whereIn('slug', $roles)
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | Check Any Role
    |--------------------------------------------------------------------------
    |
    | User must have at least one of the given roles.
    |
    */

    public function hasAnyRole(array $roles): bool
    {
        return $this->hasRole($roles);
    }


    /*
    |--------------------------------------------------------------------------
    | Check All Roles
    |--------------------------------------------------------------------------
    |
    | User must have every given role.
    |
    */

    public function hasAllRoles(array $roles): bool
    {
        $roles = collect($roles)
            ->map(fn ($role) => trim($role))
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        if (empty($roles)) {
            return true;
        }

        return $this->roles()
                ->whereIn('slug', $roles)
                ->count() === count($roles);
    }


    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }


    /*
    |--------------------------------------------------------------------------
    | Client
    |--------------------------------------------------------------------------
    */

    public function isClient(): bool
    {
        return $this->hasRole('client');
    }


    /*
    |--------------------------------------------------------------------------
    | Staff
    |--------------------------------------------------------------------------
    |
    | Future-ready.
    |
    */

    public function isStaff(): bool
    {
        return $this->hasRole('staff');
    }


    /*
    |--------------------------------------------------------------------------
    | Seller
    |--------------------------------------------------------------------------
    |
    | Future-ready.
    |
    */

    public function isSeller(): bool
    {
        return $this->hasRole('seller');
    }


    /*
    |--------------------------------------------------------------------------
    | Assign Role
    |--------------------------------------------------------------------------
    |
    | Adds a role without removing existing roles.
    |
    */

    public function assignRole(string|Role $role): self
    {
        $roleModel = $role instanceof Role
            ? $role
            : Role::where('slug', $role)->firstOrFail();

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

    public function removeRole(string|Role $role): self
    {
        $roleModel = $role instanceof Role
            ? $role
            : Role::where('slug', $role)->first();

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

    public function syncRoles(array $roles): self
    {
        $roles = collect($roles)
            ->map(fn ($role) => trim($role))
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

        $this->roles()->sync($roleIds);

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | Check Permission
    |--------------------------------------------------------------------------
    |
    | This is ONLY for the new/custom permission system.
    |
    | Existing Admin / Client authorization is not changed.
    |
    | Examples:
    |
    | hasPermission('view-reports')
    | hasPermission('create-orders')
    |
    */

    public function hasPermission(string $permission): bool
    {
        $permission = trim($permission);


        /*
        |--------------------------------------------------------------------------
        | Empty Permission
        |--------------------------------------------------------------------------
        */

        if ($permission === '') {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | Admin Bypass
        |--------------------------------------------------------------------------
        |
        | Admin automatically has access to custom permission protected
        | functionality as well.
        |
        */

        if ($this->isAdmin()) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Check Through Roles
        |--------------------------------------------------------------------------
        |
        | User
        |   ↓
        | Roles
        |   ↓
        | Role Permissions
        |
        */

        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {

                $query->where(
                    'slug',
                    $permission
                );

            })
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | Check Any Permission
    |--------------------------------------------------------------------------
    |
    | Returns true when the user has at least one permission.
    |
    | Example:
    |
    | hasAnyPermission([
    |     'view-reports',
    |     'view-orders',
    | ])
    |
    */

    public function hasAnyPermission(array $permissions): bool
    {
        $permissions = collect($permissions)
            ->map(fn ($permission) => trim($permission))
            ->filter()
            ->unique()
            ->values()
            ->toArray();


        if (empty($permissions)) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | Admin Bypass
        |--------------------------------------------------------------------------
        */

        if ($this->isAdmin()) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Check Permissions
        |--------------------------------------------------------------------------
        */

        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissions) {

                $query->whereIn(
                    'slug',
                    $permissions
                );

            })
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | Check All Permissions
    |--------------------------------------------------------------------------
    |
    | Returns true only when the user has every requested permission.
    |
    | Example:
    |
    | hasAllPermissions([
    |     'view-reports',
    |     'edit-reports',
    | ])
    |
    */

    public function hasAllPermissions(array $permissions): bool
    {
        $permissions = collect($permissions)
            ->map(fn ($permission) => trim($permission))
            ->filter()
            ->unique()
            ->values()
            ->toArray();


        if (empty($permissions)) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Admin Bypass
        |--------------------------------------------------------------------------
        */

        if ($this->isAdmin()) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Check Permission Count
        |--------------------------------------------------------------------------
        */

        $permissionCount = $this->roles()
            ->whereHas('permissions', function ($query) use ($permissions) {

                $query->whereIn(
                    'slug',
                    $permissions
                );

            })
            ->withCount([
                'permissions as matched_permissions_count' => function ($query) use ($permissions) {

                    $query->whereIn(
                        'slug',
                        $permissions
                    );

                },
            ])
            ->get()
            ->sum('matched_permissions_count');


        /*
        |--------------------------------------------------------------------------
        | Unique Permission Count
        |--------------------------------------------------------------------------
        |
        | A permission can exist through multiple roles.
        | Therefore we check unique permission IDs separately.
        |
        */

        $matchedPermissions = $this->roles()
            ->whereHas('permissions', function ($query) use ($permissions) {

                $query->whereIn(
                    'slug',
                    $permissions
                );

            })
            ->with([
                'permissions' => function ($query) use ($permissions) {

                    $query->whereIn(
                        'slug',
                        $permissions
                    );

                },
            ])
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('slug')
            ->unique()
            ->count();


        return $matchedPermissions === count($permissions);
    }


    /*
    |--------------------------------------------------------------------------
    | Account Status
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === 'active';
    }


    public function isInactive(): bool
    {
        return $this->status === 'inactive';
    }


    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }
}
