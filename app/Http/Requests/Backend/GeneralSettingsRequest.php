<?php

declare(strict_types=1);

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

final class GeneralSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'website_name' => [
                'required',
                'string',
                'max:255',
            ],

            'website_url' => [
                'required',
                'url',
                'max:255',
            ],

            'website_tagline' => [
                'nullable',
                'string',
                'max:255',
            ],

            'website_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,svg',
                'max:2048',
            ],

            'favicon' => [
                'nullable',
                'file',
                'mimes:ico,png',
                'max:1024',
            ],

            'currency' => [
                'required',
                'string',
                'max:10',
            ],

            'currency_position' => [
                'required',
                'in:before,after',
            ],

            'products_per_page' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'shipping_method' => [
                'required',
                'string',
                'max:100',
            ],

            'free_shipping_threshold' => [
                'required',
                'numeric',
                'min:0',
            ],

            'processing_time' => [
                'required',
                'string',
                'max:100',
            ],

            'maintenance_mode' => [
                'nullable',
                'boolean',
            ],

            'customer_registration' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
