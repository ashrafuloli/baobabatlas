@extends('backend.layouts.backend')

@section('title', 'Add Product')

@section('content')
    <div class="product-create-page">

        {{-- Page Header --}}
        <div class="product-create-page__header">
            <div class="product-create-page__header-content">
                <span class="product-create-page__eyebrow">
                    Ecommerce
                </span>

                <h1 class="product-create-page__title">
                    Add Product
                </h1>

                <p class="product-create-page__subtitle">
                    Create a new product with media, pricing, options, variants, and SEO.
                </p>
            </div>

            <a
                href="{{ route('admin-products') }}"
                class="product-create-page__back-button"
            >
                <i class="ri-arrow-left-line"></i>
                Back to Products
            </a>
        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="product-create-page__alert product-create-page__alert--error">
                <div class="product-create-page__alert-icon">
                    <i class="ri-error-warning-line"></i>
                </div>

                <div>
                    <strong>Please fix the following errors:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif


        <form
            action="{{ route('admin-products.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="product-create-page__form"
            id="product-create-form"
        >
            @csrf

            <div class="product-create-page__layout">

                {{-- =====================================================
                    MAIN CONTENT
                ====================================================== --}}
                <div class="product-create-page__main">

                    {{-- Product Source --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">
                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-store-2-line"></i>
                                </div>

                                <div>
                                    <h2>Product Source</h2>

                                    <p>
                                        Choose where this product comes from.
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="product-create-page__card-body">

                            <div class="product-create-page__field">

                                <label for="source">
                                    Source
                                    <span>*</span>
                                </label>

                                <select
                                    id="source"
                                    name="source"
                                    required
                                >
                                    <option
                                        value="own"
                                        @selected(old('source', 'own') === 'own')
                                    >
                                        Own
                                    </option>

                                    <option
                                        value="amazon"
                                        @selected(old('source') === 'amazon')
                                    >
                                        Amazon
                                    </option>

                                    <option
                                        value="aliexpress"
                                        @selected(old('source') === 'aliexpress')
                                    >
                                        AliExpress
                                    </option>
                                </select>

                            </div>

                        </div>

                    </section>


                    {{-- Product Information --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">
                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-shopping-bag-3-line"></i>
                                </div>

                                <div>
                                    <h2>Product Information</h2>

                                    <p>
                                        Add the basic information for this product.
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="product-create-page__card-body">

                            {{-- Name --}}
                            <div class="product-create-page__field">

                                <label for="name">
                                    Product Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter product name"
                                    required
                                >

                            </div>


                            {{-- Slug + SKU --}}
                            <div class="product-create-page__grid">

                                <div class="product-create-page__field">

                                    <label for="slug">
                                        Slug
                                    </label>

                                    <input
                                        type="text"
                                        id="slug"
                                        name="slug"
                                        value="{{ old('slug') }}"
                                        placeholder="product-slug"
                                    >

                                    <small>
                                        Leave empty to generate automatically.
                                    </small>

                                </div>


                                <div class="product-create-page__field">

                                    <label for="sku">
                                        SKU
                                    </label>

                                    <input
                                        type="text"
                                        id="sku"
                                        name="sku"
                                        value="{{ old('sku') }}"
                                        placeholder="Enter SKU"
                                    >

                                </div>

                            </div>


                            {{-- Brand + Sort --}}
                            <div class="product-create-page__grid">

                                <div class="product-create-page__field">

                                    <label for="brand_id">
                                        Brand
                                    </label>

                                    <select
                                        id="brand_id"
                                        name="brand_id"
                                    >
                                        <option value="">
                                            Select Brand
                                        </option>

                                        @foreach ($brands as $brand)
                                            <option
                                                value="{{ $brand->id }}"
                                                @selected(
                                                    (string) old('brand_id') ===
                                                    (string) $brand->id
                                                )
                                            >
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>


                                <div class="product-create-page__field">

                                    <label for="sort_order">
                                        Sort Order
                                    </label>

                                    <input
                                        type="number"
                                        id="sort_order"
                                        name="sort_order"
                                        value="{{ old('sort_order', 0) }}"
                                        min="0"
                                        placeholder="0"
                                    >

                                </div>

                            </div>


                            {{-- Categories --}}
                            <div class="product-create-page__field">

                                <label for="category_ids">
                                    Categories
                                </label>

                                @php
                                    $oldCategoryIds = collect(
                                        old('category_ids', [])
                                    )->map(
                                        fn ($id) => (string) $id
                                    )->all();
                                @endphp

                                <select
                                    id="category_ids"
                                    name="category_ids[]"
                                    multiple
                                >
                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            @selected(
                                                in_array(
                                                    (string) $category->id,
                                                    $oldCategoryIds,
                                                    true
                                                )
                                            )
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <small>
                                    Hold Ctrl or Command to select multiple categories.
                                </small>

                            </div>


                            {{-- Short Description --}}
                            <div class="product-create-page__field">

                                <label for="short_description">
                                    Short Description
                                </label>

                                <textarea
                                    id="short_description"
                                    name="short_description"
                                    rows="4"
                                    placeholder="Write a short summary of this product..."
                                >{{ old('short_description') }}</textarea>

                            </div>


                            {{-- Rich Text Description --}}
                            <div class="product-create-page__field">

                                <div class="product-create-page__label-row">

                                    <label for="description">
                                        Product Description
                                    </label>

                                    <span class="product-create-page__field-hint">
                                        Rich Text Editor
                                    </span>

                                </div>


                                <div
                                    class="product-create-page__rich-editor"
                                    data-rich-editor
                                >

                                    <div class="product-create-page__rich-toolbar">

                                        <button
                                            type="button"
                                            data-editor-action="bold"
                                            title="Bold"
                                        >
                                            <i class="ri-bold"></i>
                                        </button>

                                        <button
                                            type="button"
                                            data-editor-action="italic"
                                            title="Italic"
                                        >
                                            <i class="ri-italic"></i>
                                        </button>

                                        <button
                                            type="button"
                                            data-editor-action="underline"
                                            title="Underline"
                                        >
                                            <i class="ri-underline"></i>
                                        </button>

                                        <span class="product-create-page__toolbar-divider"></span>

                                        <button
                                            type="button"
                                            data-editor-action="heading"
                                            title="Heading"
                                        >
                                            <i class="ri-heading"></i>
                                        </button>

                                        <button
                                            type="button"
                                            data-editor-action="unordered-list"
                                            title="Bullet List"
                                        >
                                            <i class="ri-list-unordered"></i>
                                        </button>

                                        <button
                                            type="button"
                                            data-editor-action="ordered-list"
                                            title="Numbered List"
                                        >
                                            <i class="ri-list-ordered"></i>
                                        </button>

                                        <span class="product-create-page__toolbar-divider"></span>

                                        <button
                                            type="button"
                                            data-editor-action="link"
                                            title="Add Link"
                                        >
                                            <i class="ri-link"></i>
                                        </button>

                                        <button
                                            type="button"
                                            data-editor-action="clear"
                                            title="Clear Formatting"
                                        >
                                            <i class="ri-format-clear"></i>
                                        </button>

                                    </div>


                                    <div
                                        class="product-create-page__rich-content"
                                        contenteditable="true"
                                        data-rich-content
                                    >{!! old('description') !!}</div>


                                    <textarea
                                        id="description"
                                        name="description"
                                        data-rich-input
                                        hidden
                                    >{{ old('description') }}</textarea>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                        PRODUCT MEDIA
                    ====================================================== --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">
                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-image-2-line"></i>
                                </div>

                                <div>
                                    <h2>Product Media</h2>

                                    <p>
                                        Add a primary image and gallery images.
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="product-create-page__card-body">

                            {{-- Thumbnail --}}
                            <div class="product-create-page__media-block">

                                <div class="product-create-page__media-heading">

                                    <div>
                                        <h3>Product Thumbnail</h3>

                                        <p>
                                            This image will be used as the primary product image.
                                        </p>
                                    </div>

                                    <span>
                                        1000 × 1000px recommended
                                    </span>

                                </div>


                                <input
                                    type="file"
                                    id="thumbnail"
                                    name="thumbnail"
                                    accept="image/jpeg,image/png,image/webp"
                                    hidden
                                >


                                <label
                                    for="thumbnail"
                                    class="product-create-page__thumbnail-upload"
                                >

                                    <div
                                        class="product-create-page__thumbnail-preview"
                                        id="thumbnail-preview"
                                    >

                                        <div class="product-create-page__upload-icon">
                                            <i class="ri-image-add-line"></i>
                                        </div>

                                        <strong>
                                            Upload product image
                                        </strong>

                                        <span>
                                            JPG, PNG or WebP
                                        </span>

                                    </div>

                                </label>


                                <p class="product-create-page__upload-note">
                                    Maximum recommended file size: 2MB.
                                </p>

                            </div>


                            {{-- Gallery --}}
                            <div class="product-create-page__media-block">

                                <div class="product-create-page__media-heading">

                                    <div>
                                        <h3>Product Gallery</h3>

                                        <p>
                                            Add multiple images to showcase this product.
                                        </p>
                                    </div>

                                    <span>
                                        Multiple images
                                    </span>

                                </div>


                                <input
                                    type="file"
                                    id="gallery"
                                    name="gallery[]"
                                    accept="image/jpeg,image/png,image/webp"
                                    multiple
                                    hidden
                                >


                                <label
                                    for="gallery"
                                    class="product-create-page__gallery-upload"
                                >

                                    <div class="product-create-page__gallery-upload-content">

                                        <div class="product-create-page__upload-icon">
                                            <i class="ri-gallery-upload-line"></i>
                                        </div>

                                        <strong>
                                            Click to upload gallery images
                                        </strong>

                                        <span>
                                            Select multiple JPG, PNG or WebP images
                                        </span>

                                    </div>

                                </label>


                                <div
                                    class="product-create-page__gallery-preview"
                                    id="gallery-preview"
                                ></div>

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                        VIDEO
                    ====================================================== --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">
                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-youtube-line"></i>
                                </div>

                                <div>
                                    <h2>Product Video</h2>

                                    <p>
                                        Add a YouTube video to showcase the product.
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="product-create-page__card-body">

                            <div class="product-create-page__field">

                                <label for="video_url">
                                    YouTube Embed URL
                                </label>

                                <input
                                    type="url"
                                    id="video_url"
                                    name="video_url"
                                    value="{{ old('video_url') }}"
                                    placeholder="https://www.youtube.com/embed/VIDEO_ID"
                                >

                                <small>
                                    Example:
                                    https://www.youtube.com/embed/VIDEO_ID
                                </small>

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                        PRICING
                    ====================================================== --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">
                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-price-tag-3-line"></i>
                                </div>

                                <div>
                                    <h2>Pricing</h2>

                                    <p>
                                        Set default product pricing.
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="product-create-page__card-body">

                            <div class="product-create-page__grid product-create-page__grid--three">

                                <div class="product-create-page__field">

                                    <label for="price">
                                        Price
                                        <span>*</span>
                                    </label>

                                    <div class="product-create-page__input-prefix">

                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="price"
                                            name="price"
                                            value="{{ old('price') }}"
                                            min="0"
                                            step="0.01"
                                            placeholder="0.00"
                                            required
                                        >

                                    </div>

                                </div>


                                <div class="product-create-page__field">

                                    <label for="compare_price">
                                        Compare Price
                                    </label>

                                    <div class="product-create-page__input-prefix">

                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="compare_price"
                                            name="compare_price"
                                            value="{{ old('compare_price') }}"
                                            min="0"
                                            step="0.01"
                                            placeholder="0.00"
                                        >

                                    </div>

                                </div>


                                <div class="product-create-page__field">

                                    <label for="cost_price">
                                        Cost Price
                                    </label>

                                    <div class="product-create-page__input-prefix">

                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="cost_price"
                                            name="cost_price"
                                            value="{{ old('cost_price') }}"
                                            min="0"
                                            step="0.01"
                                            placeholder="0.00"
                                        >

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                        OPTIONS & VARIANTS
                    ====================================================== --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">
                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-list-settings-line"></i>
                                </div>

                                <div>
                                    <h2>Options & Variants</h2>

                                    <p>
                                        Select product options and generate every possible variant combination.
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="product-create-page__card-body">

                            {{-- Attribute / Option Selection --}}
                            <div class="product-create-page__variant-builder">

                                <div class="product-create-page__sub-heading">

                                    <div>
                                        <h3>Product Options</h3>

                                        <p>
                                            Select options like Color, Size, Storage, Material, etc.
                                        </p>
                                    </div>

                                </div>


                                <div class="product-create-page__attribute-list">

                                    @forelse ($attributes as $attribute)

                                        <div
                                            class="product-create-page__attribute-card"
                                            data-attribute-card
                                            data-attribute-id="{{ $attribute->id }}"
                                        >

                                            <label class="product-create-page__attribute-checkbox">

                                                <input
                                                    type="checkbox"
                                                    name="attribute_ids[]"
                                                    value="{{ $attribute->id }}"
                                                    data-attribute-toggle
                                                >

                                                <span class="product-create-page__attribute-content">

                                                    <strong>
                                                        {{ $attribute->name }}
                                                    </strong>

                                                    <small>
                                                        {{ $attribute->values->count() }}
                                                        {{ $attribute->values->count() === 1 ? 'option' : 'options' }}
                                                    </small>

                                                </span>

                                                <i class="ri-check-line"></i>

                                            </label>


                                            <div
                                                class="product-create-page__attribute-values"
                                                data-attribute-values
                                                hidden
                                            >

                                                <div class="product-create-page__values-header">

                                                    <span>
                                                        Available {{ $attribute->name }} options
                                                    </span>

                                                    <button
                                                        type="button"
                                                        class="product-create-page__select-all"
                                                        data-select-all
                                                    >
                                                        Select All
                                                    </button>

                                                </div>


                                                <div class="product-create-page__values-grid">

                                                    @foreach ($attribute->values as $value)

                                                        <label class="product-create-page__value-checkbox">

                                                            <input
                                                                type="checkbox"
                                                                name="attribute_values[{{ $attribute->id }}][]"
                                                                value="{{ $value->id }}"
                                                                data-attribute-value
                                                                data-attribute-id="{{ $attribute->id }}"
                                                                data-attribute-name="{{ $attribute->name }}"
                                                                data-value-label="{{ $value->label }}"
                                                                disabled
                                                            >

                                                            <span>
                                                                {{ $value->label }}
                                                            </span>

                                                        </label>

                                                    @endforeach

                                                </div>

                                            </div>

                                        </div>

                                    @empty

                                        <div class="product-create-page__variant-empty">

                                            <div class="product-create-page__variant-empty-icon">
                                                <i class="ri-settings-4-line"></i>
                                            </div>

                                            <div>

                                                <strong>
                                                    No product options available
                                                </strong>

                                                <p>
                                                    Create attributes and options before creating variants.
                                                </p>

                                            </div>

                                        </div>

                                    @endforelse

                                </div>

                            </div>


                            {{-- Variant Generator --}}
                            <div class="product-create-page__variant-generator">

                                <div class="product-create-page__generator-content">

                                    <div class="product-create-page__generator-icon">
                                        <i class="ri-magic-line"></i>
                                    </div>

                                    <div>

                                        <h3>
                                            Generate Variants
                                        </h3>

                                        <p>
                                            Generate all possible combinations from the selected options.
                                        </p>

                                    </div>

                                </div>


                                <button
                                    type="button"
                                    class="product-create-page__generate-button"
                                    id="generate-variants"
                                >
                                    <i class="ri-magic-line"></i>
                                    Generate Variants
                                </button>

                            </div>


                            {{-- Variant List --}}
                            <div
                                class="product-create-page__variants"
                                id="variants-container"
                                hidden
                            >

                                <div class="product-create-page__variants-header">

                                    <div>

                                        <h3>
                                            Product Variants
                                        </h3>

                                        <p>
                                            Customize each variant individually.
                                        </p>

                                    </div>

                                    <span
                                        class="product-create-page__variant-count"
                                        id="variant-count"
                                    >
                                        0 Variants
                                    </span>

                                </div>


                                <div class="product-create-page__variant-table-wrapper">

                                    <table class="product-create-page__variant-table">

                                        <thead>
                                        <tr>
                                            <th>Variant</th>
                                            <th>SKU</th>
                                            <th>Price</th>
                                            <th>Compare Price</th>
                                            <th>Stock</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody id="variants-list"></tbody>

                                    </table>

                                </div>

                            </div>


                            {{-- Variant Note --}}
                            <div class="product-create-page__variant-note">

                                <i class="ri-information-line"></i>

                                <p>
                                    Each variant can have its own SKU, price, compare price,
                                    stock, image, and active status.
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                        SEO
                    ====================================================== --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">
                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-search-eye-line"></i>
                                </div>

                                <div>
                                    <h2>SEO</h2>

                                    <p>
                                        Optimize this product for search engines.
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="product-create-page__card-body">

                            <div class="product-create-page__field">

                                <div class="product-create-page__label-row">

                                    <label for="meta_title">
                                        Meta Title
                                    </label>

                                    <span class="product-create-page__character-count">
                                        <span id="meta-title-count">0</span>/255
                                    </span>

                                </div>

                                <input
                                    type="text"
                                    id="meta_title"
                                    name="meta_title"
                                    value="{{ old('meta_title') }}"
                                    maxlength="255"
                                    placeholder="Enter SEO meta title"
                                >

                            </div>


                            <div class="product-create-page__field">

                                <div class="product-create-page__label-row">

                                    <label for="meta_description">
                                        Meta Description
                                    </label>

                                    <span class="product-create-page__character-count">
                                        <span id="meta-description-count">0</span>/500
                                    </span>

                                </div>

                                <textarea
                                    id="meta_description"
                                    name="meta_description"
                                    rows="5"
                                    maxlength="500"
                                    placeholder="Write a short description for search engines..."
                                >{{ old('meta_description') }}</textarea>

                            </div>

                        </div>

                    </section>

                </div>


                {{-- =====================================================
                    SIDEBAR
                ====================================================== --}}
                <aside class="product-create-page__sidebar">

                    {{-- Status --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">

                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-eye-line"></i>
                                </div>

                                <div>
                                    <h2>Product Status</h2>

                                    <p>
                                        Control product visibility.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="product-create-page__card-body">

                            <label class="product-create-page__switch-row">

                                <span class="product-create-page__switch-text">

                                    <strong>
                                        Active
                                    </strong>

                                    <small>
                                        Product is visible to customers.
                                    </small>

                                </span>

                                <input
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    @checked(old('status', true))
                                >

                                <span class="product-create-page__switch"></span>

                            </label>


                            <label class="product-create-page__switch-row">

                                <span class="product-create-page__switch-text">

                                    <strong>
                                        Featured Product
                                    </strong>

                                    <small>
                                        Highlight this product in featured areas.
                                    </small>

                                </span>

                                <input
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                    @checked(old('featured'))
                                >

                                <span class="product-create-page__switch"></span>

                            </label>

                        </div>

                    </section>


                    {{-- Checklist --}}
                    <section class="product-create-page__card">

                        <div class="product-create-page__card-header">

                            <div class="product-create-page__card-heading">

                                <div class="product-create-page__section-icon">
                                    <i class="ri-file-list-3-line"></i>
                                </div>

                                <div>
                                    <h2>Product Checklist</h2>

                                    <p>
                                        Important product sections.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="product-create-page__card-body">

                            <div class="product-create-page__check-item">
                                <i class="ri-checkbox-circle-line"></i>
                                <span>Product information</span>
                            </div>

                            <div class="product-create-page__check-item">
                                <i class="ri-checkbox-circle-line"></i>
                                <span>Product media</span>
                            </div>

                            <div class="product-create-page__check-item">
                                <i class="ri-checkbox-circle-line"></i>
                                <span>Pricing</span>
                            </div>

                            <div class="product-create-page__check-item">
                                <i class="ri-checkbox-circle-line"></i>
                                <span>Options & variants</span>
                            </div>

                            <div class="product-create-page__check-item">
                                <i class="ri-checkbox-circle-line"></i>
                                <span>SEO information</span>
                            </div>

                        </div>

                    </section>


                    {{-- Actions --}}
                    <div class="product-create-page__actions">

                        <a
                            href="{{ route('admin-products') }}"
                            class="product-create-page__cancel-button"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="product-create-page__submit-button"
                        >
                            <i class="ri-save-line"></i>
                            Create Product
                        </button>

                    </div>

                </aside>

            </div>
        </form>

    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector('.product-create-page');

            if (!page) {
                return;
            }

            const form = page.querySelector('#product-create-form');


            /*
            |--------------------------------------------------------------------------
            | Slug Generator
            |--------------------------------------------------------------------------
            */

            const nameInput = page.querySelector('#name');
            const slugInput = page.querySelector('#slug');

            if (nameInput && slugInput) {
                let slugManuallyChanged = slugInput.value.trim() !== '';

                slugInput.addEventListener('input', () => {
                    slugManuallyChanged = slugInput.value.trim() !== '';
                });

                nameInput.addEventListener('input', () => {
                    if (slugManuallyChanged) {
                        return;
                    }

                    slugInput.value = nameInput.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Rich Text Editor
            |--------------------------------------------------------------------------
            */

            const richEditor = page.querySelector('[data-rich-editor]');

            if (richEditor) {
                const content = richEditor.querySelector('[data-rich-content]');
                const input = richEditor.querySelector('[data-rich-input]');
                const buttons = richEditor.querySelectorAll(
                    '[data-editor-action]',
                );

                const syncRichText = () => {
                    if (content && input) {
                        input.value = content.innerHTML.trim();
                    }
                };

                buttons.forEach((button) => {
                    button.addEventListener('click', () => {
                        const action = button.dataset.editorAction;

                        content.focus();

                        switch (action) {
                            case 'bold':
                                document.execCommand('bold');
                                break;

                            case 'italic':
                                document.execCommand('italic');
                                break;

                            case 'underline':
                                document.execCommand('underline');
                                break;

                            case 'heading':
                                document.execCommand(
                                    'formatBlock',
                                    false,
                                    'h3',
                                );
                                break;

                            case 'unordered-list':
                                document.execCommand(
                                    'insertUnorderedList',
                                );
                                break;

                            case 'ordered-list':
                                document.execCommand(
                                    'insertOrderedList',
                                );
                                break;

                            case 'link': {
                                const url = window.prompt(
                                    'Enter URL',
                                    'https://',
                                );

                                if (url) {
                                    document.execCommand(
                                        'createLink',
                                        false,
                                        url,
                                    );
                                }

                                break;
                            }

                            case 'clear':
                                document.execCommand(
                                    'removeFormat',
                                );
                                break;

                            default:
                                break;
                        }

                        syncRichText();
                    });
                });

                content.addEventListener(
                    'input',
                    syncRichText,
                );

                if (form) {
                    form.addEventListener('submit', syncRichText);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Thumbnail Preview
            |--------------------------------------------------------------------------
            */

            const thumbnailInput = page.querySelector('#thumbnail');
            const thumbnailPreview = page.querySelector('#thumbnail-preview');

            if (thumbnailInput && thumbnailPreview) {
                thumbnailInput.addEventListener('change', () => {
                    const file = thumbnailInput.files?.[0];

                    if (!file) {
                        return;
                    }

                    if (!file.type.startsWith('image/')) {
                        thumbnailInput.value = '';

                        return;
                    }

                    const reader = new FileReader();

                    reader.addEventListener('load', (event) => {
                        thumbnailPreview.innerHTML = `
                    <img
                        src="${event.target.result}"
                        alt="Product thumbnail preview"
                    >

                    <button
                        type="button"
                        class="product-create-page__remove-upload"
                        data-remove-thumbnail
                        title="Remove image"
                    >
                        <i class="ri-close-line"></i>
                    </button>
                `;

                        const removeButton = thumbnailPreview.querySelector(
                            '[data-remove-thumbnail]',
                        );

                        removeButton?.addEventListener('click', (clickEvent) => {
                            clickEvent.preventDefault();
                            clickEvent.stopPropagation();

                            thumbnailInput.value = '';

                            thumbnailPreview.innerHTML = `
                        <div class="product-create-page__upload-icon">
                            <i class="ri-image-add-line"></i>
                        </div>

                        <strong>
                            Upload product image
                        </strong>

                        <span>
                            JPG, PNG or WebP
                        </span>
                    `;
                        });
                    });

                    reader.readAsDataURL(file);
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Gallery Preview
            |--------------------------------------------------------------------------
            */

            const galleryInput = page.querySelector('#gallery');
            const galleryPreview = page.querySelector('#gallery-preview');

            if (galleryInput && galleryPreview) {
                galleryInput.addEventListener('change', () => {
                    galleryPreview.innerHTML = '';

                    const files = Array.from(
                        galleryInput.files || [],
                    );

                    files.forEach((file, index) => {
                        if (!file.type.startsWith('image/')) {
                            return;
                        }

                        const reader = new FileReader();

                        reader.addEventListener('load', (event) => {
                            const item = document.createElement('div');

                            item.className =
                                'product-create-page__gallery-item';

                            item.dataset.galleryIndex = String(index);

                            item.innerHTML = `
                        <img
                            src="${event.target.result}"
                            alt="Gallery preview"
                        >

                        <button
                            type="button"
                            class="product-create-page__remove-upload"
                            data-remove-gallery="${index}"
                            title="Remove image"
                        >
                            <i class="ri-close-line"></i>
                        </button>
                    `;

                            galleryPreview.appendChild(item);
                        });

                        reader.readAsDataURL(file);
                    });
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Attribute / Option Selection
            |--------------------------------------------------------------------------
            */

            const attributeCards = page.querySelectorAll(
                '[data-attribute-card]',
            );

            attributeCards.forEach((card) => {
                const toggle = card.querySelector(
                    '[data-attribute-toggle]',
                );

                const valuesContainer = card.querySelector(
                    '[data-attribute-values]',
                );

                const valueInputs = card.querySelectorAll(
                    '[data-attribute-value]',
                );

                const selectAllButton = card.querySelector(
                    '[data-select-all]',
                );

                if (!toggle || !valuesContainer) {
                    return;
                }

                const updateSelectAllButton = () => {
                    if (!selectAllButton || !toggle.checked) {
                        return;
                    }

                    const checkedCount = Array.from(valueInputs)
                        .filter((input) => input.checked)
                        .length;

                    const totalCount = valueInputs.length;

                    selectAllButton.textContent =
                        totalCount > 0 &&
                        checkedCount === totalCount
                            ? 'Deselect All'
                            : 'Select All';
                };

                const updateValuesState = () => {
                    const enabled = toggle.checked;

                    valuesContainer.hidden = !enabled;

                    valueInputs.forEach((input) => {
                        input.disabled = !enabled;

                        if (!enabled) {
                            input.checked = false;
                        }
                    });

                    updateSelectAllButton();
                };

                toggle.addEventListener(
                    'change',
                    updateValuesState,
                );

                valueInputs.forEach((input) => {
                    input.addEventListener(
                        'change',
                        updateSelectAllButton,
                    );
                });

                selectAllButton?.addEventListener('click', () => {
                    if (!toggle.checked) {
                        return;
                    }

                    const allChecked = Array.from(valueInputs)
                        .every((input) => input.checked);

                    valueInputs.forEach((input) => {
                        input.checked = !allChecked;
                    });

                    updateSelectAllButton();
                });

                updateValuesState();
            });


            /*
            |--------------------------------------------------------------------------
            | Variant Elements
            |--------------------------------------------------------------------------
            */

            const generateButton = page.querySelector(
                '#generate-variants',
            );

            const variantsContainer = page.querySelector(
                '#variants-container',
            );

            const variantsList = page.querySelector(
                '#variants-list',
            );

            const variantCount = page.querySelector(
                '#variant-count',
            );

            const defaultPrice = page.querySelector(
                '#price',
            );

            const defaultComparePrice = page.querySelector(
                '#compare_price',
            );


            /*
            |--------------------------------------------------------------------------
            | Generate Variants
            |--------------------------------------------------------------------------
            */

            if (
                generateButton &&
                variantsContainer &&
                variantsList
            ) {
                generateButton.addEventListener('click', () => {
                    const selectedAttributes = [];

                    attributeCards.forEach((card) => {
                        const toggle = card.querySelector(
                            '[data-attribute-toggle]',
                        );

                        if (!toggle?.checked) {
                            return;
                        }

                        const attributeId = String(
                            card.dataset.attributeId || '',
                        ).trim();

                        if (!attributeId) {
                            return;
                        }

                        const selectedValues = Array.from(
                            card.querySelectorAll(
                                '[data-attribute-value]:checked',
                            ),
                        )
                            .map((input) => {
                                const valueId = String(
                                    input.value || '',
                                ).trim();

                                const valueLabel = String(
                                    input.dataset.valueLabel || '',
                                ).trim();

                                const valueAttributeId = String(
                                    input.dataset.attributeId ||
                                    attributeId,
                                ).trim();

                                const attributeName = String(
                                    input.dataset.attributeName || '',
                                ).trim();

                                if (
                                    !valueId ||
                                    !valueAttributeId
                                ) {
                                    return null;
                                }

                                return {
                                    id: valueId,
                                    label: valueLabel,
                                    attributeId: valueAttributeId,
                                    attributeName,
                                };
                            })
                            .filter(Boolean);

                        if (selectedValues.length > 0) {
                            selectedAttributes.push({
                                attributeId,
                                values: selectedValues,
                            });
                        }
                    });


                    /*
                    |--------------------------------------------------------------------------
                    | Validate Selected Attributes
                    |--------------------------------------------------------------------------
                    */

                    if (selectedAttributes.length === 0) {
                        variantsContainer.hidden = true;

                        window.alert(
                            'Please select at least one option and one value before generating variants.',
                        );

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Build Combinations
                    |--------------------------------------------------------------------------
                    */

                    const groups = selectedAttributes.map(
                        (attribute) => attribute.values,
                    );

                    const combinations = buildCombinations(groups);


                    /*
                    |--------------------------------------------------------------------------
                    | Validate Combinations
                    |--------------------------------------------------------------------------
                    */

                    if (!combinations.length) {
                        variantsContainer.hidden = true;

                        window.alert(
                            'No valid variant combinations could be generated.',
                        );

                        return;
                    }


                    const invalidCombination = combinations.find(
                        (combination) => {
                            return combination.length === 0 ||
                                combination.some((item) => {
                                    return !item.id ||
                                        !item.attributeId;
                                });
                        },
                    );

                    if (invalidCombination) {
                        variantsContainer.hidden = true;

                        window.alert(
                            'One or more variant combinations are missing attribute values.',
                        );

                        return;
                    }


                    renderVariants(combinations);

                    variantsContainer.hidden = false;

                    variantsContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                    });
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Build Variant Combinations
            |--------------------------------------------------------------------------
            */

            function buildCombinations(groups) {
                if (!Array.isArray(groups) || !groups.length) {
                    return [];
                }

                if (
                    groups.some(
                        (group) =>
                            !Array.isArray(group) ||
                            group.length === 0,
                    )
                ) {
                    return [];
                }

                return groups.reduce(
                    (combinations, group) => {
                        if (!combinations.length) {
                            return group.map((item) => [item]);
                        }

                        return combinations.flatMap(
                            (combination) => {
                                return group.map((item) => {
                                    return [
                                        ...combination,
                                        item,
                                    ];
                                });
                            },
                        );
                    },
                    [],
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Render Variants
            |--------------------------------------------------------------------------
            */

            function renderVariants(combinations) {
                if (!variantsList) {
                    return;
                }

                variantsList.innerHTML = '';

                combinations.forEach((combination, index) => {
                    const row = document.createElement('tr');

                    const variantLabel = combination
                        .map((item) => item.label)
                        .filter(Boolean)
                        .join(' / ');

                    row.dataset.variantIndex = String(index);

                    const valueInputs = combination
                        .map((item) => {
                            const attributeId = String(
                                item.attributeId || '',
                            ).trim();

                            const valueId = String(
                                item.id || '',
                            ).trim();

                            if (!attributeId || !valueId) {
                                return '';
                            }

                            return `
                        <span>
                            ${escapeHtml(item.attributeName || '')}:
                            ${escapeHtml(item.label || '')}
                        </span>

                        <input
                            type="hidden"
                            name="variants[${index}][values][${escapeAttribute(attributeId)}]"
                            value="${escapeAttribute(valueId)}"
                            data-variant-value
                            data-attribute-id="${escapeAttribute(attributeId)}"
                            data-value-id="${escapeAttribute(valueId)}"
                        >
                    `;
                        })
                        .join('');


                    row.innerHTML = `
                <td>
                    <div class="product-create-page__variant-name">

                        <strong>
                            ${escapeHtml(variantLabel)}
                        </strong>

                        <div class="product-create-page__variant-options">
                            ${valueInputs}
                        </div>

                        <input
                            type="hidden"
                            name="variants[${index}][name]"
                            value="${escapeAttribute(variantLabel)}"
                        >

                    </div>
                </td>


                <td>
                    <input
                        type="text"
                        name="variants[${index}][sku]"
                        class="product-create-page__variant-input"
                        placeholder="SKU"
                        required
                    >
                </td>


                <td>
                    <div class="product-create-page__variant-price">

                        <span>$</span>

                        <input
                            type="number"
                            name="variants[${index}][price]"
                            class="product-create-page__variant-input"
                            min="0"
                            step="0.01"
                            value="${escapeAttribute(
                        defaultPrice?.value || '',
                    )}"
                            placeholder="0.00"
                            required
                        >

                    </div>
                </td>


                <td>
                    <div class="product-create-page__variant-price">

                        <span>$</span>

                        <input
                            type="number"
                            name="variants[${index}][compare_price]"
                            class="product-create-page__variant-input"
                            min="0"
                            step="0.01"
                            value="${escapeAttribute(
                        defaultComparePrice?.value || '',
                    )}"
                            placeholder="0.00"
                        >

                    </div>
                </td>


                <td>
                    <input
                        type="number"
                        name="variants[${index}][stock]"
                        class="product-create-page__variant-input"
                        min="0"
                        step="1"
                        value="0"
                        placeholder="0"
                        required
                    >
                </td>


                <td>
                    <label
                        class="product-create-page__variant-image"
                    >

                        <input
                            type="file"
                            name="variants[${index}][image]"
                            accept="image/jpeg,image/png,image/webp"
                            hidden
                            data-variant-image-input
                        >

                        <span
                            data-variant-image-preview
                        >
                            <i class="ri-image-add-line"></i>
                        </span>

                    </label>
                </td>


                <td>
                    <label class="product-create-page__variant-switch">

                        <input
                            type="checkbox"
                            name="variants[${index}][status]"
                            value="1"
                            checked
                        >

                        <span></span>

                    </label>
                </td>


                <td>
                    <button
                        type="button"
                        class="product-create-page__remove-variant"
                        data-remove-variant
                        title="Remove variant"
                    >
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            `;

                    variantsList.appendChild(row);

                    setupVariantImage(row);
                });

                updateVariantCount();
                setupVariantRemoval();
            }


            /*
            |--------------------------------------------------------------------------
            | Variant Image Preview
            |--------------------------------------------------------------------------
            */

            function setupVariantImage(row) {
                const input = row.querySelector(
                    '[data-variant-image-input]',
                );

                const preview = row.querySelector(
                    '[data-variant-image-preview]',
                );

                if (!input || !preview) {
                    return;
                }

                input.addEventListener('change', () => {
                    const file = input.files?.[0];

                    if (!file) {
                        return;
                    }

                    if (!file.type.startsWith('image/')) {
                        input.value = '';

                        return;
                    }

                    const reader = new FileReader();

                    reader.addEventListener('load', (event) => {
                        preview.innerHTML = `
                    <img
                        src="${event.target.result}"
                        alt="Variant image"
                    >
                `;
                    });

                    reader.readAsDataURL(file);
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Remove Variant
            |--------------------------------------------------------------------------
            */

            function setupVariantRemoval() {
                if (!variantsList) {
                    return;
                }

                variantsList
                    .querySelectorAll('[data-remove-variant]')
                    .forEach((button) => {
                        button.addEventListener('click', () => {
                            button.closest('tr')?.remove();

                            reindexVariants();
                            updateVariantCount();
                        });
                    });
            }


            /*
            |--------------------------------------------------------------------------
            | Reindex Variants
            |--------------------------------------------------------------------------
            */

            function reindexVariants() {
                if (!variantsList) {
                    return;
                }

                const rows = Array.from(
                    variantsList.querySelectorAll('tr'),
                );

                rows.forEach((row, index) => {
                    row.dataset.variantIndex = String(index);

                    row.querySelectorAll('[name]').forEach((input) => {
                        input.name = input.name.replace(
                            /variants\[\d+\]/,
                            `variants[${index}]`,
                        );
                    });
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Variant Count
            |--------------------------------------------------------------------------
            */

            function updateVariantCount() {
                if (!variantCount || !variantsList) {
                    return;
                }

                const count = variantsList.querySelectorAll('tr').length;

                variantCount.textContent =
                    `${count} ${count === 1 ? 'Variant' : 'Variants'}`;

                if (variantsContainer) {
                    variantsContainer.hidden = count === 0;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | SEO Character Counters
            |--------------------------------------------------------------------------
            */

            setupCharacterCounter(
                '#meta_title',
                '#meta-title-count',
            );

            setupCharacterCounter(
                '#meta_description',
                '#meta-description-count',
            );


            function setupCharacterCounter(
                inputSelector,
                countSelector,
            ) {
                const input = page.querySelector(inputSelector);
                const counter = page.querySelector(countSelector);

                if (!input || !counter) {
                    return;
                }

                const update = () => {
                    counter.textContent = String(
                        input.value.length,
                    );
                };

                input.addEventListener('input', update);

                update();
            }


            /*
            |--------------------------------------------------------------------------
            | Form Submit Validation
            |--------------------------------------------------------------------------
            */

            if (form) {
                form.addEventListener('submit', (event) => {

                    /*
                    |--------------------------------------------------------------------------
                    | Sync Rich Text
                    |--------------------------------------------------------------------------
                    */

                    if (richEditor) {
                        const content =
                            richEditor.querySelector(
                                '[data-rich-content]',
                            );

                        const input =
                            richEditor.querySelector(
                                '[data-rich-input]',
                            );

                        if (content && input) {
                            input.value =
                                content.innerHTML.trim();
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Reindex Variants
                    |--------------------------------------------------------------------------
                    */

                    reindexVariants();


                    /*
                    |--------------------------------------------------------------------------
                    | Validate Variants
                    |--------------------------------------------------------------------------
                    */

                    const variantRows = Array.from(
                        variantsList?.querySelectorAll('tr') || [],
                    );

                    for (const row of variantRows) {
                        const valueInputs = Array.from(
                            row.querySelectorAll(
                                'input[data-variant-value]',
                            ),
                        ).filter((input) => {
                            return (
                                input.value.trim() !== '' &&
                                input.dataset.attributeId &&
                                input.dataset.valueId
                            );
                        });

                        if (valueInputs.length === 0) {
                            event.preventDefault();

                            window.alert(
                                'Each variant must have attribute values.',
                            );

                            row.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center',
                            });

                            return;
                        }
                    }
                });
            }


            /*
            |--------------------------------------------------------------------------
            | HTML Escaping
            |--------------------------------------------------------------------------
            */

            function escapeHtml(value) {
                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }


            function escapeAttribute(value) {
                return escapeHtml(value);
            }
        });
    </script>
@endpush
