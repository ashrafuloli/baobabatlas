<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

final class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'website_name' => 'Baobab Atlas',
            'website_url' => 'https://baobabatlas.com',
            'website_tagline' => 'Connecting Guinea to the World',

            'website_logo' => 'uploads/website/logo.png',
            'favicon' => 'uploads/website/favicon.png',

            'currency' => 'USD',
            'currency_position' => 'before',
            'products_per_page' => '12',

            'maintenance_mode' => '0',
            'customer_registration' => '1',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
