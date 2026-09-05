<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class BrandSeeder extends Seeder
{
    /**
     * Seed application brands.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'logo' => 'https://cdn.simpleicons.org/apple',
                'description' => 'Premium consumer electronics and technology products.',
                'featured' => true,
            ],
            [
                'name' => 'Samsung',
                'logo' => 'https://cdn.simpleicons.org/samsung',
                'description' => 'Global technology brand specializing in smartphones and electronics.',
                'featured' => true,
            ],
            [
                'name' => 'Sony',
                'logo' => 'https://cdn.simpleicons.org/sony',
                'description' => 'Consumer electronics, entertainment and technology products.',
                'featured' => true,
            ],
            [
                'name' => 'Nike',
                'logo' => 'https://cdn.simpleicons.org/nike',
                'description' => 'Sportswear, footwear and athletic equipment.',
                'featured' => true,
            ],
            [
                'name' => 'Adidas',
                'logo' => 'https://cdn.simpleicons.org/adidas',
                'description' => 'Sports footwear, apparel and lifestyle products.',
                'featured' => true,
            ],
            [
                'name' => 'JBL',
                'logo' => 'https://cdn.simpleicons.org/jbl',
                'description' => 'Audio products including headphones and portable speakers.',
                'featured' => false,
            ],
            [
                'name' => 'Logitech',
                'logo' => 'https://cdnjs.cloudflare.com/ajax/libs/simple-icons/15.1.0/logitech.svg',
                'description' => 'Computer accessories, keyboards, mice and productivity devices.',
                'featured' => false,
            ],
            [
                'name' => 'Anker',
                'logo' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=1200&q=85',
                'description' => 'Charging accessories, power products and consumer electronics.',
                'featured' => false,
            ],
        ];

        foreach ($brands as $sortOrder => $brand) {
            Brand::updateOrCreate(
                [
                    'slug' => Str::slug($brand['name']),
                ],
                [
                    'name' => $brand['name'],
                    'logo' => $brand['logo'],
                    'description' => $brand['description'],
                    'sort_order' => $sortOrder + 1,
                    'status' => true,
                    'featured' => $brand['featured'],
                    'meta_title' => $brand['name'],
                    'meta_description' => $brand['description'],
                ],
            );
        }
    }
}
