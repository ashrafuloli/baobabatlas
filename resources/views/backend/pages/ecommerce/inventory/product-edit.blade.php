@extends('backend.layouts.backend')

@section('title', 'Edit Product Inventory')

@section('content')
    <div class="inventory-product-edit-page">
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
                    Update product pricing and review its current inventory.
                </p>
            </div>

            <a
                href="{{ route('admin-inventory') }}"
                class="inventory-product-edit-page__back"
            >
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Inventory</span>
            </a>
        </div>

        <div class="inventory-product-edit-page__layout">
            <main class="inventory-product-edit-page__main">
                {{-- Product Information --}}
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

                {{-- Pricing --}}
                <section class="inventory-product-edit-page__card">
                    <div class="inventory-product-edit-page__card-header">
                        <div>
                            <h2 class="inventory-product-edit-page__card-title">
                                Product Pricing
                            </h2>

                            <p class="inventory-product-edit-page__card-description">
                                Change the current selling price of this product.
                            </p>
                        </div>
                    </div>

                    <form
                        action="{{ route('admin-inventory-product-update', ['product' => $product]) }}"
                        method="POST"
                        class="inventory-product-edit-page__form"
                        data-product-inventory-form
                    >
                        @csrf
                        @method('PUT')

                        <div class="inventory-product-edit-page__form-grid">
                            <div class="inventory-product-edit-page__field">
                                <label
                                    for="product-price"
                                    class="inventory-product-edit-page__label"
                                >
                                    Selling Price
                                    <span>*</span>
                                </label>

                                <div class="inventory-product-edit-page__price-input">
                                    <span>$</span>

                                    <input
                                        type="number"
                                        id="product-price"
                                        name="price"
                                        value="{{ old('price', $product->price) }}"
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

                            <div class="inventory-product-edit-page__field">
                                <span class="inventory-product-edit-page__label">
                                    Current Price
                                </span>

                                <div class="inventory-product-edit-page__current-value">
                                    ${{ number_format((float) $product->price, 2) }}
                                </div>
                            </div>
                        </div>

                        <div class="inventory-product-edit-page__form-footer">
                            <a
                                href="{{ route('admin-inventory') }}"
                                class="inventory-product-edit-page__button inventory-product-edit-page__button--secondary"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inventory-product-edit-page__button inventory-product-edit-page__button--primary"
                                data-save-button
                            >
                                <i class="fa-solid fa-check"></i>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </form>
                </section>

                {{-- Variants --}}
                @if ($product->variants->isNotEmpty())
                    <section class="inventory-product-edit-page__card">
                        <div class="inventory-product-edit-page__card-header">
                            <div>
                                <h2 class="inventory-product-edit-page__card-title">
                                    Product Variants
                                </h2>

                                <p class="inventory-product-edit-page__card-description">
                                    Manage variant pricing and stock separately.
                                </p>
                            </div>

                            <span class="inventory-product-edit-page__count">
                                {{ $product->variants->count() }}
                                {{ Str::plural('variant', $product->variants->count()) }}
                            </span>
                        </div>

                        <div class="inventory-product-edit-page__variants">
                            @foreach ($product->variants as $variant)
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

                                <div class="inventory-product-edit-page__variant">
                                    <div class="inventory-product-edit-page__variant-info">
                                        <strong>
                                            {{ $variantLabels ?: 'Default variant' }}
                                        </strong>

                                        <span>
                                            SKU:
                                            {{ $variant->sku ?: '—' }}
                                        </span>
                                    </div>

                                    <div class="inventory-product-edit-page__variant-data">
                                        <span>Price</span>

                                        <strong>
                                            ${{ number_format((float) $variant->price, 2) }}
                                        </strong>
                                    </div>

                                    <div class="inventory-product-edit-page__variant-data">
                                        <span>Stock</span>

                                        @if ($variant->stock === 0)
                                            <strong class="is-danger">
                                                0
                                            </strong>
                                        @elseif ($variant->stock <= 5)
                                            <strong class="is-warning">
                                                {{ number_format($variant->stock) }}
                                            </strong>
                                        @else
                                            <strong class="is-success">
                                                {{ number_format($variant->stock) }}
                                            </strong>
                                        @endif
                                    </div>

                                    <a
                                        href="{{ route('admin-inventory-variant-edit', ['variant' => $variant]) }}"
                                        class="inventory-product-edit-page__icon-button"
                                        title="Edit variant"
                                        aria-label="Edit variant"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>

            <aside class="inventory-product-edit-page__sidebar">
                @php
                    $totalStock = $product->variants->sum('stock');

                    $totalVariants = $product->variants->count();

                    $lowStock = $product->variants
                        ->where('stock', '>', 0)
                        ->where('stock', '<=', 5)
                        ->count();

                    $outOfStock = $product->variants
                        ->where('stock', 0)
                        ->count();
                @endphp

                {{-- Inventory Summary --}}
                <section class="inventory-product-edit-page__card">
                    <div class="inventory-product-edit-page__card-header">
                        <div>
                            <h2 class="inventory-product-edit-page__card-title">
                                Inventory Summary
                            </h2>
                        </div>
                    </div>

                    <div class="inventory-product-edit-page__summary">
                        <div class="inventory-product-edit-page__summary-item">
                            <span>Variants</span>
                            <strong>
                                {{ number_format($totalVariants) }}
                            </strong>
                        </div>

                        <div class="inventory-product-edit-page__summary-item">
                            <span>Total Stock</span>
                            <strong>
                                {{ number_format($totalStock) }}
                            </strong>
                        </div>

                        <div class="inventory-product-edit-page__summary-item">
                            <span>Low Stock</span>
                            <strong class="is-warning">
                                {{ number_format($lowStock) }}
                            </strong>
                        </div>

                        <div class="inventory-product-edit-page__summary-item">
                            <span>Out of Stock</span>
                            <strong class="is-danger">
                                {{ number_format($outOfStock) }}
                            </strong>
                        </div>
                    </div>
                </section>

                {{-- Inventory Notice --}}
                <section class="inventory-product-edit-page__notice">
                    <div class="inventory-product-edit-page__notice-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                    <div>
                        <h3>
                            Inventory source
                        </h3>

                        <p>
                            Stock is managed at the variant level. This page
                            only updates the product selling price.
                        </p>
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

            const saveButton = page.querySelector(
                '[data-save-button]'
            );

            if (!form || !priceInput || !saveButton) {
                return;
            }

            const initialPrice = Number(
                priceInput.value || 0
            ).toFixed(2);

            const updateButtonState = () => {
                const currentPrice = Number(
                    priceInput.value || 0
                ).toFixed(2);

                saveButton.disabled = (
                    currentPrice === initialPrice
                );
            };

            priceInput.addEventListener(
                'input',
                updateButtonState
            );

            form.addEventListener('submit', () => {
                saveButton.disabled = true;

                saveButton.innerHTML = `
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span>Saving...</span>
                `;
            });

            updateButtonState();
        });
    </script>
@endpush
