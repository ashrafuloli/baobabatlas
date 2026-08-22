@extends('backend.layouts.backend')

@section('title', 'Out of Stock')

@section('content')

    <div class="inventory-page inventory-out-of-stock-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="inventory-page__header">

            <div>

            <span class="inventory-page__eyebrow">
                Ecommerce / Inventory
            </span>

                <h1>
                    Out of Stock
                </h1>

                <p>
                    Products that are currently unavailable due to zero stock.
                </p>

            </div>


            <a
                href="{{ route('admin-inventory') }}"
                class="inventory-page__back"
            >

                <i class="ri-arrow-left-line"></i>

                All Inventory

            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- STATS --}}
        {{-- ================================================================ --}}

        <div class="inventory-stats">


            {{-- Out of Stock --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon inventory-stat-card__icon--danger">

                    <i class="ri-close-circle-line"></i>

                </div>

                <div>

                <span>
                    Out of Stock
                </span>

                    <strong>
                        5
                    </strong>

                </div>

            </div>


            {{-- Variable Products --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon">

                    <i class="ri-stack-line"></i>

                </div>

                <div>

                <span>
                    Variable Products
                </span>

                    <strong>
                        2
                    </strong>

                </div>

            </div>


            {{-- Simple Products --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon inventory-stat-card__icon--stock">

                    <i class="ri-shopping-bag-3-line"></i>

                </div>

                <div>

                <span>
                    Simple Products
                </span>

                    <strong>
                        3
                    </strong>

                </div>

            </div>


            {{-- Total Products --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon inventory-stat-card__icon--warning">

                    <i class="ri-error-warning-line"></i>

                </div>

                <div>

                <span>
                    Affected Products
                </span>

                    <strong>
                        5
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- INVENTORY CARD --}}
        {{-- ================================================================ --}}

        <div class="inventory-card">


            {{-- ============================================================ --}}
            {{-- TOOLBAR --}}
            {{-- ============================================================ --}}

            <div class="inventory-toolbar">

                {{-- Search --}}
                <div class="inventory-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        placeholder="Search product or SKU..."
                    >

                </div>


                {{-- Filters --}}
                <div class="inventory-toolbar__actions">


                    <select
                        name="category"
                        class="inventory-filter"
                    >

                        <option value="">
                            All Categories
                        </option>

                        <option value="fashion">
                            Fashion
                        </option>

                        <option value="electronics">
                            Electronics
                        </option>

                        <option value="home-living">
                            Home & Living
                        </option>

                        <option value="beauty">
                            Beauty
                        </option>

                        <option value="sports">
                            Sports & Fitness
                        </option>

                    </select>


                    <select
                        name="product_type"
                        class="inventory-filter"
                    >

                        <option value="">
                            All Types
                        </option>

                        <option value="simple">
                            Simple
                        </option>

                        <option value="variable">
                            Variable
                        </option>

                    </select>


                    <a
                        href="{{ route('admin-inventory') }}"
                        class="inventory-filter-link"
                    >

                        <i class="ri-stack-line"></i>

                        All Stock

                    </a>


                    <a
                        href="{{ route('admin-inventory-low-stock') }}"
                        class="inventory-filter-link inventory-filter-link--warning"
                    >

                        <i class="ri-error-warning-line"></i>

                        Low Stock

                    </a>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- ALERT --}}
            {{-- ============================================================ --}}

            <div class="inventory-out-of-stock-alert">

                <div class="inventory-out-of-stock-alert__icon">

                    <i class="ri-close-circle-line"></i>

                </div>


                <div>

                    <strong>
                        Products Currently Unavailable
                    </strong>

                    <p>
                        These products have no available stock. Update the stock quantity to make them available again.
                    </p>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="inventory-table-wrapper">

                <table class="inventory-table inventory-out-of-stock-table">

                    <thead>

                    <tr>

                        <th>
                            Product
                        </th>

                        <th>
                            SKU
                        </th>

                        <th>
                            Type
                        </th>

                        <th>
                            Price
                        </th>

                        <th>
                            Current Stock
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Update Stock
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 1 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="inventory-product">

                                <div class="inventory-product__image">

                                    <img
                                        src="https://placehold.co/100x100"
                                        alt="Leather Backpack"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Leather Backpack
                                    </strong>

                                    <span>
                                        Bags & Accessories
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-BP-003
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Simple
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $49.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input inventory-stock-input--critical">

                                <input
                                    type="number"
                                    name="stock"
                                    value="0"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--out-of-stock">

                                <i></i>

                                Out of Stock

                            </span>

                        </td>


                        <td>

                            <button
                                type="button"
                                class="inventory-update-btn"
                            >

                                <i class="ri-save-line"></i>

                                Update

                            </button>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 2 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="inventory-product">

                                <div class="inventory-product__image">

                                    <img
                                        src="https://placehold.co/100x100"
                                        alt="Classic Denim Jacket"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Classic Denim Jacket
                                    </strong>

                                    <span>
                                        Fashion
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-DJ-009
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Variable
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $69.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input inventory-stock-input--critical">

                                <input
                                    type="number"
                                    name="stock"
                                    value="0"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--out-of-stock">

                                <i></i>

                                Out of Stock

                            </span>

                        </td>


                        <td>

                            <button
                                type="button"
                                class="inventory-update-btn"
                            >

                                <i class="ri-save-line"></i>

                                Update

                            </button>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 3 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="inventory-product">

                                <div class="inventory-product__image">

                                    <img
                                        src="https://placehold.co/100x100"
                                        alt="Smart Watch"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Smart Watch
                                    </strong>

                                    <span>
                                        Electronics
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-SW-010
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Variable
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $129.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input inventory-stock-input--critical">

                                <input
                                    type="number"
                                    name="stock"
                                    value="0"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--out-of-stock">

                                <i></i>

                                Out of Stock

                            </span>

                        </td>


                        <td>

                            <button
                                type="button"
                                class="inventory-update-btn"
                            >

                                <i class="ri-save-line"></i>

                                Update

                            </button>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 4 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="inventory-product">

                                <div class="inventory-product__image">

                                    <img
                                        src="https://placehold.co/100x100"
                                        alt="Ceramic Vase"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Ceramic Vase
                                    </strong>

                                    <span>
                                        Home & Living
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-CV-011
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Simple
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $34.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input inventory-stock-input--critical">

                                <input
                                    type="number"
                                    name="stock"
                                    value="0"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--out-of-stock">

                                <i></i>

                                Out of Stock

                            </span>

                        </td>


                        <td>

                            <button
                                type="button"
                                class="inventory-update-btn"
                            >

                                <i class="ri-save-line"></i>

                                Update

                            </button>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PRODUCT 5 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="inventory-product">

                                <div class="inventory-product__image">

                                    <img
                                        src="https://placehold.co/100x100"
                                        alt="Travel Duffel Bag"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Travel Duffel Bag
                                    </strong>

                                    <span>
                                        Bags & Accessories
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-TD-012
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Simple
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $59.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input inventory-stock-input--critical">

                                <input
                                    type="number"
                                    name="stock"
                                    value="0"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--out-of-stock">

                                <i></i>

                                Out of Stock

                            </span>

                        </td>


                        <td>

                            <button
                                type="button"
                                class="inventory-update-btn"
                            >

                                <i class="ri-save-line"></i>

                                Update

                            </button>

                        </td>

                    </tr>


                    </tbody>

                </table>

            </div>


            {{-- ============================================================ --}}
            {{-- PAGINATION --}}
            {{-- ============================================================ --}}

            <div class="inventory-pagination">

                <div class="inventory-pagination__info">

                    Showing
                    <strong>1</strong>
                    to
                    <strong>5</strong>
                    of
                    <strong>5</strong>
                    out-of-stock products

                </div>


                <div class="inventory-pagination__buttons">

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
