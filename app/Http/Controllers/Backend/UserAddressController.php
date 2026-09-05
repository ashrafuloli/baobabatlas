<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Actions\Address\CreateUserAddress;
use App\Actions\Address\DeleteUserAddress;
use App\Actions\Address\SetDefaultUserAddress;
use App\Actions\Address\UpdateUserAddress;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAddressRequest;
use App\Http\Requests\UpdateUserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class UserAddressController extends Controller
{
    public function store(
        StoreUserAddressRequest $request,
        CreateUserAddress $createUserAddress,
    ): RedirectResponse {
        $createUserAddress->execute(
            $request->user(),
            $request->validated(),
        );

        return back()->with(
            'success',
            'Address has been added successfully.',
        );
    }

    public function update(
        UpdateUserAddressRequest $request,
        UserAddress $address,
        UpdateUserAddress $updateUserAddress,
    ): RedirectResponse {
        $updateUserAddress->execute(
            $request->user(),
            $address,
            $request->validated(),
        );

        return back()->with(
            'success',
            'Address has been updated successfully.',
        );
    }

    public function destroy(
        Request $request,
        UserAddress $address,
        DeleteUserAddress $deleteUserAddress,
    ): RedirectResponse {
        $deleteUserAddress->execute(
            $request->user(),
            $address,
        );

        return back()->with(
            'success',
            'Address has been deleted successfully.',
        );
    }

    public function setDefault(
        Request $request,
        UserAddress $address,
        SetDefaultUserAddress $setDefaultUserAddress,
    ): RedirectResponse {
        $setDefaultUserAddress->execute(
            $request->user(),
            $address,
        );

        return back()->with(
            'success',
            'Default address has been updated successfully.',
        );
    }
}
