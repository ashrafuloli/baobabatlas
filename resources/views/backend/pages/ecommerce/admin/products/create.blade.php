@extends('backend.layouts.backend')

@section('title', 'Add Product')

@section('content')

    <div class="product-create-page">

        {{-- Page Header --}}
        <div class="product-create-page__header">

            <div>

            <span class="product-create-page__eyebrow">
                Ecommerce
            </span>

                <h1>
                    Add Product
                </h1>

                <p>
                    Create and publish a new product to your ecommerce store.
                </p>

            </div>

            <a href="{{ route('admin-products') }}" class="product-create-page__back">
                <i class="ri-arrow-left-line"></i>
                Back to Products
            </a>

        </div>


        <form action="#" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="product-create-layout">

                {{-- ========================================================= --}}
                {{-- MAIN CONTENT --}}
                {{-- ========================================================= --}}

                <div class="product-create-main">


                    {{-- ===================================================== --}}
                    {{-- PRODUCT SOURCE --}}
                    {{-- ===================================================== --}}

                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <div>

                                <h4>
                                    Product Source
                                </h4>

                                <p>
                                    Select the source of this product.
                                </p>

                            </div>

                        </div>


                        <div class="product-form-card__body">

                            <div class="product-source-options">


                                {{-- Own Product --}}
                                <label class="product-source-option">

                                    <input
                                        type="radio"
                                        name="product_source"
                                        value="own"
                                        checked
                                    >

                                    <span class="product-source-option__content">

                                    <span class="product-source-option__icon">

                                        <i class="ri-store-2-line"></i>

                                    </span>

                                    <span class="product-source-option__text">

                                        <strong>
                                            Own Product
                                        </strong>

                                        <span>
                                            Product managed directly by Baobab Atlas.
                                        </span>

                                    </span>

                                </span>

                                    <span class="product-source-option__check">
                                    <i class="ri-check-line"></i>
                                </span>

                                </label>


                                {{-- Amazon --}}
                                <label class="product-source-option">

                                    <input
                                        type="radio"
                                        name="product_source"
                                        value="amazon"
                                    >

                                    <span class="product-source-option__content">

                                    <span class="product-source-option__icon amazon">

                                        <i class="ri-amazon-line"></i>

                                    </span>

                                    <span class="product-source-option__text">

                                        <strong>
                                            Amazon Product
                                        </strong>

                                        <span>
                                            Product sourced from Amazon.
                                        </span>

                                    </span>

                                </span>

                                    <span class="product-source-option__check">
                                    <i class="ri-check-line"></i>
                                </span>

                                </label>


                                {{-- AliExpress --}}
                                <label class="product-source-option">

                                    <input
                                        type="radio"
                                        name="product_source"
                                        value="aliexpress"
                                    >

                                    <span class="product-source-option__content">

                                    <span class="product-source-option__icon aliexpress">

                                        <i class="ri-global-line"></i>

                                    </span>

                                    <span class="product-source-option__text">

                                        <strong>
                                            AliExpress Product
                                        </strong>

                                        <span>
                                            Product sourced from AliExpress.
                                        </span>

                                    </span>

                                </span>

                                    <span class="product-source-option__check">
                                    <i class="ri-check-line"></i>
                                </span>

                                </label>

                            </div>

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- PRODUCT INFORMATION --}}
                    {{-- ===================================================== --}}

                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <div>

                                <h4>
                                    Product Information
                                </h4>

                                <p>
                                    Enter the main information about your product.
                                </p>

                            </div>

                        </div>


                        <div class="product-form-card__body">


                            {{-- Product URL --}}
                            <div class="product-form-group">

                                <label for="product-url">
                                    Product URL
                                </label>

                                <input
                                    type="url"
                                    id="product-url"
                                    name="product_url"
                                    placeholder="https://www.example.com/product"
                                >

                                <span class="product-form-help">
                                Add the original product URL manually when applicable.
                            </span>

                            </div>


                            {{-- Product Name --}}
                            <div class="product-form-group">

                                <label for="product-name">
                                    Product Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="product-name"
                                    name="name"
                                    placeholder="Enter product name"
                                >

                            </div>


                            {{-- Category / Brand --}}
                            <div class="product-form-row">

                                <div class="product-form-group">

                                    <label for="category">
                                        Category
                                        <span>*</span>
                                    </label>

                                    <select
                                        id="category"
                                        name="category"
                                    >

                                        <option value="">
                                            Select Category
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

                                        <option value="books">
                                            Books
                                        </option>

                                    </select>

                                </div>


                                <div class="product-form-group">

                                    <label for="brand">
                                        Brand
                                    </label>

                                    <input
                                        type="text"
                                        id="brand"
                                        name="brand"
                                        placeholder="Enter brand name"
                                    >

                                </div>

                            </div>


                            {{-- SKU --}}
                            <div class="product-form-group">

                                <label for="sku">
                                    SKU
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="sku"
                                    name="sku"
                                    placeholder="e.g. BA-TX-001"
                                >

                            </div>


                            {{-- Short Description --}}
                            <div class="product-form-group">

                                <label for="short-description">
                                    Short Description
                                    <span>*</span>
                                </label>

                                <textarea
                                    id="short-description"
                                    name="short_description"
                                    rows="5"
                                    placeholder="Write a short description of the product..."
                                ></textarea>

                            </div>

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- PRODUCT MEDIA --}}
                    {{-- ===================================================== --}}

                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <div>

                                <h4>
                                    Product Media
                                </h4>

                                <p>
                                    Add the main product image and gallery images.
                                </p>

                            </div>

                        </div>


                        <div class="product-form-card__body">


                            {{-- Main Image --}}
                            <div class="product-media-section">

                                <div class="product-media-section__title">

                                    <strong>
                                        Main Image
                                    </strong>

                                    <span>
                                    Primary image shown for the product.
                                </span>

                                </div>


                                <div class="product-main-image-upload">

                                    <div class="product-main-image-upload__icon">

                                        <i class="ri-image-add-line"></i>

                                    </div>

                                    <strong>
                                        Upload Main Image
                                    </strong>

                                    <span>
                                    JPG, PNG or WEBP
                                </span>

                                    <input
                                        type="file"
                                        name="main_image"
                                        accept="image/png,image/jpeg,image/webp"
                                    >

                                </div>

                            </div>


                            {{-- Gallery --}}
                            <div class="product-media-section">

                                <div class="product-media-section__title">

                                    <strong>
                                        Gallery
                                    </strong>

                                    <span>
                                    Add additional product images.
                                </span>

                                </div>


                                <div class="product-gallery-upload">

                                    <div class="product-gallery-upload__icon">

                                        <i class="ri-gallery-upload-line"></i>

                                    </div>

                                    <div class="product-gallery-upload__content">

                                        <strong>
                                            Upload Gallery Images
                                        </strong>

                                        <span>
                                        Add multiple images for the product gallery.
                                    </span>

                                        <small>
                                            JPG, PNG or WEBP. Maximum 5MB per image.
                                        </small>

                                    </div>

                                    <input
                                        type="file"
                                        name="gallery[]"
                                        multiple
                                        accept="image/png,image/jpeg,image/webp"
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- PRICING & INVENTORY --}}
                    {{-- ===================================================== --}}

                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <div>

                                <h4>
                                    Pricing & Inventory
                                </h4>

                                <p>
                                    Set pricing and available product stock.
                                </p>

                            </div>

                        </div>


                        <div class="product-form-card__body">

                            <div class="product-form-row">

                                {{-- Regular Price --}}
                                <div class="product-form-group">

                                    <label for="regular-price">
                                        Regular Price
                                        <span>*</span>
                                    </label>

                                    <div class="product-input-prefix">

                                    <span>
                                        $
                                    </span>

                                        <input
                                            type="number"
                                            id="regular-price"
                                            name="regular_price"
                                            placeholder="0.00"
                                            step="0.01"
                                        >

                                    </div>

                                </div>


                                {{-- Sale Price --}}
                                <div class="product-form-group">

                                    <label for="sale-price">
                                        Sale Price
                                    </label>

                                    <div class="product-input-prefix">

                                    <span>
                                        $
                                    </span>

                                        <input
                                            type="number"
                                            id="sale-price"
                                            name="sale_price"
                                            placeholder="0.00"
                                            step="0.01"
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- Stock --}}
                            <div class="product-form-group">

                                <label for="stock">
                                    Stock
                                    <span>*</span>
                                </label>

                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    placeholder="Enter stock quantity"
                                    min="0"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- ATTRIBUTES --}}
                    {{-- ===================================================== --}}

                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <div>

                                <h4>
                                    Attributes
                                </h4>

                                <p>
                                    Configure product attributes and multiple variants.
                                </p>

                            </div>

                        </div>


                        <div class="product-form-card__body">


                            {{-- Enable Variants --}}
                            <div class="product-variant-toggle">

                                <div class="product-variant-toggle__content">

                                    <strong>
                                        This product has multiple variants
                                    </strong>

                                    <span>
                                    Enable this when customers can choose different options such as size, color or material.
                                </span>

                                </div>


                                <label class="product-switch">

                                    <input
                                        type="checkbox"
                                        name="has_variants"
                                        value="1"
                                    >

                                    <span class="product-switch__slider"></span>

                                </label>

                            </div>


                            {{-- Variant Attributes --}}
                            <div class="product-variant-builder">


                                <div class="product-variant-builder__header">

                                    <div>

                                        <h5>
                                            Variant Attributes
                                        </h5>

                                        <p>
                                            Add attributes and enter their available values.
                                        </p>

                                    </div>


                                    <button
                                        type="button"
                                        class="product-add-attribute-btn"
                                    >
                                        <i class="ri-add-line"></i>
                                        Add Attribute
                                    </button>

                                </div>


                                {{-- Attribute Item --}}
                                <div class="product-attribute-item">


                                    <div class="product-attribute-item__top">

                                        <div class="product-form-group">

                                            <label>
                                                Attribute
                                            </label>

                                            <select
                                                name="attributes[0][name]"
                                            >

                                                <option value="">
                                                    Select Attribute
                                                </option>

                                                <option value="size">
                                                    Size
                                                </option>

                                                <option value="color">
                                                    Color
                                                </option>

                                                <option value="material">
                                                    Material
                                                </option>

                                            </select>

                                        </div>


                                        <button
                                            type="button"
                                            class="product-remove-attribute-btn"
                                        >
                                            <i class="ri-delete-bin-line"></i>
                                        </button>

                                    </div>


                                    <div class="product-form-group">

                                        <label>
                                            Attribute Values
                                        </label>


                                        <div class="product-value-input">

                                            <input
                                                type="text"
                                                name="attributes[0][values][]"
                                                placeholder="Enter value"
                                            >

                                            <button
                                                type="button"
                                                class="product-add-value-btn"
                                            >
                                                <i class="ri-add-line"></i>
                                            </button>

                                        </div>


                                        <div class="product-value-list">

                                        <span class="product-value-tag">

                                            S

                                            <button type="button">
                                                <i class="ri-close-line"></i>
                                            </button>

                                        </span>


                                            <span class="product-value-tag">

                                            M

                                            <button type="button">
                                                <i class="ri-close-line"></i>
                                            </button>

                                        </span>


                                            <span class="product-value-tag">

                                            L

                                            <button type="button">
                                                <i class="ri-close-line"></i>
                                            </button>

                                        </span>


                                            <span class="product-value-tag">

                                            XL

                                            <button type="button">
                                                <i class="ri-close-line"></i>
                                            </button>

                                        </span>

                                        </div>

                                    </div>

                                </div>


                                {{-- Second Attribute Example --}}
                                <div class="product-attribute-item">


                                    <div class="product-attribute-item__top">

                                        <div class="product-form-group">

                                            <label>
                                                Attribute
                                            </label>

                                            <select
                                                name="attributes[1][name]"
                                            >

                                                <option value="">
                                                    Select Attribute
                                                </option>

                                                <option value="size">
                                                    Size
                                                </option>

                                                <option value="color" selected>
                                                    Color
                                                </option>

                                                <option value="material">
                                                    Material
                                                </option>

                                            </select>

                                        </div>


                                        <button
                                            type="button"
                                            class="product-remove-attribute-btn"
                                        >
                                            <i class="ri-delete-bin-line"></i>
                                        </button>

                                    </div>


                                    <div class="product-form-group">

                                        <label>
                                            Attribute Values
                                        </label>


                                        <div class="product-value-input">

                                            <input
                                                type="text"
                                                name="attributes[1][values][]"
                                                placeholder="Enter value"
                                            >

                                            <button
                                                type="button"
                                                class="product-add-value-btn"
                                            >
                                                <i class="ri-add-line"></i>
                                            </button>

                                        </div>


                                        <div class="product-value-list">

                                        <span class="product-value-tag">

                                            Black

                                            <button type="button">
                                                <i class="ri-close-line"></i>
                                            </button>

                                        </span>


                                            <span class="product-value-tag">

                                            White

                                            <button type="button">
                                                <i class="ri-close-line"></i>
                                            </button>

                                        </span>


                                            <span class="product-value-tag">

                                            Blue

                                            <button type="button">
                                                <i class="ri-close-line"></i>
                                            </button>

                                        </span>

                                        </div>

                                    </div>

                                </div>


                                {{-- Generate Variations --}}
                                <div class="product-generate-variations">

                                    <div>

                                        <strong>
                                            Ready to create variations?
                                        </strong>

                                        <span>
                                        Generate combinations from the selected attribute values.
                                    </span>

                                    </div>


                                    <button
                                        type="button"
                                        class="product-generate-btn"
                                    >

                                        <i class="ri-magic-line"></i>

                                        Generate Variations

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- VARIATIONS --}}
                    {{-- ===================================================== --}}

                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <div>

                                <h4>
                                    Variations
                                </h4>

                                <p>
                                    Manage price, stock, SKU and image for each variation.
                                </p>

                            </div>

                            <span class="product-variation-count">
                            12 Variations
                        </span>

                        </div>


                        <div class="product-form-card__body product-form-card__body--table">

                            <div class="product-variation-table-wrapper">

                                <table class="product-variation-table">

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

                                        <th>
                                            Action
                                        </th>

                                    </tr>

                                    </thead>


                                    <tbody>


                                    {{-- Variation 1 --}}
                                    <tr>

                                        <td>

                                            <div class="product-variation-name">

                                                <strong>
                                                    Medium / Black
                                                </strong>

                                                <span>
                                                    Size: M · Color: Black
                                                </span>

                                            </div>

                                        </td>


                                        <td>

                                            <input
                                                type="text"
                                                name="variations[0][sku]"
                                                placeholder="SKU"
                                            >

                                        </td>


                                        <td>

                                            <div class="product-table-price">

                                                <span>
                                                    $
                                                </span>

                                                <input
                                                    type="number"
                                                    name="variations[0][price]"
                                                    placeholder="0.00"
                                                    step="0.01"
                                                >

                                            </div>

                                        </td>


                                        <td>

                                            <div class="product-table-price">

                                                <span>
                                                    $
                                                </span>

                                                <input
                                                    type="number"
                                                    name="variations[0][sale_price]"
                                                    placeholder="0.00"
                                                    step="0.01"
                                                >

                                            </div>

                                        </td>


                                        <td>

                                            <input
                                                type="number"
                                                name="variations[0][stock]"
                                                placeholder="0"
                                                min="0"
                                            >

                                        </td>


                                        <td>

                                            <label class="product-variation-image">

                                                <i class="ri-image-add-line"></i>

                                                <input
                                                    type="file"
                                                    name="variations[0][image]"
                                                    accept="image/*"
                                                >

                                            </label>

                                        </td>


                                        <td>

                                            <label class="product-switch product-switch--small">

                                                <input
                                                    type="checkbox"
                                                    name="variations[0][status]"
                                                    checked
                                                >

                                                <span class="product-switch__slider"></span>

                                            </label>

                                        </td>


                                        <td>

                                            <button
                                                type="button"
                                                class="product-remove-row-btn"
                                            >
                                                <i class="ri-delete-bin-line"></i>
                                            </button>

                                        </td>

                                    </tr>


                                    {{-- Variation 2 --}}
                                    <tr>

                                        <td>

                                            <div class="product-variation-name">

                                                <strong>
                                                    Large / Black
                                                </strong>

                                                <span>
                                                    Size: L · Color: Black
                                                </span>

                                            </div>

                                        </td>


                                        <td>

                                            <input
                                                type="text"
                                                name="variations[1][sku]"
                                                placeholder="SKU"
                                            >

                                        </td>


                                        <td>

                                            <div class="product-table-price">

                                                <span>
                                                    $
                                                </span>

                                                <input
                                                    type="number"
                                                    name="variations[1][price]"
                                                    placeholder="0.00"
                                                    step="0.01"
                                                >

                                            </div>

                                        </td>


                                        <td>

                                            <div class="product-table-price">

                                                <span>
                                                    $
                                                </span>

                                                <input
                                                    type="number"
                                                    name="variations[1][sale_price]"
                                                    placeholder="0.00"
                                                    step="0.01"
                                                >

                                            </div>

                                        </td>


                                        <td>

                                            <input
                                                type="number"
                                                name="variations[1][stock]"
                                                placeholder="0"
                                                min="0"
                                            >

                                        </td>


                                        <td>

                                            <label class="product-variation-image">

                                                <i class="ri-image-add-line"></i>

                                                <input
                                                    type="file"
                                                    name="variations[1][image]"
                                                    accept="image/*"
                                                >

                                            </label>

                                        </td>


                                        <td>

                                            <label class="product-switch product-switch--small">

                                                <input
                                                    type="checkbox"
                                                    name="variations[1][status]"
                                                    checked
                                                >

                                                <span class="product-switch__slider"></span>

                                            </label>

                                        </td>


                                        <td>

                                            <button
                                                type="button"
                                                class="product-remove-row-btn"
                                            >
                                                <i class="ri-delete-bin-line"></i>
                                            </button>

                                        </td>

                                    </tr>


                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- SHIPPING --}}
                    {{-- ===================================================== --}}

                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <div>

                                <h4>
                                    Shipping
                                </h4>

                                <p>
                                    Enter the physical dimensions used for shipping.
                                </p>

                            </div>

                        </div>


                        <div class="product-form-card__body">


                            {{-- Weight --}}
                            <div class="product-form-group">

                                <label for="shipping-weight">
                                    Weight
                                </label>

                                <div class="product-input-suffix">

                                    <input
                                        type="number"
                                        id="shipping-weight"
                                        name="shipping_weight"
                                        placeholder="0"
                                        step="0.01"
                                    >

                                    <span>
                                    kg
                                </span>

                                </div>

                            </div>


                            <div class="product-form-row">


                                {{-- Length --}}
                                <div class="product-form-group">

                                    <label for="length">
                                        Length
                                    </label>

                                    <div class="product-input-suffix">

                                        <input
                                            type="number"
                                            id="length"
                                            name="length"
                                            placeholder="0"
                                            step="0.01"
                                        >

                                        <span>
                                        cm
                                    </span>

                                    </div>

                                </div>


                                {{-- Width --}}
                                <div class="product-form-group">

                                    <label for="width">
                                        Width
                                    </label>

                                    <div class="product-input-suffix">

                                        <input
                                            type="number"
                                            id="width"
                                            name="width"
                                            placeholder="0"
                                            step="0.01"
                                        >

                                        <span>
                                        cm
                                    </span>

                                    </div>

                                </div>

                            </div>


                            {{-- Height --}}
                            <div class="product-form-group">

                                <label for="height">
                                    Height
                                </label>

                                <div class="product-input-suffix">

                                    <input
                                        type="number"
                                        id="height"
                                        name="height"
                                        placeholder="0"
                                        step="0.01"
                                    >

                                    <span>
                                    cm
                                </span>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- SEO --}}
                    {{-- ===================================================== --}}

                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <div>

                                <h4>
                                    SEO
                                </h4>

                                <p>
                                    Add search engine optimization information for this product.
                                </p>

                            </div>

                        </div>


                        <div class="product-form-card__body">


                            {{-- Meta Title --}}
                            <div class="product-form-group">

                                <label for="meta-title">
                                    Meta Title
                                </label>

                                <input
                                    type="text"
                                    id="meta-title"
                                    name="meta_title"
                                    placeholder="Enter meta title"
                                >

                            </div>


                            {{-- Meta Description --}}
                            <div class="product-form-group">

                                <label for="meta-description">
                                    Meta Description
                                </label>

                                <textarea
                                    id="meta-description"
                                    name="meta_description"
                                    rows="5"
                                    placeholder="Enter meta description"
                                ></textarea>

                            </div>


                            {{-- Slug --}}
                            <div class="product-form-group">

                                <label for="slug">
                                    Slug
                                </label>

                                <input
                                    type="text"
                                    id="slug"
                                    name="slug"
                                    placeholder="product-slug"
                                >

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- SIDEBAR --}}
                {{-- ========================================================= --}}

                <aside class="product-create-sidebar">


                    {{-- Publish --}}
                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <h4>
                                Publish
                            </h4>

                        </div>


                        <div class="product-form-card__body">

                            <div class="product-publish-status">

                            <span>
                                Status
                            </span>

                                <strong>
                                    Draft
                                </strong>

                            </div>


                            <div class="product-publish-info">

                                <i class="ri-information-line"></i>

                                <span>
                                Save the product as a draft or publish it to your store.
                            </span>

                            </div>


                            <div class="product-publish-actions">

                                <button
                                    type="submit"
                                    name="action"
                                    value="draft"
                                    class="product-btn product-btn--secondary"
                                >
                                    Save Draft
                                </button>


                                <button
                                    type="submit"
                                    name="action"
                                    value="publish"
                                    class="product-btn product-btn--primary"
                                >
                                    Publish Product
                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- Product Status --}}
                    <div class="product-form-card">

                        <div class="product-form-card__header">

                            <h4>
                                Product Status
                            </h4>

                        </div>


                        <div class="product-form-card__body">

                            <div class="product-form-group">

                                <label for="status">
                                    Status
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                >

                                    <option value="draft">
                                        Draft
                                    </option>

                                    <option value="active">
                                        Active
                                    </option>

                                    <option value="inactive">
                                        Inactive
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- Manual Entry --}}
                    <div class="product-source-reminder">

                        <div class="product-source-reminder__icon">

                            <i class="ri-information-line"></i>

                        </div>

                        <div>

                            <strong>
                                Manual Product Entry
                            </strong>

                            <p>
                                All product information is entered manually. No external product data will be imported automatically.
                            </p>

                        </div>

                    </div>


                    {{-- Product Tip --}}
                    <div class="product-create-help">

                        <div class="product-create-help__icon">

                            <i class="ri-lightbulb-line"></i>

                        </div>

                        <div>

                            <strong>
                                Product Tip
                            </strong>

                            <p>
                                Use clear product names, accurate information and high-quality images.
                            </p>

                        </div>

                    </div>

                </aside>

            </div>

        </form>

    </div>

@endsection
