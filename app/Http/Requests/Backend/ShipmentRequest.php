<?php

declare(strict_types=1);

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'order_id' => [
                'required',
                'integer',
                'exists:orders,id',
            ],

            'carrier' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tracking_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'string',
                Rule::in([
                    \App\Models\Shipment::STATUS_PENDING,
                    \App\Models\Shipment::STATUS_PROCESSING,
                    \App\Models\Shipment::STATUS_SHIPPED,
                    \App\Models\Shipment::STATUS_CANCELLED,
                ]),
            ],

            'delivery_status' => [
                'required',
                'string',
                Rule::in([
                    \App\Models\Shipment::DELIVERY_STATUS_PENDING,
                    \App\Models\Shipment::DELIVERY_STATUS_IN_TRANSIT,
                    \App\Models\Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY,
                    \App\Models\Shipment::DELIVERY_STATUS_DELIVERED,
                    \App\Models\Shipment::DELIVERY_STATUS_FAILED,
                ]),
            ],

            'shipped_at' => [
                'nullable',
                'date',
            ],

            'delivered_at' => [
                'nullable',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'order_id' => $this->integer('order_id') ?: null,
            'carrier' => $this->filled('carrier')
                ? trim((string) $this->input('carrier'))
                : null,
            'tracking_number' => $this->filled('tracking_number')
                ? trim((string) $this->input('tracking_number'))
                : null,
            'status' => trim((string) $this->input('status')),
            'delivery_status' => trim(
                (string) $this->input('delivery_status')
            ),
            'notes' => $this->filled('notes')
                ? trim((string) $this->input('notes'))
                : null,
        ]);
    }
}
