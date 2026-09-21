@extends('backend.layouts.backend')

@section('title', 'Out of Stock Inventory')

@section('content')
    <div class="inventory-out-of-stock-page">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="inventory-out-of-stock-page__header">

            <div class="inventory-out-of-stock-page__heading">

                <div class="inventory-out-of-stock-page__breadcrumb">

                    <a href="{{ route('admin-inventory') }}">
                        Inventory
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>
                        Out of Stock
                    </span>

                </div>


                <h1 class="inventory-out-of-stock-page__title">
                    Out of Stock Inventory
                </h1>


                <p class="inventory-out-of-stock-page__subtitle">
                    Products and variants that currently have no available stock.
                </p>

            </div>


            <a
                href="{{ route('admin-inventory') }}"
                class="inventory-out-of-stock-page__back"
            >
                <i class="fa-solid fa-arrow-left"></i>

                <span>
                    All Inventory
                </span>
            </a>

        </div>


        {{-- =========================================================
            TOOLBAR
        ========================================================== --}}
        <div class="inventory-out-of-stock-page__toolbar">

            <div class="inventory-out-of-stock-page__summary">

                <div class="inventory-out-of-stock-page__summary-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>


                <div>

                    <strong>
                        Out of Stock Items
                    </strong>

                    <span>
                        Simple products with zero stock and variable
                        products with one or more out-of-stock active variants.
                    </span>

                </div>

            </div>


            <div class="inventory-out-of-stock-page__count">

                {{ number_format($products->total()) }}

                {{ Str::plural(
                    'product',
                    $products->total()
                ) }}

            </div>

        </div>


        {{-- =========================================================
            PRODUCTS
        ========================================================== --}}
        @if ($products->isNotEmpty())

            <div class="inventory-out-of-stock-page__card">

                <div class="inventory-out-of-stock-page__table-wrapper">

                    <table class="inventory-out-of-stock-page__table">

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
                                Out of Stock
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        @foreach ($products as $product)

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
                                | All Variants
                                |--------------------------------------------------------------------------
                                */

                                $variants =
                                    $product->variants;


                                /*
                                |--------------------------------------------------------------------------
                                | Out Of Stock Variants
                                |--------------------------------------------------------------------------
                                |
                                | IMPORTANT:
                                |
                                | Only ACTIVE variants with stock = 0
                                | are considered out of stock.
                                |
                                | Example:
                                |
                                | Small  = 0  -> Show
                                | Medium = 10 -> Don't show
                                | Large  = 5  -> Don't show
                                |
                                */

                                $outOfStockVariants =
                                    $isVariable
                                        ? $variants->filter(
                                            fn ($variant): bool =>
                                                (bool) $variant->status
                                                && (int) $variant->stock === 0
                                        )
                                        : collect();


                                /*
                                |--------------------------------------------------------------------------
                                | Simple Product Stock
                                |--------------------------------------------------------------------------
                                */

                                $simpleStock =
                                    $isSimple
                                        ? (int) $product->stock
                                        : null;


                                /*
                                |--------------------------------------------------------------------------
                                | Product Image
                                |--------------------------------------------------------------------------
                                */

                                $productImage =
                                    $product->thumbnail;


                                /*
                                |--------------------------------------------------------------------------
                                | Out Of Stock Count
                                |--------------------------------------------------------------------------
                                */

                                $outOfStockCount =
                                    $isSimple
                                        ? 1
                                        : $outOfStockVariants->count();

                            @endphp


                            {{-- =================================================
                                PRODUCT ROW
                            ================================================== --}}
                            <tr>

                                {{-- Product --}}
                                <td>

                                    <div class="inventory-out-of-stock-page__product">

                                        <div class="inventory-out-of-stock-page__product-image">

                                            @if ($productImage)

                                                <img
                                                    src="{{ asset($productImage) }}"
                                                    alt="{{ $product->name }}"
                                                    loading="lazy"
                                                >

                                            @else

                                                <i class="fa-solid fa-box"></i>

                                            @endif

                                        </div>


                                        <div class="inventory-out-of-stock-page__product-info">

                                            <a
                                                href="{{ route(
                                                    'admin-inventory-product-edit',
                                                    ['product' => $product]
                                                ) }}"
                                            >
                                                {{ $product->name }}
                                            </a>


                                            @if ($product->brand)

                                                <span>
                                                    {{ $product->brand->name }}
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- SKU --}}
                                <td>

                                    <span class="inventory-out-of-stock-page__sku">

                                        {{ $product->sku ?: '—' }}

                                    </span>

                                </td>


                                {{-- Type --}}
                                <td>

                                    @if ($isVariable)

                                        <span
                                            class="
                                                inventory-out-of-stock-page__type
                                                inventory-out-of-stock-page__type--variable
                                            "
                                        >

                                            <i class="fa-solid fa-layer-group"></i>

                                            Variable

                                        </span>

                                    @else

                                        <span
                                            class="
                                                inventory-out-of-stock-page__type
                                                inventory-out-of-stock-page__type--simple
                                            "
                                        >

                                            <i class="fa-solid fa-box"></i>

                                            Simple

                                        </span>

                                    @endif

                                </td>


                                {{-- Variants --}}
                                <td>

                                    @if ($isVariable)

                                        <span class="inventory-out-of-stock-page__variant-count">

                                            {{ number_format(
                                                $variants->count()
                                            ) }}

                                        </span>

                                    @else

                                        <span class="inventory-out-of-stock-page__variant-count">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Out Of Stock --}}
                                <td>

                                    @if ($isSimple)

                                        {{-- =====================================
                                            SIMPLE PRODUCT
                                        ====================================== --}}
                                        <div class="inventory-out-of-stock-page__stock-list">

                                            <div
                                                class="
                                                    inventory-out-of-stock-page__stock-item
                                                    inventory-out-of-stock-page__stock-item--simple
                                                "
                                            >

                                                <div class="inventory-out-of-stock-page__stock-info">

                                                    <strong>
                                                        Product Stock
                                                    </strong>

                                                    <span>
                                                        SKU:
                                                        {{ $product->sku ?: '—' }}
                                                    </span>

                                                </div>


                                                <span class="inventory-out-of-stock-page__stock-badge">

                                                    Out of Stock

                                                </span>

                                            </div>

                                        </div>

                                    @elseif ($outOfStockVariants->isNotEmpty())

                                        {{-- =====================================
                                            VARIABLE PRODUCT
                                        ====================================== --}}
                                        <div class="inventory-out-of-stock-page__stock-list">

                                            @foreach (
                                                $outOfStockVariants
                                                as $variant
                                            )

                                                @php

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

                                                @endphp


                                                <div
                                                    class="
                                                        inventory-out-of-stock-page__stock-item
                                                        inventory-out-of-stock-page__stock-item--variant
                                                    "
                                                >

                                                    <div class="inventory-out-of-stock-page__stock-info">

                                                        <strong>
                                                            {{ $variantLabels ?: 'Variant' }}
                                                        </strong>

                                                        <span>
                                                            SKU:
                                                            {{ $variant->sku ?: '—' }}
                                                        </span>

                                                    </div>


                                                    <span class="inventory-out-of-stock-page__stock-badge">

                                                        Out of Stock

                                                    </span>

                                                </div>

                                            @endforeach

                                        </div>

                                    @else

                                        <span class="inventory-out-of-stock-page__no-stock">
                                            No out-of-stock variants.
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="inventory-out-of-stock-page__actions">

                                        {{-- Product Edit --}}
                                        <a
                                            href="{{ route(
                                                'admin-inventory-product-edit',
                                                ['product' => $product]
                                            ) }}"
                                            class="inventory-out-of-stock-page__action"
                                            title="Edit product inventory"
                                            aria-label="Edit product inventory"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>


                                        {{-- Variant Toggle --}}
                                        @if (
                                            $isVariable
                                            && $outOfStockVariants->isNotEmpty()
                                        )

                                            <button
                                                type="button"
                                                class="
                                                    inventory-out-of-stock-page__action
                                                    inventory-out-of-stock-page__action--toggle
                                                "
                                                data-variants-toggle
                                                aria-expanded="false"
                                                aria-label="Toggle out of stock variants"
                                                title="View out of stock variants"
                                            >

                                                <i class="fa-solid fa-chevron-down"></i>

                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>


                            {{-- =================================================
                                VARIABLE PRODUCT DETAILS
                            ================================================== --}}
                            @if (
                                $isVariable
                                && $outOfStockVariants->isNotEmpty()
                            )

                                <tr
                                    class="inventory-out-of-stock-page__mobile-details"
                                    data-variants-row
                                    hidden
                                >

                                    <td colspan="6">

                                        <div class="inventory-out-of-stock-page__details">

                                            <div class="inventory-out-of-stock-page__details-header">

                                                <strong>
                                                    Out of Stock Variants
                                                </strong>

                                                <span>
                                                    {{ $outOfStockVariants->count() }}
                                                    {{ Str::plural(
                                                        'variant',
                                                        $outOfStockVariants->count()
                                                    ) }}
                                                </span>

                                            </div>


                                            <div class="inventory-out-of-stock-page__details-list">

                                                @foreach (
                                                    $outOfStockVariants
                                                    as $variant
                                                )

                                                    @php

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

                                                    @endphp


                                                    <a
                                                        href="{{ route(
                                                            'admin-inventory-variant-edit',
                                                            ['variant' => $variant]
                                                        ) }}"
                                                        class="inventory-out-of-stock-page__details-item"
                                                    >

                                                        <span>
                                                            {{ $variantLabels ?: 'Variant' }}
                                                        </span>


                                                        <span class="inventory-out-of-stock-page__details-status">
                                                            Out of Stock
                                                        </span>


                                                        <i class="fa-solid fa-arrow-right"></i>

                                                    </a>

                                                @endforeach

                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            @endif

                        @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- =========================================================
                    PAGINATION
                ========================================================== --}}
                @if ($products->hasPages())

                    <div class="inventory-out-of-stock-page__pagination">

                        {{ $products->links() }}

                    </div>

                @endif

            </div>


        @else

            {{-- =========================================================
                EMPTY STATE
            ========================================================== --}}
            <div class="inventory-out-of-stock-page__empty">

                <div class="inventory-out-of-stock-page__empty-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>


                <h2>
                    No Out of Stock Products
                </h2>


                <p>
                    All simple products have available stock and all
                    variable products have available stock for their
                    active variants.
                </p>


                <a
                    href="{{ route('admin-inventory') }}"
                    class="inventory-out-of-stock-page__button"
                >

                    <i class="fa-solid fa-boxes-stacked"></i>

                    <span>
                        View Inventory
                    </span>

                </a>

            </div>

        @endif

    </div>
@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const page =
                document.querySelector(
                    '.inventory-out-of-stock-page'
                );


            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Variant Toggle Buttons
            |--------------------------------------------------------------------------
            */

            const toggleButtons =
                page.querySelectorAll(
                    '[data-variants-toggle]'
                );


            toggleButtons.forEach(
                (button) => {

                    button.addEventListener(
                        'click',
                        () => {

                            const currentRow =
                                button.closest('tr');


                            if (!currentRow) {
                                return;
                            }


                            const detailsRow =
                                currentRow.nextElementSibling;


                            if (
                                !detailsRow
                                || !detailsRow.matches(
                                    '[data-variants-row]'
                                )
                            ) {
                                return;
                            }


                            const isHidden =
                                detailsRow.hasAttribute(
                                    'hidden'
                                );


                            if (isHidden) {

                                detailsRow.removeAttribute(
                                    'hidden'
                                );

                            } else {

                                detailsRow.setAttribute(
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
                                'is-active',
                                isHidden
                            );

                        }
                    );

                }
            );

        });
    </script>

@endpush
