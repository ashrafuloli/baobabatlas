@extends('backend.layouts.backend')

@section('title', 'Edit Variant Inventory')

@section('content')
    @php
        $product = $variant->product;

        $variantStock = (int) $variant->stock;

        $isOutOfStock = $variantStock === 0;

        $isLowStock =
            $variantStock > 0
            && $variantStock <= $lowStockThreshold;
    @endphp

    <div class="inventory-variant-edit-page">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="inventory-variant-edit-page__header">

            <div class="inventory-variant-edit-page__heading">

                <div class="inventory-variant-edit-page__breadcrumb">

                    <a href="{{ route('admin-inventory') }}">
                        Inventory
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <a
                        href="{{ route(
                            'admin-inventory-product-edit',
                            ['product' => $product]
                        ) }}"
                    >
                        {{ $product->name }}
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>
                        Variant
                    </span>

                </div>


                <h1 class="inventory-variant-edit-page__title">
                    Edit Variant Inventory
                </h1>


                <p class="inventory-variant-edit-page__subtitle">
                    Update the variant price and available stock.
                </p>

            </div>


            <a
                href="{{ route(
                    'admin-inventory-product-edit',
                    ['product' => $product]
                ) }}"
                class="inventory-variant-edit-page__back"
            >
                <i class="fa-solid fa-arrow-left"></i>

                <span>
                    Back to Product
                </span>
            </a>

        </div>


        {{-- =========================================================
            LAYOUT
        ========================================================== --}}
        <div class="inventory-variant-edit-page__layout">

            <main class="inventory-variant-edit-page__main">


                {{-- =================================================
                    VARIANT INFORMATION
                ================================================== --}}
                <section class="inventory-variant-edit-page__card">

                    <div class="inventory-variant-edit-page__card-header">

                        <div>

                            <h2 class="inventory-variant-edit-page__card-title">
                                Variant Information
                            </h2>

                            <p class="inventory-variant-edit-page__card-description">
                                Review the product and variant details.
                            </p>

                        </div>


                        {{-- Variant Status --}}
                        @if ($variant->status)

                            <span
                                class="
                                    inventory-variant-edit-page__status
                                    inventory-variant-edit-page__status--active
                                "
                            >
                                <span></span>
                                Active
                            </span>

                        @else

                            <span
                                class="
                                    inventory-variant-edit-page__status
                                    inventory-variant-edit-page__status--inactive
                                "
                            >
                                <span></span>
                                Inactive
                            </span>

                        @endif

                    </div>


                    <div class="inventory-variant-edit-page__product">

                        {{-- Product / Variant Image --}}
                        <div class="inventory-variant-edit-page__product-image">

                            @if ($variant->image)

                                <img
                                    src="{{ asset($variant->image) }}"
                                    alt="{{ $product->name }}"
                                >

                            @elseif ($product->thumbnail)

                                <img
                                    src="{{ asset($product->thumbnail) }}"
                                    alt="{{ $product->name }}"
                                >

                            @else

                                <i class="fa-solid fa-box"></i>

                            @endif

                        </div>


                        <div class="inventory-variant-edit-page__product-content">

                            <h3>
                                {{ $product->name }}
                            </h3>


                            {{-- Variant Labels --}}
                            @php
                                $variantLabels = $variant->values
                                    ->map(function ($value): string {
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
                                    })
                                    ->filter()
                                    ->implode(' / ');
                            @endphp


                            <div class="inventory-variant-edit-page__variant-name">
                                {{ $variantLabels ?: 'Variant' }}
                            </div>


                            <div class="inventory-variant-edit-page__product-meta">

                                <span>
                                    Product SKU:

                                    <strong>
                                        {{ $product->sku ?: '—' }}
                                    </strong>
                                </span>


                                <span>
                                    Variant SKU:

                                    <strong>
                                        {{ $variant->sku ?: '—' }}
                                    </strong>
                                </span>


                                <span>
                                    Type:

                                    <strong>
                                        Variable
                                    </strong>
                                </span>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    INVENTORY FORM
                ================================================== --}}
                <section class="inventory-variant-edit-page__card">

                    <div class="inventory-variant-edit-page__card-header">

                        <div>

                            <h2 class="inventory-variant-edit-page__card-title">
                                Inventory Details
                            </h2>

                            <p class="inventory-variant-edit-page__card-description">
                                Update the current selling price and stock quantity.
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route(
                            'admin-inventory-variant-update',
                            ['variant' => $variant]
                        ) }}"
                        method="POST"
                        class="inventory-variant-edit-page__form"
                        data-variant-inventory-form
                    >

                        @csrf

                        @method('PUT')


                        <div class="inventory-variant-edit-page__form-grid">

                            {{-- Price --}}
                            <div class="inventory-variant-edit-page__field">

                                <label
                                    for="variant-price"
                                    class="inventory-variant-edit-page__label"
                                >
                                    Selling Price
                                    <span>*</span>
                                </label>


                                <div class="inventory-variant-edit-page__price-input">

                                    <span>
                                        $
                                    </span>

                                    <input
                                        type="number"
                                        id="variant-price"
                                        name="price"
                                        value="{{ old(
                                            'price',
                                            $variant->price
                                        ) }}"
                                        min="0"
                                        step="0.01"
                                        inputmode="decimal"
                                        required
                                        class="@error('price') is-invalid @enderror"
                                    >

                                </div>


                                @error('price')

                                <p class="inventory-variant-edit-page__error">
                                    {{ $message }}
                                </p>

                                @enderror

                            </div>


                            {{-- Stock --}}
                            <div class="inventory-variant-edit-page__field">

                                <label
                                    for="variant-stock"
                                    class="inventory-variant-edit-page__label"
                                >
                                    Stock Quantity
                                    <span>*</span>
                                </label>


                                <input
                                    type="number"
                                    id="variant-stock"
                                    name="stock"
                                    value="{{ old(
                                        'stock',
                                        $variant->stock
                                    ) }}"
                                    min="0"
                                    step="1"
                                    inputmode="numeric"
                                    required
                                    class="
                                        inventory-variant-edit-page__stock-input
                                        @error('stock') is-invalid @enderror
                                    "
                                >


                                @error('stock')

                                <p class="inventory-variant-edit-page__error">
                                    {{ $message }}
                                </p>

                                @enderror

                            </div>

                        </div>


                        {{-- =================================================
                            STOCK STATUS
                        ================================================== --}}
                        <div
                            class="
                                inventory-variant-edit-page__stock-status
                                {{ $isOutOfStock
                                    ? 'is-danger'
                                    : ($isLowStock ? 'is-warning' : 'is-success')
                                }}
                            "
                            data-stock-status
                        >

                            <div class="inventory-variant-edit-page__stock-status-icon">

                                <i
                                    class="
                                        fa-solid
                                        {{ $isOutOfStock
                                            ? 'fa-circle-xmark'
                                            : ($isLowStock
                                                ? 'fa-triangle-exclamation'
                                                : 'fa-circle-check')
                                        }}
                                    "
                                    data-stock-status-icon
                                ></i>

                            </div>


                            <div class="inventory-variant-edit-page__stock-status-content">

                                <strong data-stock-status-title>

                                    @if ($isOutOfStock)

                                        Out of Stock

                                    @elseif ($isLowStock)

                                        Low Stock

                                    @else

                                        In Stock

                                    @endif

                                </strong>


                                <span data-stock-status-text>

                                    @if ($isOutOfStock)

                                        This variant currently has no available stock.

                                    @elseif ($isLowStock)

                                        This variant is running low on available stock.

                                    @else

                                        This variant has a healthy stock level.

                                    @endif

                                </span>

                            </div>

                        </div>


                        {{-- =================================================
                            FORM FOOTER
                        ================================================== --}}
                        <div class="inventory-variant-edit-page__form-footer">

                            <a
                                href="{{ route(
                                    'admin-inventory-product-edit',
                                    ['product' => $product]
                                ) }}"
                                class="
                                    inventory-variant-edit-page__button
                                    inventory-variant-edit-page__button--secondary
                                "
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                class="
                                    inventory-variant-edit-page__button
                                    inventory-variant-edit-page__button--primary
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

            </main>


            {{-- =========================================================
                SIDEBAR
            ========================================================== --}}
            <aside class="inventory-variant-edit-page__sidebar">


                {{-- =================================================
                    CURRENT INVENTORY
                ================================================== --}}
                <section class="inventory-variant-edit-page__card">

                    <div class="inventory-variant-edit-page__card-header">

                        <div>

                            <h2 class="inventory-variant-edit-page__card-title">
                                Current Inventory
                            </h2>

                        </div>

                    </div>


                    <div class="inventory-variant-edit-page__summary">

                        {{-- Current Stock --}}
                        <div class="inventory-variant-edit-page__summary-item">

                            <span>
                                Current Stock
                            </span>


                            <strong
                                data-current-stock
                                class="
                                    {{ $isOutOfStock
                                        ? 'is-danger'
                                        : ($isLowStock ? 'is-warning' : 'is-success')
                                    }}
                                "
                            >
                                {{ number_format($variantStock) }}
                            </strong>

                        </div>


                        {{-- Current Price --}}
                        <div class="inventory-variant-edit-page__summary-item">

                            <span>
                                Current Price
                            </span>

                            <strong>
                                ${{ number_format(
                                    (float) $variant->price,
                                    2
                                ) }}
                            </strong>

                        </div>


                        {{-- SKU --}}
                        <div class="inventory-variant-edit-page__summary-item">

                            <span>
                                SKU
                            </span>

                            <strong>
                                {{ $variant->sku ?: '—' }}
                            </strong>

                        </div>


                        {{-- Product Type --}}
                        <div class="inventory-variant-edit-page__summary-item">

                            <span>
                                Product Type
                            </span>

                            <strong>
                                Variable
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    STOCK ADJUSTMENT NOTICE
                ================================================== --}}
                <section class="inventory-variant-edit-page__notice">

                    <div class="inventory-variant-edit-page__notice-icon">

                        <i class="fa-solid fa-circle-info"></i>

                    </div>


                    <div>

                        <h3>
                            Stock adjustment
                        </h3>

                        <p>
                            Changing the stock quantity automatically
                            creates an inventory adjustment record.
                        </p>

                    </div>

                </section>


                {{-- =================================================
                    PRODUCT LINK
                ================================================== --}}
                <section class="inventory-variant-edit-page__card">

                    <div class="inventory-variant-edit-page__product-link">

                        <span>
                            Product
                        </span>


                        <strong>
                            {{ $product->name }}
                        </strong>


                        <a
                            href="{{ route(
                                'admin-inventory-product-edit',
                                ['product' => $product]
                            ) }}"
                        >
                            View Product

                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>

                </section>

            </aside>

        </div>

    </div>
