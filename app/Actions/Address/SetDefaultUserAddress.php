<?php

declare(strict_types=1);

namespace App\Actions\Address;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;

final class SetDefaultUserAddress
{
    public function execute(
        User $user,
        UserAddress $address,
    ): UserAddress {
        return DB::transaction(function () use (
            $user,
            $address,
        ): UserAddress {
            if ($address->user_id !== $user->id) {
                abort(403);
            }

            $user->addresses()->update([
                'is_default' => false,
            ]);

            $address->update([
                'is_default' => true,
            ]);

            return $address->refresh();
        });
    }
}
