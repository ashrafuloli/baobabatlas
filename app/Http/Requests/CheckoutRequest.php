<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Saved Address
            |--------------------------------------------------------------------------
            */

            'address_id' => [
                'nullable',
                'integer',
                'min:1',
                Rule::exists('user_addresses', 'id')
                    ->where(
                        'user_id',
                        $this->user()?->id
                    ),
            ],

            /*
            |--------------------------------------------------------------------------
            | Customer Contact
            |--------------------------------------------------------------------------
            */

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

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            /*
            |--------------------------------------------------------------------------
            | New Shipping Contact
            |--------------------------------------------------------------------------
            */

            'shipping_first_name' => [
                'required_without:address_id',
                'nullable',
                'string',
                'max:100',
            ],

            'shipping_last_name' => [
                'required_without:address_id',
                'nullable',
                'string',
                'max:100',
            ],

            'shipping_phone' => [
                'required_without:address_id',
                'nullable',
                'string',
                'max:30',
            ],

            /*
            |--------------------------------------------------------------------------
            | Shipping Address
            |--------------------------------------------------------------------------
            */

            'country' => [
                'required_without:address_id',
                'nullable',
                'string',
                'size:2',
                Rule::in(
                    array_keys(
                        config('countries', [])
                    )
                ),
            ],

            'address' => [
                'required_without:address_id',
                'nullable',
                'string',
                'max:255',
            ],

            'apartment' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'required_without:address_id',
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'required_without:address_id',
                'nullable',
                'string',
                'max:100',
            ],

            'postal_code' => [
                'required_without:address_id',
                'nullable',
                'string',
                'max:20',
            ],

            /*
            |--------------------------------------------------------------------------
            | Save Address
            |--------------------------------------------------------------------------
            */

            'save_address' => [
                'nullable',
                'boolean',
            ],

            'address_label' => [
                'nullable',
                'string',
                'max:50',
            ],

            /*
            |--------------------------------------------------------------------------
            | Order Notes
            |--------------------------------------------------------------------------
            */

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $addressId = $this->integer('address_id');

        $addressId = $addressId > 0
            ? $addressId
            : null;

        $shippingFirstName = trim(
            (string) $this->input('shipping_first_name')
        );

        $shippingLastName = trim(
            (string) $this->input('shipping_last_name')
        );

        $shippingPhone = trim(
            (string) $this->input('shipping_phone')
        );

        $country = strtoupper(
            trim((string) $this->input('country'))
        );

        $data = [
            'address_id' => $addressId,
            'save_address' => $this->boolean('save_address'),
        ];

        /*
        |--------------------------------------------------------------------------
        | New Address Contact
        |--------------------------------------------------------------------------
        |
        | CreateOrder expects first_name, last_name and phone.
        | When no saved address is selected, normalize shipping_* fields
        | into those canonical fields.
        |
        */

        if ($addressId === null) {
            $data['first_name'] = $shippingFirstName;
            $data['last_name'] = $shippingLastName;
            $data['phone'] = $shippingPhone;
        }

        /*
        |--------------------------------------------------------------------------
        | Country
        |--------------------------------------------------------------------------
        */

        if ($country !== '') {
            $data['country'] = $country;
        }

        $this->merge($data);
    }
}
