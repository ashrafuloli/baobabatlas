<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class ProductSeeder extends Seeder
{
    /**
     * Seed realistic ecommerce products.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $color = Attribute::where('slug', 'color')->firstOrFail();
            $size = Attribute::where('slug', 'size')->firstOrFail();
            $storage = Attribute::where('slug', 'storage')->firstOrFail();

            $products = [
                [
                    'name' => 'iPhone 17 Pro Max',
                    'brand' => 'Apple',
                    'category' => 'Smartphones',
                    'sku' => 'APL-IP17PM-001',
                    'source' => 'own',
                    'price' => 1199.00,
                    'compare_price' => 1299.00,
                    'cost_price' => 980.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=900&q=85',
                    'description' => 'A premium flagship smartphone with a large high-resolution display, advanced camera system and powerful performance.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1556656793-08538906a9f8?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'APL-IP17PM-DB-256',
                            'price' => 1199.00,
                            'stock' => 24,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'deep-blue'],
                                ['attribute' => 'storage', 'value' => '256gb'],
                            ],
                        ],
                        [
                            'sku' => 'APL-IP17PM-DB-512',
                            'price' => 1399.00,
                            'stock' => 18,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'deep-blue'],
                                ['attribute' => 'storage', 'value' => '512gb'],
                            ],
                        ],
                        [
                            'sku' => 'APL-IP17PM-SL-256',
                            'price' => 1199.00,
                            'stock' => 21,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                                ['attribute' => 'storage', 'value' => '256gb'],
                            ],
                        ],
                        [
                            'sku' => 'APL-IP17PM-SL-512',
                            'price' => 1399.00,
                            'stock' => 12,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                                ['attribute' => 'storage', 'value' => '512gb'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'iPhone 17',
                    'brand' => 'Apple',
                    'category' => 'Smartphones',
                    'sku' => 'APL-IP17-001',
                    'source' => 'own',
                    'price' => 899.00,
                    'compare_price' => 999.00,
                    'cost_price' => 720.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?auto=format&fit=crop&w=900&q=85',
                    'description' => 'A modern flagship smartphone offering fast performance, an immersive display and an advanced camera experience.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1556656793-08538906a9f8?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'APL-IP17-BK-128',
                            'price' => 899.00,
                            'stock' => 31,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'storage', 'value' => '128gb'],
                            ],
                        ],
                        [
                            'sku' => 'APL-IP17-WH-256',
                            'price' => 999.00,
                            'stock' => 26,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                                ['attribute' => 'storage', 'value' => '256gb'],
                            ],
                        ],
                        [
                            'sku' => 'APL-IP17-DB-256',
                            'price' => 999.00,
                            'stock' => 19,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'deep-blue'],
                                ['attribute' => 'storage', 'value' => '256gb'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Samsung Galaxy S26 Ultra',
                    'brand' => 'Samsung',
                    'category' => 'Smartphones',
                    'sku' => 'SAM-S26U-001',
                    'source' => 'own',
                    'price' => 1099.00,
                    'compare_price' => 1199.00,
                    'cost_price' => 890.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Premium Android smartphone featuring a vivid display, high-performance processor and versatile camera system.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1565849904461-04a58ad377e0?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'SAM-S26U-BK-256',
                            'price' => 1099.00,
                            'stock' => 20,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'storage', 'value' => '256gb'],
                            ],
                        ],
                        [
                            'sku' => 'SAM-S26U-SL-512',
                            'price' => 1299.00,
                            'stock' => 14,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                                ['attribute' => 'storage', 'value' => '512gb'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Samsung Galaxy S26',
                    'brand' => 'Samsung',
                    'category' => 'Smartphones',
                    'sku' => 'SAM-S26-001',
                    'source' => 'own',
                    'price' => 799.00,
                    'compare_price' => 899.00,
                    'cost_price' => 630.00,
                    'featured' => false,
                    'thumbnail' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=900&q=85',
                    'description' => 'A sleek Samsung smartphone with a vibrant AMOLED display, fast performance and versatile cameras.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'SAM-S26-BK-128',
                            'price' => 799.00,
                            'stock' => 27,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'storage', 'value' => '128gb'],
                            ],
                        ],
                        [
                            'sku' => 'SAM-S26-SL-256',
                            'price' => 899.00,
                            'stock' => 22,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                                ['attribute' => 'storage', 'value' => '256gb'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Sony WH-1000XM6 Wireless Headphones',
                    'brand' => 'Sony',
                    'category' => 'Audio',
                    'sku' => 'SONY-WH1000XM6-001',
                    'source' => 'own',
                    'price' => 399.00,
                    'compare_price' => 449.00,
                    'cost_price' => 285.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Premium wireless headphones with active noise cancellation, rich sound and all-day comfort.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1484704849700-f032a568e944?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'SONY-WH1000XM6-BK',
                            'price' => 399.00,
                            'stock' => 32,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                            ],
                        ],
                        [
                            'sku' => 'SONY-WH1000XM6-SL',
                            'price' => 399.00,
                            'stock' => 17,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Sony WH-CH720N Wireless Headphones',
                    'brand' => 'Sony',
                    'category' => 'Audio',
                    'sku' => 'SONY-WHCH720N-001',
                    'source' => 'amazon',
                    'price' => 129.00,
                    'compare_price' => 149.00,
                    'cost_price' => 82.00,
                    'featured' => false,
                    'thumbnail' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Lightweight wireless noise-cancelling headphones designed for comfortable everyday listening.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1484704849700-f032a568e944?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'SONY-WHCH720N-BK',
                            'price' => 129.00,
                            'stock' => 35,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                            ],
                        ],
                        [
                            'sku' => 'SONY-WHCH720N-WH',
                            'price' => 129.00,
                            'stock' => 18,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'JBL Charge 6 Portable Speaker',
                    'brand' => 'JBL',
                    'category' => 'Audio',
                    'sku' => 'JBL-CHARGE6-001',
                    'source' => 'amazon',
                    'price' => 179.00,
                    'compare_price' => 199.00,
                    'cost_price' => 120.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Portable Bluetooth speaker with powerful sound, durable construction and long battery life.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1589003077984-894e133dabab?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'JBL-CHARGE6-BK',
                            'price' => 179.00,
                            'stock' => 26,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                            ],
                        ],
                        [
                            'sku' => 'JBL-CHARGE6-RED',
                            'price' => 179.00,
                            'stock' => 11,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'red'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'JBL Tune 770NC',
                    'brand' => 'JBL',
                    'category' => 'Audio',
                    'sku' => 'JBL-T770NC-001',
                    'source' => 'amazon',
                    'price' => 129.00,
                    'compare_price' => 149.00,
                    'cost_price' => 84.00,
                    'featured' => false,
                    'thumbnail' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Wireless over-ear headphones with adaptive noise cancellation and powerful JBL sound.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'JBL-T770NC-BK',
                            'price' => 129.00,
                            'stock' => 29,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                            ],
                        ],
                        [
                            'sku' => 'JBL-T770NC-WH',
                            'price' => 129.00,
                            'stock' => 15,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'MacBook Pro 14-inch',
                    'brand' => 'Apple',
                    'category' => 'Laptops',
                    'sku' => 'APL-MBP14-001',
                    'source' => 'own',
                    'price' => 1999.00,
                    'compare_price' => 2199.00,
                    'cost_price' => 1580.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=1200&q=85',
                    'description' => 'Professional laptop with powerful Apple Silicon performance, premium display and long battery life.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'APL-MBP14-SL-512',
                            'price' => 1999.00,
                            'stock' => 14,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                                ['attribute' => 'storage', 'value' => '512gb'],
                            ],
                        ],
                        [
                            'sku' => 'APL-MBP14-MD-1TB',
                            'price' => 2299.00,
                            'stock' => 8,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'midnight'],
                                ['attribute' => 'storage', 'value' => '1tb'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Samsung Galaxy Book Pro',
                    'brand' => 'Samsung',
                    'category' => 'Laptops',
                    'sku' => 'SAM-GBPRO-001',
                    'source' => 'own',
                    'price' => 1299.00,
                    'compare_price' => 1399.00,
                    'cost_price' => 980.00,
                    'featured' => false,
                    'thumbnail' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Slim premium laptop designed for productivity, mobility and everyday computing.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'SAM-GBPRO-BK-256',
                            'price' => 1299.00,
                            'stock' => 16,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'storage', 'value' => '256gb'],
                            ],
                        ],
                        [
                            'sku' => 'SAM-GBPRO-SL-512',
                            'price' => 1399.00,
                            'stock' => 10,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                                ['attribute' => 'storage', 'value' => '512gb'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Logitech MX Master 4',
                    'brand' => 'Logitech',
                    'category' => 'Mice',
                    'sku' => 'LOG-MXM4-001',
                    'source' => 'own',
                    'price' => 99.00,
                    'compare_price' => 119.00,
                    'cost_price' => 62.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Premium wireless productivity mouse designed for precision, comfort and multi-device workflows.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'LOG-MXM4-BK',
                            'price' => 99.00,
                            'stock' => 40,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Logitech MX Keys',
                    'brand' => 'Logitech',
                    'category' => 'Keyboards',
                    'sku' => 'LOG-MXKEYS-001',
                    'source' => 'own',
                    'price' => 109.00,
                    'compare_price' => 129.00,
                    'cost_price' => 70.00,
                    'featured' => false,
                    'thumbnail' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Premium wireless keyboard with comfortable low-profile keys and a clean professional design.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1595225476474-87563907a212?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'LOG-MXKEYS-BK',
                            'price' => 109.00,
                            'stock' => 34,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                            ],
                        ],
                        [
                            'sku' => 'LOG-MXKEYS-SL',
                            'price' => 109.00,
                            'stock' => 12,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Nike Air Max 270',
                    'brand' => 'Nike',
                    'category' => 'Shoes',
                    'sku' => 'NIKE-AM270-001',
                    'source' => 'own',
                    'price' => 149.00,
                    'compare_price' => 179.00,
                    'cost_price' => 88.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Comfortable everyday sneakers with lightweight construction and distinctive Air cushioning.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'NIKE-AM270-BK-8',
                            'price' => 149.00,
                            'stock' => 12,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'size', 'value' => '8'],
                            ],
                        ],
                        [
                            'sku' => 'NIKE-AM270-BK-9',
                            'price' => 149.00,
                            'stock' => 18,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'size', 'value' => '9'],
                            ],
                        ],
                        [
                            'sku' => 'NIKE-AM270-WH-10',
                            'price' => 159.00,
                            'stock' => 15,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                                ['attribute' => 'size', 'value' => '10'],
                            ],
                        ],
                        [
                            'sku' => 'NIKE-AM270-WH-11',
                            'price' => 159.00,
                            'stock' => 9,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                                ['attribute' => 'size', 'value' => '11'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Nike Air Force 1',
                    'brand' => 'Nike',
                    'category' => 'Shoes',
                    'sku' => 'NIKE-AF1-001',
                    'source' => 'own',
                    'price' => 119.00,
                    'compare_price' => 139.00,
                    'cost_price' => 72.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Classic everyday sneakers with timeless styling, durable construction and comfortable cushioning.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1495555961986-6d4c1ecb7be3?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'NIKE-AF1-WH-8',
                            'price' => 119.00,
                            'stock' => 17,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                                ['attribute' => 'size', 'value' => '8'],
                            ],
                        ],
                        [
                            'sku' => 'NIKE-AF1-WH-10',
                            'price' => 119.00,
                            'stock' => 21,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                                ['attribute' => 'size', 'value' => '10'],
                            ],
                        ],
                        [
                            'sku' => 'NIKE-AF1-BK-11',
                            'price' => 129.00,
                            'stock' => 13,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'size', 'value' => '11'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Adidas Ultraboost Light',
                    'brand' => 'Adidas',
                    'category' => 'Sportswear',
                    'sku' => 'ADI-UBLIGHT-001',
                    'source' => 'own',
                    'price' => 160.00,
                    'compare_price' => 190.00,
                    'cost_price' => 95.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Responsive running shoes designed for everyday training, comfort and long-distance performance.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1554062614-6da4fa3e42d9?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'ADI-UBLIGHT-BK-9',
                            'price' => 160.00,
                            'stock' => 22,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'size', 'value' => '9'],
                            ],
                        ],
                        [
                            'sku' => 'ADI-UBLIGHT-WH-10',
                            'price' => 160.00,
                            'stock' => 16,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                                ['attribute' => 'size', 'value' => '10'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Adidas Samba OG',
                    'brand' => 'Adidas',
                    'category' => 'Shoes',
                    'sku' => 'ADI-SAMBAOG-001',
                    'source' => 'own',
                    'price' => 110.00,
                    'compare_price' => 130.00,
                    'cost_price' => 68.00,
                    'featured' => false,
                    'thumbnail' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Iconic low-profile sneakers with classic Adidas styling and versatile everyday comfort.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'ADI-SAMBAOG-BK-8',
                            'price' => 110.00,
                            'stock' => 20,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'size', 'value' => '8'],
                            ],
                        ],
                        [
                            'sku' => 'ADI-SAMBAOG-WH-10',
                            'price' => 110.00,
                            'stock' => 14,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                                ['attribute' => 'size', 'value' => '10'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Anker 737 Power Bank',
                    'brand' => 'Anker',
                    'category' => 'Accessories',
                    'sku' => 'ANK-737-001',
                    'source' => 'aliexpress',
                    'price' => 149.00,
                    'compare_price' => 169.00,
                    'cost_price' => 98.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1625842268584-8f3296236761?auto=format&fit=crop&w=1200&q=85',
                    'description' => 'High-capacity portable charger designed for laptops, tablets and smartphones.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1589003077984-894e133dabab?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'ANK-737-BK',
                            'price' => 149.00,
                            'stock' => 28,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Anker USB-C 7-in-1 Hub',
                    'brand' => 'Anker',
                    'category' => 'Computer Accessories',
                    'sku' => 'ANK-USBC7-001',
                    'source' => 'aliexpress',
                    'price' => 59.00,
                    'compare_price' => 69.00,
                    'cost_price' => 36.00,
                    'featured' => false,
                    'thumbnail' => 'https://images.unsplash.com/photo-1625842268584-8f3296236761?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Compact USB-C hub with multiple ports for laptops, tablets and modern workstations.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1625842268584-8f3296236761?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1628258334105-2a0b3d6a2a7b?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'ANK-USBC7-SL',
                            'price' => 59.00,
                            'stock' => 38,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'AirPods Pro',
                    'brand' => 'Apple',
                    'category' => 'Audio',
                    'sku' => 'APL-APPRO-001',
                    'source' => 'own',
                    'price' => 249.00,
                    'compare_price' => 279.00,
                    'cost_price' => 178.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Premium wireless earbuds with active noise cancellation, spatial audio and a compact charging case.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1588423771073-b8903fbbf8f7?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'APL-APPRO-WH',
                            'price' => 249.00,
                            'stock' => 31,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'white'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Logitech Brio 4K Webcam',
                    'brand' => 'Logitech',
                    'category' => 'Webcams',
                    'sku' => 'LOG-BRIO4K-001',
                    'source' => 'own',
                    'price' => 179.00,
                    'compare_price' => 199.00,
                    'cost_price' => 115.00,
                    'featured' => true,
                    'thumbnail' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Premium 4K webcam designed for professional video calls, streaming and content creation.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1588702547923-7093a6c3ba33?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'LOG-BRIO4K-BK',
                            'price' => 179.00,
                            'stock' => 23,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                            ],
                        ],
                    ],
                ],

                [
                    'name' => 'Apple Watch Series',
                    'brand' => 'Apple',
                    'category' => 'Accessories',
                    'sku' => 'APL-WATCH-001',
                    'source' => 'own',
                    'price' => 399.00,
                    'compare_price' => 449.00,
                    'cost_price' => 290.00,
                    'featured' => false,
                    'thumbnail' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=900&q=85',
                    'description' => 'Premium smartwatch with fitness tracking, notifications, health features and seamless smartphone integration.',
                    'gallery' => [
                        'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1434494878577-86c23bcb06b9?auto=format&fit=crop&w=1200&q=85',
                    ],
                    'variants' => [
                        [
                            'sku' => 'APL-WATCH-BK-41',
                            'price' => 399.00,
                            'stock' => 15,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'black'],
                                ['attribute' => 'size', 'value' => '7'],
                            ],
                        ],
                        [
                            'sku' => 'APL-WATCH-SL-45',
                            'price' => 429.00,
                            'stock' => 11,
                            'values' => [
                                ['attribute' => 'color', 'value' => 'silver'],
                                ['attribute' => 'size', 'value' => '9'],
                            ],
                        ],
                    ],
                ],
            ];

            foreach ($products as $sortOrder => $productData) {
                $this->createProduct(
                    productData: $productData,
                    sortOrder: $sortOrder + 1,
                    color: $color,
                    size: $size,
                    storage: $storage,
                );
            }
        });
    }

    /**
     * Create a product with its categories, variants and gallery.
     */
    private function createProduct(
        array $productData,
        int $sortOrder,
        Attribute $color,
        Attribute $size,
        Attribute $storage,
    ): void {
        $brand = Brand::where('slug', Str::slug($productData['brand']))
            ->firstOrFail();

        $category = Category::where('slug', Str::slug($productData['category']))
            ->firstOrFail();

        $product = Product::updateOrCreate(
            ['slug' => Str::slug($productData['name'])],
            [
                'brand_id' => $brand->id,
                'name' => $productData['name'],
                'sku' => $productData['sku'],
                'source' => $productData['source'],
                'thumbnail' => $productData['thumbnail'],
                'video_url' => null,
                'short_description' => Str::limit(
                    $productData['description'],
                    150,
                ),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'cost_price' => $productData['cost_price'],
                'status' => true,
                'featured' => $productData['featured'],
                'sort_order' => $sortOrder,
                'meta_title' => $productData['name'],
                'meta_description' => $productData['description'],
            ],
        );

        $product->categories()->sync([$category->id]);

        ProductVariantValue::whereHas(
            'variant',
            fn ($query) => $query->where('product_id', $product->id),
        )->delete();

        ProductVariant::where('product_id', $product->id)->delete();

        ProductImage::where('product_id', $product->id)->delete();

        foreach ($productData['variants'] as $variantData) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'sku' => $variantData['sku'],
                'price' => $variantData['price'],
                'compare_price' => $productData['compare_price'],
                'stock' => $variantData['stock'],
                'image' => $productData['thumbnail'],
                'status' => true,
            ]);

            foreach ($variantData['values'] as $variantValue) {
                $attribute = match ($variantValue['attribute']) {
                    'color' => $color,
                    'size' => $size,
                    'storage' => $storage,
                    default => throw new \InvalidArgumentException(
                        'Unknown attribute: ' . $variantValue['attribute'],
                    ),
                };

                $attributeValue = AttributeValue::where('attribute_id', $attribute->id)
                    ->where('slug', $variantValue['value'])
                    ->firstOrFail();

                ProductVariantValue::create([
                    'product_variant_id' => $variant->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => $attributeValue->id,
                ]);
            }
        }

        foreach ($productData['gallery'] as $imageOrder => $image) {
            ProductImage::create([
                'product_id' => $product->id,
                'variant_id' => null,
                'image' => $image,
                'alt_text' => $productData['name'] . ' product image',
                'sort_order' => $imageOrder + 1,
                'is_primary' => $imageOrder === 0,
            ]);
        }
    }
}
