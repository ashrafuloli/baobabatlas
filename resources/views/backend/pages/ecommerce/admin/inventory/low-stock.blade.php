@extends('backend.layouts.backend')

@section('title', 'Low Stock')

@section('content')

    <div class="inventory-page inventory-low-stock-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="inventory-page__header">

            <div>

            <span class="inventory-page__eyebrow">
                Ecommerce / Inventory
            </span>

                <h1>
                    Low Stock
                </h1>

                <p>
                    Products that are running low on available stock.
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


            {{-- Low Stock Products --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon inventory-stat-card__icon--warning">

                    <i class="ri-error-warning-line"></i>

                </div>

                <div>

                <span>
                    Low Stock Products
                </span>

                    <strong>
                        12
                    </strong>

                </div>

            </div>


            {{-- Critical Stock --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon inventory-stat-card__icon--danger">

                    <i class="ri-alarm-warning-line"></i>

                </div>

                <div>

                <span>
                    Critical Stock
                </span>

                    <strong>
                        4
                    </strong>

                </div>

            </div>


            {{-- Total Units --}}
            <div class="inventory-stat-card">

                <div class="inventory-stat-card__icon inventory-stat-card__icon--stock">

                    <i class="ri-stack-line"></i>

                </div>

                <div>

                <span>
                    Remaining Units
                </span>

                    <strong>
                        68
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

                <div class="inventory-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        placeholder="Search product or SKU..."
                    >

                </div>


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
                        name="stock_level"
                        class="inventory-filter"
                    >

                        <option value="">
                            All Low Stock
                        </option>

                        <option value="critical">
                            Critical
                        </option>

                        <option value="low">
                            Low
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
                        href="{{ route('admin-inventory-out-of-stock') }}"
                        class="inventory-filter-link inventory-filter-link--danger"
                    >

                        <i class="ri-close-circle-line"></i>

                        Out of Stock

                    </a>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- ALERT --}}
            {{-- ============================================================ --}}

            <div class="inventory-low-stock-alert">

                <div class="inventory-low-stock-alert__icon">

                    <i class="ri-error-warning-line"></i>

                </div>


                <div>

                    <strong>
                        Stock Attention Required
                    </strong>

                    <p>
                        These products have reached their low-stock threshold.
                        Consider updating their stock levels.
                    </p>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="inventory-table-wrapper">

                <table class="inventory-table inventory-low-stock-table">

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
                            Threshold
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

                            <div class="inventory-stock-input inventory-stock-input--warning">

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

                            <span class="inventory-threshold">
                                10 units
                            </span>

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
                    {{-- PRODUCT 2 --}}
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

                            <div class="inventory-stock-input inventory-stock-input--critical">

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

                            <span class="inventory-threshold">
                                10 units
                            </span>

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
                                        alt="Leather Wallet"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Leather Wallet
                                    </strong>

                                    <span>
                                        Bags & Accessories
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-LW-006
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Simple
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $29.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input inventory-stock-input--critical">

                                <input
                                    type="number"
                                    name="stock"
                                    value="3"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-threshold">
                                8 units
                            </span>

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
                    {{-- PRODUCT 4 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="inventory-product">

                                <div class="inventory-product__image">

                                    <img
                                        src="https://placehold.co/100x100"
                                        alt="Wireless Mouse"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Wireless Mouse
                                    </strong>

                                    <span>
                                        Electronics
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-WM-007
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Simple
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $24.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input inventory-stock-input--warning">

                                <input
                                    type="number"
                                    name="stock"
                                    value="7"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-threshold">
                                10 units
                            </span>

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
                    {{-- PRODUCT 5 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <div class="inventory-product">

                                <div class="inventory-product__image">

                                    <img
                                        src="https://placehold.co/100x100"
                                        alt="Cotton Hoodie"
                                    >

                                </div>


                                <div class="inventory-product__content">

                                    <strong>
                                        Cotton Hoodie
                                    </strong>

                                    <span>
                                        Fashion
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-sku">
                                BA-HD-008
                            </span>

                        </td>


                        <td>

                            <span class="inventory-type">
                                Variable
                            </span>

                        </td>


                        <td>

                            <strong class="inventory-price">
                                $54.99
                            </strong>

                        </td>


                        <td>

                            <div class="inventory-stock-input inventory-stock-input--critical">

                                <input
                                    type="number"
                                    name="stock"
                                    value="5"
                                    min="0"
                                >

                                <span>
                                    units
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="inventory-threshold">
                                12 units
                            </span>

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
                    <strong>12</strong>
                    low-stock products

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

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
