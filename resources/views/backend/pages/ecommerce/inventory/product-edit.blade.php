@extends('backend.layouts.backend')

@section('title', 'Edit Product Inventory')

@section('content')
    @php
        $isSimple = $product->isSimple();
        $isVariable = $product->isVariable();

        $variants = $product->variants;

        $totalVariants = $variants->count();

        /*
        |--------------------------------------------------------------------------
        | Inventory Summary
        |--------------------------------------------------------------------------
        */

        if ($isSimple) {
            $totalStock = (int) $product->stock;

            $lowStock = (
                $totalStock > 0
                && $totalStock <= $lowStockThreshold
            ) ? 1 : 0;

            $outOfStock = $totalStock === 0
                ? 1
                : 0;
        } else {
            $totalStock = (int) $variants->sum('stock');

            $lowStock = $variants
                ->filter(
                    fn ($variant): bool =>
                        (int) $variant->stock > 0
                        && (int) $variant->stock <= $lowStockThreshold
                )
                ->count();

            $outOfStock = $variants
                ->filter(
                    fn ($variant): bool =>
                        (int) $variant->stock === 0
                )
                ->count();
        }
    @endphp


    <div class="inventory-product-edit-page">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="inventory-product-edit-page__header">

            <div class="inventory-product-edit-page__heading">

                <div class="inventory-product-edit-page__breadcrumb">

                    <a href="{{ route('admin-inventory') }}">
                        Inventory
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>
                        Edit Product
                    </span>

                </div>


                <h1 class="inventory-product-edit-page__title">
                    Edit Product Inventory
                </h1>


                <p class="inventory-product-edit-page__subtitle">
                    Update pricing and manage inventory for this product.
                </p>

            </div>


            <a
                href="{{ route('admin-inventory') }}"
                class="inventory-product-edit-page__back"
            >
                <i class="fa-solid fa-arrow-left"></i>

                <span>
                    Back to Inventory
                </span>
            </a>

        </div>


        {{-- =========================================================
            LAYOUT
        ========================================================== --}}
        <div class="inventory-product-edit-page__layout">

            <main class="inventory-product-edit-page__main">


                {{-- =================================================
                    PRODUCT INFORMATION
                ================================================== --}}
                <section class="inventory-product-edit-page__card">

                    <div class="inventory-product-edit-page__card-header">

                        <div>

                            <h2 class="inventory-product-edit-page__card-title">
                                Product Information
                            </h2>

                            <p class="inventory-product-edit-page__card-description">
                                Basic information about this inventory item.
                            </p>

                        </div>


                        {{-- Product Type --}}
                        <span
                            class="
                                inventory-product-edit-page__type
                                inventory-product-edit-page__type--{{ $isVariable ? 'variable' : 'simple' }}
                            "
                        >

                            @if ($isVariable)
                                <i class="fa-solid fa-layer-group"></i>
                                Variable Product
                            @else
                                <i class="fa-solid fa-box"></i>
                                Simple Product
                            @endif

                        </span>

                    </div>


                    <div class="inventory-product-edit-page__product">

                        <div class="inventory-product-edit-page__product-image">

                            @if ($product->thumbnail)

                                <img
                                    src="{{ asset($product->thumbnail) }}"
                                    alt="{{ $product->name }}"
                                >

                            @else

                                <i class="fa-solid fa-box"></i>

                            @endif

                        </div>


                        <div class="inventory-product-edit-page__product-content">

                            <h3>
                                {{ $product->name }}
                            </h3>


                            <div class="inventory-product-edit-page__product-meta">

                                <span>
                                    SKU:

                                    <strong>
                                        {{ $product->sku ?: '—' }}
                                    </strong>
                                </span>


                                @if ($product->brand)

                                    <span>
                                        Brand:

                                        <strong>
                                            {{ $product->brand->name }}
                                        </strong>
                                    </span>

                                @endif


                                <span>
                                    Type:

                                    <strong>
                                        {{ $isVariable ? 'Variable' : 'Simple' }}
                                    </strong>
                                </span>


                                <span>
                                    Status:

                                    @if ($product->status)

                                        <strong class="is-success">
                                            Active
                                        </strong>

                                    @else

                                        <strong class="is-danger">
                                            Inactive
                                        </strong>

                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    PRODUCT PRICING + SIMPLE STOCK
                ================================================== --}}
                <section class="inventory-product-edit-page__card">

                    <div class="inventory-product-edit-page__card-header">

                        <div>

                            <h2 class="inventory-product-edit-page__card-title">
                                Product Pricing
                            </h2>

                            <p class="inventory-product-edit-page__card-description">

                                @if ($isSimple)

                                    Update the selling price and inventory
                                    stock for this simple product.

                                @else

                                    Update the product selling price.
                                    Variant stock is managed separately below.

                                @endif

                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route(
                            'admin-inventory-product-update',
                            ['product' => $product]
                        ) }}"
                        method="POST"
                        class="inventory-product-edit-page__form"
                        data-product-inventory-form
                    >

                        @csrf

                        @method('PUT')


                        <div class="inventory-product-edit-page__form-grid">

                            {{-- Selling Price --}}
                            <div class="inventory-product-edit-page__field">

                                <label
                                    for="product-price"
                                    class="inventory-product-edit-page__label"
                                >
                                    Selling Price
                                    <span>*</span>
                                </label>


                                <div class="inventory-product-edit-page__price-input">

                                    <span>
                                        $
                                    </span>

                                    <input
                                        type="number"
                                        id="product-price"
                                        name="price"
                                        value="{{ old(
                                            'price',
                                            $product->price
                                        ) }}"
                                        min="0"
                                        step="0.01"
                                        inputmode="decimal"
                                        required
                                        class="@error('price') is-invalid @enderror"
                                    >

                                </div>


                                @error('price')

                                <p class="inventory-product-edit-page__error">
                                    {{ $message }}
                                </p>

                                @enderror

                            </div>


                            {{-- Current Price --}}
                            <div class="inventory-product-edit-page__field">

                                <span class="inventory-product-edit-page__label">
                                    Current Price
                                </span>


                                <div class="inventory-product-edit-page__current-value">

                                    ${{ number_format(
                                        (float) $product->price,
                                        2
                                    ) }}

                                </div>

                            </div>


                            {{-- Simple Product Stock --}}
                            @if ($isSimple)

                                <div class="inventory-product-edit-page__field">

                                    <label
                                        for="product-stock"
                                        class="inventory-product-edit-page__label"
                                    >
                                        Stock
                                        <span>*</span>
                                    </label>


                                    <div class="inventory-product-edit-page__price-input">

                                        <span>
                                            <i class="fa-solid fa-cubes"></i>
                                        </span>

                                        <input
                                            type="number"
                                            id="product-stock"
                                            name="stock"
                                            value="{{ old(
                                                'stock',
                                                $product->stock
                                            ) }}"
                                            min="0"
                                            step="1"
                                            inputmode="numeric"
                                            required
                                            class="@error('stock') is-invalid @enderror"
                                        >

                                    </div>


                                    @error('stock')

                                    <p class="inventory-product-edit-page__error">
                                        {{ $message }}
                                    </p>

                                    @enderror

                                </div>


                                {{-- Current Stock --}}
                                <div class="inventory-product-edit-page__field">

                                    <span class="inventory-product-edit-page__label">
                                        Current Stock
                                    </span>


                                    <div
                                        class="
                                            inventory-product-edit-page__current-value
                                            inventory-product-edit-page__current-value--stock
                                        "
                                    >
                                        {{ number_format(
                                            (int) $product->stock
                                        ) }}
                                    </div>

                                </div>

                            @endif

                        </div>


                        {{-- Variable Stock Notice --}}
                        @if ($isVariable)

                            <div class="inventory-product-edit-page__inline-notice">

                                <div class="inventory-product-edit-page__inline-notice-icon">

                                    <i class="fa-solid fa-layer-group"></i>

                                </div>


                                <div>

                                    <strong>
                                        Variant inventory
                                    </strong>

                                    <p>
                                        This is a variable product.
                                        Stock is managed separately for each
                                        variant below.
                                    </p>

                                </div>

                            </div>

                        @endif


                        {{-- Form Footer --}}
                        <div class="inventory-product-edit-page__form-footer">

                            <a
                                href="{{ route('admin-inventory') }}"
                                class="
                                    inventory-product-edit-page__button
                                    inventory-product-edit-page__button--secondary
                                "
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                class="
                                    inventory-product-edit-page__button
                                    inventory-product-edit-page__button--primary
                                "
                                data-save-button
                            >

                                <i class="fa-solid fa-check"></i>

                                <span>
                                    Save Changes
                                </span>

                            </button>

                        </div>

                    </form>

                </section>


                {{-- =================================================
                    VARIABLE PRODUCT VARIANTS
                ================================================== --}}
                @if ($isVariable)

                    <section class="inventory-product-edit-page__card">

                        <div class="inventory-product-edit-page__card-header">

                            <div>

                                <h2 class="inventory-product-edit-page__card-title">
                                    Product Variants
                                </h2>

                                <p class="inventory-product-edit-page__card-description">
                                    Manage pricing and stock separately for
                                    each product variant.
                                </p>

                            </div>


                            <span class="inventory-product-edit-page__count">

                                {{ $totalVariants }}

                                {{ Str::plural(
                                    'variant',
                                    $totalVariants
                                ) }}

                            </span>

                        </div>


                        @if ($variants->isNotEmpty())

                            <div class="inventory-product-edit-page__variants">

                                @foreach ($variants as $variant)

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


                                    <div class="inventory-product-edit-page__variant">

                                        {{-- Variant Information --}}
                                        <div class="inventory-product-edit-page__variant-info">

                                            <strong>
                                                {{ $variantLabels ?: 'Variant' }}
                                            </strong>

                                            <span>
                                                SKU:
                                                {{ $variant->sku ?: '—' }}
                                            </span>

                                        </div>


                                        {{-- Price --}}
                                        <div class="inventory-product-edit-page__variant-data">

                                            <span>
                                                Price
                                            </span>

                                            <strong>
                                                ${{ number_format(
                                                    (float) $variant->price,
                                                    2
                                                ) }}
                                            </strong>

                                        </div>


                                        {{-- Stock --}}
                                        <div class="inventory-product-edit-page__variant-data">

                                            <span>
                                                Stock
                                            </span>


                                            @if ((int) $variant->stock === 0)

                                                <strong class="is-danger">
                                                    0
                                                </strong>

                                            @elseif (
                                                (int) $variant->stock
                                                <= $lowStockThreshold
                                            )

                                                <strong class="is-warning">
                                                    {{ number_format(
                                                        (int) $variant->stock
                                                    ) }}
                                                </strong>

                                            @else

                                                <strong class="is-success">
                                                    {{ number_format(
                                                        (int) $variant->stock
                                                    ) }}
                                                </strong>

                                            @endif

                                        </div>


                                        {{-- Variant Status --}}
                                        <div class="inventory-product-edit-page__variant-data">

                                            <span>
                                                Status
                                            </span>


                                            @if ($variant->status)

                                                <strong class="is-success">
                                                    Active
                                                </strong>

                                            @else

                                                <strong class="is-danger">
                                                    Inactive
                                                </strong>

                                            @endif

                                        </div>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route(
                                                'admin-inventory-variant-edit',
                                                ['variant' => $variant]
                                            ) }}"
                                            class="inventory-product-edit-page__icon-button"
                                            title="Edit variant"
                                            aria-label="Edit variant"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="inventory-product-edit-page__empty">

                                <div class="inventory-product-edit-page__empty-icon">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>

                                <h3>
                                    No variants found
                                </h3>

                                <p>
                                    This variable product does not have any
                                    variants configured yet.
                                </p>

                            </div>

                        @endif

                    </section>

                @endif

            </main>


            {{-- =========================================================
                SIDEBAR
            ========================================================== --}}
            <aside class="inventory-product-edit-page__sidebar">


                {{-- =================================================
                    INVENTORY SUMMARY
                ================================================== --}}
                <section class="inventory-product-edit-page__card">

                    <div class="inventory-product-edit-page__card-header">

                        <div>

                            <h2 class="inventory-product-edit-page__card-title">
                                Inventory Summary
                            </h2>

                        </div>

                    </div>


                    <div class="inventory-product-edit-page__summary">

                        {{-- Product Type --}}
                        <div class="inventory-product-edit-page__summary-item">

                            <span>
                                Type
                            </span>

                            <strong>
                                {{ $isVariable ? 'Variable' : 'Simple' }}
                            </strong>

                        </div>


                        {{-- Variants --}}
                        <div class="inventory-product-edit-page__summary-item">

                            <span>
                                Variants
                            </span>

                            <strong>
                                @if ($isVariable)
                                    {{ number_format($totalVariants) }}
                                @else
                                    —
                                @endif
                            </strong>

                        </div>


                        {{-- Total Stock --}}
                        <div class="inventory-product-edit-page__summary-item">

                            <span>
                                Total Stock
                            </span>

                            <strong>
                                {{ number_format($totalStock) }}
                            </strong>

                        </div>


                        {{-- Low Stock --}}
                        <div class="inventory-product-edit-page__summary-item">

                            <span>
                                Low Stock
                            </span>

                            <strong
                                class="{{ $lowStock > 0 ? 'is-warning' : '' }}"
                            >
                                {{ number_format($lowStock) }}
                            </strong>

                        </div>


                        {{-- Out Of Stock --}}
                        <div class="inventory-product-edit-page__summary-item">

                            <span>
                                Out of Stock
                            </span>

                            <strong
                                class="{{ $outOfStock > 0 ? 'is-danger' : '' }}"
                            >
                                {{ number_format($outOfStock) }}
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    INVENTORY SOURCE NOTICE
                ================================================== --}}
                <section class="inventory-product-edit-page__notice">

                    <div class="inventory-product-edit-page__notice-icon">

                        @if ($isSimple)

                            <i class="fa-solid fa-box"></i>

                        @else

                            <i class="fa-solid fa-layer-group"></i>

                        @endif

                    </div>


                    <div>

                        <h3>
                            Inventory source
                        </h3>


                        @if ($isSimple)

                            <p>
                                Stock for this simple product is managed
                                directly at the product level.
                            </p>

                        @else

                            <p>
                                Stock for this variable product is managed
                                at the variant level. Each variant has its
                                own independent stock quantity.
                            </p>

                        @endif

                    </div>

                </section>

            </aside>

        </div>

    </div>
