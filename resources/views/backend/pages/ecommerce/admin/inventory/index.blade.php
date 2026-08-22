@extends('backend.layouts.backend')

@section('title', 'Inventory')

@section('content')

    <div class="inventory-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="inventory-page__header">

            <div>

            <span class="inventory-page__eyebrow">
                Ecommerce
            </span>

                <h1>
                    Inventory
                </h1>

                <p>
                    View and update product stock from one place.
                </p>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- INVENTORY STATS --}}
        {{-- ================================================================ --}}

        <div class="inventory-stats">


            {{-- Total Products --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon">

                    <i class="ri-shopping-bag-3-line"></i>

                </div>

                <div>

                <span>
                    Total Products
                </span>

                    <strong>
                        128
                    </strong>

                </div>

            </div>


            {{-- Total Stock --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon inventory-stat-card__icon--stock">

                    <i class="ri-stack-line"></i>

                </div>

                <div>

                <span>
                    Total Stock
                </span>

                    <strong>
                        2,458
                    </strong>

                </div>

            </div>


            {{-- Low Stock --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon inventory-stat-card__icon--warning">

                    <i class="ri-error-warning-line"></i>

                </div>

                <div>

                <span>
                    Low Stock
                </span>

                    <strong>
                        12
                    </strong>

                </div>

            </div>


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
                        name="stock_status"
                        class="inventory-filter"
                    >

                        <option value="">
                            All Stock
                        </option>

                        <option value="in-stock">
                            In Stock
                        </option>

                        <option value="low-stock">
                            Low Stock
                        </option>

                        <option value="out-of-stock">
                            Out of Stock
                        </option>

                    </select>


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

                    </select>


                    <a
                        href="{{ route('admin-inventory-low-stock') }}"
                        class="inventory-filter-link"
                    >

                        <i class="ri-error-warning-line"></i>

                        Low Stock

                    </a>


                    <a
                        href="{{ route('admin-inventory-out-of-stock') }}"
                        class="inventory-filter-link inventory-filter-link--danger"
                    >

                        <i class="ri-close-circle-line"></i>

                        Out of Stock

                    </a>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="inventory-table-wrapper">

                <table class="inventory-table">

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
                            Stock
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Update
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
                                        alt="Premium Cotton T-Shirt"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Premium Cotton T-Shirt
                                    </strong>

                                    <span>
                                        Fashion
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-TS-001
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Variable
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $39.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input">

                                <input
                                    type="number"
                                    name="stock"
                                    value="125"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--in-stock">

                                <i></i>

                                In Stock

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
                                        alt="Running Sneakers"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Running Sneakers
                                    </strong>

                                    <span>
                                        Sports & Fitness
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-SN-002
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Variable
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $79.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input">

                                <input
                                    type="number"
                                    name="stock"
                                    value="8"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--low-stock">

                                <i></i>

                                Low Stock

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

                            <div class="inventory-stock-input">

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
                                        alt="Wireless Headphones"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Wireless Headphones
                                    </strong>

                                    <span>
                                        Electronics
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-WH-004
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

                            <div class="inventory-stock-input">

                                <input
                                    type="number"
                                    name="stock"
                                    value="56"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--in-stock">

                                <i></i>

                                In Stock

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
                                        alt="Ceramic Coffee Mug"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Ceramic Coffee Mug
                                    </strong>

                                    <span>
                                        Home & Living
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-CM-005
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Simple
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $18.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input">

                                <input
                                    type="number"
                                    name="stock"
                                    value="4"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-status inventory-status--low-stock">

                                <i></i>

                                Low Stock

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
                    <strong>128</strong>
                    products

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


                    <button type="button">
                        2
                    </button>


                    <button type="button">
                        3
                    </button>


                    <button type="button">
                        4
                    </button>


                    <button type="button">
                        5
                    </button>


                    <button type="button">

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
