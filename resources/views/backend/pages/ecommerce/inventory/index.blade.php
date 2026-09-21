@extends('backend.layouts.backend')

@section('title', 'Inventory')

@section('content')
    <div class="inventory-page">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="inventory-page__header">

            <div>
                <h1 class="inventory-page__title">
                    Inventory
                </h1>

                <p class="inventory-page__subtitle">
                    Monitor product and variant stock levels.
                </p>
            </div>


            <div class="inventory-page__actions">

                <a
                    href="{{ route('admin-inventory-low-stock') }}"
                    class="inventory-page__action inventory-page__action--warning"
                >
                    <span class="inventory-page__action-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </span>

                    Low Stock
                </a>


                <a
                    href="{{ route('admin-inventory-out-of-stock') }}"
                    class="inventory-page__action inventory-page__action--danger"
                >
                    <span class="inventory-page__action-icon">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </span>

                    Out of Stock
                </a>

            </div>

        </div>


        {{-- =========================================================
            STATISTICS
        ========================================================== --}}
        <div class="inventory-stats">

            {{-- Total Products --}}
            <div class="inventory-stat">

                <div class="inventory-stat__icon">
                    <i class="fa-solid fa-box"></i>
                </div>

                <div class="inventory-stat__content">

                    <span class="inventory-stat__label">
                        Total Products
                    </span>

                    <strong class="inventory-stat__value">
                        {{ number_format($stats['totalProducts']) }}
                    </strong>

                </div>

            </div>


            {{-- Total Variants --}}
            <div class="inventory-stat">

                <div class="inventory-stat__icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>

                <div class="inventory-stat__content">

                    <span class="inventory-stat__label">
                        Total Variants
                    </span>

                    <strong class="inventory-stat__value">
                        {{ number_format($stats['totalVariants']) }}
                    </strong>

                </div>

            </div>


            {{-- Total Stock --}}
            <div class="inventory-stat">

                <div class="inventory-stat__icon">
                    <i class="fa-solid fa-cubes"></i>
                </div>

                <div class="inventory-stat__content">

                    <span class="inventory-stat__label">
                        Total Stock
                    </span>

                    <strong class="inventory-stat__value">
                        {{ number_format($stats['totalStock']) }}
                    </strong>

                </div>

            </div>


            {{-- Low Stock Products --}}
            <div class="inventory-stat inventory-stat--warning">

                <div class="inventory-stat__icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div class="inventory-stat__content">

                    <span class="inventory-stat__label">
                        Low Stock
                    </span>

                    <strong class="inventory-stat__value">
                        {{ number_format($stats['lowStockProducts']) }}
                    </strong>

                </div>

            </div>


            {{-- Out Of Stock Products --}}
            <div class="inventory-stat inventory-stat--danger">

                <div class="inventory-stat__icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>

                <div class="inventory-stat__content">

                    <span class="inventory-stat__label">
                        Out of Stock
                    </span>

                    <strong class="inventory-stat__value">
                        {{ number_format($stats['outOfStockProducts']) }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =========================================================
            FILTERS
        ========================================================== --}}
        <div class="inventory-card inventory-filters">

            <form
                action="{{ route('admin-inventory') }}"
                method="GET"
                class="inventory-filters__form"
                id="inventory-filter-form"
            >

                {{-- Search --}}
                <div class="inventory-filter">

                    <label
                        for="inventory-search"
                        class="inventory-filter__label"
                    >
                        Search
                    </label>

                    <div class="inventory-filter__input-wrapper">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="search"
                            name="search"
                            id="inventory-search"
                            value="{{ request('search') }}"
                            placeholder="Search product or SKU..."
                            class="inventory-filter__input"
                            autocomplete="off"
                        >

                    </div>

                </div>


                {{-- Brand --}}
                <div class="inventory-filter">

                    <label
                        for="inventory-brand"
                        class="inventory-filter__label"
                    >
                        Brand
                    </label>

                    <select
                        name="brand_id"
                        id="inventory-brand"
                        class="inventory-filter__select"
                    >

                        <option value="">
                            All Brands
                        </option>

                        @foreach ($brands as $brand)

                            <option
                                value="{{ $brand->id }}"
                                @selected(
                                    (string) request('brand_id')
                                    === (string) $brand->id
                                )
                            >
                                {{ $brand->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Category --}}
                <div class="inventory-filter">

                    <label
                        for="inventory-category"
                        class="inventory-filter__label"
                    >
                        Category
                    </label>

                    <select
                        name="category_id"
                        id="inventory-category"
                        class="inventory-filter__select"
                    >

                        <option value="">
                            All Categories
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    (string) request('category_id')
                                    === (string) $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div class="inventory-filter">

                    <label
                        for="inventory-status"
                        class="inventory-filter__label"
                    >
                        Status
                    </label>

                    <select
                        name="status"
                        id="inventory-status"
                        class="inventory-filter__select"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="1"
                            @selected(request('status') === '1')
                        >
                            Active
                        </option>

                        <option
                            value="0"
                            @selected(request('status') === '0')
                        >
                            Inactive
                        </option>

                    </select>

                </div>


                {{-- Filter Buttons --}}
                <div class="inventory-filters__buttons">

                    <button
                        type="submit"
                        class="inventory-button inventory-button--primary"
                    >
                        <i class="fa-solid fa-filter"></i>

                        Filter
                    </button>


                    <a
                        href="{{ route('admin-inventory') }}"
                        class="inventory-button inventory-button--secondary"
                        id="inventory-reset"
                    >
                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- =========================================================
            INVENTORY TABLE
        ========================================================== --}}
        <div class="inventory-card inventory-table-card">

            <div class="inventory-table-card__header">

                <div>

                    <h2 class="inventory-table-card__title">
                        Inventory Items
                    </h2>

                    <p class="inventory-table-card__description">

                        {{ number_format($products->total()) }}

                        {{ Str::plural('product', $products->total()) }}

                        found

                    </p>

                </div>

            </div>


            <div class="inventory-table-wrapper">

                <table class="inventory-table">

                    <thead>

                    <tr>

                        <th>
                            Product
                        </th>

                        <th>
                            SKU
                        </th>

                        <th>
                            Type
                        </th>

                        <th>
                            Variants
                        </th>

                        <th>
                            Stock
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="inventory-table__action-column">
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    @forelse ($products as $product)

                        @php
                            /*
                            |--------------------------------------------------------------------------
                            | Product Type
                            |--------------------------------------------------------------------------
                            */

                            $isSimple =
                                $product->isSimple();

                            $isVariable =
                                $product->isVariable();


                            /*
                            |--------------------------------------------------------------------------
                            | Variants
                            |--------------------------------------------------------------------------
                            |
                            | Keep ALL variants for the expandable list.
                            |
                            | Only ACTIVE variants participate in stock
                            | calculations.
                            |
                            */

                            $variants =
                                $product->variants;

                            $activeVariants =
                                $isVariable
                                    ? $variants->where(
                                        'status',
                                        true,
                                    )
                                    : collect();


                            $hasVariants =
                                $isVariable
                                && $variants->isNotEmpty();


                            $hasActiveVariants =
                                $isVariable
                                && $activeVariants->isNotEmpty();


                            /*
                            |--------------------------------------------------------------------------
                            | Variant Stock Summary
                            |--------------------------------------------------------------------------
                            */

                            $outOfStockVariantCount =
                                $isVariable
                                    ? $activeVariants
                                        ->where(
                                            'stock',
                                            0,
                                        )
                                        ->count()
                                    : 0;


                            $lowStockVariantCount =
                                $isVariable
                                    ? $activeVariants
                                        ->filter(
                                            fn ($variant): bool =>
                                                (int) $variant->stock > 0
                                                && (int) $variant->stock <= $lowStockThreshold
                                        )
                                        ->count()
                                    : 0;


                            $availableVariantCount =
                                $isVariable
                                    ? $activeVariants
                                        ->filter(
                                            fn ($variant): bool =>
                                                (int) $variant->stock > 0
                                        )
                                        ->count()
                                    : 0;


                            /*
                            |--------------------------------------------------------------------------
                            | Product Stock
                            |--------------------------------------------------------------------------
                            */

                            if ($isSimple) {

                                /*
                                |--------------------------------------------------------------------------
                                | Simple Product
                                |--------------------------------------------------------------------------
                                */

                                $totalProductStock =
                                    (int) $product->stock;


                                $productOutOfStock =
                                    $totalProductStock === 0;


                                $productLowStock =
                                    $totalProductStock > 0
                                    && $totalProductStock <= $lowStockThreshold;


                                $productInStock =
                                    $totalProductStock > 0;

                            } elseif ($isVariable) {

                                /*
                                |--------------------------------------------------------------------------
                                | Variable Product
                                |--------------------------------------------------------------------------
                                |
                                | Product stock is the SUM of ACTIVE
                                | variant stock only.
                                |
                                */

                                $totalProductStock =
                                    (int) $activeVariants->sum('stock');


                                /*
                                |--------------------------------------------------------------------------
                                | Product Out Of Stock
                                |--------------------------------------------------------------------------
                                |
                                | The whole variable product is out of
                                | stock only when it has active variants
                                | and ALL active variants are zero.
                                |
                                */

                                $productOutOfStock =
                                    $hasActiveVariants
                                    && $availableVariantCount === 0;


                                /*
                                |--------------------------------------------------------------------------
                                | Product Low Stock
                                |--------------------------------------------------------------------------
                                |
                                | Product is low stock when:
                                |
                                | - At least one active variant is low stock
                                | - But the whole product is not out of stock
                                |
                                */

                                $productLowStock =
                                    !$productOutOfStock
                                    && $lowStockVariantCount > 0;


                                /*
                                |--------------------------------------------------------------------------
                                | Product In Stock
                                |--------------------------------------------------------------------------
                                */

                                $productInStock =
                                    $availableVariantCount > 0;

                            } else {

                                /*
                                |--------------------------------------------------------------------------
                                | Invalid Product Type Fallback
                                |--------------------------------------------------------------------------
                                */

                                $totalProductStock = 0;

                                $productOutOfStock = false;

                                $productLowStock = false;

                                $productInStock = false;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Product Type Label
                            |--------------------------------------------------------------------------
                            */

                            $productTypeLabel =
                                $isVariable
                                    ? 'Variable'
                                    : 'Simple';

                        @endphp


                        {{-- =================================================
                            PRODUCT ROW
                        ================================================== --}}
                        <tr
                            class="inventory-table__row"
                            data-product-type="{{ $productTypeLabel }}"
                        >

                            {{-- Product --}}
                            <td>

                                <div class="inventory-product">

                                    <div class="inventory-product__image">

                                        @if ($product->thumbnail)

                                            <img
                                                src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->name }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <span>
                                                <i class="fa-solid fa-box"></i>
                                            </span>

                                        @endif

                                    </div>


                                    <div class="inventory-product__info">

                                        <a
                                            href="{{ route(
                                                'admin-inventory-product-edit',
                                                ['product' => $product]
                                            ) }}"
                                            class="inventory-product__name"
                                        >
                                            {{ $product->name }}
                                        </a>


                                        @if ($product->brand)

                                            <span class="inventory-product__brand">
                                                {{ $product->brand->name }}
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- SKU --}}
                            <td>

                                <span class="inventory-sku">
                                    {{ $product->sku ?: '—' }}
                                </span>

                            </td>


                            {{-- Type --}}
                            <td>

                                <span
                                    class="
                                        inventory-product-type
                                        inventory-product-type--{{ $isVariable ? 'variable' : 'simple' }}
                                    "
                                >

                                    @if ($isVariable)

                                        <i class="fa-solid fa-layer-group"></i>

                                        Variable

                                    @else

                                        <i class="fa-solid fa-box"></i>

                                        Simple

                                    @endif

                                </span>

                            </td>


                            {{-- Variants --}}
                            <td>

                                @if ($isVariable)

                                    @if ($hasVariants)

                                        <span class="inventory-variant-count">

                                            {{ $variants->count() }}

                                            {{ Str::plural(
                                                'variant',
                                                $variants->count()
                                            ) }}

                                        </span>

                                    @else

                                        <span class="inventory-no-variant">
                                            No variants
                                        </span>

                                    @endif

                                @else

                                    <span class="inventory-no-variant">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Stock --}}
                            <td>

                                <div class="inventory-stock">

                                    <strong class="inventory-stock__total">
                                        {{ number_format($totalProductStock) }}
                                    </strong>


                                    @if ($productOutOfStock)

                                        <span
                                            class="
                                                inventory-stock__badge
                                                inventory-stock__badge--danger
                                            "
                                        >
                                            Out of stock
                                        </span>

                                    @elseif ($productLowStock)

                                        <span
                                            class="
                                                inventory-stock__badge
                                                inventory-stock__badge--warning
                                            "
                                        >
                                            Low stock
                                        </span>

                                    @else

                                        <span
                                            class="
                                                inventory-stock__badge
                                                inventory-stock__badge--success
                                            "
                                        >
                                            In stock
                                        </span>

                                    @endif

                                </div>

                            </td>


                            {{-- Status --}}
                            <td>

                                @if ($product->status)

                                    <span
                                        class="
                                            inventory-status
                                            inventory-status--active
                                        "
                                    >

                                        <span class="inventory-status__dot"></span>

                                        Active

                                    </span>

                                @else

                                    <span
                                        class="
                                            inventory-status
                                            inventory-status--inactive
                                        "
                                    >

                                        <span class="inventory-status__dot"></span>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="inventory-table__actions">

                                    @if ($isVariable && $hasVariants)

                                        <button
                                            type="button"
                                            class="
                                                inventory-icon-button
                                                inventory-icon-button--view
                                            "
                                            data-inventory-toggle
                                            aria-label="View variants"
                                            aria-expanded="false"
                                            title="View variants"
                                        >
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </button>

                                    @endif


                                    <a
                                        href="{{ route(
                                            'admin-inventory-product-edit',
                                            ['product' => $product]
                                        ) }}"
                                        class="inventory-icon-button"
                                        aria-label="Edit inventory"
                                        title="Edit inventory"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                </div>

                            </td>

                        </tr>


                        {{-- =================================================
                            VARIABLE PRODUCT VARIANTS
                        ================================================== --}}
                        @if ($isVariable && $hasVariants)

                            <tr
                                class="inventory-variants-row"
                                hidden
                            >

                                <td colspan="7">

                                    <div class="inventory-variants">

                                        <div class="inventory-variants__header">

                                            <span>
                                                Variant
                                            </span>

                                            <span>
                                                SKU
                                            </span>

                                            <span>
                                                Price
                                            </span>

                                            <span>
                                                Stock
                                            </span>

                                            <span>
                                                Status
                                            </span>

                                            <span>
                                                Action
                                            </span>

                                        </div>


                                        @foreach ($variants as $variant)

                                            @php

                                                /*
                                                |--------------------------------------------------------------------------
                                                | Variant Labels
                                                |--------------------------------------------------------------------------
                                                */

                                                $variantLabels =
                                                    $variant->values
                                                        ->map(
                                                            function ($value): string {

                                                                $attribute =
                                                                    $value->attribute?->name;

                                                                $attributeValue =
                                                                    $value->attributeValue?->value
                                                                    ?? $value->attributeValue?->name;

                                                                if (!$attributeValue) {
                                                                    return '';
                                                                }

                                                                return $attribute
                                                                    ? "{$attribute}: {$attributeValue}"
                                                                    : $attributeValue;

                                                            }
                                                        )
                                                        ->filter()
                                                        ->implode(' / ');


                                                /*
                                                |--------------------------------------------------------------------------
                                                | Variant Stock
                                                |--------------------------------------------------------------------------
                                                */

                                                $variantStock =
                                                    (int) $variant->stock;


                                                $variantOutOfStock =
                                                    $variantStock === 0;


                                                $variantLowStock =
                                                    $variantStock > 0
                                                    && $variantStock <= $lowStockThreshold;

                                            @endphp


                                            <div
                                                class="
                                                    inventory-variant
                                                    {{ !$variant->status
                                                        ? 'inventory-variant--inactive'
                                                        : ''
                                                    }}
                                                "
                                            >

                                                {{-- Variant --}}
                                                <div class="inventory-variant__name">

                                                    {{ $variantLabels ?: 'Variant' }}

                                                </div>


                                                {{-- SKU --}}
                                                <div class="inventory-variant__sku">

                                                    {{ $variant->sku ?: '—' }}

                                                </div>


                                                {{-- Price --}}
                                                <div class="inventory-variant__price">

                                                    {{ number_format(
                                                        (float) $variant->price,
                                                        2
                                                    ) }}

                                                </div>


                                                {{-- Stock --}}
                                                <div class="inventory-variant__stock">

                                                    <strong>
                                                        {{ number_format(
                                                            $variantStock
                                                        ) }}
                                                    </strong>


                                                    @if ($variantOutOfStock)

                                                        <span
                                                            class="
                                                                inventory-stock__badge
                                                                inventory-stock__badge--danger
                                                            "
                                                        >
                                                            Out
                                                        </span>

                                                    @elseif ($variantLowStock)

                                                        <span
                                                            class="
                                                                inventory-stock__badge
                                                                inventory-stock__badge--warning
                                                            "
                                                        >
                                                            Low
                                                        </span>

                                                    @else

                                                        <span
                                                            class="
                                                                inventory-stock__badge
                                                                inventory-stock__badge--success
                                                            "
                                                        >
                                                            In
                                                        </span>

                                                    @endif

                                                </div>


                                                {{-- Status --}}
                                                <div>

                                                    @if ($variant->status)

                                                        <span
                                                            class="
                                                                inventory-status
                                                                inventory-status--active
                                                            "
                                                        >

                                                            <span class="inventory-status__dot"></span>

                                                            Active

                                                        </span>

                                                    @else

                                                        <span
                                                            class="
                                                                inventory-status
                                                                inventory-status--inactive
                                                            "
                                                        >

                                                            <span class="inventory-status__dot"></span>

                                                            Inactive

                                                        </span>

                                                    @endif

                                                </div>


                                                {{-- Action --}}
                                                <div class="inventory-variant__action">

                                                    <a
                                                        href="{{ route(
                                                            'admin-inventory-variant-edit',
                                                            ['variant' => $variant]
                                                        ) }}"
                                                        class="inventory-icon-button"
                                                        aria-label="Edit variant"
                                                        title="Edit variant"
                                                    >
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </td>

                            </tr>

                        @endif

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="inventory-table__empty"
                            >

                                <div class="inventory-empty">

                                    <div class="inventory-empty__icon">
                                        <i class="fa-solid fa-box-open"></i>
                                    </div>


                                    <h3>
                                        No inventory found
                                    </h3>


                                    <p>
                                        Try changing your search or filters.
                                    </p>


                                    <a
                                        href="{{ route('admin-inventory') }}"
                                        class="inventory-button inventory-button--secondary"
                                    >
                                        Clear Filters
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            {{ $products->links('backend.components.pagination') }}

        </div>

    </div>
