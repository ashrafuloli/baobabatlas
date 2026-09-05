@extends('backend.layouts.backend')

@section('title', 'Products')

@section('content')
    <div class="product-index-page">
        {{-- Header --}}
        <div class="product-index-page__header">
            <div>
                <span class="product-index-page__eyebrow">Ecommerce</span>

                <h1 class="product-index-page__title">
                    Products
                </h1>

                <p class="product-index-page__subtitle">
                    Manage your products, inventory, and product information.
                </p>
            </div>

            <a
                href="{{ route('admin-products.create') }}"
                class="product-index-page__add-button"
            >
                <i class="ri-add-line"></i>
                <span>Add Product</span>
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="product-index-page__alert product-index-page__alert--success">
                <i class="ri-checkbox-circle-line"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Product Card --}}
        <div class="product-index-page__card">

            {{-- Filter Bar --}}
            <div class="product-index-page__filters">
                <div class="product-index-page__search">
                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        id="product-search"
                        placeholder="Search products..."
                        autocomplete="off"
                        value="{{ request('search', '') }}"
                    >

                    <button
                        type="button"
                        class="product-index-page__search-clear"
                        id="product-search-clear"
                        aria-label="Clear search"
                    >
                        <i class="ri-close-line"></i>
                    </button>
                </div>

                <div class="product-index-page__filter-group">
                    {{-- Status --}}
                    <div class="product-index-page__select">
                        <select id="product-status-filter">
                            <option value="">All Status</option>

                            <option
                                value="active"
                                @selected(request('status') === 'active')
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                @selected(request('status') === 'inactive')
                            >
                                Inactive
                            </option>
                        </select>

                        <i class="ri-arrow-down-s-line"></i>
                    </div>

                    {{-- Source --}}
                    <div class="product-index-page__select">
                        <select id="product-source-filter">
                            <option value="">All Sources</option>

                            <option
                                value="own"
                                @selected(request('source') === 'own')
                            >
                                Own
                            </option>

                            <option
                                value="amazon"
                                @selected(request('source') === 'amazon')
                            >
                                Amazon
                            </option>

                            <option
                                value="aliexpress"
                                @selected(request('source') === 'aliexpress')
                            >
                                AliExpress
                            </option>
                        </select>

                        <i class="ri-arrow-down-s-line"></i>
                    </div>

                    {{-- Category --}}
                    <div class="product-index-page__select">
                        <select id="product-category-filter">
                            <option value="">All Categories</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected((string) request('category') === (string) $category->id)
                                >
                                    {{ $category->name }}
                                </option>

                                @foreach ($category->children as $subcategory)
                                    <option
                                        value="{{ $subcategory->id }}"
                                        @selected((string) request('category') === (string) $subcategory->id)
                                    >
                                        — {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>

                        <i class="ri-arrow-down-s-line"></i>
                    </div>

                    {{-- Brand --}}
                    <div class="product-index-page__select">
                        <select id="product-brand-filter">
                            <option value="">All Brands</option>

                            @foreach ($brands as $brand)
                                <option
                                    value="{{ $brand->id }}"
                                    @selected((string) request('brand') === (string) $brand->id)
                                >
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>

                        <i class="ri-arrow-down-s-line"></i>
                    </div>

                    {{-- Filter Button --}}
                    <button
                        type="button"
                        class="product-index-page__filter-button"
                        id="product-filter-button"
                    >
                        <i class="ri-equalizer-line"></i>
                        <span>Filter</span>
                    </button>

                    {{-- Clear Button --}}
                    <button
                        type="button"
                        class="product-index-page__clear-button"
                        id="product-clear-filters"
                    >
                        <i class="ri-close-circle-line"></i>
                        <span>Clear</span>
                    </button>
                </div>
            </div>

            {{-- Filter Summary --}}
            <div class="product-index-page__filter-summary">
                <div class="product-index-page__result-count">
                    <span>
                        Showing
                        <strong id="product-visible-count">
                            {{ $products->count() }}
                        </strong>
                        of
                        <strong>{{ $products->total() }}</strong>
                        products
                    </span>
                </div>

                <div
                    class="product-index-page__active-filters"
                    id="product-active-filters"
                ></div>
            </div>

            {{-- Table --}}
            <div class="product-index-page__table-wrapper">
                <table class="product-index-page__table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Source</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody id="products-table-body">
                    @forelse ($products as $product)
                        @php
                            $productCategories = $product->categories;

                            $brandId = $product->brand?->id ?? '';
                            $brandName = $product->brand?->name ?? '';
                        @endphp

                        <tr
                            class="product-index-page__product-row"
                            data-product-row
                        >
                            {{-- Product --}}
                            <td>
                                <div class="product-index-page__product">
                                    <div class="product-index-page__thumbnail">
                                        @if ($product->thumbnail)
                                            <img
                                                src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->name }}"
                                            >
                                        @else
                                            <i class="ri-shopping-bag-3-line"></i>
                                        @endif
                                    </div>

                                    <div class="product-index-page__product-info">
                                        <a
                                            href="{{ route('admin-products.show', $product) }}"
                                            class="product-index-page__product-name"
                                        >
                                            {{ $product->name }}
                                        </a>

                                        @if ($product->sku)
                                            <span class="product-index-page__sku">
                                                SKU: {{ $product->sku }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Source --}}
                            <td>
                                <span
                                    class="product-index-page__source product-index-page__source--{{ strtolower($product->source) }}"
                                >
                                    {{ $product->source === 'aliexpress'
                                        ? 'AliExpress'
                                        : ucfirst($product->source) }}
                                </span>
                            </td>

                            {{-- Categories --}}
                            <td>
                                <div class="product-index-page__categories">
                                    @forelse ($productCategories as $category)
                                        <span>
                                            {{ $category->name }}
                                        </span>
                                    @empty
                                        <span class="product-index-page__muted">
                                            —
                                        </span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Brand --}}
                            <td>
                                @if ($product->brand)
                                    <span class="product-index-page__brand">
                                        {{ $brandName }}
                                    </span>
                                @else
                                    <span class="product-index-page__muted">
                                        —
                                    </span>
                                @endif
                            </td>

                            {{-- Price --}}
                            <td>
                                <div class="product-index-page__price">
                                    <strong>
                                        ${{ number_format((float) $product->price, 2) }}
                                    </strong>

                                    @if ($product->compare_price)
                                        <del>
                                            ${{ number_format((float) $product->compare_price, 2) }}
                                        </del>
                                    @endif
                                </div>
                            </td>

                            {{-- Stock --}}
                            <td>
                                @php
                                    $stock = $product->variants->sum('stock');
                                @endphp

                                @if ($product->variants->isNotEmpty())
                                    <span
                                        class="
                                            product-index-page__stock
                                            {{ $stock <= 0 ? 'product-index-page__stock--empty' : '' }}
                                        "
                                    >
                                        {{ $stock }}
                                    </span>
                                @else
                                    <span class="product-index-page__muted">
                                        —
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if ($product->status)
                                    <span class="product-index-page__status product-index-page__status--active">
                                        Active
                                    </span>
                                @else
                                    <span class="product-index-page__status product-index-page__status--inactive">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="product-index-page__actions">
                                    <a
                                        href="{{ route('admin-products.show', $product) }}"
                                        class="product-index-page__action"
                                        title="View"
                                    >
                                        <i class="ri-eye-line"></i>
                                    </a>

                                    <a
                                        href="{{ route('admin-products.edit', $product) }}"
                                        class="product-index-page__action"
                                        title="Edit"
                                    >
                                        <i class="ri-edit-line"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin-products.destroy', $product) }}"
                                        method="POST"
                                        data-delete-product
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="product-index-page__action product-index-page__action--danger"
                                            title="Delete"
                                        >
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="8"
                                class="product-index-page__empty product-index-page__empty--initial"
                            >
                                <i class="ri-shopping-bag-3-line"></i>

                                <strong>
                                    {{ request()->hasAny([
                                        'search',
                                        'status',
                                        'source',
                                        'category',
                                        'brand',
                                    ])
                                        ? 'No products found.'
                                        : 'No products found.' }}
                                </strong>

                                <span>
                                    {{ request()->hasAny([
                                        'search',
                                        'status',
                                        'source',
                                        'category',
                                        'brand',
                                    ])
                                        ? 'Try changing your search or filter options.'
                                        : 'Add your first product to get started.' }}
                                </span>

                                @if (
                                    !request()->hasAny([
                                        'search',
                                        'status',
                                        'source',
                                        'category',
                                        'brand',
                                    ])
                                )
                                    <a href="{{ route('admin-products.create') }}">
                                        Add Product
                                    </a>
                                @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector('.product-index-page');

            if (!page) {
                return;
            }

            const searchInput = page.querySelector('#product-search');

            const searchClear = page.querySelector(
                '#product-search-clear'
            );

            const statusFilter = page.querySelector(
                '#product-status-filter'
            );

            const sourceFilter = page.querySelector(
                '#product-source-filter'
            );

            const categoryFilter = page.querySelector(
                '#product-category-filter'
            );

            const brandFilter = page.querySelector(
                '#product-brand-filter'
            );

            const filterButton = page.querySelector(
                '#product-filter-button'
            );

            const clearFiltersButton = page.querySelector(
                '#product-clear-filters'
            );

            const activeFilters = page.querySelector(
                '#product-active-filters'
            );

            const visibleCount = page.querySelector(
                '#product-visible-count'
            );

            /*
             * Build URL from the current filter values.
             */
            const buildFilterUrl = () => {
                const url = new URL(
                    window.location.href
                );

                url.searchParams.delete('search');
                url.searchParams.delete('status');
                url.searchParams.delete('source');
                url.searchParams.delete('category');
                url.searchParams.delete('brand');
                url.searchParams.delete('page');

                const search = searchInput.value.trim();
                const status = statusFilter.value;
                const source = sourceFilter.value;
                const category = categoryFilter.value;
                const brand = brandFilter.value;

                if (search) {
                    url.searchParams.set(
                        'search',
                        search
                    );
                }

                if (status) {
                    url.searchParams.set(
                        'status',
                        status
                    );
                }

                if (source) {
                    url.searchParams.set(
                        'source',
                        source
                    );
                }

                if (category) {
                    url.searchParams.set(
                        'category',
                        category
                    );
                }

                if (brand) {
                    url.searchParams.set(
                        'brand',
                        brand
                    );

                }

                return url;
            };

            /*
             * Apply filters through URL.
             */
            const applyFilters = () => {
                const url = buildFilterUrl();

                window.location.href = url.toString();
            };

            /*
             * Clear all URL filters.
             */
            const clearFilters = () => {
                const url = new URL(
                    window.location.href
                );

                url.searchParams.delete('search');
                url.searchParams.delete('status');
                url.searchParams.delete('source');
                url.searchParams.delete('category');
                url.searchParams.delete('brand');
                url.searchParams.delete('page');

                window.location.href = url.toString();
            };

            /*
             * Render active filter badges.
             */
            const renderActiveFilters = () => {
                if (!activeFilters) {
                    return;
                }

                activeFilters.innerHTML = '';

                const filters = [];

                if (searchInput.value.trim()) {
                    filters.push({
                        label: `Search: ${searchInput.value.trim()}`,
                    });
                }

                if (statusFilter.value) {
                    filters.push({
                        label: `Status: ${
                            statusFilter.options[
                                statusFilter.selectedIndex
                                ]?.text || ''
                        }`,
                    });
                }

                if (sourceFilter.value) {
                    filters.push({
                        label: `Source: ${
                            sourceFilter.options[
                                sourceFilter.selectedIndex
                                ]?.text || ''
                        }`,
                    });
                }

                if (categoryFilter.value) {
                    filters.push({
                        label: `Category: ${
                            categoryFilter.options[
                                categoryFilter.selectedIndex
                                ]?.text || ''
                        }`,
                    });
                }

                if (brandFilter.value) {
                    filters.push({
                        label: `Brand: ${
                            brandFilter.options[
                                brandFilter.selectedIndex
                                ]?.text || ''
                        }`,
                    });
                }

                filters.forEach((filter) => {
                    const badge =
                        document.createElement('span');

                    badge.className =
                        'product-index-page__active-filter';

                    badge.textContent =
                        filter.label;

                    activeFilters.appendChild(
                        badge
                    );
                });
            };

            /*
             * Update search clear button.
             */
            const updateSearchClear = () => {
                searchClear.classList.toggle(
                    'is-visible',
                    searchInput.value.length > 0
                );
            };

            /*
             * Search on Enter.
             *
             * Search is intentionally NOT applied
             * on every keystroke because filtering is
             * server-side.
             */
            searchInput.addEventListener(
                'keydown',
                (event) => {
                    if (event.key !== 'Enter') {
                        return;
                    }

                    event.preventDefault();

                    applyFilters();
                }
            );

            /*
             * Search clear.
             */
            searchClear.addEventListener(
                'click',
                () => {
                    searchInput.value = '';

                    applyFilters();
                }
            );

            /*
             * Filter button.
             */
            filterButton.addEventListener(
                'click',
                applyFilters
            );

            /*
             * Clear all filters.
             */
            clearFiltersButton.addEventListener(
                'click',
                clearFilters
            );

            /*
             * Update clear button while typing.
             */
            searchInput.addEventListener(
                'input',
                updateSearchClear
            );

            /*
             * Delete confirmation.
             */
            page.querySelectorAll(
                '[data-delete-product]'
            ).forEach((form) => {
                form.addEventListener(
                    'submit',
                    (event) => {
                        const confirmed =
                            window.confirm(
                                'Are you sure you want to delete this product? This action cannot be undone.'
                            );

                        if (!confirmed) {
                            event.preventDefault();
                        }
                    }
                );
            });

            /*
             * Initial state.
             */
            updateSearchClear();
            renderActiveFilters();

            if (visibleCount) {
                visibleCount.textContent =
                    {{ $products->count() }};
            }
        });
    </script>
@endsection
