<?php

declare(strict_types=1);

namespace App\Http\Requests\Frontend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class OrderMessageRequest extends FormRequest
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
            'order_item_id' => [
                'nullable',
                'integer',
                'min:1',
                Rule::exists('order_items', 'id')
                    ->where('order_id', $this->route('order')?->id),
            ],
            'message' => [
                'required',
                'string',
                'min:1',
                'max:5000',
            ],
        ];
    }

    /**
     * Prepare the input for validation.
     */
    protected function prepareForValidation(): void
    {
        $message = trim((string) $this->input('message'));

        $orderItemId = $this->integer('order_item_id');

        $this->merge([
            'order_item_id' => $orderItemId > 0 ? $orderItemId : null,
            'message' => $message,
        ]);
    }
}
