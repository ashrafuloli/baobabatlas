<?php

declare(strict_types=1);

namespace App\Actions\Address;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;

final class UpdateUserAddress
{
    /**
     * Update an existing user address.
     *
     * @param array<string, mixed> $data
     */
    public function execute(
        User $user,
        UserAddress $address,
        array $data,
    ): UserAddress {
        return DB::transaction(function () use (
            $user,
            $address,
            $data,
        ): UserAddress {
            if ($address->user_id !== $user->id) {
                abort(403);
            }

            $isDefault = (bool) ($data['is_default'] ?? false);

            if ($isDefault) {
                $user->addresses()
                    ->whereKeyNot($address->id)
                    ->update([
                        'is_default' => false,
                    ]);
            }

            $address->update([
                'label' => $data['label'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'country' => $data['country'],
                'address' => $data['address'],
                'apartment' => $data['apartment'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'] ?? null,
                'postal_code' => $data['postal_code'],
                'is_default' => $isDefault,
            ]);

            return $address->refresh();
        });
    }
}
