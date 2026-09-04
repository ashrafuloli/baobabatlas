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
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <i class="ri-arrow-down-s-line"></i>
                    </div>

                    {{-- Source --}}
                    <div class="product-index-page__select">
                        <select id="product-source-filter">
                            <option value="">All Sources</option>
                            <option value="own">Own</option>
                            <option value="amazon">Amazon</option>
                            <option value="aliexpress">AliExpress</option>
                        </select>

                        <i class="ri-arrow-down-s-line"></i>
                    </div>

                    {{-- Category --}}
                    <div class="product-index-page__select">
                        <select id="product-category-filter">
                            <option value="">All Categories</option>

                            @foreach (
                                $products
                                    ->flatMap(fn ($product) => $product->categories)
                                    ->unique('id')
                                    ->sortBy('name')
                                as $category
                            )
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <i class="ri-arrow-down-s-line"></i>
                    </div>

                    {{-- Brand --}}
                    <div class="product-index-page__select">
                        <select id="product-brand-filter">
                            <option value="">All Brands</option>

                            @foreach (
                                $products
                                    ->pluck('brand')
                                    ->filter()
                                    ->unique('id')
                                    ->sortBy('name')
                                as $brand
                            )
                                <option value="{{ $brand->id }}">
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
                        <strong>{{ $products->count() }}</strong>
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
                            $categoryIds = $productCategories
                                ->pluck('id')
                                ->implode(',');

                            $categoryNames = $productCategories
                                ->pluck('name')
                                ->implode(' ');

                            $brandId = $product->brand?->id ?? '';
                            $brandName = $product->brand?->name ?? '';

                            $searchText = strtolower(
                                $product->name .
                                ' ' .
                                ($product->sku ?? '') .
                                ' ' .
                                $categoryNames .
                                ' ' .
                                $brandName
                            );
                        @endphp

                        <tr
                            class="product-index-page__product-row"
                            data-product-row
                            data-search="{{ $searchText }}"
                            data-status="{{ $product->status ? 'active' : 'inactive' }}"
                            data-source="{{ strtolower($product->source) }}"
                            data-categories="{{ $categoryIds }}"
                            data-brand="{{ $brandId }}"
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
                                    @forelse ($product->categories as $category)
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
                                            {{ $product->brand->name }}
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
                                <strong>No products found.</strong>
                                <span>
                                        Add your first product to get started.
                                    </span>

                                <a href="{{ route('admin-products.create') }}">
                                    Add Product
                                </a>
                            </td>
                        </tr>
                    @endforelse

                    {{-- JS Empty State --}}
                    <tr
                        id="product-filter-empty"
                        class="product-index-page__filter-empty"
                        hidden
                    >
                        <td colspan="8">
                            <div class="product-index-page__empty-content">
                                <div class="product-index-page__empty-icon">
                                    <i class="ri-search-line"></i>
                                </div>

                                <strong>No matching products</strong>

                                <span>
                                        Try changing your search or filter options.
                                    </span>

                                <button
                                    type="button"
                                    id="product-empty-clear"
                                >
                                    Clear Filters
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector('.product-index-page');

            if (!page) {
                return;
            }

            const searchInput = page.querySelector('#product-search');
            const searchClear = page.querySelector('#product-search-clear');

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

            const emptyState = page.querySelector(
                '#product-filter-empty'
            );

            const emptyClearButton = page.querySelector(
                '#product-empty-clear'
            );

            const rows = Array.from(
                page.querySelectorAll('[data-product-row]')
            );

            const normalize = (value) => {
                return String(value || '')
                    .toLowerCase()
                    .trim();
            };

            const getSelectedText = (select) => {
                if (!select || !select.value) {
                    return '';
                }

                return select.options[select.selectedIndex]?.text || '';
            };

            const renderActiveFilters = () => {
                activeFilters.innerHTML = '';

                const filters = [];

                if (searchInput.value.trim()) {
                    filters.push({
                        label: `Search: ${searchInput.value.trim()}`,
                    });
                }

                if (statusFilter.value) {
                    filters.push({
                        label: `Status: ${getSelectedText(statusFilter)}`,
                    });
                }

                if (sourceFilter.value) {
                    filters.push({
                        label: `Source: ${getSelectedText(sourceFilter)}`,
                    });
                }

                if (categoryFilter.value) {
                    filters.push({
                        label: `Category: ${getSelectedText(categoryFilter)}`,
                    });
                }

                if (brandFilter.value) {
                    filters.push({
                        label: `Brand: ${getSelectedText(brandFilter)}`,
                    });
                }

                filters.forEach((filter) => {
                    const badge = document.createElement('span');

                    badge.className =
                        'product-index-page__active-filter';

                    badge.textContent = filter.label;

                    activeFilters.appendChild(badge);
                });
            };

            const applyFilters = () => {
                const search = normalize(searchInput.value);
                const status = normalize(statusFilter.value);
                const source = normalize(sourceFilter.value);
                const category = categoryFilter.value;
                const brand = brandFilter.value;

                let matchedCount = 0;

                rows.forEach((row) => {
                    const rowSearch = normalize(
                        row.dataset.search
                    );

                    const rowStatus = normalize(
                        row.dataset.status
                    );

                    const rowSource = normalize(
                        row.dataset.source
                    );

                    const rowCategories = row.dataset.categories
                        ? row.dataset.categories.split(',')
                        : [];

                    const rowBrand = row.dataset.brand || '';

                    const matchesSearch =
                        !search ||
                        rowSearch.includes(search);

                    const matchesStatus =
                        !status ||
                        rowStatus === status;

                    const matchesSource =
                        !source ||
                        rowSource === source;

                    const matchesCategory =
                        !category ||
                        rowCategories.includes(category);

                    const matchesBrand =
                        !brand ||
                        rowBrand === brand;

                    const matches =
                        matchesSearch &&
                        matchesStatus &&
                        matchesSource &&
                        matchesCategory &&
                        matchesBrand;

                    row.hidden = !matches;

                    if (matches) {
                        matchedCount++;
                    }
                });

                visibleCount.textContent = matchedCount;

                emptyState.hidden = matchedCount !== 0;

                searchClear.classList.toggle(
                    'is-visible',
                    searchInput.value.length > 0
                );

                renderActiveFilters();
            };

            const clearFilters = () => {
                searchInput.value = '';
                statusFilter.value = '';
                sourceFilter.value = '';
                categoryFilter.value = '';
                brandFilter.value = '';

                applyFilters();
                searchInput.focus();
            };

            searchInput.addEventListener(
                'input',
                applyFilters
            );

            searchClear.addEventListener(
                'click',
                () => {
                    searchInput.value = '';
                    applyFilters();
                    searchInput.focus();
                }
            );

            statusFilter.addEventListener(
                'change',
                applyFilters
            );

            sourceFilter.addEventListener(
                'change',
                applyFilters
            );

            categoryFilter.addEventListener(
                'change',
                applyFilters
            );

            brandFilter.addEventListener(
                'change',
                applyFilters
            );

            filterButton.addEventListener(
                'click',
                applyFilters
            );

            clearFiltersButton.addEventListener(
                'click',
                clearFilters
            );

            emptyClearButton.addEventListener(
                'click',
                clearFilters
            );

            page.querySelectorAll(
                '[data-delete-product]'
            ).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    const confirmed = window.confirm(
                        'Are you sure you want to delete this product? This action cannot be undone.'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }
                });
            });

            applyFilters();
        });
    </script>
@endsection
