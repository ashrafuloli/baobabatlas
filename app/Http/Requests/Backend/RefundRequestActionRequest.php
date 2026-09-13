<?php

declare(strict_types=1);

namespace App\Http\Requests\Backend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class RefundRequestActionRequest extends FormRequest
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
            'admin_note' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }

    /**
     * Prepare the input for validation.
     */
    protected function prepareForValidation(): void
    {
        $adminNote = trim(
            (string) $this->input('admin_note')
        );

        $this->merge([
            'admin_note' => $adminNote !== ''
                ? $adminNote
                : null,
        ]);
    }
}
