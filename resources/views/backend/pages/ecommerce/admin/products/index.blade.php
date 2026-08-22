@extends('backend.layouts.backend')

@section('title', 'Products')

@section('content')

    <div class="products-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="products-page__header">

            <div>

            <span class="products-page__eyebrow">
                Ecommerce
            </span>

                <h1>
                    Products
                </h1>

                <p>
                    Manage your ecommerce products, inventory and product information.
                </p>

            </div>


            {{-- Add Product --}}
            <a
                href="{{ route('admin-product-create') }}"
                class="products-page__add-btn"
            >

                <i class="ri-add-line"></i>

                Add Product

            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- SUMMARY --}}
        {{-- ================================================================ --}}

        <div class="products-summary">

            {{-- Total Products --}}
            <div class="products-summary__card">

                <div class="products-summary__icon">
                    <i class="ri-shopping-bag-3-line"></i>
                </div>

                <div>

                <span>
                    Total Products
                </span>

                    <strong>
                        248
                    </strong>

                </div>

            </div>


            {{-- Active Products --}}
            <div class="products-summary__card">

                <div class="products-summary__icon products-summary__icon--success">
                    <i class="ri-checkbox-circle-line"></i>
                </div>

                <div>

                <span>
                    Active Products
                </span>

                    <strong>
                        214
                    </strong>

                </div>

            </div>


            {{-- Draft Products --}}
            <div class="products-summary__card">

                <div class="products-summary__icon products-summary__icon--warning">
                    <i class="ri-draft-line"></i>
                </div>

                <div>

                <span>
                    Draft Products
                </span>

                    <strong>
                        21
                    </strong>

                </div>

            </div>


            {{-- Out Of Stock --}}
            <div class="products-summary__card">

                <div class="products-summary__icon products-summary__icon--danger">
                    <i class="ri-error-warning-line"></i>
                </div>

                <div>

                <span>
                    Out of Stock
                </span>

                    <strong>
                        13
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PRODUCTS CARD --}}
        {{-- ================================================================ --}}

        <div class="products-card">


            {{-- ============================================================ --}}
            {{-- FILTERS --}}
            {{-- ============================================================ --}}

            <div class="products-card__filters">

                {{-- Search --}}
                <div class="products-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        placeholder="Search products..."
                    >

                </div>


                {{-- Filters --}}
                <div class="products-filter-group">

                    {{-- Category --}}
                    <select name="category">

                        <option value="">
                            All Categories
                        </option>

                        <option value="electronics">
                            Electronics
                        </option>

                        <option value="fashion">
                            Fashion
                        </option>

                        <option value="home-living">
                            Home & Living
                        </option>

                        <option value="beauty">
                            Beauty
                        </option>

                        <option value="sports-fitness">
                            Sports & Fitness
                        </option>

                    </select>


                    {{-- Source --}}
                    <select name="source">

                        <option value="">
                            All Sources
                        </option>

                        <option value="own">
                            Own Product
                        </option>

                        <option value="amazon">
                            Amazon
                        </option>

                        <option value="aliexpress">
                            AliExpress
                        </option>

                    </select>


                    {{-- Status --}}
                    <select name="status">

                        <option value="">
                            All Status
                        </option>

                        <option value="active">
                            Active
                        </option>

                        <option value="draft">
                            Draft
                        </option>

                        <option value="inactive">
                            Inactive
                        </option>

                        <option value="out-of-stock">
                            Out of Stock
                        </option>

                    </select>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="products-table-wrapper">

                <table class="products-table">

                    <thead>

                    <tr>

                        <th class="products-table__check">

                            <input
                                type="checkbox"
                                class="products-checkbox"
                            >

                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Source
                        </th>

                        <th>
                            Price
                        </th>

                        <th>
                            Stock
                        </th>

                        <th>
                            Variants
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Updated
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 1 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <input
                                type="checkbox"
                                class="products-checkbox"
                                value="1"
                            >

                        </td>


                        <td>

                            <div class="product-table-product">

                                <div class="product-table-product__image">

                                    <img
                                        src="https://placehold.co/80x80"
                                        alt="Premium Cotton T-Shirt"
                                    >

                                </div>


                                <div class="product-table-product__info">

                                    <a
                                        href="{{ route('admin-product-details', 1) }}"
                                    >
                                        Premium Cotton T-Shirt
                                    </a>

                                    <span>
                                        SKU: BA-TS-001
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>
                            Fashion
                        </td>


                        <td>

                            <span class="product-source-badge product-source-badge--own">

                                <i class="ri-store-2-line"></i>

                                Own

                            </span>

                        </td>


                        <td>

                            <div class="product-price">

                                <strong>
                                    $29.99
                                </strong>

                                <span>
                                    $39.99
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="product-stock product-stock--available">
                                125
                            </span>

                        </td>


                        <td>

                            <span class="product-variant-badge">
                                8 Variants
                            </span>

                        </td>


                        <td>

                            <span class="product-status product-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>
                            Aug 15, 2026
                        </td>


                        <td>

                            <div class="product-actions">

                                {{-- View --}}
                                <a
                                    href="{{ route('admin-product-details', 1) }}"
                                    class="product-action-btn"
                                    title="View"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin-product-edit', 1) }}"
                                    class="product-action-btn"
                                    title="Edit"
                                >
                                    <i class="ri-edit-line"></i>
                                </a>


                                {{-- Delete - Route not available yet --}}
                                <button
                                    type="button"
                                    class="product-action-btn product-action-btn--danger"
                                    title="Delete"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 2 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <input
                                type="checkbox"
                                class="products-checkbox"
                                value="2"
                            >

                        </td>


                        <td>

                            <div class="product-table-product">

                                <div class="product-table-product__image">

                                    <img
                                        src="https://placehold.co/80x80"
                                        alt="Wireless Headphones"
                                    >

                                </div>


                                <div class="product-table-product__info">

                                    <a
                                        href="{{ route('admin-product-details', 2) }}"
                                    >
                                        Wireless Headphones
                                    </a>

                                    <span>
                                        SKU: BA-WH-002
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>
                            Electronics
                        </td>


                        <td>

                            <span class="product-source-badge product-source-badge--amazon">

                                <i class="ri-amazon-line"></i>

                                Amazon

                            </span>

                        </td>


                        <td>

                            <div class="product-price">

                                <strong>
                                    $79.99
                                </strong>

                            </div>

                        </td>


                        <td>

                            <span class="product-stock product-stock--available">
                                48
                            </span>

                        </td>


                        <td>

                            <span class="product-variant-badge">
                                4 Variants
                            </span>

                        </td>


                        <td>

                            <span class="product-status product-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>
                            Aug 14, 2026
                        </td>


                        <td>

                            <div class="product-actions">

                                {{-- View --}}
                                <a
                                    href="{{ route('admin-product-details', 2) }}"
                                    class="product-action-btn"
                                    title="View"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin-product-edit', 2) }}"
                                    class="product-action-btn"
                                    title="Edit"
                                >
                                    <i class="ri-edit-line"></i>
                                </a>


                                {{-- Delete --}}
                                <button
                                    type="button"
                                    class="product-action-btn product-action-btn--danger"
                                    title="Delete"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 3 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <input
                                type="checkbox"
                                class="products-checkbox"
                                value="3"
                            >

                        </td>


                        <td>

                            <div class="product-table-product">

                                <div class="product-table-product__image">

                                    <img
                                        src="https://placehold.co/80x80"
                                        alt="Leather Travel Bag"
                                    >

                                </div>


                                <div class="product-table-product__info">

                                    <a
                                        href="{{ route('admin-product-details', 3) }}"
                                    >
                                        Leather Travel Bag
                                    </a>

                                    <span>
                                        SKU: BA-LTB-003
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>
                            Fashion
                        </td>


                        <td>

                            <span class="product-source-badge product-source-badge--aliexpress">

                                <i class="ri-global-line"></i>

                                AliExpress

                            </span>

                        </td>


                        <td>

                            <div class="product-price">

                                <strong>
                                    $59.00
                                </strong>

                                <span>
                                    $69.00
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="product-stock product-stock--low">
                                7
                            </span>

                        </td>


                        <td>

                            <span class="product-variant-badge">
                                6 Variants
                            </span>

                        </td>


                        <td>

                            <span class="product-status product-status--active">

                                <i></i>

                                Active

                            </span>

                        </td>


                        <td>
                            Aug 13, 2026
                        </td>


                        <td>

                            <div class="product-actions">

                                {{-- View --}}
                                <a
                                    href="{{ route('admin-product-details', 3) }}"
                                    class="product-action-btn"
                                    title="View"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin-product-edit', 3) }}"
                                    class="product-action-btn"
                                    title="Edit"
                                >
                                    <i class="ri-edit-line"></i>
                                </a>


                                {{-- Delete --}}
                                <button
                                    type="button"
                                    class="product-action-btn product-action-btn--danger"
                                    title="Delete"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 4 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <input
                                type="checkbox"
                                class="products-checkbox"
                                value="4"
                            >

                        </td>


                        <td>

                            <div class="product-table-product">

                                <div class="product-table-product__image">

                                    <img
                                        src="https://placehold.co/80x80"
                                        alt="Ceramic Coffee Mug"
                                    >

                                </div>


                                <div class="product-table-product__info">

                                    <a
                                        href="{{ route('admin-product-details', 4) }}"
                                    >
                                        Ceramic Coffee Mug
                                    </a>

                                    <span>
                                        SKU: BA-CM-004
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>
                            Home & Living
                        </td>


                        <td>

                            <span class="product-source-badge product-source-badge--own">

                                <i class="ri-store-2-line"></i>

                                Own

                            </span>

                        </td>


                        <td>

                            <div class="product-price">

                                <strong>
                                    $18.50
                                </strong>

                            </div>

                        </td>


                        <td>

                            <span class="product-stock product-stock--out">
                                0
                            </span>

                        </td>


                        <td>

                            <span class="product-variant-badge">
                                3 Variants
                            </span>

                        </td>


                        <td>

                            <span class="product-status product-status--inactive">

                                <i></i>

                                Inactive

                            </span>

                        </td>


                        <td>
                            Aug 12, 2026
                        </td>


                        <td>

                            <div class="product-actions">

                                {{-- View --}}
                                <a
                                    href="{{ route('admin-product-details', 4) }}"
                                    class="product-action-btn"
                                    title="View"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin-product-edit', 4) }}"
                                    class="product-action-btn"
                                    title="Edit"
                                >
                                    <i class="ri-edit-line"></i>
                                </a>


                                {{-- Delete --}}
                                <button
                                    type="button"
                                    class="product-action-btn product-action-btn--danger"
                                    title="Delete"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 5 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <input
                                type="checkbox"
                                class="products-checkbox"
                                value="5"
                            >

                        </td>


                        <td>

                            <div class="product-table-product">

                                <div class="product-table-product__image">

                                    <img
                                        src="https://placehold.co/80x80"
                                        alt="Running Shoes"
                                    >

                                </div>


                                <div class="product-table-product__info">

                                    <a
                                        href="{{ route('admin-product-details', 5) }}"
                                    >
                                        Running Shoes
                                    </a>

                                    <span>
                                        SKU: BA-RS-005
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>
                            Sports & Fitness
                        </td>


                        <td>

                            <span class="product-source-badge product-source-badge--own">

                                <i class="ri-store-2-line"></i>

                                Own

                            </span>

                        </td>


                        <td>

                            <div class="product-price">

                                <strong>
                                    $89.99
                                </strong>

                            </div>

                        </td>


                        <td>

                            <span class="product-stock product-stock--available">
                                72
                            </span>

                        </td>


                        <td>

                            <span class="product-variant-badge">
                                10 Variants
                            </span>

                        </td>


                        <td>

                            <span class="product-status product-status--draft">

                                <i></i>

                                Draft

                            </span>

                        </td>


                        <td>
                            Aug 11, 2026
                        </td>


                        <td>

                            <div class="product-actions">

                                {{-- View --}}
                                <a
                                    href="{{ route('admin-product-details', 5) }}"
                                    class="product-action-btn"
                                    title="View"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin-product-edit', 5) }}"
                                    class="product-action-btn"
                                    title="Edit"
                                >
                                    <i class="ri-edit-line"></i>
                                </a>


                                {{-- Delete --}}
                                <button
                                    type="button"
                                    class="product-action-btn product-action-btn--danger"
                                    title="Delete"
                                >
                                    <i class="ri-delete-bin-line"></i>
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

            <div class="products-card__footer">

            <span>
                Showing 1–5 of 248 products
            </span>


                <div class="products-pagination">

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


                    <span>
                    ...
                </span>


                    <button type="button">
                        50
                    </button>


                    <button type="button">
                        <i class="ri-arrow-right-s-line"></i>
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
