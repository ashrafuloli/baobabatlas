<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class CategorySeeder extends Seeder
{
    /**
     * Seed application categories and subcategories.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=800&q=80',
                'description' => 'Smartphones, laptops, audio devices and consumer electronics.',
                'featured' => true,
                'children' => [
                    [
                        'name' => 'Smartphones',
                        'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Laptops',
                        'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Audio',
                        'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Accessories',
                        'image' => 'https://images.unsplash.com/photo-1625842268584-8f3296236761?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],

            [
                'name' => 'Fashion',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=800&q=80',
                'description' => 'Footwear, clothing and everyday fashion essentials.',
                'featured' => true,
                'children' => [
                    [
                        'name' => 'Men\'s Clothing',
                        'image' => 'https://images.unsplash.com/photo-1617127365659-c47fa864d8bc?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Women\'s Clothing',
                        'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Shoes',
                        'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Sportswear',
                        'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],

            [
                'name' => 'Home & Living',
                'image' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=800&q=80',
                'description' => 'Useful products and accessories for modern homes.',
                'featured' => true,
                'children' => [
                    [
                        'name' => 'Kitchen',
                        'image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Home Accessories',
                        'image' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Lighting',
                        'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],

            [
                'name' => 'Computers',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=1200&q=85',
                'description' => 'Computer hardware and productivity accessories.',
                'featured' => false,
                'children' => [
                    [
                        'name' => 'Keyboards',
                        'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Mice',
                        'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Webcams',
                        'image' => 'https://images.unsplash.com/photo-1587826080692-f439cd0b70da?auto=format&fit=crop&w=800&q=80',
                    ],
                    [
                        'name' => 'Computer Accessories',
                        'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=800&q=80',
                    ],
                ],
            ],
        ];

        $sortOrder = 1;

        foreach ($categories as $categoryData) {
            $parent = Category::updateOrCreate(
                [
                    'slug' => Str::slug($categoryData['name']),
                ],
                [
                    'parent_id' => null,
                    'name' => $categoryData['name'],
                    'image' => $categoryData['image'],
                    'description' => $categoryData['description'],
                    'sort_order' => $sortOrder++,
                    'status' => true,
                    'featured' => $categoryData['featured'],
                    'meta_title' => $categoryData['name'],
                    'meta_description' => $categoryData['description'],
                ],
            );

            foreach (
                $categoryData['children']
                as $childOrder => $childData
            ) {
                Category::updateOrCreate(
                    [
                        'slug' => Str::slug($childData['name']),
                    ],
                    [
                        'parent_id' => $parent->id,
                        'name' => $childData['name'],
                        'image' => $childData['image'],
                        'description' => $childData['name'] . ' products.',
                        'sort_order' => $childOrder + 1,
                        'status' => true,
                        'featured' => false,
                        'meta_title' => $childData['name'],
                        'meta_description' => 'Browse our ' . $childData['name'] . ' collection.',
                    ],
                );
            }
        }
    }
}
