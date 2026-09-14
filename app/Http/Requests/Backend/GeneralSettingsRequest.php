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
            /*
            |--------------------------------------------------------------------------
            | Website Information
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | Branding
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | System Preferences
            |--------------------------------------------------------------------------
            */

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
