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
                href="{{ route('admin-category-create') }}"
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
                        18
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
                        15
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
                        248
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
                        3
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

                        <option value="active">
                            Active
                        </option>

                        <option value="inactive">
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

                        <option value="parent">
                            Main Categories
                        </option>

                        <option value="subcategory">
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


                    {{-- ================================================= --}}
                    {{-- CATEGORY 1 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="category-info">

                                <div class="category-info__icon">

                                    <i class="ri-smartphone-line"></i>

                                </div>


                                <div class="category-info__content">

                                    <strong>
                                        Electronics
                                    </strong>

                                    <span>
                                        electronics
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

                            <span class="category-product-count">
                                48 Products
                            </span>

                        </td>


                        {{-- Status --}}
                        <td>

                            <span class="category-status active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        {{-- Created --}}
                        <td>
                            Aug 01, 2026
                        </td>


                        {{-- Actions --}}
                        <td>

                            <div class="category-actions">

                                {{-- Details --}}
                                <a
                                    href="{{ route('admin-category-details', 1) }}"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin-category-edit', 1) }}"
                                    title="Edit Category"
                                >

                                    <i class="ri-edit-line"></i>

                                </a>


                                {{-- More --}}
                                <button
                                    type="button"
                                    title="More"
                                >

                                    <i class="ri-more-2-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- SUBCATEGORY --}}
                    {{-- ================================================= --}}

                    <tr class="category-row category-row--child">

                        <td>

                            <div class="category-info category-info--child">

                                <div class="category-info__connector">
                                    ↳
                                </div>


                                <div class="category-info__icon subcategory">

                                    <i class="ri-smartphone-line"></i>

                                </div>


                                <div class="category-info__content">

                                    <strong>
                                        Smartphones
                                    </strong>

                                    <span>
                                        smartphones
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

                                Electronics

                            </span>

                        </td>


                        {{-- Products --}}
                        <td>

                            <span class="category-product-count">
                                18 Products
                            </span>

                        </td>


                        {{-- Status --}}
                        <td>

                            <span class="category-status active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        {{-- Created --}}
                        <td>
                            Aug 02, 2026
                        </td>


                        {{-- Actions --}}
                        <td>

                            <div class="category-actions">

                                <a
                                    href="{{ route('admin-category-details', 7) }}"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('admin-category-edit', 7) }}"
                                    title="Edit Category"
                                >

                                    <i class="ri-edit-line"></i>

                                </a>


                                <button
                                    type="button"
                                    title="More"
                                >

                                    <i class="ri-more-2-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- CATEGORY 2 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="category-info">

                                <div class="category-info__icon fashion">

                                    <i class="ri-t-shirt-line"></i>

                                </div>


                                <div class="category-info__content">

                                    <strong>
                                        Fashion
                                    </strong>

                                    <span>
                                        fashion
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="category-type category-type--parent">

                                <i class="ri-folder-2-line"></i>

                                Main Category

                            </span>

                        </td>


                        <td>

                            <span class="category-parent-empty">
                                —
                            </span>

                        </td>


                        <td>

                            <span class="category-product-count">
                                76 Products
                            </span>

                        </td>


                        <td>

                            <span class="category-status active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>
                            Jul 28, 2026
                        </td>


                        <td>

                            <div class="category-actions">

                                <a
                                    href="{{ route('admin-category-details', 2) }}"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('admin-category-edit', 2) }}"
                                    title="Edit Category"
                                >

                                    <i class="ri-edit-line"></i>

                                </a>


                                <button
                                    type="button"
                                    title="More"
                                >

                                    <i class="ri-more-2-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- CATEGORY 3 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="category-info">

                                <div class="category-info__icon home">

                                    <i class="ri-home-5-line"></i>

                                </div>


                                <div class="category-info__content">

                                    <strong>
                                        Home & Living
                                    </strong>

                                    <span>
                                        home-living
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="category-type category-type--parent">

                                <i class="ri-folder-2-line"></i>

                                Main Category

                            </span>

                        </td>


                        <td>

                            <span class="category-parent-empty">
                                —
                            </span>

                        </td>


                        <td>

                            <span class="category-product-count">
                                34 Products
                            </span>

                        </td>


                        <td>

                            <span class="category-status active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>
                            Jul 25, 2026
                        </td>


                        <td>

                            <div class="category-actions">

                                <a
                                    href="{{ route('admin-category-details', 3) }}"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('admin-category-edit', 3) }}"
                                    title="Edit Category"
                                >

                                    <i class="ri-edit-line"></i>

                                </a>


                                <button
                                    type="button"
                                    title="More"
                                >

                                    <i class="ri-more-2-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- CATEGORY 4 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="category-info">

                                <div class="category-info__icon beauty">

                                    <i class="ri-heart-pulse-line"></i>

                                </div>


                                <div class="category-info__content">

                                    <strong>
                                        Beauty
                                    </strong>

                                    <span>
                                        beauty
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="category-type category-type--parent">

                                <i class="ri-folder-2-line"></i>

                                Main Category

                            </span>

                        </td>


                        <td>

                            <span class="category-parent-empty">
                                —
                            </span>

                        </td>


                        <td>

                            <span class="category-product-count">
                                29 Products
                            </span>

                        </td>


                        <td>

                            <span class="category-status active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>
                            Jul 20, 2026
                        </td>


                        <td>

                            <div class="category-actions">

                                <a
                                    href="{{ route('admin-category-details', 4) }}"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('admin-category-edit', 4) }}"
                                    title="Edit Category"
                                >

                                    <i class="ri-edit-line"></i>

                                </a>


                                <button
                                    type="button"
                                    title="More"
                                >

                                    <i class="ri-more-2-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- CATEGORY 5 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="category-info">

                                <div class="category-info__icon sports">

                                    <i class="ri-football-line"></i>

                                </div>


                                <div class="category-info__content">

                                    <strong>
                                        Sports & Fitness
                                    </strong>

                                    <span>
                                        sports-fitness
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="category-type category-type--parent">

                                <i class="ri-folder-2-line"></i>

                                Main Category

                            </span>

                        </td>


                        <td>

                            <span class="category-parent-empty">
                                —
                            </span>

                        </td>


                        <td>

                            <span class="category-product-count">
                                18 Products
                            </span>

                        </td>


                        <td>

                            <span class="category-status inactive">

                                <i></i>

                                Inactive

                            </span>

                        </td>


                        <td>
                            Jul 18, 2026
                        </td>


                        <td>

                            <div class="category-actions">

                                <a
                                    href="{{ route('admin-category-details', 5) }}"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('admin-category-edit', 5) }}"
                                    title="Edit Category"
                                >

                                    <i class="ri-edit-line"></i>

                                </a>


                                <button
                                    type="button"
                                    title="More"
                                >

                                    <i class="ri-more-2-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- CATEGORY 6 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="category-info">

                                <div class="category-info__icon">

                                    <i class="ri-book-open-line"></i>

                                </div>


                                <div class="category-info__content">

                                    <strong>
                                        Books
                                    </strong>

                                    <span>
                                        books
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="category-type category-type--parent">

                                <i class="ri-folder-2-line"></i>

                                Main Category

                            </span>

                        </td>


                        <td>

                            <span class="category-parent-empty">
                                —
                            </span>

                        </td>


                        <td>

                            <span class="category-product-count empty">
                                0 Products
                            </span>

                        </td>


                        <td>

                            <span class="category-status active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>
                            Jul 15, 2026
                        </td>


                        <td>

                            <div class="category-actions">

                                <a
                                    href="{{ route('admin-category-details', 6) }}"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('admin-category-edit', 6) }}"
                                    title="Edit Category"
                                >

                                    <i class="ri-edit-line"></i>

                                </a>


                                <button
                                    type="button"
                                    title="More"
                                >

                                    <i class="ri-more-2-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    </tbody>

                </table>

            </div>


            {{-- ============================================================ --}}
            {{-- PAGINATION --}}
            {{-- ============================================================ --}}

            <div class="categories-pagination">

                <div class="categories-pagination__info">

                    Showing 1–7 of 18 categories

                </div>


                <div class="categories-pagination__buttons">

                    <button
                        type="button"
                        disabled
                    >

                        <i class="ri-arrow-left-s-line"></i>

                    </button>


                    <button
                        type="button"
                        class="active"
                    >
                        1
                    </button>


                    <button type="button">
                        2
                    </button>


                    <button type="button">
                        3
                    </button>


                    <button type="button">

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