@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const page =
                document.querySelector(
                    '.inventory-variant-edit-page'
                );


            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const form =
                page.querySelector(
                    '[data-variant-inventory-form]'
                );


            const priceInput =
                page.querySelector(
                    '#variant-price'
                );


            const stockInput =
                page.querySelector(
                    '#variant-stock'
                );


            const saveButton =
                page.querySelector(
                    '[data-save-button]'
                );


            const status =
                page.querySelector(
                    '[data-stock-status]'
                );


            const statusIcon =
                page.querySelector(
                    '[data-stock-status-icon]'
                );


            const statusTitle =
                page.querySelector(
                    '[data-stock-status-title]'
                );


            const statusText =
                page.querySelector(
                    '[data-stock-status-text]'
                );


            if (
                !form
                || !priceInput
                || !stockInput
                || !saveButton
                || !status
                || !statusIcon
                || !statusTitle
                || !statusText
            ) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Configuration
            |--------------------------------------------------------------------------
            */

            const lowStockThreshold =
                {{ (int) $lowStockThreshold }};


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
                Number(
                    stockInput.value || 0
                );


            /*
            |--------------------------------------------------------------------------
            | Stock Status
            |--------------------------------------------------------------------------
            */

            const updateStockStatus = () => {

                const stock =
                    Math.max(
                        0,
                        Number(
                            stockInput.value || 0
                        )
                    );


                /*
                |--------------------------------------------------------------------------
                | Reset Status Classes
                |--------------------------------------------------------------------------
                */

                status.classList.remove(
                    'is-success',
                    'is-warning',
                    'is-danger'
                );


                statusIcon.classList.remove(
                    'fa-circle-check',
                    'fa-triangle-exclamation',
                    'fa-circle-xmark'
                );


                /*
                |--------------------------------------------------------------------------
                | Out Of Stock
                |--------------------------------------------------------------------------
                */

                if (stock === 0) {

                    status.classList.add(
                        'is-danger'
                    );


                    statusIcon.classList.add(
                        'fa-circle-xmark'
                    );


                    statusTitle.textContent =
                        'Out of Stock';


                    statusText.textContent =
                        'This variant currently has no available stock.';


                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Low Stock
                |--------------------------------------------------------------------------
                */

                if (
                    stock > 0
                    && stock <= lowStockThreshold
                ) {

                    status.classList.add(
                        'is-warning'
                    );


                    statusIcon.classList.add(
                        'fa-triangle-exclamation'
                    );


                    statusTitle.textContent =
                        'Low Stock';


                    statusText.textContent =
                        'This variant is running low on available stock.';


                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | In Stock
                |--------------------------------------------------------------------------
                */

                status.classList.add(
                    'is-success'
                );


                statusIcon.classList.add(
                    'fa-circle-check'
                );


                statusTitle.textContent =
                    'In Stock';


                statusText.textContent =
                    'This variant has a healthy stock level.';

            };


            /*
            |--------------------------------------------------------------------------
            | Save Button State
            |--------------------------------------------------------------------------
            */

            const updateButtonState = () => {

                const currentPrice =
                    Number(
                        priceInput.value || 0
                    ).toFixed(2);


                const currentStock =
                    Number(
                        stockInput.value || 0
                    );


                const hasChanges =
                    currentPrice !== initialPrice
                    || currentStock !== initialStock;


                saveButton.disabled =
                    !hasChanges;

            };


            /*
            |--------------------------------------------------------------------------
            | Price Input
            |--------------------------------------------------------------------------
            */

            priceInput.addEventListener(
                'input',
                updateButtonState
            );


            /*
            |--------------------------------------------------------------------------
            | Stock Input
            |--------------------------------------------------------------------------
            */

            stockInput.addEventListener(
                'input',
                () => {

                    updateStockStatus();

                    updateButtonState();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Submit
            |--------------------------------------------------------------------------
            */

            form.addEventListener(
                'submit',
                () => {

                    saveButton.disabled =
                        true;


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

            updateStockStatus();

            updateButtonState();

        });
    </script>

@endpush
