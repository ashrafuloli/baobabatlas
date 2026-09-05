<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::query()
            ->where('status', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->with([
                'children' => function ($query): void {
                    $query
                        ->where('status', true)
                        ->withCount('products')
                        ->orderBy('sort_order')
                        ->orderBy('name');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Brands
        |--------------------------------------------------------------------------
        */

        $brands = Brand::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Attributes
        |--------------------------------------------------------------------------
        */

        $attributes = Attribute::query()
            ->where('status', true)
            ->with([
                'values' => function ($query): void {
                    $query
                        ->where('status', true)
                        ->orderBy('sort_order')
                        ->orderBy('label');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Selected Category Filters
        |--------------------------------------------------------------------------
        */

        $selectedCategorySlugs = $request->input(
            'category',
            [],
        );

        if (! is_array($selectedCategorySlugs)) {
            $selectedCategorySlugs = [
                $selectedCategorySlugs,
            ];
        }

        $selectedCategorySlugs = array_values(
            array_filter(
                $selectedCategorySlugs,
                static fn ($slug): bool => is_string($slug)
                    && $slug !== ''
                    && $slug !== 'all',
            ),
        );

        /*
        |--------------------------------------------------------------------------
        | Resolve Category IDs
        |--------------------------------------------------------------------------
        |
        | If a parent category is selected, its direct children
        | will also be included.
        |
        */

        $categoryIds = collect();

        if ($selectedCategorySlugs !== []) {
            $selectedCategories = Category::query()
                ->where('status', true)
                ->whereIn('slug', $selectedCategorySlugs)
                ->get([
                    'id',
                    'parent_id',
                ]);

            $selectedParentIds = $selectedCategories
                ->whereNull('parent_id')
                ->pluck('id');

            $selectedChildIds = $selectedCategories
                ->whereNotNull('parent_id')
                ->pluck('id');

            $childCategoryIds = Category::query()
                ->where('status', true)
                ->whereIn(
                    'parent_id',
                    $selectedParentIds,
                )
                ->pluck('id');

            $categoryIds = $selectedChildIds
                ->merge($selectedParentIds)
                ->merge($childCategoryIds)
                ->unique()
                ->values();
        }

        /*
        |--------------------------------------------------------------------------
        | Selected Brand Filters
        |--------------------------------------------------------------------------
        */

        $selectedBrandIds = $request->input(
            'brand',
            [],
        );

        if (! is_array($selectedBrandIds)) {
            $selectedBrandIds = [
                $selectedBrandIds,
            ];
        }

        $selectedBrandIds = array_values(
            array_filter(
                $selectedBrandIds,
                static fn ($id): bool => is_numeric($id),
            ),
        );

        /*
        |--------------------------------------------------------------------------
        | Selected Attribute Filters
        |--------------------------------------------------------------------------
        |
        | Expected URL:
        |
        | attribute[color][]=black
        | attribute[color][]=white
        | attribute[size][]=m
        | attribute[storage][]=256gb
        |
        */

        $selectedAttributes = $request->input(
            'attribute',
            [],
        );

        if (! is_array($selectedAttributes)) {
            $selectedAttributes = [];
        }

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products = Product::query()
            ->with([
                'brand',
                'categories',
                'variants',
            ])
            ->where('status', true)

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->filled('search'),
                function ($query) use ($request): void {
                    $search = $request
                        ->string('search')
                        ->trim()
                        ->toString();

                    if ($search === '') {
                        return;
                    }

                    $query->where(function ($query) use ($search): void {
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
                                'brand',
                                function ($query) use ($search): void {
                                    $query->where(
                                        'name',
                                        'like',
                                        "%{$search}%",
                                    );
                                },
                            )
                            ->orWhereHas(
                                'categories',
                                function ($query) use ($search): void {
                                    $query->where(
                                        'name',
                                        'like',
                                        "%{$search}%",
                                    );
                                },
                            );
                    });
                },
            )

            /*
            |--------------------------------------------------------------------------
            | Category Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                $categoryIds->isNotEmpty(),
                function ($query) use ($categoryIds): void {
                    $query->whereHas(
                        'categories',
                        function ($query) use ($categoryIds): void {
                            $query->whereIn(
                                'categories.id',
                                $categoryIds,
                            );
                        },
                    );
                },
            )

            /*
            |--------------------------------------------------------------------------
            | Brand Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                $selectedBrandIds !== [],
                function ($query) use ($selectedBrandIds): void {
                    $query->whereIn(
                        'brand_id',
                        $selectedBrandIds,
                    );
                },
            )

            /*
            |--------------------------------------------------------------------------
            | Minimum Price
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->filled('min_price'),
                function ($query) use ($request): void {
                    $minPrice = (float) $request->input(
                        'min_price',
                    );

                    if ($minPrice >= 0) {
                        $query->where(
                            'price',
                            '>=',
                            $minPrice,
                        );
                    }
                },
            )

            /*
            |--------------------------------------------------------------------------
            | Maximum Price
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->filled('max_price'),
                function ($query) use ($request): void {
                    $maxPrice = (float) $request->input(
                        'max_price',
                    );

                    if ($maxPrice > 0) {
                        $query->where(
                            'price',
                            '<=',
                            $maxPrice,
                        );
                    }
                },
            )

            /*
            |--------------------------------------------------------------------------
            | Attribute Filters
            |--------------------------------------------------------------------------
            |
            | Product
            |   -> variants
            |       -> values
            |           -> attribute
            |           -> attributeValue
            |
            */

            ->when(
                $selectedAttributes !== [],
                function ($query) use ($selectedAttributes): void {
                    foreach (
                        $selectedAttributes as $attributeSlug => $valueSlugs
                    ) {
                        if (! is_array($valueSlugs)) {
                            $valueSlugs = [
                                $valueSlugs,
                            ];
                        }

                        $valueSlugs = array_values(
                            array_filter(
                                $valueSlugs,
                                static fn ($slug): bool => is_string($slug)
                                    && $slug !== '',
                            ),
                        );

                        if (
                            ! is_string($attributeSlug)
                            || $attributeSlug === ''
                            || $valueSlugs === []
                        ) {
                            continue;
                        }

                        $query->whereHas(
                            'variants.values',
                            function ($query) use (
                                $attributeSlug,
                                $valueSlugs,
                            ): void {
                                $query
                                    ->whereHas(
                                        'attribute',
                                        function ($query) use (
                                            $attributeSlug,
                                        ): void {
                                            $query->where(
                                                'slug',
                                                $attributeSlug,
                                            );
                                        },
                                    )
                                    ->whereHas(
                                        'attributeValue',
                                        function ($query) use (
                                            $valueSlugs,
                                        ): void {
                                            $query->whereIn(
                                                'slug',
                                                $valueSlugs,
                                            );
                                        },
                                    );
                            },
                        );
                    }
                },
            )

            /*
            |--------------------------------------------------------------------------
            | Sorting
            |--------------------------------------------------------------------------
            */

            ->when(
                $request->filled('sort'),
                function ($query) use ($request): void {
                    match ($request->input('sort')) {
                        'newest' => $query
                            ->orderByDesc('created_at')
                            ->orderBy('name'),

                        'price-low-high' => $query
                            ->orderBy('price')
                            ->orderBy('name'),

                        'price-high-low' => $query
                            ->orderByDesc('price')
                            ->orderBy('name'),

                        default => $query
                            ->orderBy('sort_order')
                            ->orderBy('name'),
                    };
                },
                function ($query): void {
                    $query
                        ->orderBy('sort_order')
                        ->orderBy('name');
                },
            )

            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            ->paginate(12)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Dynamic Maximum Price
        |--------------------------------------------------------------------------
        */

        $maximumProductPrice = (float) Product::query()
            ->where('status', true)
            ->max('price');

        $priceMax = (int) ceil(
                $maximumProductPrice / 1000,
            ) * 1000;

        $priceMax = max(
            $priceMax,
            10000,
        );

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.pages.shop.index',
            compact(
                'categories',
                'brands',
                'attributes',
                'products',
                'priceMax',
                'selectedCategorySlugs',
                'selectedBrandIds',
                'selectedAttributes',
            ),
        );
    }


}
