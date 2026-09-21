@extends('backend.layouts.backend')

@section('title', 'Low Stock Inventory')

@section('content')
    <div class="inventory-low-stock-page">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="inventory-low-stock-page__header">

            <div class="inventory-low-stock-page__heading">

                <div class="inventory-low-stock-page__breadcrumb">

                    <a href="{{ route('admin-inventory') }}">
                        Inventory
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>
                        Low Stock
                    </span>

                </div>


                <h1 class="inventory-low-stock-page__title">
                    Low Stock Inventory
                </h1>


                <p class="inventory-low-stock-page__subtitle">
                    Products and variants that are running low on stock.
                </p>

            </div>


            <a
                href="{{ route('admin-inventory') }}"
                class="inventory-low-stock-page__back"
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
        <div class="inventory-low-stock-page__toolbar">

            <div class="inventory-low-stock-page__summary">

                <div class="inventory-low-stock-page__summary-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>


                <div>

                    <strong>
                        Low Stock Items
                    </strong>

                    <span>
                        Stock quantity is between 1 and
                        {{ $lowStockThreshold }}.
                    </span>

                </div>

            </div>


            <div class="inventory-low-stock-page__count">

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

            <div class="inventory-low-stock-page__card">

                <div class="inventory-low-stock-page__table-wrapper">

                    <table class="inventory-low-stock-page__table">

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
                                Low Stock
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        @foreach ($products as $product)

                            @php
                                $isSimple = $product->isSimple();

                                $isVariable = $product->isVariable();

                                $variants = $product->variants;


                                /*
                                |--------------------------------------------------------------------------
                                | Low Stock Variants
                                |--------------------------------------------------------------------------
                                */

                                $lowStockVariants = $isVariable
                                    ? $variants->filter(
                                        fn ($variant): bool =>
                                            $variant->status
                                            && (int) $variant->stock > 0
                                            && (int) $variant->stock <= $lowStockThreshold
                                    )
                                    : collect();


                                /*
                                |--------------------------------------------------------------------------
                                | Simple Product Stock
                                |--------------------------------------------------------------------------
                                */

                                $simpleStock = $isSimple
                                    ? (int) $product->stock
                                    : null;


                                /*
                                |--------------------------------------------------------------------------
                                | Product Image
                                |--------------------------------------------------------------------------
                                */

                                $productImage =
                                    $product->thumbnail;
                            @endphp


                            {{-- =================================================
                                PRODUCT ROW
                            ================================================== --}}
                            <tr>

                                {{-- Product --}}
                                <td>

                                    <div class="inventory-low-stock-page__product">

                                        <div class="inventory-low-stock-page__product-image">

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


                                        <div class="inventory-low-stock-page__product-info">

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

                                    <span class="inventory-low-stock-page__sku">
                                        {{ $product->sku ?: '—' }}
                                    </span>

                                </td>


                                {{-- Type --}}
                                <td>

                                    @if ($isVariable)

                                        <span
                                            class="
                                                inventory-low-stock-page__type
                                                inventory-low-stock-page__type--variable
                                            "
                                        >

                                            <i class="fa-solid fa-layer-group"></i>

                                            Variable

                                        </span>

                                    @else

                                        <span
                                            class="
                                                inventory-low-stock-page__type
                                                inventory-low-stock-page__type--simple
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

                                        <span class="inventory-low-stock-page__variant-count">

                                            {{ number_format(
                                                $variants->count()
                                            ) }}

                                        </span>

                                    @else

                                        <span class="inventory-low-stock-page__variant-count">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Low Stock --}}
                                <td>

                                    @if ($isSimple)

                                        {{-- =====================================
                                            SIMPLE PRODUCT
                                        ====================================== --}}
                                        <div class="inventory-low-stock-page__stock-list">

                                            <div
                                                class="
                                                    inventory-low-stock-page__stock-item
                                                    inventory-low-stock-page__stock-item--simple
                                                "
                                            >

                                                <div class="inventory-low-stock-page__stock-info">

                                                    <strong>
                                                        Product Stock
                                                    </strong>

                                                    <span>
                                                        SKU:
                                                        {{ $product->sku ?: '—' }}
                                                    </span>

                                                </div>


                                                <span class="inventory-low-stock-page__stock-badge">

                                                    {{ number_format(
                                                        $simpleStock
                                                    ) }}

                                                </span>

                                            </div>

                                        </div>

                                    @else

                                        {{-- =====================================
                                            VARIABLE PRODUCT
                                        ====================================== --}}
                                        <div class="inventory-low-stock-page__stock-list">

                                            @forelse ($lowStockVariants as $variant)

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
                                                        inventory-low-stock-page__stock-item
                                                        inventory-low-stock-page__stock-item--variant
                                                    "
                                                    data-stock-item
                                                >

                                                    <div class="inventory-low-stock-page__stock-info">

                                                        <strong>
                                                            {{ $variantLabels ?: 'Variant' }}
                                                        </strong>

                                                        <span>
                                                            SKU:
                                                            {{ $variant->sku ?: '—' }}
                                                        </span>

                                                    </div>


                                                    <span class="inventory-low-stock-page__stock-badge">

                                                        {{ number_format(
                                                            (int) $variant->stock
                                                        ) }}

                                                    </span>

                                                </div>

                                            @empty

                                                <span class="inventory-low-stock-page__no-stock">

                                                    No low-stock variants.

                                                </span>

                                            @endforelse

                                        </div>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="inventory-low-stock-page__actions">

                                        {{-- Product Edit --}}
                                        <a
                                            href="{{ route(
                                                'admin-inventory-product-edit',
                                                ['product' => $product]
                                            ) }}"
                                            class="inventory-low-stock-page__action"
                                            title="Edit product inventory"
                                            aria-label="Edit product inventory"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>


                                        {{-- Variant Toggle --}}
                                        @if (
                                            $isVariable
                                            && $lowStockVariants->isNotEmpty()
                                        )

                                            <button
                                                type="button"
                                                class="
                                                    inventory-low-stock-page__action
                                                    inventory-low-stock-page__action--toggle
                                                "
                                                data-variants-toggle
                                                aria-expanded="false"
                                                aria-label="Toggle low stock variants"
                                                title="View low stock variants"
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
                                && $lowStockVariants->isNotEmpty()
                            )

                                <tr
                                    class="inventory-low-stock-page__mobile-details"
                                    data-variants-row
                                >

                                    <td colspan="6">

                                        <div class="inventory-low-stock-page__details">

                                            <div class="inventory-low-stock-page__details-header">

                                                <strong>
                                                    Low Stock Variants
                                                </strong>

                                            </div>


                                            <div class="inventory-low-stock-page__details-list">

                                                @foreach (
                                                    $lowStockVariants
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
                                                        class="inventory-low-stock-page__details-item"
                                                    >

                                                        <span>
                                                            {{ $variantLabels ?: 'Variant' }}
                                                        </span>


                                                        <strong>
                                                            {{ number_format(
                                                                (int) $variant->stock
                                                            ) }}
                                                        </strong>


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


                {{-- Pagination --}}
                @if ($products->hasPages())

                    <div class="inventory-low-stock-page__pagination">

                        {{ $products->links() }}

                    </div>

                @endif

            </div>


        @else

            {{-- =========================================================
                EMPTY STATE
            ========================================================== --}}
            <div class="inventory-low-stock-page__empty">

                <div class="inventory-low-stock-page__empty-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>


                <h2>
                    No Low Stock Products
                </h2>


                <p>
                    All simple products and active variants currently
                    have stock above the low-stock threshold.
                </p>


                <a
                    href="{{ route('admin-inventory') }}"
                    class="inventory-low-stock-page__button"
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
                    '.inventory-low-stock-page'
                );


            if (!page) {
                return;
            }


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


                            const isOpen =
                                detailsRow.classList.toggle(
                                    'is-open'
                                );


                            button.setAttribute(
                                'aria-expanded',
                                String(isOpen)
                            );


                            button.classList.toggle(
                                'is-active',
                                isOpen
                            );

                        }
                    );

                }
            );

        });
    </script>

@endpush
