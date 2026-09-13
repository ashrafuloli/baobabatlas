@extends('backend.layouts.backend')

@section('title', 'Edit Variant Inventory')

@section('content')
    <div class="inventory-variant-edit-page">
        <div class="inventory-variant-edit-page__header">
            <div class="inventory-variant-edit-page__heading">
                <div class="inventory-variant-edit-page__breadcrumb">
                    <a href="{{ route('admin-inventory') }}">
                        Inventory
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <a
                        href="{{ route('admin-inventory-product-edit', [
                            'product' => $variant->product,
                        ]) }}"
                    >
                        {{ $variant->product->name }}
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>Variant</span>
                </div>

                <h1 class="inventory-variant-edit-page__title">
                    Edit Variant Inventory
                </h1>

                <p class="inventory-variant-edit-page__subtitle">
                    Update the variant price and available stock.
                </p>
            </div>

            <a
                href="{{ route('admin-inventory-product-edit', [
                    'product' => $variant->product,
                ]) }}"
                class="inventory-variant-edit-page__back"
            >
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Product</span>
            </a>
        </div>

        <div class="inventory-variant-edit-page__layout">
            <main class="inventory-variant-edit-page__main">
                {{-- Variant Information --}}
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
                    </div>

                    <div class="inventory-variant-edit-page__product">
                        <div class="inventory-variant-edit-page__product-image">
                            @if ($variant->image)
                                <img
                                    src="{{ asset($variant->image) }}"
                                    alt="{{ $variant->product->name }}"
                                >
                            @elseif ($variant->product->thumbnail)
                                <img
                                    src="{{ asset($variant->product->thumbnail) }}"
                                    alt="{{ $variant->product->name }}"
                                >
                            @else
                                <i class="fa-solid fa-box"></i>
                            @endif
                        </div>

                        <div class="inventory-variant-edit-page__product-content">
                            <h3>
                                {{ $variant->product->name }}
                            </h3>

                            @php
                                $variantLabels = $variant->values
                                    ->map(function ($value): string {
                                        $attribute = $value->attribute?->name;

                                        $attributeValue = $value->attributeValue?->value
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
                                {{ $variantLabels ?: 'Default variant' }}
                            </div>

                            <div class="inventory-variant-edit-page__product-meta">
                                <span>
                                    Product SKU:
                                    <strong>
                                        {{ $variant->product->sku ?: '—' }}
                                    </strong>
                                </span>

                                <span>
                                    Variant SKU:
                                    <strong>
                                        {{ $variant->sku ?: '—' }}
                                    </strong>
                                </span>

                                <span>
                                    Status:
                                    @if ($variant->status)
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

                {{-- Inventory Form --}}
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
                        action="{{ route('admin-inventory-variant-update', [
                            'variant' => $variant,
                        ]) }}"
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
                                    <span>$</span>

                                    <input
                                        type="number"
                                        id="variant-price"
                                        name="price"
                                        value="{{ old('price', $variant->price) }}"
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
                                    value="{{ old('stock', $variant->stock) }}"
                                    min="0"
                                    step="1"
                                    inputmode="numeric"
                                    required
                                    class="inventory-variant-edit-page__stock-input @error('stock') is-invalid @enderror"
                                >

                                @error('stock')
                                <p class="inventory-variant-edit-page__error">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="inventory-variant-edit-page__stock-status">
                            <div class="inventory-variant-edit-page__stock-status-icon">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>

                            <div class="inventory-variant-edit-page__stock-status-content">
                                <strong data-stock-status-title>
                                    Stock Status
                                </strong>

                                <span data-stock-status-text>
                                    Checking current stock...
                                </span>
                            </div>
                        </div>

                        <div class="inventory-variant-edit-page__form-footer">
                            <a
                                href="{{ route('admin-inventory-product-edit', [
                                    'product' => $variant->product,
                                ]) }}"
                                class="inventory-variant-edit-page__button inventory-variant-edit-page__button--secondary"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inventory-variant-edit-page__button inventory-variant-edit-page__button--primary"
                                data-save-button
                            >
                                <i class="fa-solid fa-check"></i>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </form>
                </section>
            </main>

            <aside class="inventory-variant-edit-page__sidebar">
                {{-- Current Stock --}}
                <section class="inventory-variant-edit-page__card">
                    <div class="inventory-variant-edit-page__card-header">
                        <div>
                            <h2 class="inventory-variant-edit-page__card-title">
                                Current Inventory
                            </h2>
                        </div>
                    </div>

                    <div class="inventory-variant-edit-page__summary">
                        <div class="inventory-variant-edit-page__summary-item">
                            <span>Current Stock</span>

                            <strong data-current-stock>
                                {{ number_format($variant->stock) }}
                            </strong>
                        </div>

                        <div class="inventory-variant-edit-page__summary-item">
                            <span>Current Price</span>

                            <strong>
                                ${{ number_format((float) $variant->price, 2) }}
                            </strong>
                        </div>

                        <div class="inventory-variant-edit-page__summary-item">
                            <span>SKU</span>

                            <strong>
                                {{ $variant->sku ?: '—' }}
                            </strong>
                        </div>
                    </div>
                </section>

                {{-- Stock Warning --}}
                <section class="inventory-variant-edit-page__notice">
                    <div class="inventory-variant-edit-page__notice-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                    <div>
                        <h3>
                            Stock adjustment
                        </h3>

                        <p>
                            Changing the stock quantity will automatically
                            create an inventory adjustment record.
                        </p>
                    </div>
                </section>

                {{-- Product Link --}}
                <section class="inventory-variant-edit-page__card">
                    <div class="inventory-variant-edit-page__product-link">
                        <span>
                            Product
                        </span>

                        <strong>
                            {{ $variant->product->name }}
                        </strong>

                        <a
                            href="{{ route('admin-inventory-product-edit', [
                                'product' => $variant->product,
                            ]) }}"
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
            const page = document.querySelector(
                '.inventory-variant-edit-page'
            );

            if (!page) {
                return;
            }

            const form = page.querySelector(
                '[data-variant-inventory-form]'
            );

            const priceInput = page.querySelector(
                '#variant-price'
            );

            const stockInput = page.querySelector(
                '#variant-stock'
            );

            const saveButton = page.querySelector(
                '[data-save-button]'
            );

            const statusTitle = page.querySelector(
                '[data-stock-status-title]'
            );

            const statusText = page.querySelector(
                '[data-stock-status-text]'
            );

            if (
                !form
                || !priceInput
                || !stockInput
                || !saveButton
                || !statusTitle
                || !statusText
            ) {
                return;
            }

            const initialPrice = Number(
                priceInput.value || 0
            ).toFixed(2);

            const initialStock = Number(
                stockInput.value || 0
            );

            const updateButtonState = () => {
                const currentPrice = Number(
                    priceInput.value || 0
                ).toFixed(2);

                const currentStock = Number(
                    stockInput.value || 0
                );

                const hasChanges = (
                    currentPrice !== initialPrice
                    || currentStock !== initialStock
                );

                saveButton.disabled = !hasChanges;
            };

            const updateStockStatus = () => {
                const stock = Number(
                    stockInput.value || 0
                );

                if (stock <= 0) {
                    statusTitle.textContent = 'Out of Stock';
                    statusText.textContent =
                        'This variant currently has no available stock.';
                    return;
                }

                if (stock <= 5) {
                    statusTitle.textContent = 'Low Stock';
                    statusText.textContent =
                        'This variant is running low on available stock.';
                    return;
                }

                statusTitle.textContent = 'In Stock';
                statusText.textContent =
                    'This variant has a healthy stock level.';
            };

            priceInput.addEventListener(
                'input',
                updateButtonState
            );

            stockInput.addEventListener(
                'input',
                () => {
                    updateStockStatus();
                    updateButtonState();
                }
            );

            form.addEventListener('submit', () => {
                saveButton.disabled = true;

                saveButton.innerHTML = `
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span>Saving...</span>
                `;
            });

            updateStockStatus();
            updateButtonState();
        });
    </script>
@endpush
