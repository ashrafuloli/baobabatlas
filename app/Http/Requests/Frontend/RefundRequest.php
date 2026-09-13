<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

final class RefundRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'reason' => [
                'required',
                'string',
                'max:100',
            ],
            'message' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $reason = trim((string) $this->input('reason'));
        $message = trim((string) $this->input('message'));

        $this->merge([
            'reason' => $reason,
            'message' => $message !== '' ? $message : null,
        ]);
    }
}
