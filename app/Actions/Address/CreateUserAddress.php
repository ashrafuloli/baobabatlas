<?php

declare(strict_types=1);

namespace App\Actions\Address;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;

final class CreateUserAddress
{
    /**
     * Create a new user address.
     *
     * @param array<string, mixed> $data
     */
    public function execute(
        User $user,
        array $data,
    ): UserAddress {
        return DB::transaction(function () use (
            $user,
            $data,
        ): UserAddress {
            $isDefault = (bool) ($data['is_default'] ?? false);

            $hasAddresses = $user->addresses()->exists();

            if (!$hasAddresses) {
                $isDefault = true;
            }

            if ($isDefault) {
                $user->addresses()->update([
                    'is_default' => false,
                ]);
            }

            return $user->addresses()->create([
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
        });
    }
}
