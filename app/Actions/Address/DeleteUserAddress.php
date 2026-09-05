<?php

declare(strict_types=1);

namespace App\Actions\Address;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;

final class DeleteUserAddress
{
    public function execute(
        User $user,
        UserAddress $address,
    ): void {
        DB::transaction(function () use (
            $user,
            $address,
        ): void {
            if ($address->user_id !== $user->id) {
                abort(403);
            }

            $wasDefault = $address->is_default;

            $address->delete();

            if (!$wasDefault) {
                return;
            }

            $nextAddress = $user->addresses()
                ->latest('id')
                ->first();

            if ($nextAddress !== null) {
                $nextAddress->update([
                    'is_default' => true,
                ]);
            }
        });
    }
}
