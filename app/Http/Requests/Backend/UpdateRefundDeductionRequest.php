<?php

declare(strict_types=1);

namespace App\Http\Requests\Backend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateRefundDeductionRequest extends FormRequest
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
            'deduction_amount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],
            'deduction_reason' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * Prepare the input for validation.
     */
    protected function prepareForValidation(): void
    {
        $deductionAmount = trim(
            (string) $this->input('deduction_amount'),
        );

        $deductionReason = trim(
            (string) $this->input('deduction_reason'),
        );

        $this->merge([
            'deduction_amount' => $deductionAmount !== ''
                ? $deductionAmount
                : 0,

            'deduction_reason' => $deductionReason !== ''
                ? $deductionReason
                : null,
        ]);
    }
}
