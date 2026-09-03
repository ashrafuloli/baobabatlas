@extends('backend.layouts.backend')

@section('title', 'Categories')

@section('content')

    <div class="categories-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="categories-page__header">

            <div>

                <span class="categories-page__eyebrow">
                    Ecommerce
                </span>

                <h1>
                    Categories
                </h1>

                <p>
                    Organize your ecommerce products into clear and manageable categories.
                </p>

            </div>


            {{-- Add Category --}}
            <a
                href="{{ route('admin-categories.create') }}"
                class="categories-page__add-btn"
            >

                <i class="ri-add-line"></i>

                Add Category

            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- STATISTICS --}}
        {{-- ================================================================ --}}

        <div class="categories-stats">

            {{-- Total --}}
            <div class="categories-stat-card">

                <div class="categories-stat-card__icon">

                    <i class="ri-price-tag-3-line"></i>

                </div>

                <div>

                    <span>
                        Total Categories
                    </span>

                    <strong>
                        {{ $totalCategories }}
                    </strong>

                </div>

            </div>


            {{-- Active --}}
            <div class="categories-stat-card">

                <div class="categories-stat-card__icon active">

                    <i class="ri-checkbox-circle-line"></i>

                </div>

                <div>

                    <span>
                        Active Categories
                    </span>

                    <strong>
                        {{ $activeCategories }}
                    </strong>

                </div>

            </div>


            {{-- Products --}}
            <div class="categories-stat-card">

                <div class="categories-stat-card__icon products">

                    <i class="ri-shopping-bag-3-line"></i>

                </div>

                <div>

                    <span>
                        Products Assigned
                    </span>

                    <strong>
                        {{ $productsAssigned }}
                    </strong>

                </div>

            </div>


            {{-- Empty --}}
            <div class="categories-stat-card">

                <div class="categories-stat-card__icon empty">

                    <i class="ri-folder-warning-line"></i>

                </div>

                <div>

                    <span>
                        Empty Categories
                    </span>

                    <strong>
                        {{--                        {{ $emptyCategories }}--}}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- CATEGORIES CARD --}}
        {{-- ================================================================ --}}

        <div class="categories-card">


            {{-- ============================================================ --}}
            {{-- TOOLBAR --}}
            {{-- ============================================================ --}}

            <div class="categories-toolbar">

                <div class="categories-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search categories..."
                    >

                </div>


                <div class="categories-toolbar__actions">

                    {{-- Status --}}
                    <select
                        name="status"
                        class="categories-select"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="active"
                            {{ $status === 'active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            {{ $status === 'inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>

                    </select>


                    {{-- Type --}}
                    <select
                        name="type"
                        class="categories-select"
                    >

                        <option value="">
                            All Types
                        </option>

                        <option
                            value="parent"
                            {{ $type === 'parent' ? 'selected' : '' }}
                        >
                            Main Categories
                        </option>

                        <option
                            value="subcategory"
                            {{ $type === 'subcategory' ? 'selected' : '' }}
                        >
                            Subcategories
                        </option>

                    </select>


                    <button
                        type="button"
                        class="categories-filter-btn"
                    >

                        <i class="ri-filter-3-line"></i>

                        Filter

                    </button>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="categories-table-wrapper">

                <table class="categories-table">

                    <thead>

                    <tr>

                        <th>
                            Category
                        </th>

                        <th>
                            Type
                        </th>

                        <th>
                            Parent Category
                        </th>

                        <th>
                            Products
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Created
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    @forelse($categories as $category)

                        {{-- ================================================= --}}
                        {{-- MAIN CATEGORY --}}
                        {{-- ================================================= --}}

                        @if($type !== 'subcategory')

                            <tr>

                                <td>

                                    <div class="category-info">

                                        <div class="category-info__icon">
                                            @if ( $category && !empty($category->image))
                                                <img src="{{ asset($category->image) }}" alt="image">
                                            @else
                                                <i class="ri-folder-2-line"></i>
                                            @endif
                                        </div>


                                        <div class="category-info__content">

                                            <strong>
                                                {{ $category->name }}
                                            </strong>

                                            <span>
                                                {{ $category->slug }}
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- Type --}}
                                <td>

                                    <span class="category-type category-type--parent">

                                        <i class="ri-folder-2-line"></i>

                                        Main Category

                                    </span>

                                </td>


                                {{-- Parent --}}
                                <td>

                                    <span class="category-parent-empty">
                                        —
                                    </span>

                                </td>


                                {{-- Products --}}
                                <td>

                                    <span
                                        class="category-product-count {{ $category->products_count == 0 ? 'empty' : '' }}"
                                    >

                                        {{ $category->products_count }}

                                        {{ $category->products_count == 1 ? 'Product' : 'Products' }}

                                    </span>

                                </td>


                                {{-- Status --}}
                                <td>

                                    <span
                                        class="category-status {{ $category->status ? 'active' : 'inactive' }}"
                                    >

                                        <i></i>

                                        {{ $category->status ? 'Active' : 'Inactive' }}

                                    </span>

                                </td>


                                {{-- Created --}}
                                <td>

                                    {{ $category->created_at->format('M d, Y') }}

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="category-actions">

                                        {{-- Details --}}
                                        <a
                                            href="{{ route('admin-categories.show', $category->id) }}"
                                            title="View Details"
                                        >

                                            <i class="ri-eye-line"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('admin-categories.edit', $category->id) }}"
                                            title="Edit Category"
                                        >

                                            <i class="ri-edit-line"></i>

                                        </a>


                                        {{-- More --}}
                                        <form action="{{ route('admin-categories.destroy', $category->id) }}"
                                              method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Category"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endif


                        {{-- ================================================= --}}
                        {{-- SUBCATEGORIES --}}
                        {{-- ================================================= --}}

                        @foreach($category->children as $child)

                            <tr class="category-row category-row--child">

                                <td>

                                    <div class="category-info category-info--child">

                                        <div class="category-info__connector">
                                            ↳
                                        </div>


                                        <div class="category-info__icon subcategory">

                                            @if ( $child && !empty($child->image))
                                                <img src="{{ asset($child->image) }}" alt="image">
                                            @else
                                                <i class="ri-folder-2-line"></i>
                                            @endif

                                        </div>


                                        <div class="category-info__content">

                                            <strong>
                                                {{ $child->name }}
                                            </strong>

                                            <span>
                                                {{ $child->slug }}
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- Type --}}
                                <td>

                                    <span class="category-type category-type--child">

                                        <i class="ri-corner-down-right-line"></i>

                                        Subcategory

                                    </span>

                                </td>


                                {{-- Parent --}}
                                <td>

                                    <span class="category-parent">

                                        <i class="ri-folder-2-line"></i>

                                        {{ $category->name }}

                                    </span>

                                </td>


                                {{-- Products --}}
                                <td>

                                    <span
                                        class="category-product-count {{ $child->products_count == 0 ? 'empty' : '' }}"
                                    >

                                        {{ $child->products_count }}

                                        {{ $child->products_count == 1 ? 'Product' : 'Products' }}

                                    </span>

                                </td>


                                {{-- Status --}}
                                <td>

                                    <span
                                        class="category-status {{ $child->status ? 'active' : 'inactive' }}"
                                    >

                                        <i></i>

                                        {{ $child->status ? 'Active' : 'Inactive' }}

                                    </span>

                                </td>


                                {{-- Created --}}
                                <td>

                                    {{ $child->created_at->format('M d, Y') }}

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="category-actions">

                                        {{-- Details --}}
                                        <a
                                            href="{{ route('admin-categories.show', $child->id) }}"
                                            title="View Details"
                                        >

                                            <i class="ri-eye-line"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('admin-categories.edit', $child->id) }}"
                                            title="Edit Category"
                                        >

                                            <i class="ri-edit-line"></i>

                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin-categories.destroy', $child->id) }}"
                                              method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Category"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                style="text-align: center; padding: 40px;"
                            >

                                No categories found.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ============================================================ --}}
            {{-- PAGINATION --}}
            {{-- ============================================================ --}}

            <div class="categories-pagination">

                <div class="categories-pagination__info">

                    Showing
                    {{ $categories->count() }}
                    of
                    {{ $totalCategories }}
                    categories

                </div>


                <div class="categories-pagination__buttons">

                    {{-- Previous --}}
                    <button
                        type="button"
                        disabled
                    >

                        <i class="ri-arrow-left-s-line"></i>

                    </button>


                    {{-- Current --}}
                    <button
                        type="button"
                        class="active"
                    >
                        1
                    </button>


                    {{-- Next --}}
                    <button
                        type="button"
                        disabled
                    >

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection


