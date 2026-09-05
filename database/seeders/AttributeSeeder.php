<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class AttributeSeeder extends Seeder
{
    /**
     * Seed product attributes and values.
     */
    public function run(): void
    {
        $attributes = [
            [
                'name' => 'Color',
                'values' => [
                    ['label' => 'Black', 'value' => 'black'],
                    ['label' => 'White', 'value' => 'white'],
                    ['label' => 'Silver', 'value' => 'silver'],
                    ['label' => 'Deep Blue', 'value' => 'deep-blue'],
                    ['label' => 'Red', 'value' => 'red'],
                    ['label' => 'Midnight', 'value' => 'midnight'],
                    ['label' => 'Natural Titanium', 'value' => 'natural-titanium'],
                ],
            ],
            [
                'name' => 'Size',
                'values' => [
                    ['label' => 'XS', 'value' => 'xs'],
                    ['label' => 'S', 'value' => 's'],
                    ['label' => 'M', 'value' => 'm'],
                    ['label' => 'L', 'value' => 'l'],
                    ['label' => 'XL', 'value' => 'xl'],
                    ['label' => '7', 'value' => '7'],
                    ['label' => '8', 'value' => '8'],
                    ['label' => '9', 'value' => '9'],
                    ['label' => '10', 'value' => '10'],
                    ['label' => '11', 'value' => '11'],
                ],
            ],
            [
                'name' => 'Storage',
                'values' => [
                    ['label' => '128GB', 'value' => '128gb'],
                    ['label' => '256GB', 'value' => '256gb'],
                    ['label' => '512GB', 'value' => '512gb'],
                    ['label' => '1TB', 'value' => '1tb'],
                ],
            ],
        ];

        foreach ($attributes as $attributeOrder => $attributeData) {
            $attribute = Attribute::updateOrCreate(
                ['slug' => Str::slug($attributeData['name'])],
                [
                    'name' => $attributeData['name'],
                    'sort_order' => $attributeOrder + 1,
                    'status' => true,
                ],
            );

            foreach ($attributeData['values'] as $valueOrder => $valueData) {
                $attribute->values()->updateOrCreate(
                    ['slug' => $valueData['value']],
                    [
                        'label' => $valueData['label'],
                        'value' => $valueData['value'],
                        'sort_order' => $valueOrder + 1,
                        'status' => true,
                    ],
                );
            }
        }
    }
}