@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const page = document.querySelector(
                '.inventory-product-edit-page'
            );


            if (!page) {
                return;
            }


            const form = page.querySelector(
                '[data-product-inventory-form]'
            );


            const priceInput = page.querySelector(
                '#product-price'
            );


            const stockInput = page.querySelector(
                '#product-stock'
            );


            const saveButton = page.querySelector(
                '[data-save-button]'
            );


            if (
                !form
                || !priceInput
                || !saveButton
            ) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Initial Values
            |--------------------------------------------------------------------------
            */

            const initialPrice =
                Number(
                    priceInput.value || 0
                ).toFixed(2);


            const initialStock =
                stockInput
                    ? Number(
                        stockInput.value || 0
                    )
                    : null;


            /*
            |--------------------------------------------------------------------------
            | Update Save Button
            |--------------------------------------------------------------------------
            */

            const updateButtonState = () => {

                const currentPrice =
                    Number(
                        priceInput.value || 0
                    ).toFixed(2);


                const priceChanged =
                    currentPrice !== initialPrice;


                let stockChanged = false;


                if (stockInput) {

                    const currentStock =
                        Number(
                            stockInput.value || 0
                        );


                    stockChanged =
                        currentStock !== initialStock;

                }


                saveButton.disabled =
                    !priceChanged
                    && !stockChanged;

            };


            /*
            |--------------------------------------------------------------------------
            | Input Events
            |--------------------------------------------------------------------------
            */

            priceInput.addEventListener(
                'input',
                updateButtonState
            );


            stockInput?.addEventListener(
                'input',
                updateButtonState
            );


            /*
            |--------------------------------------------------------------------------
            | Submit
            |--------------------------------------------------------------------------
            */

            form.addEventListener(
                'submit',
                () => {

                    saveButton.disabled = true;


                    saveButton.innerHTML = `
                        <i class="fa-solid fa-spinner fa-spin"></i>
                        <span>Saving...</span>
                    `;

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Initial State
            |--------------------------------------------------------------------------
            */

            updateButtonState();

        });
    </script>

@endpush