@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /*
            |--------------------------------------------------------------------------
            | Filter Form
            |--------------------------------------------------------------------------
            */

            const filterForm =
                document.getElementById(
                    'inventory-filter-form'
                );


            const searchInput =
                document.getElementById(
                    'inventory-search'
                );


            const selects =
                filterForm?.querySelectorAll(
                    'select'
                );


            /*
            |--------------------------------------------------------------------------
            | Variant Toggle Buttons
            |--------------------------------------------------------------------------
            */

            const variantToggleButtons =
                document.querySelectorAll(
                    '[data-inventory-toggle]'
                );


            /*
            |--------------------------------------------------------------------------
            | Submit Filters On Select Change
            |--------------------------------------------------------------------------
            */

            selects?.forEach((select) => {

                select.addEventListener(
                    'change',
                    () => {

                        filterForm?.submit();

                    }
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Search Debounce
            |--------------------------------------------------------------------------
            */

            let searchTimer = null;


            searchInput?.addEventListener(
                'input',
                () => {

                    window.clearTimeout(
                        searchTimer
                    );


                    searchTimer =
                        window.setTimeout(
                            () => {

                                filterForm?.submit();

                            },
                            500
                        );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Expand / Collapse Variants
            |--------------------------------------------------------------------------
            */

            variantToggleButtons.forEach(
                (button) => {

                    button.addEventListener(
                        'click',
                        () => {

                            const row =
                                button.closest(
                                    '.inventory-table__row'
                                );


                            const variantsRow =
                                row?.nextElementSibling;


                            if (
                                !variantsRow
                                || !variantsRow.classList.contains(
                                    'inventory-variants-row'
                                )
                            ) {
                                return;
                            }


                            const isHidden =
                                variantsRow.hasAttribute(
                                    'hidden'
                                );


                            if (isHidden) {

                                variantsRow.removeAttribute(
                                    'hidden'
                                );

                            } else {

                                variantsRow.setAttribute(
                                    'hidden',
                                    ''
                                );

                            }


                            button.setAttribute(
                                'aria-expanded',
                                isHidden
                                    ? 'true'
                                    : 'false'
                            );


                            button.classList.toggle(
                                'is-expanded',
                                isHidden
                            );

                        }
                    );

                }
            );

        });
    </script>

@endpush