{{-- ================================================================ --}}
{{-- PAGE SCRIPT --}}
{{-- ================================================================ --}}

@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const page =
                document.querySelector('.categories-page');

            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const searchInput =
                page.querySelector(
                    'input[name="search"]'
                );

            const statusSelect =
                page.querySelector(
                    'select[name="status"]'
                );

            const typeSelect =
                page.querySelector(
                    'select[name="type"]'
                );

            const filterButton =
                page.querySelector(
                    '.categories-filter-btn'
                );


            /*
            |--------------------------------------------------------------------------
            | Apply Filters
            |--------------------------------------------------------------------------
            */

            function applyFilters() {

                const params =
                    new URLSearchParams();


                /*
                |--------------------------------------------------------------------------
                | Search
                |--------------------------------------------------------------------------
                */

                const search =
                    searchInput
                        ? searchInput.value.trim()
                        : '';


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                const status =
                    statusSelect
                        ? statusSelect.value
                        : '';


                /*
                |--------------------------------------------------------------------------
                | Type
                |--------------------------------------------------------------------------
                */

                const type =
                    typeSelect
                        ? typeSelect.value
                        : '';


                /*
                |--------------------------------------------------------------------------
                | Build Query
                |--------------------------------------------------------------------------
                */

                if (search) {

                    params.set(
                        'search',
                        search
                    );

                }


                if (status) {

                    params.set(
                        'status',
                        status
                    );

                }


                if (type) {

                    params.set(
                        'type',
                        type
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Redirect
                |--------------------------------------------------------------------------
                */

                const queryString =
                    params.toString();


                const url =
                    window.location.pathname
                    +
                    (
                        queryString
                            ? '?' + queryString
                            : ''
                    );


                window.location.href = url;

            }


            /*
            |--------------------------------------------------------------------------
            | Filter Button
            |--------------------------------------------------------------------------
            */

            if (filterButton) {

                filterButton.addEventListener(
                    'click',
                    function () {

                        applyFilters();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Search By Enter
            |--------------------------------------------------------------------------
            */

            if (searchInput) {

                searchInput.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Enter'
                        ) {

                            event.preventDefault();

                            applyFilters();

                        }

                    }
                );

            }

        });

    </script>

@endpush
