<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class StoreUserAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label' => [
                'required',
                'string',
                'max:50',
            ],
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],
            'last_name' => [
                'required',
                'string',
                'max:100',
            ],
            'phone' => [
                'required',
                'string',
                'max:30',
            ],
            'country' => [
                'required',
                'string',
                'max:100',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'apartment' => [
                'nullable',
                'string',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],
            'state' => [
                'nullable',
                'string',
                'max:100',
            ],
            'postal_code' => [
                'required',
                'string',
                'max:20',
            ],
            'is_default' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
