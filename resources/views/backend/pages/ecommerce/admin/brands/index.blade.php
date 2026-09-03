@extends('backend.layouts.backend')

@section('title', 'Brands')

@section('content')

    <div class="brands-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="brands-page__header">

            <div>

                <span class="brands-page__eyebrow">
                    Ecommerce
                </span>

                <h1>
                    Brands
                </h1>

                <p>
                    Manage your ecommerce product brands and keep your brand catalog organized.
                </p>

            </div>


            {{-- Add Brand --}}
            <a
                href="{{ route('admin-brands.create') }}"
                class="brands-page__add-btn"
            >

                <i class="ri-add-line"></i>

                Add Brand

            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- STATISTICS --}}
        {{-- ================================================================ --}}

        <div class="brands-stats">

            {{-- Total --}}
            <div class="brands-stat-card">

                <div class="brands-stat-card__icon">

                    <i class="ri-price-tag-3-line"></i>

                </div>

                <div>

                    <span>
                        Total Brands
                    </span>

                    <strong>
                        {{ $totalBrands }}
                    </strong>

                </div>

            </div>


            {{-- Active --}}
            <div class="brands-stat-card">

                <div class="brands-stat-card__icon active">

                    <i class="ri-checkbox-circle-line"></i>

                </div>

                <div>

                    <span>
                        Active Brands
                    </span>

                    <strong>
                        {{ $activeBrands }}
                    </strong>

                </div>

            </div>


            {{-- Featured --}}
            <div class="brands-stat-card">

                <div class="brands-stat-card__icon featured">

                    <i class="ri-star-line"></i>

                </div>

                <div>

                    <span>
                        Featured Brands
                    </span>

                    <strong>
                        {{ $featuredBrands }}
                    </strong>

                </div>

            </div>


            {{-- Inactive --}}
            <div class="brands-stat-card">

                <div class="brands-stat-card__icon inactive">

                    <i class="ri-close-circle-line"></i>

                </div>

                <div>

                    <span>
                        Inactive Brands
                    </span>

                    <strong>
                        {{ $totalBrands - $activeBrands }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- BRANDS CARD --}}
        {{-- ================================================================ --}}

        <div class="brands-card">


            {{-- ============================================================ --}}
            {{-- TOOLBAR --}}
            {{-- ============================================================ --}}

            <div class="brands-toolbar">

                <div class="brands-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Search brands..."
                    >

                </div>


                <div class="brands-toolbar__actions">

                    {{-- Status --}}
                    <select
                        name="status"
                        class="brands-select"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="active"
                            {{ ($status ?? '') === 'active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>

                    </select>


                    <button
                        type="button"
                        class="brands-filter-btn"
                    >

                        <i class="ri-filter-3-line"></i>

                        Filter

                    </button>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="brands-table-wrapper">

                <table class="brands-table">

                    <thead>

                    <tr>

                        <th>
                            Brand
                        </th>

                        <th>
                            Products
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Featured
                        </th>

                        <th>
                            Sort Order
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

                    @forelse($brands as $brand)

                        <tr>

                            {{-- Brand --}}
                            <td>

                                <div class="brand-info">

                                    <div class="brand-info__icon">

                                        @if($brand->logo)

                                            <img
                                                src="{{ asset($brand->logo) }}"
                                                alt="{{ $brand->name }}"
                                            >

                                        @else

                                            <i class="ri-price-tag-3-line"></i>

                                        @endif

                                    </div>


                                    <div class="brand-info__content">

                                        <strong>
                                            {{ $brand->name }}
                                        </strong>

                                        <span>
                                            {{ $brand->slug }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- Products --}}
                            <td>

                                <span
                                    class="brand-product-count {{ ($brand->products_count ?? 0) == 0 ? 'empty' : '' }}"
                                >

                                    {{ $brand->products_count ?? 0 }}

                                    {{ ($brand->products_count ?? 0) == 1 ? 'Product' : 'Products' }}

                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                <span
                                    class="brand-status {{ $brand->status ? 'active' : 'inactive' }}"
                                >

                                    <i></i>

                                    {{ $brand->status ? 'Active' : 'Inactive' }}

                                </span>

                            </td>


                            {{-- Featured --}}
                            <td>

                                @if($brand->featured)

                                    <span class="brand-featured active">

                                        <i class="ri-star-fill"></i>

                                        Featured

                                    </span>

                                @else

                                    <span class="brand-featured">

                                        <i class="ri-star-line"></i>

                                        Standard

                                    </span>

                                @endif

                            </td>


                            {{-- Sort Order --}}
                            <td>

                                <span class="brand-sort-order">
                                    {{ $brand->sort_order }}
                                </span>

                            </td>


                            {{-- Created --}}
                            <td>

                                {{ $brand->created_at->format('M d, Y') }}

                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="brand-actions">

                                    {{-- Details --}}
                                    <a
                                        href="{{ route('admin-brands.show', $brand->id) }}"
                                        title="View Details"
                                    >

                                        <i class="ri-eye-line"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin-brands.edit', $brand->id) }}"
                                        title="Edit Brand"
                                    >

                                        <i class="ri-edit-line"></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin-brands.destroy', $brand->id) }}"
                                        method="POST"
                                        style="display: inline;"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Delete Brand"
                                            onclick="return confirm('Are you sure you want to delete this brand?')"
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
                                colspan="7"
                                style="text-align: center; padding: 40px;"
                            >

                                No brands found.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ============================================================ --}}
            {{-- PAGINATION --}}
            {{-- ============================================================ --}}

            <div class="brands-pagination">

                <div class="brands-pagination__info">

                    Showing
                    {{ $brands->count() }}
                    of
                    {{ $totalBrands }}
                    brands

                </div>


                <div class="brands-pagination__buttons">

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
                document.querySelector('.brands-page');

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

            const filterButton =
                page.querySelector(
                    '.brands-filter-btn'
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
