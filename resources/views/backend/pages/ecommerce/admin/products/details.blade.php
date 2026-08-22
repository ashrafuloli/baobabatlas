@extends('backend.layouts.backend')

@section('title', 'Product Details')

@section('content')

    <div class="product-details-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="product-details-page__header">

            <div>

            <span class="product-details-page__eyebrow">
                Ecommerce / Products
            </span>

                <div class="product-details-page__title-row">

                    <h1>
                        Premium Cotton T-Shirt
                    </h1>

                    <span class="product-details-status product-details-status--active">
                    <i></i>
                    Active
                </span>

                </div>

                <p>
                    Product details, inventory, variants and shipping information.
                </p>

            </div>


            <div class="product-details-page__actions">

                {{-- Back to Products --}}
                <a
                    href="{{ route('admin-products') }}"
                    class="product-details-btn product-details-btn--secondary"
                >

                    <i class="ri-arrow-left-line"></i>

                    Back to Products

                </a>


                {{-- Edit Product --}}
                <a
                    href="{{ route('admin-product-edit', $product) }}"
                    class="product-details-btn product-details-btn--primary"
                >

                    <i class="ri-edit-line"></i>

                    Edit Product

                </a>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PRODUCT OVERVIEW --}}
        {{-- ================================================================ --}}

        <div class="product-details-overview">

            <div class="product-details-overview__media">

                <div class="product-details-main-image">

                    <img
                        src="https://placehold.co/600x600"
                        alt="Premium Cotton T-Shirt"
                    >

                </div>


                <div class="product-details-gallery">

                    <button
                        type="button"
                        class="product-details-gallery__item active"
                    >

                        <img
                            src="https://placehold.co/100x100"
                            alt="Product image"
                        >

                    </button>


                    <button
                        type="button"
                        class="product-details-gallery__item"
                    >

                        <img
                            src="https://placehold.co/100x100"
                            alt="Product image"
                        >

                    </button>


                    <button
                        type="button"
                        class="product-details-gallery__item"
                    >

                        <img
                            src="https://placehold.co/100x100"
                            alt="Product image"
                        >

                    </button>


                    <button
                        type="button"
                        class="product-details-gallery__item"
                    >

                        <img
                            src="https://placehold.co/100x100"
                            alt="Product image"
                        >

                    </button>

                </div>

            </div>


            <div class="product-details-overview__content">

                <div class="product-details-source">

                <span class="product-details-source__label">
                    Product Source
                </span>

                    <span class="product-details-source__badge">

                    <i class="ri-store-2-line"></i>

                    Own Product

                </span>

                </div>


                <div class="product-details-price">

                <span class="product-details-price__sale">
                    $29.99
                </span>

                    <span class="product-details-price__regular">
                    $39.99
                </span>

                </div>


                <p class="product-details-description">
                    Premium quality cotton t-shirt designed for everyday comfort
                    with a clean and modern fit.
                </p>


                <div class="product-details-meta">

                    <div class="product-details-meta__item">

                    <span>
                        SKU
                    </span>

                        <strong>
                            BA-TS-001
                        </strong>

                    </div>


                    <div class="product-details-meta__item">

                    <span>
                        Category
                    </span>

                        <strong>
                            Fashion
                        </strong>

                    </div>


                    <div class="product-details-meta__item">

                    <span>
                        Brand
                    </span>

                        <strong>
                            Baobab Atlas
                        </strong>

                    </div>


                    <div class="product-details-meta__item">

                    <span>
                        Stock
                    </span>

                        <strong class="stock">
                            125 units
                        </strong>

                    </div>

                </div>


                <div class="product-details-overview__footer">

                    <div class="product-details-stat">

                    <span>
                        Variants
                    </span>

                        <strong>
                            8
                        </strong>

                    </div>


                    <div class="product-details-stat">

                    <span>
                        Gallery
                    </span>

                        <strong>
                            4 Images
                        </strong>

                    </div>


                    <div class="product-details-stat">

                    <span>
                        Updated
                    </span>

                        <strong>
                            Aug 15, 2026
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PRODUCT INFORMATION --}}
        {{-- ================================================================ --}}

        <div class="product-details-card">

            <div class="product-details-card__header">

                <div>

                    <h4>
                        Product Information
                    </h4>

                    <p>
                        Basic information about this product.
                    </p>

                </div>

            </div>


            <div class="product-details-card__body">

                <div class="product-info-grid">

                    <div class="product-info-item">

                    <span>
                        Product Name
                    </span>

                        <strong>
                            Premium Cotton T-Shirt
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        Category
                    </span>

                        <strong>
                            Fashion
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        Brand
                    </span>

                        <strong>
                            Baobab Atlas
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        SKU
                    </span>

                        <strong>
                            BA-TS-001
                        </strong>

                    </div>


                    <div class="product-info-item product-info-item--full">

                    <span>
                        Short Description
                    </span>

                        <p>
                            Premium quality cotton t-shirt designed for everyday
                            comfort. Made with soft and breathable cotton fabric
                            and available in multiple sizes and colors.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PRODUCT MEDIA --}}
        {{-- ================================================================ --}}

        <div class="product-details-card">

            <div class="product-details-card__header">

                <div>

                    <h4>
                        Product Media
                    </h4>

                    <p>
                        Main product image and gallery images.
                    </p>

                </div>

            </div>


            <div class="product-details-card__body">

                <div class="product-media-details">

                    <div class="product-media-details__main">

                    <span class="product-media-details__label">
                        Main Image
                    </span>

                        <div class="product-media-details__main-image">

                            <img
                                src="https://placehold.co/600x600"
                                alt="Premium Cotton T-Shirt"
                            >

                        </div>

                    </div>


                    <div class="product-media-details__gallery">

                    <span class="product-media-details__label">
                        Gallery
                    </span>

                        <div class="product-media-details__grid">

                            <div class="product-media-details__image">

                                <img
                                    src="https://placehold.co/300x300"
                                    alt="Product gallery"
                                >

                            </div>


                            <div class="product-media-details__image">

                                <img
                                    src="https://placehold.co/300x300"
                                    alt="Product gallery"
                                >

                            </div>


                            <div class="product-media-details__image">

                                <img
                                    src="https://placehold.co/300x300"
                                    alt="Product gallery"
                                >

                            </div>


                            <div class="product-media-details__image">

                                <img
                                    src="https://placehold.co/300x300"
                                    alt="Product gallery"
                                >

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PRICING & INVENTORY --}}
        {{-- ================================================================ --}}

        <div class="product-details-card">

            <div class="product-details-card__header">

                <div>

                    <h4>
                        Pricing & Inventory
                    </h4>

                    <p>
                        Current pricing and inventory information.
                    </p>

                </div>

            </div>


            <div class="product-details-card__body">

                <div class="product-info-grid">

                    <div class="product-info-item">

                    <span>
                        Regular Price
                    </span>

                        <strong>
                            $39.99
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        Sale Price
                    </span>

                        <strong class="product-info-item__sale">
                            $29.99
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        Current Stock
                    </span>

                        <strong class="product-info-item__success">
                            125 Units
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        Stock Status
                    </span>

                        <strong class="product-info-item__success">
                            In Stock
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- ATTRIBUTES --}}
        {{-- ================================================================ --}}

        <div class="product-details-card">

            <div class="product-details-card__header">

                <div>

                    <h4>
                        Attributes
                    </h4>

                    <p>
                        Product attributes used to create variations.
                    </p>

                </div>


                <span class="product-attribute-count">
                2 Attributes
            </span>

            </div>


            <div class="product-details-card__body">

                <div class="product-attributes-grid">


                    {{-- Size --}}
                    <div class="product-attribute-card">

                        <div class="product-attribute-card__header">

                            <div class="product-attribute-card__icon">
                                <i class="ri-ruler-line"></i>
                            </div>

                            <div>

                                <strong>
                                    Size
                                </strong>

                                <span>
                                4 Values
                            </span>

                            </div>

                        </div>


                        <div class="product-attribute-card__values">

                        <span>
                            S
                        </span>

                            <span>
                            M
                        </span>

                            <span>
                            L
                        </span>

                            <span>
                            XL
                        </span>

                        </div>

                    </div>


                    {{-- Color --}}
                    <div class="product-attribute-card">

                        <div class="product-attribute-card__header">

                            <div class="product-attribute-card__icon">
                                <i class="ri-palette-line"></i>
                            </div>

                            <div>

                                <strong>
                                    Color
                                </strong>

                                <span>
                                3 Values
                            </span>

                            </div>

                        </div>


                        <div class="product-attribute-card__values">

                        <span>
                            Black
                        </span>

                            <span>
                            White
                        </span>

                            <span>
                            Blue
                        </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- VARIATIONS --}}
        {{-- ================================================================ --}}

        <div class="product-details-card">

            <div class="product-details-card__header">

                <div>

                    <h4>
                        Variations
                    </h4>

                    <p>
                        Individual pricing, inventory and media for each variation.
                    </p>

                </div>


                <span class="product-attribute-count">
                8 Variations
            </span>

            </div>


            <div class="product-details-card__body product-details-card__body--table">

                <div class="product-details-variation-wrapper">

                    <table class="product-details-variation-table">

                        <thead>

                        <tr>

                            <th>
                                Variant
                            </th>

                            <th>
                                SKU
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Sale Price
                            </th>

                            <th>
                                Stock
                            </th>

                            <th>
                                Image
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                        </thead>


                        <tbody>


                        {{-- Variation 1 --}}
                        <tr>

                            <td>

                                <div class="product-details-variant-name">

                                    <strong>
                                        S / Black
                                    </strong>

                                    <span>
                                        Size: S · Color: Black
                                    </span>

                                </div>

                            </td>


                            <td>
                                BA-TS-S-BLK
                            </td>


                            <td>
                                $29.99
                            </td>


                            <td>
                                $24.99
                            </td>


                            <td>

                                <span class="product-details-stock product-details-stock--available">
                                    24
                                </span>

                            </td>


                            <td>

                                <div class="product-details-variation-image">

                                    <img
                                        src="https://placehold.co/60x60"
                                        alt="S Black"
                                    >

                                </div>

                            </td>


                            <td>

                                <span class="product-details-status product-details-status--active">

                                    <i></i>

                                    Active

                                </span>

                            </td>

                        </tr>


                        {{-- Variation 2 --}}
                        <tr>

                            <td>

                                <div class="product-details-variant-name">

                                    <strong>
                                        M / Black
                                    </strong>

                                    <span>
                                        Size: M · Color: Black
                                    </span>

                                </div>

                            </td>


                            <td>
                                BA-TS-M-BLK
                            </td>


                            <td>
                                $29.99
                            </td>


                            <td>
                                $24.99
                            </td>


                            <td>

                                <span class="product-details-stock product-details-stock--available">
                                    35
                                </span>

                            </td>


                            <td>

                                <div class="product-details-variation-image">

                                    <img
                                        src="https://placehold.co/60x60"
                                        alt="M Black"
                                    >

                                </div>

                            </td>


                            <td>

                                <span class="product-details-status product-details-status--active">

                                    <i></i>

                                    Active

                                </span>

                            </td>

                        </tr>


                        {{-- Variation 3 --}}
                        <tr>

                            <td>

                                <div class="product-details-variant-name">

                                    <strong>
                                        L / Black
                                    </strong>

                                    <span>
                                        Size: L · Color: Black
                                    </span>

                                </div>

                            </td>


                            <td>
                                BA-TS-L-BLK
                            </td>


                            <td>
                                $29.99
                            </td>


                            <td>
                                $24.99
                            </td>


                            <td>

                                <span class="product-details-stock product-details-stock--low">
                                    6
                                </span>

                            </td>


                            <td>

                                <div class="product-details-variation-image">

                                    <img
                                        src="https://placehold.co/60x60"
                                        alt="L Black"
                                    >

                                </div>

                            </td>


                            <td>

                                <span class="product-details-status product-details-status--active">

                                    <i></i>

                                    Active

                                </span>

                            </td>

                        </tr>


                        {{-- Variation 4 --}}
                        <tr>

                            <td>

                                <div class="product-details-variant-name">

                                    <strong>
                                        XL / Black
                                    </strong>

                                    <span>
                                        Size: XL · Color: Black
                                    </span>

                                </div>

                            </td>


                            <td>
                                BA-TS-XL-BLK
                            </td>


                            <td>
                                $29.99
                            </td>


                            <td>
                                $24.99
                            </td>


                            <td>

                                <span class="product-details-stock product-details-stock--available">
                                    18
                                </span>

                            </td>


                            <td>

                                <div class="product-details-variation-image">

                                    <img
                                        src="https://placehold.co/60x60"
                                        alt="XL Black"
                                    >

                                </div>

                            </td>


                            <td>

                                <span class="product-details-status product-details-status--active">

                                    <i></i>

                                    Active

                                </span>

                            </td>

                        </tr>


                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- SHIPPING --}}
        {{-- ================================================================ --}}

        <div class="product-details-card">

            <div class="product-details-card__header">

                <div>

                    <h4>
                        Shipping
                    </h4>

                    <p>
                        Product weight and physical dimensions.
                    </p>

                </div>

            </div>


            <div class="product-details-card__body">

                <div class="product-info-grid">

                    <div class="product-info-item">

                    <span>
                        Weight
                    </span>

                        <strong>
                            0.45 kg
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        Length
                    </span>

                        <strong>
                            30 cm
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        Width
                    </span>

                        <strong>
                            25 cm
                        </strong>

                    </div>


                    <div class="product-info-item">

                    <span>
                        Height
                    </span>

                        <strong>
                            3 cm
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- SEO --}}
        {{-- ================================================================ --}}

        <div class="product-details-card">

            <div class="product-details-card__header">

                <div>

                    <h4>
                        SEO
                    </h4>

                    <p>
                        Search engine optimization information.
                    </p>

                </div>

            </div>


            <div class="product-details-card__body">

                <div class="product-info-grid">

                    <div class="product-info-item product-info-item--full">

                    <span>
                        Meta Title
                    </span>

                        <strong>
                            Premium Cotton T-Shirt | Baobab Atlas
                        </strong>

                    </div>


                    <div class="product-info-item product-info-item--full">

                    <span>
                        Meta Description
                    </span>

                        <p>
                            Shop our premium cotton t-shirt made with soft,
                            breathable fabric and available in multiple sizes
                            and colors.
                        </p>

                    </div>


                    <div class="product-info-item product-info-item--full">

                    <span>
                        Slug
                    </span>

                        <strong>
                            premium-cotton-t-shirt
                        </strong>

                    </div>

                </div>

            </div>

        </div>


    </div>

@endsection
