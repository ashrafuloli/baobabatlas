@extends('backend.layouts.backend')

@section('title', 'Edit Product')

@push('styles')
    <link
        href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"
        rel="stylesheet"
    >
@endpush

@section('content')
    <div class="product-edit-page">
        <form
            action="{{ route('admin-products.update', $product) }}"
            method="POST"
            enctype="multipart/form-data"
            id="product-edit-form"
        >
            @csrf
            @method('PUT')

            <div class="product-edit-page__header">
                <div>
                    <div class="product-edit-page__breadcrumb">
                        <a href="{{ route('admin-products') }}">
                            <i class="ri-shopping-bag-line"></i>
                            Products
                        </a>

                        <i class="ri-arrow-right-s-line"></i>

                        <span>Edit Product</span>
                    </div>

                    <h1 class="product-edit-page__title">
                        Edit Product
                    </h1>

                    <p class="product-edit-page__subtitle">
                        Update product information, media, pricing, options and variants.
                    </p>
                </div>

                <div class="product-edit-page__header-actions">
                    <a
                        href="{{ route('admin-products') }}"
                        class="product-edit-page__btn product-edit-page__btn--light"
                    >
                        <i class="ri-arrow-left-line"></i>
                        <span>Back</span>
                    </a>

                    <button
                        type="submit"
                        class="product-edit-page__btn product-edit-page__btn--primary"
                    >
                        <i class="ri-save-line"></i>
                        <span>Update Product</span>
                    </button>
                </div>
            </div>

            @if ($errors->any())
                <div class="product-edit-page__alert product-edit-page__alert--danger">
                    <div class="product-edit-page__alert-icon">
                        <i class="ri-error-warning-line"></i>
                    </div>

                    <div>
                        <strong>Please fix the following errors.</strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="product-edit-page__alert product-edit-page__alert--success">
                    <i class="ri-checkbox-circle-line"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="product-edit-page__layout">
                <main class="product-edit-page__main">

                    {{-- Product Information --}}
                    <section class="product-edit-page__card">
                        <div class="product-edit-page__card-header">
                            <div>
                                <h2>Product Information</h2>
                                <p>Basic information about your product.</p>
                            </div>

                            <span class="product-edit-page__card-icon">
                                <i class="ri-information-line"></i>
                            </span>
                        </div>

                        <div class="product-edit-page__card-body">
                            <div class="product-edit-page__grid product-edit-page__grid--2">
                                <div class="product-edit-page__field">
                                    <label for="name">
                                        Product Name
                                        <span>*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $product->name) }}"
                                        placeholder="Enter product name"
                                        required
                                        data-product-name
                                    >
                                </div>

                                <div class="product-edit-page__field">
                                    <label for="slug">
                                        Slug
                                        <span>*</span>
                                    </label>

                                    <div class="product-edit-page__input-with-icon">
                                        <i class="ri-link"></i>

                                        <input
                                            type="text"
                                            id="slug"
                                            name="slug"
                                            value="{{ old('slug', $product->slug) }}"
                                            placeholder="product-slug"
                                            required
                                            data-product-slug
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="product-edit-page__grid product-edit-page__grid--2">
                                <div class="product-edit-page__field">
                                    <label for="sku">
                                        SKU
                                    </label>

                                    <input
                                        type="text"
                                        id="sku"
                                        name="sku"
                                        value="{{ old('sku', $product->sku) }}"
                                        placeholder="Enter SKU"
                                    >
                                </div>

                                <div class="product-edit-page__field">
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
                                            @selected(old('source', $product->source) === 'own')
                                        >
                                            Own Product
                                        </option>

                                        <option
                                            value="amazon"
                                            @selected(old('source', $product->source) === 'amazon')
                                        >
                                            Amazon
                                        </option>

                                        <option
                                            value="aliexpress"
                                            @selected(old('source', $product->source) === 'aliexpress')
                                        >
                                            AliExpress
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="product-edit-page__grid product-edit-page__grid--2">
                                <div class="product-edit-page__field">
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
                                                    (string) old(
                                                        'brand_id',
                                                        $product->brand_id
                                                    ) === (string) $brand->id
                                                )
                                            >
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="product-edit-page__field">
                                    <label for="sort_order">
                                        Sort Order
                                    </label>

                                    <input
                                        type="number"
                                        id="sort_order"
                                        name="sort_order"
                                        value="{{ old('sort_order', $product->sort_order) }}"
                                        min="0"
                                        placeholder="0"
                                    >
                                </div>
                            </div>

                            {{-- Categories --}}
                            @php
                                $selectedCategoryIds = collect(
                                    old(
                                        'category_ids',
                                        $product->categories->pluck('id')->all(),
                                    ),
                                )
                                    ->map(fn ($id) => (string) $id)
                                    ->all();
                            @endphp

                            <div class="product-edit-page__field">
                                <label for="category_ids">
                                    Categories
                                </label>

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
                                                    $selectedCategoryIds,
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
                            <div class="product-edit-page__field">

                                <div class="product-create-page__label-row">

                                    <label for="short_description">
                                        Short Description
                                    </label>

                                    <span class="product-create-page__field-hint">
                                        Rich Text Editor
                                    </span>

                                </div>

                                <div
                                    class="product-create-page__quill"
                                    data-quill-editor
                                    data-placeholder="Write a short summary of this product..."
                                ></div>

                                <textarea
                                    id="short_description"
                                    name="short_description"
                                    hidden
                                    data-quill-source
                                >{{ old('short_description', $product->short_description) }}</textarea>

                            </div>


                            {{-- Product Description --}}
                            <div class="product-edit-page__field">

                                <div class="product-create-page__label-row">

                                    <label for="description">
                                        Product Description
                                    </label>

                                    <span class="product-create-page__field-hint">
                                        Rich Text Editor
                                    </span>

                                </div>

                                <div
                                    class="product-create-page__quill"
                                    data-quill-editor
                                    data-placeholder="Write your product description..."
                                ></div>

                                <textarea
                                    id="description"
                                    name="description"
                                    hidden
                                    data-quill-source
                                >{{ old('description', $product->description) }}</textarea>

                            </div>
                        </div>
                    </section>

                    {{-- Media --}}
                    <section class="product-edit-page__card">
                        <div class="product-edit-page__card-header">
                            <div>
                                <h2>Product Media</h2>
                                <p>Manage thumbnail and product gallery images.</p>
                            </div>

                            <span class="product-edit-page__card-icon">
                                <i class="ri-image-line"></i>
                            </span>
                        </div>

                        <div class="product-edit-page__card-body">
                            <div class="product-edit-page__field">
                                <label>
                                    Product Thumbnail
                                </label>

                                <div class="product-edit-page__thumbnail-upload">
                                    <div
                                        class="product-edit-page__thumbnail-preview"
                                        data-thumbnail-preview
                                    >
                                        @if ($product->thumbnail)
                                            <img
                                                src="{{ asset($product->thumbnail) }}"
                                                alt="{{ $product->name }}"
                                                data-thumbnail-preview-image
                                            >
                                        @else
                                            <div class="product-edit-page__empty-image">
                                                <i class="ri-image-add-line"></i>
                                                <span>No image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="product-edit-page__thumbnail-content">
                                        <label
                                            for="thumbnail"
                                            class="product-edit-page__upload-button"
                                        >
                                            <i class="ri-upload-2-line"></i>
                                            <span>Choose Thumbnail</span>
                                        </label>

                                        <input
                                            type="file"
                                            id="thumbnail"
                                            name="thumbnail"
                                            accept="image/*"
                                            hidden
                                            data-thumbnail-input
                                        >

                                        <p>
                                            Recommended: square product image.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="product-edit-page__field">
                                <label>
                                    Gallery Images
                                </label>

                                <label
                                    for="gallery"
                                    class="product-edit-page__gallery-upload"
                                >
                                    <i class="ri-image-add-line"></i>

                                    <strong>
                                        Add Gallery Images
                                    </strong>

                                    <span>
                                        Select multiple images
                                    </span>
                                </label>

                                <input
                                    type="file"
                                    id="gallery"
                                    name="gallery[]"
                                    accept="image/*"
                                    multiple
                                    hidden
                                    data-gallery-input
                                >

                                <div
                                    class="product-edit-page__gallery-grid"
                                    data-gallery-preview
                                >
                                    @foreach ($product->images->sortBy('sort_order') as $image)
                                        <div
                                            class="product-edit-page__gallery-item"
                                            data-existing-gallery-item
                                            data-image-id="{{ $image->id }}"
                                        >
                                            <img
                                                src="{{ asset($image->image) }}"
                                                alt="{{ $image->alt_text ?: $product->name }}"
                                            >

                                            <button
                                                type="button"
                                                data-remove-existing-gallery
                                                aria-label="Remove image"
                                            >
                                                <i class="ri-close-line"></i>
                                            </button>

                                            <input
                                                type="hidden"
                                                name="remove_gallery[]"
                                                value=""
                                                data-remove-gallery-input
                                            >
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Video --}}
                    <section class="product-edit-page__card">
                        <div class="product-edit-page__card-header">
                            <div>
                                <h2>Product Video</h2>
                                <p>Add a YouTube video for this product.</p>
                            </div>

                            <span class="product-edit-page__card-icon">
                                <i class="ri-youtube-line"></i>
                            </span>
                        </div>

                        <div class="product-edit-page__card-body">
                            <div class="product-edit-page__field">
                                <label for="video_url">
                                    YouTube Embed URL
                                </label>

                                <div class="product-edit-page__input-with-icon">
                                    <i class="ri-youtube-line"></i>

                                    <input
                                        type="url"
                                        id="video_url"
                                        name="video_url"
                                        value="{{ old('video_url', $product->video_url) }}"
                                        placeholder="https://www.youtube.com/embed/..."
                                    >
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Pricing --}}
                    <section class="product-edit-page__card">
                        <div class="product-edit-page__card-header">
                            <div>
                                <h2>Pricing</h2>
                                <p>Set product selling and cost prices.</p>
                            </div>

                            <span class="product-edit-page__card-icon">
                                <i class="ri-money-dollar-circle-line"></i>
                            </span>
                        </div>

                        <div class="product-edit-page__card-body">
                            <div class="product-edit-page__grid product-edit-page__grid--3">
                                <div class="product-edit-page__field">
                                    <label for="price">
                                        Price
                                        <span>*</span>
                                    </label>

                                    <div class="product-edit-page__price-input">
                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="price"
                                            name="price"
                                            value="{{ old('price', $product->price) }}"
                                            step="0.01"
                                            min="0"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="product-edit-page__field">
                                    <label for="compare_price">
                                        Compare Price
                                    </label>

                                    <div class="product-edit-page__price-input">
                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="compare_price"
                                            name="compare_price"
                                            value="{{ old('compare_price', $product->compare_price) }}"
                                            step="0.01"
                                            min="0"
                                        >
                                    </div>
                                </div>

                                <div class="product-edit-page__field">
                                    <label for="cost_price">
                                        Cost Price
                                    </label>

                                    <div class="product-edit-page__price-input">
                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="cost_price"
                                            name="cost_price"
                                            value="{{ old('cost_price', $product->cost_price) }}"
                                            step="0.01"
                                            min="0"
                                        >
                                    </div>
                                </div>

                                <div class="product-edit-page__field">
                                    <label for="shipping_cost">
                                        Shipping Cost
                                    </label>

                                    <div class="product-edit-page__price-input">
                                        <span>$</span>

                                        <input
                                            type="number"
                                            id="shipping_cost"
                                            name="shipping_cost"
                                            value="{{ old('shipping_cost', $product->shipping_cost ?? 0) }}"
                                            min="0"
                                            step="0.01"
                                            placeholder="0.00"
                                        >
                                    </div>

                                    <small>
                                        Shipping charge for this product.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Options & Variants --}}
                    <section class="product-edit-page__card">
                        <div class="product-edit-page__card-header">
                            <div>
                                <h2>Options & Variants</h2>
                                <p>
                                    Manage product options, variants, prices,
                                    stock and variant images.
                                </p>
                            </div>

                            <span class="product-edit-page__card-icon">
                                <i class="ri-list-settings-line"></i>
                            </span>
                        </div>

                        <div class="product-edit-page__card-body">

                            @php
                                $selectedAttributeIds = collect(
                                    old(
                                        'attribute_ids',
                                        $product->variants
                                            ->flatMap(
                                                fn ($variant) => $variant->values
                                                    ->pluck('attribute_id')
                                            )
                                            ->unique()
                                            ->values()
                                            ->all(),
                                    ),
                                )
                                    ->map(fn ($id) => (string) $id)
                                    ->all();

                                $oldAttributeValues = old('attribute_values', []);

                                $variantData = old(
                                    'variants',
                                    $product->variants->map(function ($variant) {
                                        return [
                                            'id' => $variant->id,
                                            'sku' => $variant->sku,
                                            'price' => $variant->price,
                                            'compare_price' => $variant->compare_price,
                                            'stock' => $variant->stock,
                                            'status' => $variant->status,
                                            'image' => $variant->image,
                                            'values' => $variant->values
                                                ->mapWithKeys(
                                                    fn ($value) => [
                                                        $value->attribute_id =>
                                                            $value->attribute_value_id,
                                                    ]
                                                )
                                                ->all(),
                                        ];
                                    })->values()->all(),
                                );
                            @endphp

                            <div class="product-edit-page__attributes">
                                @foreach ($attributes as $attribute)
                                    @php
                                        $attributeSelected = in_array(
                                            (string) $attribute->id,
                                            $selectedAttributeIds,
                                            true,
                                        );

                                        $selectedValues = $oldAttributeValues[$attribute->id]
                                            ?? $product->variants
                                                ->flatMap(
                                                    fn ($variant) => $variant->values
                                                        ->where('attribute_id', $attribute->id)
                                                        ->pluck('attribute_value_id'),
                                                )
                                                ->unique()
                                                ->values()
                                                ->all();
                                    @endphp

                                    <div
                                        class="product-edit-page__attribute-card"
                                        data-attribute-card
                                        data-attribute-id="{{ $attribute->id }}"
                                    >
                                        <label class="product-edit-page__attribute-header">
                                            <span>
                                                <input
                                                    type="checkbox"
                                                    name="attribute_ids[]"
                                                    value="{{ $attribute->id }}"
                                                    @checked($attributeSelected)
                                                    data-attribute-toggle
                                                >

                                                <span class="product-edit-page__custom-check">
                                                    <i class="ri-check-line"></i>
                                                </span>

                                                <strong>
                                                    {{ $attribute->name }}
                                                </strong>
                                            </span>

                                            <span>
                                                {{ $attribute->values->count() }} values
                                            </span>
                                        </label>

                                        <div class="product-edit-page__attribute-values">
                                            @foreach ($attribute->values as $value)
                                                <label class="product-edit-page__value-check">
                                                    <input
                                                        type="checkbox"
                                                        name="attribute_values[{{ $attribute->id }}][]"
                                                        value="{{ $value->id }}"
                                                        @checked(in_array($value->id, $selectedValues))
                                                        data-attribute-value
                                                        data-attribute-id="{{ $attribute->id }}"
                                                        data-attribute-name="{{ $attribute->name }}"
                                                        data-value-label="{{ $value->label }}"
                                                        @disabled(!$attributeSelected)
                                                    >

                                                    <span>
                                                        {{ $value->label }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="product-edit-page__variant-toolbar">
                                <div>
                                    <h3>
                                        Variants
                                    </h3>

                                    <p>
                                        Each variant can have its own price,
                                        stock, SKU and image.
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    class="product-edit-page__btn product-edit-page__btn--outline"
                                    data-generate-variants
                                >
                                    <i class="ri-refresh-line"></i>
                                    <span>Generate Variants</span>
                                </button>
                            </div>

                            <div
                                class="product-edit-page__variants"
                                data-variants-container
                            >
                                @foreach ($variantData as $index => $variant)
                                    <div
                                        class="product-edit-page__variant-row"
                                        data-variant-row
                                        data-variant-id="{{ $variant['id'] ?? '' }}"
                                    >
                                        <div class="product-edit-page__variant-heading">
                                            <div>
                                                <span class="product-edit-page__variant-number">
                                                    {{ $index + 1 }}
                                                </span>

                                                <div>
                                                    <strong data-variant-label>
                                                        Variant
                                                    </strong>

                                                    @if (!empty($variant['sku']))
                                                        <small>
                                                            {{ $variant['sku'] }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>

                                            <button
                                                type="button"
                                                class="product-edit-page__remove-variant"
                                                data-remove-variant
                                            >
                                                <i class="ri-delete-bin-line"></i>
                                                <span>Remove</span>
                                            </button>
                                        </div>

                                        <input
                                            type="hidden"
                                            name="variants[{{ $index }}][id]"
                                            value="{{ $variant['id'] ?? '' }}"
                                            data-variant-id-input
                                        >

                                        <div class="product-edit-page__variant-values">
                                            @foreach (($variant['values'] ?? []) as $attributeId => $valueId)
                                                @php
                                                    $attribute = $attributes->firstWhere('id', $attributeId);
                                                    $value = $attribute?->values->firstWhere('id', $valueId);
                                                @endphp

                                                @if ($attribute && $value)
                                                    <span class="product-edit-page__variant-value">
                                                        <strong>
                                                            {{ $attribute->name }}:
                                                        </strong>

                                                        {{ $value->label }}

                                                        <input
                                                            type="hidden"
                                                            name="variants[{{ $index }}][values][{{ $attributeId }}]"
                                                            value="{{ $valueId }}"
                                                            data-variant-value
                                                            data-attribute-id="{{ $attributeId }}"
                                                            data-value-id="{{ $valueId }}"
                                                        >
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="product-edit-page__variant-grid">
                                            <div class="product-edit-page__field">
                                                <label>
                                                    SKU
                                                </label>

                                                <input
                                                    type="text"
                                                    name="variants[{{ $index }}][sku]"
                                                    value="{{ $variant['sku'] ?? '' }}"
                                                    placeholder="Variant SKU"
                                                    data-variant-sku
                                                >
                                            </div>

                                            <div class="product-edit-page__field">
                                                <label>
                                                    Price
                                                </label>

                                                <div class="product-edit-page__price-input">
                                                    <span>$</span>

                                                    <input
                                                        type="number"
                                                        name="variants[{{ $index }}][price]"
                                                        value="{{ $variant['price'] ?? '' }}"
                                                        step="0.01"
                                                        min="0"
                                                        placeholder="0.00"
                                                    >
                                                </div>
                                            </div>

                                            <div class="product-edit-page__field">
                                                <label>
                                                    Compare Price
                                                </label>

                                                <div class="product-edit-page__price-input">
                                                    <span>$</span>

                                                    <input
                                                        type="number"
                                                        name="variants[{{ $index }}][compare_price]"
                                                        value="{{ $variant['compare_price'] ?? '' }}"
                                                        step="0.01"
                                                        min="0"
                                                        placeholder="0.00"
                                                    >
                                                </div>
                                            </div>

                                            <div class="product-edit-page__field">
                                                <label>
                                                    Stock
                                                </label>

                                                <input
                                                    type="number"
                                                    name="variants[{{ $index }}][stock]"
                                                    value="{{ $variant['stock'] ?? 0 }}"
                                                    min="0"
                                                    placeholder="0"
                                                >
                                            </div>

                                            <div class="product-edit-page__field">
                                                <label>
                                                    Status
                                                </label>

                                                <select
                                                    name="variants[{{ $index }}][status]"
                                                >
                                                    <option
                                                        value="1"
                                                        @selected((bool) ($variant['status'] ?? true))
                                                    >
                                                        Active
                                                    </option>

                                                    <option
                                                        value="0"
                                                        @selected(!(bool) ($variant['status'] ?? true))
                                                    >
                                                        Inactive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Variant Image --}}
                                        <div class="product-edit-page__variant-image-section">
                                            <div class="product-edit-page__variant-image-title">
                                                <div>
                                                    <strong>
                                                        Variant Image
                                                    </strong>

                                                    <span>
                                                        Use a specific image for this variant.
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="product-edit-page__variant-image">
                                                <div
                                                    class="product-edit-page__variant-image-preview"
                                                    data-variant-image-preview
                                                >
                                                    @if (!empty($variant['image']))
                                                        <img
                                                            src="{{ asset($variant['image']) }}"
                                                            alt="Variant image"
                                                            data-variant-image-preview-image
                                                        >
                                                    @else
                                                        <div class="product-edit-page__empty-image">
                                                            <i class="ri-image-add-line"></i>
                                                            <span>No image</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="product-edit-page__variant-image-content">
                                                    <div class="product-edit-page__variant-image-actions">
                                                        <label class="product-edit-page__upload-button">
                                                            <i class="ri-upload-2-line"></i>
                                                            <span>Choose Image</span>

                                                            <input
                                                                type="file"
                                                                name="variants[{{ $index }}][image]"
                                                                accept="image/*"
                                                                hidden
                                                                data-variant-image-input
                                                            >
                                                        </label>

                                                        <button
                                                            type="button"
                                                            class="product-edit-page__image-remove-button"
                                                            data-remove-variant-image
                                                            @disabled(empty($variant['image']))
                                                        >
                                                            <i class="ri-delete-bin-line"></i>
                                                            <span>Remove</span>
                                                        </button>
                                                    </div>

                                                    <input
                                                        type="hidden"
                                                        name="variants[{{ $index }}][remove_image]"
                                                        value="0"
                                                        data-variant-remove-image
                                                    >

                                                    <p>
                                                        Recommended image size: 800×800px.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="product-edit-page__empty-variants"
                                data-empty-variants
                                @if (count($variantData) > 0) hidden @endif
                            >
                                <i class="ri-git-branch-line"></i>

                                <strong>
                                    No variants yet
                                </strong>

                                <p>
                                    Select options and click Generate Variants.
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- SEO --}}
                    <section class="product-edit-page__card">
                        <div class="product-edit-page__card-header">
                            <div>
                                <h2>SEO</h2>
                                <p>Optimize this product for search engines.</p>
                            </div>

                            <span class="product-edit-page__card-icon">
                                <i class="ri-search-eye-line"></i>
                            </span>
                        </div>

                        <div class="product-edit-page__card-body">
                            <div class="product-edit-page__field">
                                <div class="product-edit-page__field-label-row">
                                    <label for="meta_title">
                                        Meta Title
                                    </label>

                                    <span data-meta-title-count>
                                        0 / 60
                                    </span>
                                </div>

                                <input
                                    type="text"
                                    id="meta_title"
                                    name="meta_title"
                                    value="{{ old('meta_title', $product->meta_title) }}"
                                    maxlength="60"
                                    data-meta-title
                                    placeholder="SEO title"
                                >
                            </div>

                            <div class="product-edit-page__field">
                                <div class="product-edit-page__field-label-row">
                                    <label for="meta_description">
                                        Meta Description
                                    </label>

                                    <span data-meta-description-count>
                                        0 / 160
                                    </span>
                                </div>

                                <textarea
                                    id="meta_description"
                                    name="meta_description"
                                    rows="4"
                                    maxlength="160"
                                    data-meta-description
                                    placeholder="SEO description"
                                >{{ old('meta_description', $product->meta_description) }}</textarea>
                            </div>
                        </div>
                    </section>
                </main>

                {{-- Sidebar --}}
                <aside class="product-edit-page__sidebar">

                    {{-- Publish --}}
                    <section class="product-edit-page__card">
                        <div class="product-edit-page__card-header">
                            <div>
                                <h2>Publish</h2>
                                <p>Product visibility settings.</p>
                            </div>
                        </div>

                        <div class="product-edit-page__card-body">
                            <label class="product-edit-page__switch">
                                <span>
                                    <strong>Status</strong>
                                    <small>Make product visible</small>
                                </span>

                                <input
                                    type="hidden"
                                    name="status"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    @checked(old('status', $product->status))
                                >

                                <span class="product-edit-page__switch-slider"></span>
                            </label>

                            <label class="product-edit-page__switch">
                                <span>
                                    <strong>Featured</strong>
                                    <small>Show as featured product</small>
                                </span>

                                <input
                                    type="hidden"
                                    name="featured"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                    @checked(old('featured', $product->featured))
                                >

                                <span class="product-edit-page__switch-slider"></span>
                            </label>
                        </div>
                    </section>

                    {{-- Product Checklist --}}
                    <section class="product-edit-page__card">
                        <div class="product-edit-page__card-header">
                            <div>
                                <h2>Product Checklist</h2>
                                <p>Quick overview before updating.</p>
                            </div>
                        </div>

                        <div class="product-edit-page__card-body">
                            <div class="product-edit-page__checklist">
                                <div class="product-edit-page__checklist-item">
                                    <i class="ri-checkbox-circle-line"></i>
                                    <span>Product information</span>
                                </div>

                                <div class="product-edit-page__checklist-item">
                                    <i class="ri-checkbox-circle-line"></i>
                                    <span>Pricing</span>
                                </div>

                                <div class="product-edit-page__checklist-item">
                                    <i class="ri-checkbox-circle-line"></i>
                                    <span>Categories</span>
                                </div>

                                <div class="product-edit-page__checklist-item">
                                    <i class="ri-checkbox-circle-line"></i>
                                    <span>Media</span>
                                </div>

                                <div class="product-edit-page__checklist-item">
                                    <i class="ri-checkbox-circle-line"></i>
                                    <span>Variants</span>
                                </div>

                                <div class="product-edit-page__checklist-item">
                                    <i class="ri-checkbox-circle-line"></i>
                                    <span>SEO</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Actions --}}
                    <div class="product-edit-page__danger-zone">
                        <a
                            href="{{ route('admin-products') }}"
                            class="product-edit-page__btn product-edit-page__btn--light"
                        >
                            <i class="ri-close-line"></i>
                            <span>Cancel</span>
                        </a>

                        <button
                            type="submit"
                            class="product-edit-page__btn product-edit-page__btn--primary product-edit-page__btn--full"
                        >
                            <i class="ri-save-line"></i>
                            <span>Update Product</span>
                        </button>
                    </div>
                </aside>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector('.product-edit-page');

            if (!page) {
                return;
            }

            const form = page.querySelector('#product-edit-form');

            /*
             * HTML Escape.
             */
            const escapeHtml = (value) => {
                const div = document.createElement('div');

                div.textContent = value ?? '';

                return div.innerHTML;
            };

            /*
             * Slugify.
             */
            const slugify = (value) => {
                return value
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            };

            const nameInput = page.querySelector(
                '[data-product-name]'
            );

            const slugInput = page.querySelector(
                '[data-product-slug]'
            );

            let slugManuallyChanged = false;

            slugInput?.addEventListener('input', () => {
                slugManuallyChanged = true;
            });

            nameInput?.addEventListener('input', () => {
                if (!slugManuallyChanged && slugInput) {
                    slugInput.value = slugify(nameInput.value);
                }
            });

            /*
             * Quill 2 Rich Text Editors.
             *
             * Short Description + Product Description.
             */
            const quillToolbar = [
                [
                    {
                        header: [2, 3, false]
                    }
                ],

                [
                    'bold',
                    'italic',
                    'underline',
                    'strike'
                ],

                [
                    {
                        color: []
                    },
                    {
                        background: []
                    }
                ],

                [
                    {
                        list: 'ordered'
                    },
                    {
                        list: 'bullet'
                    }
                ],

                [
                    {
                        align: []
                    }
                ],

                [
                    'blockquote',
                    'code-block'
                ],

                [
                    'link',
                ],

                [
                    'clean'
                ]
            ];

            const quillEditors = [];

            /*
             * Initialize Quill Editor.
             */
            const initQuillEditor = (editorElement) => {
                if (
                    !editorElement ||
                    typeof window.Quill === 'undefined'
                ) {
                    return null;
                }

                const sourceTextarea =
                    editorElement.parentElement?.querySelector(
                        '[data-quill-source]'
                    );

                if (!sourceTextarea) {
                    return null;
                }

                const quill = new window.Quill(
                    editorElement,
                    {
                        theme: 'snow',

                        modules: {
                            toolbar: quillToolbar
                        },

                        placeholder:
                            editorElement.dataset.placeholder ?? ''
                    }
                );

                /*
                 * Load existing HTML content.
                 */
                const initialValue =
                    sourceTextarea.value?.trim() ?? '';

                if (initialValue) {
                    quill.clipboard.dangerouslyPasteHTML(
                        initialValue
                    );
                }

                /*
                 * Sync Quill HTML to textarea.
                 */
                const syncQuill = () => {
                    const html =
                        quill.root.innerHTML.trim();

                    sourceTextarea.value =
                        html === '<p><br></p>'
                            ? ''
                            : html;
                };

                quill.on(
                    'text-change',
                    syncQuill
                );

                /*
                 * Initial sync.
                 */
                syncQuill();

                quillEditors.push({
                    quill,
                    sourceTextarea
                });

                return quill;
            };

            /*
             * Initialize all Quill editors.
             */
            page.querySelectorAll(
                '[data-quill-editor]'
            ).forEach(
                initQuillEditor
            );

            /*
             * Thumbnail Preview.
             */
            const thumbnailInput = page.querySelector(
                '[data-thumbnail-input]'
            );

            const thumbnailPreview = page.querySelector(
                '[data-thumbnail-preview]'
            );

            thumbnailInput?.addEventListener('change', () => {
                const [file] = thumbnailInput.files;

                if (!file || !thumbnailPreview) {
                    return;
                }

                const reader = new FileReader();

                reader.onload = (event) => {
                    thumbnailPreview.innerHTML = `
                        <img
                            src="${event.target.result}"
                            alt="Thumbnail preview"
                            data-thumbnail-preview-image
                        >
                    `;
                };

                reader.readAsDataURL(file);
            });

            /*
             * Gallery Preview.
             */
            const galleryInput = page.querySelector(
                '[data-gallery-input]'
            );

            const galleryPreview = page.querySelector(
                '[data-gallery-preview]'
            );

            galleryInput?.addEventListener('change', () => {
                const files = Array.from(
                    galleryInput.files ?? []
                );

                files.forEach((file) => {
                    const reader = new FileReader();

                    reader.onload = (event) => {
                        const item =
                            document.createElement('div');

                        item.className =
                            'product-edit-page__gallery-item product-edit-page__gallery-item--new';

                        item.innerHTML = `
                            <img
                                src="${event.target.result}"
                                alt="Gallery preview"
                            >

                            <button
                                type="button"
                                data-remove-new-gallery
                                aria-label="Remove image"
                            >
                                <i class="ri-close-line"></i>
                            </button>
                        `;

                        galleryPreview?.appendChild(item);

                        item.querySelector(
                            '[data-remove-new-gallery]'
                        )?.addEventListener(
                            'click',
                            () => {
                                item.remove();
                            }
                        );
                    };

                    reader.readAsDataURL(file);
                });
            });

            /*
             * Existing Gallery Image Removal.
             */
            page.querySelectorAll(
                '[data-remove-existing-gallery]'
            ).forEach((button) => {
                button.addEventListener(
                    'click',
                    () => {
                        const item =
                            button.closest(
                                '[data-existing-gallery-item]'
                            );

                        const input =
                            item?.querySelector(
                                '[data-remove-gallery-input]'
                            );

                        if (!item || !input) {
                            return;
                        }

                        input.value =
                            item.dataset.imageId ?? '';

                        item.classList.add(
                            'is-removed'
                        );
                    }
                );
            });

            /*
             * Attribute Toggles.
             */
            page.querySelectorAll(
                '[data-attribute-toggle]'
            ).forEach((toggle) => {
                toggle.addEventListener(
                    'change',
                    () => {
                        const card =
                            toggle.closest(
                                '[data-attribute-card]'
                            );

                        if (!card) {
                            return;
                        }

                        card.querySelectorAll(
                            '[data-attribute-value]'
                        ).forEach((input) => {
                            input.disabled =
                                !toggle.checked;
                        });
                    }
                );
            });

            /*
             * Selected Attributes.
             */
            const getSelectedAttributes = () => {
                return Array.from(
                    page.querySelectorAll(
                        '[data-attribute-card]'
                    )
                )
                    .filter((card) => {
                        return card.querySelector(
                            '[data-attribute-toggle]:checked'
                        );
                    })
                    .map((card) => {
                        const attributeId =
                            card.dataset.attributeId;

                        const toggle =
                            card.querySelector(
                                '[data-attribute-toggle]'
                            );

                        const values =
                            Array.from(
                                card.querySelectorAll(
                                    '[data-attribute-value]:checked'
                                )
                            ).map((input) => ({
                                id: input.value,

                                label:
                                    input.dataset.valueLabel ?? '',

                                attributeId,

                                attributeName:
                                    input.dataset.attributeName ?? '',
                            }));

                        return {
                            id: attributeId,

                            name:
                                toggle
                                    ?.closest('label')
                                    ?.querySelector('strong')
                                    ?.textContent
                                    ?.trim() ?? '',

                            values,
                        };
                    })
                    .filter(
                        (attribute) =>
                            attribute.values.length > 0
                    );
            };

            /*
             * Cartesian Combinations.
             */
            const buildCombinations = (attributes) => {
                if (!attributes.length) {
                    return [];
                }

                return attributes.reduce(
                    (combinations, attribute) => {
                        if (!combinations.length) {
                            return attribute.values.map(
                                (value) => [value]
                            );
                        }

                        return combinations.flatMap(
                            (combination) => {
                                return attribute.values.map(
                                    (value) => [
                                        ...combination,
                                        value,
                                    ]
                                );
                            }
                        );
                    },
                    []
                );
            };

            /*
             * Existing Variant Map.
             */
            const getExistingVariantMap = () => {
                const map = new Map();

                page.querySelectorAll(
                    '[data-variant-row]'
                ).forEach((row) => {
                    const values = Array.from(
                        row.querySelectorAll(
                            '[data-variant-value]'
                        )
                    )
                        .map(
                            (input) =>
                                `${input.dataset.attributeId}:${input.dataset.valueId}`
                        )
                        .sort()
                        .join('|');

                    if (values) {
                        map.set(
                            values,
                            row
                        );
                    }
                });

                return map;
            };

            /*
             * Variant Image Handler.
             */
            const handleVariantImage = (row) => {
                const input = row.querySelector(
                    '[data-variant-image-input]'
                );

                const preview = row.querySelector(
                    '[data-variant-image-preview]'
                );

                const removeButton = row.querySelector(
                    '[data-remove-variant-image]'
                );

                const removeInput = row.querySelector(
                    '[data-variant-remove-image]'
                );

                if (!input || !preview) {
                    return;
                }

                input.addEventListener(
                    'change',
                    () => {
                        const [file] = input.files;

                        if (!file) {
                            return;
                        }

                        const reader =
                            new FileReader();

                        reader.onload = (event) => {
                            preview.innerHTML = `
                                <img
                                    src="${event.target.result}"
                                    alt="Variant image preview"
                                    data-variant-image-preview-image
                                >
                            `;

                            if (removeInput) {
                                removeInput.value = '0';
                            }

                            if (removeButton) {
                                removeButton.disabled =
                                    false;
                            }
                        };

                        reader.readAsDataURL(file);
                    }
                );

                removeButton?.addEventListener(
                    'click',
                    () => {
                        input.value = '';

                        preview.innerHTML = `
                            <div class="product-edit-page__empty-image">
                                <i class="ri-image-add-line"></i>
                                <span>No image</span>
                            </div>
                        `;

                        if (removeInput) {
                            removeInput.value = '1';
                        }

                        removeButton.disabled = true;
                    }
                );
            };

            /*
             * Initialize Variant Image Handlers.
             */
            page.querySelectorAll(
                '[data-variant-row]'
            ).forEach(
                handleVariantImage
            );

            const variantsContainer =
                page.querySelector(
                    '[data-variants-container]'
                );

            const emptyVariants =
                page.querySelector(
                    '[data-empty-variants]'
                );

            const generateButton =
                page.querySelector(
                    '[data-generate-variants]'
                );

            /*
             * Create Variant Row.
             */
            const createVariantRow = (
                combination,
                index,
                existingRow = null
            ) => {
                const existingId =
                    existingRow?.querySelector(
                        '[data-variant-id-input]'
                    )?.value ?? '';

                const existingSku =
                    existingRow?.querySelector(
                        '[data-variant-sku]'
                    )?.value ?? '';

                const existingPrice =
                    existingRow?.querySelector(
                        'input[name$="[price]"]'
                    )?.value ?? '';

                const existingComparePrice =
                    existingRow?.querySelector(
                        'input[name$="[compare_price]"]'
                    )?.value ?? '';

                const existingStock =
                    existingRow?.querySelector(
                        'input[name$="[stock]"]'
                    )?.value ?? '0';

                const existingStatus =
                    existingRow?.querySelector(
                        'select[name$="[status]"]'
                    )?.value ?? '1';

                const existingImage =
                    existingRow?.querySelector(
                        '[data-variant-image-preview-image]'
                    )?.getAttribute('src') ?? '';

                const existingRemoveImage =
                    existingRow?.querySelector(
                        '[data-variant-remove-image]'
                    )?.value ?? '0';

                const label =
                    combination
                        .map(
                            (item) =>
                                `${item.attributeName}: ${item.label}`
                        )
                        .join(' / ');

                const valueInputs =
                    combination
                        .map(
                            (item) => `
                                <input
                                    type="hidden"
                                    name="variants[${index}][values][${item.attributeId}]"
                                    value="${escapeHtml(item.id)}"
                                    data-variant-value
                                    data-attribute-id="${escapeHtml(item.attributeId)}"
                                    data-value-id="${escapeHtml(item.id)}"
                                >
                            `
                        )
                        .join('');

                const valueBadges =
                    combination
                        .map(
                            (item) => `
                                <span class="product-edit-page__variant-value">
                                    <strong>
                                        ${escapeHtml(item.attributeName)}:
                                    </strong>
                                    ${escapeHtml(item.label)}
                                </span>
                            `
                        )
                        .join('');

                const imageMarkup =
                    existingImage
                        ? `
                            <img
                                src="${escapeHtml(existingImage)}"
                                alt="Variant image"
                                data-variant-image-preview-image
                            >
                        `
                        : `
                            <div class="product-edit-page__empty-image">
                                <i class="ri-image-add-line"></i>
                                <span>No image</span>
                            </div>
                        `;

                const row =
                    document.createElement('div');

                row.className =
                    'product-edit-page__variant-row';

                row.dataset.variantRow = '';
                row.dataset.variantId =
                    existingId;

                row.innerHTML = `
                    <div class="product-edit-page__variant-heading">
                        <div>
                            <span class="product-edit-page__variant-number">
                                ${index + 1}
                            </span>

                            <div>
                                <strong data-variant-label>
                                    ${escapeHtml(label)}
                                </strong>

                                <small>
                                    ${escapeHtml(
                    existingSku ||
                    'New variant'
                )}
                                </small>
                            </div>
                        </div>

                        <button
                            type="button"
                            class="product-edit-page__remove-variant"
                            data-remove-variant
                        >
                            <i class="ri-delete-bin-line"></i>
                            <span>Remove</span>
                        </button>
                    </div>

                    <input
                        type="hidden"
                        name="variants[${index}][id]"
                        value="${escapeHtml(existingId)}"
                        data-variant-id-input
                    >

                    ${valueInputs}

                    <div class="product-edit-page__variant-values">
                        ${valueBadges}
                    </div>

                    <div class="product-edit-page__variant-grid">
                        <div class="product-edit-page__field">
                            <label>
                                SKU
                            </label>

                            <input
                                type="text"
                                name="variants[${index}][sku]"
                                value="${escapeHtml(existingSku)}"
                                placeholder="Variant SKU"
                                data-variant-sku
                            >
                        </div>

                        <div class="product-edit-page__field">
                            <label>
                                Price
                            </label>

                            <div class="product-edit-page__price-input">
                                <span>$</span>

                                <input
                                    type="number"
                                    name="variants[${index}][price]"
                                    value="${escapeHtml(existingPrice)}"
                                    step="0.01"
                                    min="0"
                                    placeholder="0.00"
                                >
                            </div>
                        </div>

                        <div class="product-edit-page__field">
                            <label>
                                Compare Price
                            </label>

                            <div class="product-edit-page__price-input">
                                <span>$</span>

                                <input
                                    type="number"
                                    name="variants[${index}][compare_price]"
                                    value="${escapeHtml(existingComparePrice)}"
                                    step="0.01"
                                    min="0"
                                    placeholder="0.00"
                                >
                            </div>
                        </div>

                        <div class="product-edit-page__field">
                            <label>
                                Stock
                            </label>

                            <input
                                type="number"
                                name="variants[${index}][stock]"
                                value="${escapeHtml(existingStock)}"
                                min="0"
                                placeholder="0"
                            >
                        </div>

                        <div class="product-edit-page__field">
                            <label>
                                Status
                            </label>

                            <select
                                name="variants[${index}][status]"
                            >
                                <option
                                    value="1"
                                    ${existingStatus === '1' ? 'selected' : ''}
                                >
                                    Active
                                </option>

                                <option
                                    value="0"
                                    ${existingStatus === '0' ? 'selected' : ''}
                                >
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="product-edit-page__variant-image-section">
                        <div class="product-edit-page__variant-image-title">
                            <div>
                                <strong>
                                    Variant Image
                                </strong>

                                <span>
                                    Use a specific image for this variant.
                                </span>
                            </div>
                        </div>

                        <div class="product-edit-page__variant-image">
                            <div
                                class="product-edit-page__variant-image-preview"
                                data-variant-image-preview
                            >
                                ${imageMarkup}
                            </div>

                            <div class="product-edit-page__variant-image-content">
                                <div class="product-edit-page__variant-image-actions">
                                    <label class="product-edit-page__upload-button">
                                        <i class="ri-upload-2-line"></i>
                                        <span>Choose Image</span>

                                        <input
                                            type="file"
                                            name="variants[${index}][image]"
                                            accept="image/*"
                                            hidden
                                            data-variant-image-input
                                        >
                                    </label>

                                    <button
                                        type="button"
                                        class="product-edit-page__image-remove-button"
                                        data-remove-variant-image
                                        ${existingImage ? '' : 'disabled'}
                                    >
                                        <i class="ri-delete-bin-line"></i>
                                        <span>Remove</span>
                                    </button>
                                </div>

                                <input
                                    type="hidden"
                                    name="variants[${index}][remove_image]"
                                    value="${escapeHtml(existingRemoveImage)}"
                                    data-variant-remove-image
                                >

                                <p>
                                    Recommended image size: 800×800px.
                                </p>
                            </div>
                        </div>
                    </div>
                `;

                handleVariantImage(row);

                row.querySelector(
                    '[data-remove-variant]'
                )?.addEventListener(
                    'click',
                    () => {
                        row.remove();

                        reindexVariants();
                    }
                );

                return row;
            };

            /*
             * Re-index Variant Inputs.
             */
            const reindexVariants = () => {
                variantsContainer
                    ?.querySelectorAll(
                        '[data-variant-row]'
                    )
                    .forEach(
                        (row, index) => {
                            const number =
                                row.querySelector(
                                    '.product-edit-page__variant-number'
                                );

                            if (number) {
                                number.textContent =
                                    index + 1;
                            }

                            row.querySelectorAll(
                                '[name]'
                            ).forEach(
                                (input) => {
                                    input.name =
                                        input.name.replace(
                                            /variants\[\d+\]/,
                                            `variants[${index}]`
                                        );
                                }
                            );
                        }
                    );

                if (emptyVariants) {
                    emptyVariants.hidden =
                        (
                            variantsContainer
                                ?.querySelectorAll(
                                    '[data-variant-row]'
                                ).length ?? 0
                        ) > 0;
                }
            };

            /*
             * Initial Variant Removal.
             */
            page.querySelectorAll(
                '[data-remove-variant]'
            ).forEach((button) => {
                button.addEventListener(
                    'click',
                    () => {
                        button
                            .closest(
                                '[data-variant-row]'
                            )
                            ?.remove();

                        reindexVariants();
                    }
                );
            });

            /*
             * Generate Variants.
             */
            generateButton?.addEventListener(
                'click',
                () => {
                    const attributes =
                        getSelectedAttributes();

                    if (!attributes.length) {
                        alert(
                            'Please select at least one attribute and value.'
                        );

                        return;
                    }

                    const combinations =
                        buildCombinations(
                            attributes
                        );

                    const existingVariantMap =
                        getExistingVariantMap();

                    if (variantsContainer) {
                        variantsContainer.innerHTML =
                            '';
                    }

                    combinations.forEach(
                        (
                            combination,
                            index
                        ) => {
                            const key =
                                combination
                                    .map(
                                        (item) =>
                                            `${item.attributeId}:${item.id}`
                                    )
                                    .sort()
                                    .join('|');

                            const existingRow =
                                existingVariantMap.get(
                                    key
                                );

                            const row =
                                createVariantRow(
                                    combination,
                                    index,
                                    existingRow
                                );

                            variantsContainer?.appendChild(
                                row
                            );
                        }
                    );

                    reindexVariants();
                }
            );

            /*
             * SEO Counters.
             */
            const metaTitle =
                page.querySelector(
                    '[data-meta-title]'
                );

            const metaTitleCount =
                page.querySelector(
                    '[data-meta-title-count]'
                );

            const metaDescription =
                page.querySelector(
                    '[data-meta-description]'
                );

            const metaDescriptionCount =
                page.querySelector(
                    '[data-meta-description-count]'
                );

            const updateCounter = (
                input,
                counter,
                max
            ) => {
                if (!input || !counter) {
                    return;
                }

                counter.textContent =
                    `${input.value.length} / ${max}`;
            };

            const updateSeoCounters = () => {
                updateCounter(
                    metaTitle,
                    metaTitleCount,
                    60
                );

                updateCounter(
                    metaDescription,
                    metaDescriptionCount,
                    160
                );
            };

            metaTitle?.addEventListener(
                'input',
                updateSeoCounters
            );

            metaDescription?.addEventListener(
                'input',
                updateSeoCounters
            );

            updateSeoCounters();

            /*
             * Form Submit.
             *
             * Sync all Quill editors before submit.
             */
            form?.addEventListener(
                'submit',
                (event) => {
                    quillEditors.forEach(
                        ({
                             quill,
                             sourceTextarea
                         }) => {
                            const html =
                                quill.root.innerHTML.trim();

                            sourceTextarea.value =
                                html === '<p><br></p>'
                                    ? ''
                                    : html;
                        }
                    );

                    /*
                     * Validate variants.
                     */
                    const rows =
                        Array.from(
                            variantsContainer
                                ?.querySelectorAll(
                                    '[data-variant-row]'
                                ) ?? []
                        );

                    for (const row of rows) {
                        const valueInputs =
                            Array.from(
                                row.querySelectorAll(
                                    'input[data-variant-value]'
                                )
                            ).filter(
                                (input) => {
                                    return (
                                        input.value.trim() !== '' &&
                                        input.dataset.attributeId &&
                                        input.dataset.valueId
                                    );
                                }
                            );

                        if (!valueInputs.length) {
                            event.preventDefault();

                            alert(
                                'Each variant must have attribute values.'
                            );

                            return;
                        }
                    }
                }
            );

            /*
             * Initial Setup.
             */
            reindexVariants();
        });
    </script>
@endpush
