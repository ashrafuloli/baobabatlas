<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class InventoryController extends Controller
{
    private const LOW_STOCK_THRESHOLD = 5;


    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $products = $this->productQuery($request)
            ->paginate(15)
            ->withQueryString();


        return view(
            'backend.pages.ecommerce.inventory.index',
            [
                'products' => $products,

                'brands' => Brand::query()
                    ->orderBy('name')
                    ->get(),

                'categories' => Category::query()
                    ->orderBy('name')
                    ->get(),

                'stats' => $this->inventoryStats(),

                'lowStockThreshold' =>
                    self::LOW_STOCK_THRESHOLD,
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Low Stock
    |--------------------------------------------------------------------------
    */

    public function lowStock(Request $request): View
    {
        $products = $this->productQuery($request)
            ->where(function (Builder $query): void {

                /*
                |--------------------------------------------------------------------------
                | Simple Product
                |--------------------------------------------------------------------------
                */

                $query->where(function (
                    Builder $simpleQuery
                ): void {

                    $simpleQuery
                        ->where('type', 'simple')
                        ->where('stock', '>', 0)
                        ->where(
                            'stock',
                            '<=',
                            self::LOW_STOCK_THRESHOLD,
                        );

                });


                /*
                |--------------------------------------------------------------------------
                | Variable Product
                |--------------------------------------------------------------------------
                |
                | A variable product is included when at least one
                | ACTIVE variant has low stock.
                |
                */

                $query->orWhere(function (
                    Builder $variableQuery
                ): void {

                    $variableQuery
                        ->where('type', 'variable')
                        ->whereHas(
                            'variants',
                            function (
                                Builder $variantQuery
                            ): void {

                                $variantQuery
                                    ->where(
                                        'status',
                                        true,
                                    )
                                    ->where(
                                        'stock',
                                        '>',
                                        0,
                                    )
                                    ->where(
                                        'stock',
                                        '<=',
                                        self::LOW_STOCK_THRESHOLD,
                                    );

                            },
                        );

                });

            })
            ->paginate(15)
            ->withQueryString();


        return view(
            'backend.pages.ecommerce.inventory.low-stock',
            [
                'products' => $products,

                'lowStockThreshold' =>
                    self::LOW_STOCK_THRESHOLD,
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Out Of Stock
    |--------------------------------------------------------------------------
    */

    public function outOfStock(Request $request): View
    {
        $products = $this->productQuery($request)
            ->where(function (Builder $query): void {

                /*
                |--------------------------------------------------------------------------
                | Simple Product
                |--------------------------------------------------------------------------
                |
                | A simple product is out of stock when its own
                | product-level stock is zero.
                |
                */

                $query->where(function (
                    Builder $simpleQuery
                ): void {

                    $simpleQuery
                        ->where('type', 'simple')
                        ->where('stock', 0);

                });


                /*
                |--------------------------------------------------------------------------
                | Variable Product
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | A variable product appears on this page when
                | ANY ACTIVE variant has zero stock.
                |
                | Example:
                |
                | Small  = 0
                | Medium = 10
                | Large  = 5
                |
                | Product appears because Small is out of stock.
                |
                */

                $query->orWhere(function (
                    Builder $variableQuery
                ): void {

                    $variableQuery
                        ->where('type', 'variable')
                        ->whereHas(
                            'variants',
                            function (
                                Builder $variantQuery
                            ): void {

                                $variantQuery
                                    ->where(
                                        'status',
                                        true,
                                    )
                                    ->where(
                                        'stock',
                                        0,
                                    );

                            },
                        );

                });

            })
            ->paginate(15)
            ->withQueryString();


        return view(
            'backend.pages.ecommerce.inventory.out-of-stock',
            [
                'products' => $products,

                'lowStockThreshold' =>
                    self::LOW_STOCK_THRESHOLD,
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Product
    |--------------------------------------------------------------------------
    */

    public function editProduct(
        Product $product,
    ): View {

        $product->load([
            'brand',
            'categories',
            'variants.values.attribute',
            'variants.values.attributeValue',
        ]);


        return view(
            'backend.pages.ecommerce.inventory.product-edit',
            [
                'product' => $product,

                'lowStockThreshold' =>
                    self::LOW_STOCK_THRESHOLD,
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    public function updateProduct(
        Request $request,
        Product $product,
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validation Rules
        |--------------------------------------------------------------------------
        */

        $rules = [
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999.99',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | Simple Product Stock
        |--------------------------------------------------------------------------
        |
        | Only simple products can update products.stock.
        |
        | Variable products keep products.stock at zero.
        |
        */

        if ($product->isSimple()) {

            $rules['stock'] = [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ];

        }


        $validated = $request->validate(
            $rules
        );


        DB::transaction(function () use (
            $product,
            $validated,
        ): void {

            /*
            |--------------------------------------------------------------------------
            | Lock Product
            |--------------------------------------------------------------------------
            */

            $product = Product::query()
                ->whereKey($product->id)
                ->lockForUpdate()
                ->firstOrFail();


            /*
            |--------------------------------------------------------------------------
            | Validate Product Type
            |--------------------------------------------------------------------------
            */

            if (
                !$product->isSimple()
                && !$product->isVariable()
            ) {

                throw ValidationException::withMessages([
                    'price' =>
                        'This product has an invalid product type.',
                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Update Product Price
            |--------------------------------------------------------------------------
            */

            $product->price =
                $validated['price'];


            /*
            |--------------------------------------------------------------------------
            | Simple Product
            |--------------------------------------------------------------------------
            */

            if ($product->isSimple()) {

                $oldStock =
                    (int) $product->stock;


                $newStock =
                    (int) $validated['stock'];


                /*
                |--------------------------------------------------------------------------
                | Update Stock
                |--------------------------------------------------------------------------
                */

                $product->stock =
                    $newStock;


                /*
                |--------------------------------------------------------------------------
                | Stock Difference
                |--------------------------------------------------------------------------
                */

                $stockDifference =
                    $newStock - $oldStock;


                /*
                |--------------------------------------------------------------------------
                | Inventory Transaction
                |--------------------------------------------------------------------------
                */

                if ($stockDifference !== 0) {

                    InventoryTransaction::query()->create([
                        'product_id' =>
                            $product->id,

                        /*
                        |--------------------------------------------------------------------------
                        | Simple Product Has No Variant
                        |--------------------------------------------------------------------------
                        */

                        'product_variant_id' =>
                            null,

                        'type' =>
                            'adjustment',

                        'quantity' =>
                            $stockDifference,

                        'reference' =>
                            'admin_inventory',

                        'note' =>
                            'Simple product inventory updated from admin inventory.',
                    ]);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Variable Product
            |--------------------------------------------------------------------------
            |
            | Variable products do not use products.stock.
            |
            */

            if ($product->isVariable()) {

                $product->stock = 0;

            }


            /*
            |--------------------------------------------------------------------------
            | Save Product
            |--------------------------------------------------------------------------
            */

            $product->save();

        });


        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin-inventory-product-edit',
                [
                    'product' => $product,
                ],
            )
            ->with(
                'success',
                $product->isSimple()
                    ? 'Product price and inventory updated successfully.'
                    : 'Product price updated successfully. Variant inventory is managed separately.',
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Variant
    |--------------------------------------------------------------------------
    */

    public function editVariant(
        ProductVariant $variant,
    ): View {

        $variant->load([
            'product.brand',
            'product.categories',
            'values.attribute',
            'values.attributeValue',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Invalid Parent Product
        |--------------------------------------------------------------------------
        */

        if (!$variant->product?->isVariable()) {

            abort(
                404,
                'This variant does not belong to a variable product.',
            );

        }


        return view(
            'backend.pages.ecommerce.inventory.variant-edit',
            [
                'variant' => $variant,

                'lowStockThreshold' =>
                    self::LOW_STOCK_THRESHOLD,
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Variant
    |--------------------------------------------------------------------------
    */

    public function updateVariant(
        Request $request,
        ProductVariant $variant,
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validate Variant
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999.99',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
        ]);


        DB::transaction(function () use (
            $variant,
            $validated,
        ): void {

            /*
            |--------------------------------------------------------------------------
            | Lock Variant
            |--------------------------------------------------------------------------
            */

            $variant = ProductVariant::query()
                ->whereKey($variant->id)
                ->lockForUpdate()
                ->firstOrFail();


            /*
            |--------------------------------------------------------------------------
            | Lock Parent Product
            |--------------------------------------------------------------------------
            */

            $product = Product::query()
                ->whereKey($variant->product_id)
                ->lockForUpdate()
                ->first();


            if ($product === null) {

                throw ValidationException::withMessages([
                    'stock' =>
                        'The parent product could not be found.',
                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Validate Parent Product Type
            |--------------------------------------------------------------------------
            */

            if (!$product->isVariable()) {

                throw ValidationException::withMessages([
                    'stock' =>
                        'Only variable products can have inventory variants.',
                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Existing Stock
            |--------------------------------------------------------------------------
            */

            $oldStock =
                (int) $variant->stock;


            $newStock =
                (int) $validated['stock'];


            /*
            |--------------------------------------------------------------------------
            | Update Variant
            |--------------------------------------------------------------------------
            */

            $variant->update([
                'price' =>
                    $validated['price'],

                'stock' =>
                    $newStock,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Stock Difference
            |--------------------------------------------------------------------------
            */

            $stockDifference =
                $newStock - $oldStock;


            /*
            |--------------------------------------------------------------------------
            | Inventory Transaction
            |--------------------------------------------------------------------------
            */

            if ($stockDifference !== 0) {

                InventoryTransaction::query()->create([
                    'product_id' =>
                        $product->id,

                    'product_variant_id' =>
                        $variant->id,

                    'type' =>
                        'adjustment',

                    'quantity' =>
                        $stockDifference,

                    'reference' =>
                        'admin_inventory',

                    'note' =>
                        'Variant inventory updated from admin inventory.',
                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Keep Variable Product Stock Zero
            |--------------------------------------------------------------------------
            */

            if ((int) $product->stock !== 0) {

                $product->stock = 0;

                $product->save();

            }

        });


        return redirect()
            ->route(
                'admin-inventory-variant-edit',
                [
                    'variant' => $variant,
                ],
            )
            ->with(
                'success',
                'Variant inventory updated successfully.',
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Product Query
    |--------------------------------------------------------------------------
    */

    private function productQuery(
        Request $request,
    ): Builder {

        $query = Product::query()
            ->with([
                'brand',
                'categories',
                'variants.values.attribute',
                'variants.values.attributeValue',
            ])
            ->orderByDesc('id');


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search = trim(
            (string) $request->input('search'),
        );


        if ($search !== '') {

            $query->where(
                function (Builder $query) use (
                    $search,
                ): void {

                    $query
                        ->where(
                            'name',
                            'like',
                            "%{$search}%",
                        )
                        ->orWhere(
                            'sku',
                            'like',
                            "%{$search}%",
                        )
                        ->orWhereHas(
                            'variants',
                            function (
                                Builder $variantQuery
                            ) use (
                                $search,
                            ): void {

                                $variantQuery->where(
                                    'sku',
                                    'like',
                                    "%{$search}%",
                                );

                            },
                        );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Brand
        |--------------------------------------------------------------------------
        */

        $brandId =
            $request->integer('brand_id');


        if ($brandId > 0) {

            $query->where(
                'brand_id',
                $brandId,
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $categoryId =
            $request->integer('category_id');


        if ($categoryId > 0) {

            $query->whereHas(
                'categories',
                fn (
                    Builder $categoryQuery
                ): Builder => $categoryQuery->whereKey(
                    $categoryId,
                ),
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        $status =
            $request->input('status');


        if (
            $status !== null
            && $status !== ''
        ) {

            $query->where(
                'status',
                filter_var(
                    $status,
                    FILTER_VALIDATE_BOOLEAN,
                ),
            );

        }


        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | Inventory Statistics
    |--------------------------------------------------------------------------
    */

    /**
     * @return array<string, int>
     */
    private function inventoryStats(): array
    {
        /*
        |--------------------------------------------------------------------------
        | Base Queries
        |--------------------------------------------------------------------------
        */

        $simpleProducts =
            Product::query()
                ->where(
                    'type',
                    'simple',
                );


        $variableProducts =
            Product::query()
                ->where(
                    'type',
                    'variable',
                );


        $variantQuery =
            ProductVariant::query();


        /*
        |--------------------------------------------------------------------------
        | Total Products
        |--------------------------------------------------------------------------
        */

        $totalProducts =
            Product::query()->count();


        /*
        |--------------------------------------------------------------------------
        | Product Counts
        |--------------------------------------------------------------------------
        */

        $totalSimpleProducts =
            (clone $simpleProducts)->count();


        $totalVariableProducts =
            (clone $variableProducts)->count();


        /*
        |--------------------------------------------------------------------------
        | Total Variants
        |--------------------------------------------------------------------------
        |
        | This counts ALL variants, including inactive variants.
        |
        */

        $totalVariants =
            (clone $variantQuery)->count();


        /*
        |--------------------------------------------------------------------------
        | Simple Product Stock
        |--------------------------------------------------------------------------
        */

        $simpleStock =
            (int) (clone $simpleProducts)
                ->sum('stock');


        /*
        |--------------------------------------------------------------------------
        | Active Variant Stock
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Only active variants are considered sellable inventory.
        |
        | Inactive variant stock is intentionally excluded.
        |
        */

        $activeVariantStock =
            (int) (clone $variantQuery)
                ->where(
                    'status',
                    true,
                )
                ->sum('stock');


        /*
        |--------------------------------------------------------------------------
        | Total Stock
        |--------------------------------------------------------------------------
        */

        $totalStock =
            $simpleStock
            + $activeVariantStock;


        /*
        |--------------------------------------------------------------------------
        | Out Of Stock — Simple Products
        |--------------------------------------------------------------------------
        */

        $outOfStockSimple =
            (clone $simpleProducts)
                ->where(
                    'stock',
                    0,
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Out Of Stock — Individual Active Variants
        |--------------------------------------------------------------------------
        |
        | Counts each active variant whose stock is zero.
        |
        */

        $outOfStockVariantsOnly =
            (clone $variantQuery)
                ->where(
                    'status',
                    true,
                )
                ->where(
                    'stock',
                    0,
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Out Of Stock — Variable Products
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | A variable product is included when ANY ACTIVE variant
        | has zero stock.
        |
        | Example:
        |
        | Black  = 0
        | White  = 1
        |
        | Product appears on the Out of Stock page.
        |
        */

        $outOfStockVariableProducts =
            (clone $variableProducts)
                ->whereHas(
                    'variants',
                    function (
                        Builder $query
                    ): void {

                        $query
                            ->where(
                                'status',
                                true,
                            )
                            ->where(
                                'stock',
                                0,
                            );

                    },
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Total Out Of Stock Products
        |--------------------------------------------------------------------------
        */

        $outOfStockProducts =
            $outOfStockSimple
            + $outOfStockVariableProducts;


        /*
        |--------------------------------------------------------------------------
        | Low Stock — Simple Products
        |--------------------------------------------------------------------------
        */

        $lowStockSimple =
            (clone $simpleProducts)
                ->where(
                    'stock',
                    '>',
                    0,
                )
                ->where(
                    'stock',
                    '<=',
                    self::LOW_STOCK_THRESHOLD,
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Low Stock — Individual Active Variants
        |--------------------------------------------------------------------------
        */

        $lowStockVariantsOnly =
            (clone $variantQuery)
                ->where(
                    'status',
                    true,
                )
                ->where(
                    'stock',
                    '>',
                    0,
                )
                ->where(
                    'stock',
                    '<=',
                    self::LOW_STOCK_THRESHOLD,
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Low Stock — Variable Products
        |--------------------------------------------------------------------------
        |
        | A variable product is considered Low Stock when at least
        | one ACTIVE variant has stock between 1 and the threshold.
        |
        */

        $lowStockVariableProducts =
            (clone $variableProducts)
                ->whereHas(
                    'variants',
                    function (
                        Builder $query
                    ): void {

                        $query
                            ->where(
                                'status',
                                true,
                            )
                            ->where(
                                'stock',
                                '>',
                                0,
                            )
                            ->where(
                                'stock',
                                '<=',
                                self::LOW_STOCK_THRESHOLD,
                            );

                    },
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Total Low Stock Products
        |--------------------------------------------------------------------------
        */

        $lowStockProducts =
            $lowStockSimple
            + $lowStockVariableProducts;


        /*
        |--------------------------------------------------------------------------
        | Return Statistics
        |--------------------------------------------------------------------------
        */

        return [

            /*
            |--------------------------------------------------------------------------
            | General
            |--------------------------------------------------------------------------
            */

            'totalProducts' =>
                $totalProducts,

            'totalSimpleProducts' =>
                $totalSimpleProducts,

            'totalVariableProducts' =>
                $totalVariableProducts,

            'totalVariants' =>
                $totalVariants,


            /*
            |--------------------------------------------------------------------------
            | Stock
            |--------------------------------------------------------------------------
            */

            'totalStock' =>
                $totalStock,


            /*
            |--------------------------------------------------------------------------
            | Product-Level Stock Status
            |--------------------------------------------------------------------------
            */

            'outOfStockProducts' =>
                $outOfStockProducts,

            'lowStockProducts' =>
                $lowStockProducts,


            /*
            |--------------------------------------------------------------------------
            | Simple Product Stats
            |--------------------------------------------------------------------------
            */

            'outOfStockSimpleProducts' =>
                $outOfStockSimple,

            'lowStockSimpleProducts' =>
                $lowStockSimple,


            /*
            |--------------------------------------------------------------------------
            | Variable Product Stats
            |--------------------------------------------------------------------------
            */

            'outOfStockVariableProducts' =>
                $outOfStockVariableProducts,

            'lowStockVariableProducts' =>
                $lowStockVariableProducts,


            /*
            |--------------------------------------------------------------------------
            | Individual Variant Stats
            |--------------------------------------------------------------------------
            */

            'outOfStockVariantsOnly' =>
                $outOfStockVariantsOnly,

            'lowStockVariantsOnly' =>
                $lowStockVariantsOnly,


            /*
            |--------------------------------------------------------------------------
            | Backward Compatibility
            |--------------------------------------------------------------------------
            |
            | These keys are kept so existing views do not break.
            |
            */

            'outOfStockVariants' =>
                $outOfStockSimple
                + $outOfStockVariableProducts,

            'lowStockVariants' =>
                $lowStockSimple
                + $lowStockVariableProducts,
        ];
    }
}
