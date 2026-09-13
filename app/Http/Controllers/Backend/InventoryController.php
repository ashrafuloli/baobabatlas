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

final class InventoryController extends Controller
{
    private const LOW_STOCK_THRESHOLD = 5;

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
                'lowStockThreshold' => self::LOW_STOCK_THRESHOLD,
            ],
        );
    }

    public function lowStock(Request $request): View
    {
        $products = $this->productQuery($request)
            ->whereHas(
                'variants',
                fn (Builder $query): Builder => $query
                    ->where('stock', '>', 0)
                    ->where(
                        'stock',
                        '<=',
                        self::LOW_STOCK_THRESHOLD,
                    ),
            )
            ->paginate(15)
            ->withQueryString();

        return view(
            'backend.pages.ecommerce.inventory.low-stock',
            [
                'products' => $products,
                'lowStockThreshold' => self::LOW_STOCK_THRESHOLD,
            ],
        );
    }

    public function outOfStock(Request $request): View
    {
        $products = $this->productQuery($request)
            ->whereHas(
                'variants',
                fn (Builder $query): Builder => $query->where(
                    'stock',
                    0,
                ),
            )
            ->paginate(15)
            ->withQueryString();

        return view(
            'backend.pages.ecommerce.inventory.out-of-stock',
            [
                'products' => $products,
            ],
        );
    }

    public function editProduct(Product $product): View
    {
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
            ],
        );
    }

    public function updateProduct(
        Request $request,
        Product $product,
    ): RedirectResponse {
        $validated = $request->validate([
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999.99',
            ],
        ]);

        $product->update([
            'price' => $validated['price'],
        ]);

        return redirect()
            ->route(
                'admin-inventory-product-edit',
                ['product' => $product],
            )
            ->with(
                'success',
                'Product price updated successfully.',
            );
    }

    public function editVariant(
        ProductVariant $variant,
    ): View {
        $variant->load([
            'product.brand',
            'product.categories',
            'values.attribute',
            'values.attributeValue',
        ]);

        return view(
            'backend.pages.ecommerce.inventory.variant-edit',
            [
                'variant' => $variant,
            ],
        );
    }

    public function updateVariant(
        Request $request,
        ProductVariant $variant,
    ): RedirectResponse {
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
            $oldStock = (int) $variant->stock;
            $newStock = (int) $validated['stock'];

            $variant->update([
                'price' => $validated['price'],
                'stock' => $newStock,
            ]);

            $stockDifference = $newStock - $oldStock;

            if ($stockDifference !== 0) {
                InventoryTransaction::query()->create([
                    'product_id' => $variant->product_id,
                    'product_variant_id' => $variant->id,
                    'type' => 'adjustment',
                    'quantity' => $stockDifference,
                    'reference' => 'admin_inventory',
                    'note' => 'Inventory updated from admin inventory.',
                ]);
            }
        });

        return redirect()
            ->route(
                'admin-inventory-variant-edit',
                ['variant' => $variant],
            )
            ->with(
                'success',
                'Variant inventory updated successfully.',
            );
    }

    private function productQuery(Request $request): Builder
    {
        $query = Product::query()
            ->with([
                'brand',
                'categories',
                'variants.values.attribute',
                'variants.values.attributeValue',
            ])
            ->orderByDesc('id');

        $search = trim(
            (string) $request->input('search'),
        );

        if ($search !== '') {
            $query->where(function (Builder $query) use (
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
                        ) use ($search): void {
                            $variantQuery->where(
                                'sku',
                                'like',
                                "%{$search}%",
                            );
                        },
                    );
            });
        }

        $brandId = $request->integer('brand_id');

        if ($brandId > 0) {
            $query->where(
                'brand_id',
                $brandId,
            );
        }

        $categoryId = $request->integer('category_id');

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

        $status = $request->input('status');

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

    /**
     * @return array<string, int>
     */
    private function inventoryStats(): array
    {
        $variantQuery = ProductVariant::query();

        return [
            'totalProducts' => Product::query()->count(),

            'totalVariants' => (clone $variantQuery)
                ->count(),

            'totalStock' => (clone $variantQuery)
                ->sum('stock'),

            'outOfStockVariants' => (clone $variantQuery)
                ->where('stock', 0)
                ->count(),

            'lowStockVariants' => (clone $variantQuery)
                ->where('stock', '>', 0)
                ->where(
                    'stock',
                    '<=',
                    self::LOW_STOCK_THRESHOLD,
                )
                ->count(),
        ];
    }
}
