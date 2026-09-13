@extends('backend.layouts.backend')

@section('title', 'Out of Stock Inventory')

@section('content')
    <div class="inventory-out-of-stock-page">
        <div class="inventory-out-of-stock-page__header">
            <div class="inventory-out-of-stock-page__heading">
                <div class="inventory-out-of-stock-page__breadcrumb">
                    <a href="{{ route('admin-inventory') }}">
                        Inventory
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>Out of Stock</span>
                </div>

                <h1 class="inventory-out-of-stock-page__title">
                    Out of Stock Inventory
                </h1>

                <p class="inventory-out-of-stock-page__subtitle">
                    Products with variants that currently have no available stock.
                </p>
            </div>

            <a
                href="{{ route('admin-inventory') }}"
                class="inventory-out-of-stock-page__back"
            >
                <i class="fa-solid fa-arrow-left"></i>
                <span>All Inventory</span>
            </a>
        </div>

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
                        These products have at least one variant with zero stock.
                    </span>
                </div>
            </div>

            <div class="inventory-out-of-stock-page__count">
                {{ $products->total() }}
                {{ Str::plural('product', $products->total()) }}
            </div>
        </div>

        @if ($products->isNotEmpty())
            <div class="inventory-out-of-stock-page__card">
                <div class="inventory-out-of-stock-page__table-wrapper">
                    <table class="inventory-out-of-stock-page__table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Variants</th>
                            <th>Out of Stock</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($products as $product)
                            @php
                                $outOfStockVariants = $product->variants
                                    ->filter(
                                        fn ($variant): bool =>
                                            $variant->stock === 0
                                    );
                            @endphp

                            <tr>
                                <td>
                                    <div class="inventory-out-of-stock-page__product">
                                        <div class="inventory-out-of-stock-page__product-image">
                                            @if ($product->thumbnail)
                                                <img
                                                    src="{{ asset($product->thumbnail) }}"
                                                    alt="{{ $product->name }}"
                                                >
                                            @else
                                                <i class="fa-solid fa-box"></i>
                                            @endif
                                        </div>

                                        <div class="inventory-out-of-stock-page__product-info">
                                            <a
                                                href="{{ route('admin-inventory-product-edit', [
                                                        'product' => $product,
                                                    ]) }}"
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

                                <td>
                                        <span class="inventory-out-of-stock-page__sku">
                                            {{ $product->sku ?: '—' }}
                                        </span>
                                </td>

                                <td>
                                        <span class="inventory-out-of-stock-page__variant-count">
                                            {{ $product->variants->count() }}
                                        </span>
                                </td>

                                <td>
                                    <div class="inventory-out-of-stock-page__stock-list">
                                        @foreach ($outOfStockVariants as $variant)
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

                                            <div class="inventory-out-of-stock-page__stock-item">
                                                <div class="inventory-out-of-stock-page__stock-info">
                                                    <strong>
                                                        {{ $variantLabels ?: 'Default variant' }}
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
                                </td>

                                <td>
                                    <div class="inventory-out-of-stock-page__actions">
                                        <a
                                            href="{{ route('admin-inventory-product-edit', [
                                                    'product' => $product,
                                                ]) }}"
                                            class="inventory-out-of-stock-page__action"
                                            title="Edit product"
                                            aria-label="Edit product"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <button
                                            type="button"
                                            class="inventory-out-of-stock-page__action inventory-out-of-stock-page__action--toggle"
                                            data-variants-toggle
                                            aria-expanded="false"
                                            aria-label="Toggle variants"
                                            title="Toggle variants"
                                        >
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr
                                class="inventory-out-of-stock-page__mobile-details"
                                data-variants-row
                            >
                                <td colspan="5">
                                    <div class="inventory-out-of-stock-page__details">
                                        <div class="inventory-out-of-stock-page__details-header">
                                            <strong>
                                                Out of Stock Variants
                                            </strong>
                                        </div>

                                        <div class="inventory-out-of-stock-page__details-list">
                                            @foreach ($outOfStockVariants as $variant)
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

                                                <a
                                                    href="{{ route('admin-inventory-variant-edit', [
                                                            'variant' => $variant,
                                                        ]) }}"
                                                    class="inventory-out-of-stock-page__details-item"
                                                >
                                                        <span>
                                                            {{ $variantLabels ?: 'Default variant' }}
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
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="inventory-out-of-stock-page__pagination">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="inventory-out-of-stock-page__empty">
                <div class="inventory-out-of-stock-page__empty-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <h2>
                    No Out of Stock Products
                </h2>

                <p>
                    All product variants currently have available stock.
                </p>

                <a
                    href="{{ route('admin-inventory') }}"
                    class="inventory-out-of-stock-page__button"
                >
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>View Inventory</span>
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector(
                '.inventory-out-of-stock-page'
            );

            if (!page) {
                return;
            }

            const toggleButtons = page.querySelectorAll(
                '[data-variants-toggle]'
            );

            toggleButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const currentRow = button.closest('tr');

                    if (!currentRow) {
                        return;
                    }

                    const detailsRow = currentRow.nextElementSibling;

                    if (
                        !detailsRow
                        || !detailsRow.matches(
                            '[data-variants-row]'
                        )
                    ) {
                        return;
                    }

                    const isOpen = detailsRow.classList.toggle(
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
                });
            });
        });
    </script>
@endpush
