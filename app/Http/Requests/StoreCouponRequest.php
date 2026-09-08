<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $maximumDiscount = $this->input('maximum_discount');

        $this->merge([
            'code' => strtoupper(
                trim((string) $this->input('code'))
            ),
            'maximum_discount' => (
                $maximumDiscount === null
                || $maximumDiscount === ''
                || (float) $maximumDiscount <= 0
            )
                ? null
                : $maximumDiscount,
        ]);
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:coupons,code',
            ],

            'discount_type' => [
                'required',
                Rule::in([
                    'percentage',
                    'fixed',
                ]),
            ],

            'discount_value' => [
                'required',
                'numeric',
                'gt:0',
                'max:9999999999.99',
            ],

            'minimum_amount' => [
                'nullable',
                'numeric',
                'gte:0',
                'max:9999999999.99',
            ],

            'maximum_discount' => [
                'nullable',
                'numeric',
                'gte:0',
                'max:9999999999.99',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],

            'usage_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'per_user_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

            'product_ids' => [
                'nullable',
                'array',
            ],

            'product_ids.*' => [
                'integer',
                'distinct',
                'exists:products,id',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            if (
                $this->input('discount_type') === 'percentage'
                && (float) $this->input('discount_value', 0) > 100
            ) {
                $validator->errors()->add(
                    'discount_value',
                    'Percentage discount cannot be greater than 100%.'
                );
            }
        });
    }
}
