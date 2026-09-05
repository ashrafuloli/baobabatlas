@extends('frontend.layouts.frontend')

@section('title', $product->meta_title ?: $product->name)

@section('contents')

    @php
        $resolveImage = static function ($path): string {
            if (blank($path)) {
                return '';
            }

            $path = trim((string) $path);

            if (
                str_starts_with($path, 'http://') ||
                str_starts_with($path, 'https://') ||
                str_starts_with($path, '//')
            ) {
                return $path;
            }

            if (str_starts_with($path, '/')) {
                return url($path);
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            if (str_starts_with($path, 'assets/')) {
                return asset($path);
            }

            if (str_starts_with($path, 'uploads/')) {
                return asset($path);
            }

            return asset(ltrim($path, '/'));
        };

        $productName = $product->name;

        /*
        |--------------------------------------------------------------------------
        | Product-level images
        |--------------------------------------------------------------------------
        */

        $productGallery = $product->images
            ->filter(
                static fn ($image): bool => empty($image->variant_id)
            )
            ->map(
                static function ($image) use ($resolveImage, $productName): array {
                    return [
                        'url' => $resolveImage($image->image),
                        'alt' => $image->alt_text ?: $productName,
                        'sort_order' => (int) $image->sort_order,
                        'is_primary' => (bool) $image->is_primary,
                    ];
                }
            )
            ->filter(
                static fn (array $image): bool => filled($image['url'])
            )
            ->sortBy([
                ['is_primary', 'desc'],
                ['sort_order', 'asc'],
            ])
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Active variants
        |--------------------------------------------------------------------------
        */

        $activeVariants = $product->variants
            ->filter(
                static fn ($variant): bool => (bool) $variant->status
            )
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Attributes
        |--------------------------------------------------------------------------
        */

        $attributes = collect();

        foreach ($activeVariants as $variant) {
            foreach ($variant->values as $variantValue) {
                $attribute = $variantValue->attribute;
                $attributeValue = $variantValue->attributeValue;

                if (
                    !$attribute ||
                    !$attributeValue ||
                    !$attribute->status ||
                    !$attributeValue->status
                ) {
                    continue;
                }

                $attributeId = (int) $attribute->id;
                $attributeValueId = (int) $attributeValue->id;

                if (!$attributes->has($attributeId)) {
                    $attributes->put(
                        $attributeId,
                        [
                            'id' => $attributeId,
                            'name' => $attribute->name,
                            'slug' => $attribute->slug,
                            'sort_order' => (int) $attribute->sort_order,
                            'values' => collect(),
                        ]
                    );
                }

                $attributeData = $attributes->get($attributeId);

                if (!$attributeData['values']->has($attributeValueId)) {
                    $attributeData['values']->put(
                        $attributeValueId,
                        [
                            'id' => $attributeValueId,
                            'label' => $attributeValue->label,
                            'value' => $attributeValue->value,
                            'slug' => $attributeValue->slug,
                            'sort_order' => (int) $attributeValue->sort_order,
                        ]
                    );
                }

                $attributes->put(
                    $attributeId,
                    $attributeData
                );
            }
        }

        $attributes = $attributes
            ->sortBy('sort_order')
            ->map(
                static function (array $attribute): array {
                    $attribute['values'] = $attribute['values']
                        ->sortBy('sort_order')
                        ->values()
                        ->all();

                    return $attribute;
                }
            )
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Variant data
        |--------------------------------------------------------------------------
        */

        $variants = $activeVariants
            ->map(
                static function ($variant) use ($resolveImage, $productName): array {
                    $images = collect();

                    /*
                     * ProductVariant.image
                     */
                    if (filled($variant->image)) {
                        $url = $resolveImage($variant->image);

                        if (filled($url)) {
                            $images->push([
                                'url' => $url,
                                'alt' => $productName,
                                'sort_order' => -1,
                                'is_primary' => true,
                            ]);
                        }
                    }

                    /*
                     * ProductImage records attached to variant
                     */
                    foreach ($variant->images as $image) {
                        $url = $resolveImage($image->image);

                        if (blank($url)) {
                            continue;
                        }

                        $images->push([
                            'url' => $url,
                            'alt' => $image->alt_text ?: $productName,
                            'sort_order' => (int) $image->sort_order,
                            'is_primary' => (bool) $image->is_primary,
                        ]);
                    }

                    /*
                     * Remove duplicate image URLs and sort.
                     */
                    $images = $images
                        ->unique('url')
                        ->sortBy([
                            ['is_primary', 'desc'],
                            ['sort_order', 'asc'],
                        ])
                        ->values();

                    /*
                     * Variant attribute combination.
                     */
                    $variantAttributes = [];

                    foreach ($variant->values as $variantValue) {
                        if (
                            !$variantValue->attribute ||
                            !$variantValue->attributeValue ||
                            !$variantValue->attribute->status ||
                            !$variantValue->attributeValue->status
                        ) {
                            continue;
                        }

                        $variantAttributes[
                            (string) $variantValue->attribute_id
                        ] = (int) $variantValue->attribute_value_id;
                    }

                    return [
                        'id' => (int) $variant->id,

                        'sku' => $variant->sku,

                        'price' => $variant->price !== null
                            ? (float) $variant->price
                            : null,

                        'compare_price' => $variant->compare_price !== null
                            ? (float) $variant->compare_price
                            : null,

                        'stock' => $variant->stock !== null
                            ? (int) $variant->stock
                            : 0,

                        'image' => filled($variant->image)
                            ? $resolveImage($variant->image)
                            : '',

                        'images' => $images->all(),

                        'attributes' => $variantAttributes,
                    ];
                }
            )
            ->values();

        $initialVariant = $variants->first();

        $initialSelections = $initialVariant['attributes'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | Initial main image
        |--------------------------------------------------------------------------
        */

        $initialGallery = collect();

        if ($initialVariant && !empty($initialVariant['images'])) {
            $initialGallery = collect(
                $initialVariant['images']
            );
        }

        if ($initialGallery->isEmpty() && $productGallery->isNotEmpty()) {
            $initialGallery = $productGallery;
        }

        if (
            $initialGallery->isEmpty() &&
            filled($product->thumbnail)
        ) {
            $thumbnailUrl = $resolveImage(
                $product->thumbnail
            );

            if (filled($thumbnailUrl)) {
                $initialGallery = collect([
                    [
                        'url' => $thumbnailUrl,
                        'alt' => $productName,
                    ],
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Related image helper
        |--------------------------------------------------------------------------
        */

        $getRelatedImage = static function ($relatedProduct) use ($resolveImage): string {
            $image = $relatedProduct->images
                ->first(
                    static fn ($image): bool => empty($image->variant_id)
                );

            if ($image && filled($image->image)) {
                return $resolveImage($image->image);
            }

            if (filled($relatedProduct->thumbnail)) {
                return $resolveImage(
                    $relatedProduct->thumbnail
                );
            }

            return '';
        };
    @endphp

    <div class="product-details-page">

        {{-- ================================================================
            Breadcrumb
        ================================================================== --}}

        <div class="product-details-breadcrumb">
            <div class="container">

                <div class="product-breadcrumb-list">

                    <a href="{{ url('/') }}">
                        Home
                    </a>

                    <i class="ri-arrow-right-s-line"></i>

                    <a href="{{ route('shop') }}">
                        Shop
                    </a>

                    @if($product->categories->isNotEmpty())
                        @php
                            $category = $product->categories->first();
                        @endphp

                        <i class="ri-arrow-right-s-line"></i>

                        <a href="{{ route('shop', ['category' => $category->slug]) }}">
                            {{ $category->name }}
                        </a>
                    @endif

                    <i class="ri-arrow-right-s-line"></i>

                    <span>
                        {{ $product->name }}
                    </span>

                </div>

            </div>
        </div>


        {{-- ================================================================
            Product Details
        ================================================================== --}}

        <section class="product-details-section">

            <div class="container">

                <div class="product-details-wrapper">

                    {{-- ====================================================
                        Gallery
                    ===================================================== --}}

                    <div class="product-gallery">

                        <div
                            class="product-gallery-thumbnails"
                            data-gallery-thumbnails
                        >
                            {{-- JavaScript renders ALL variant images here --}}
                        </div>


                        <div class="product-main-image">

                            @if(
                                $initialComparePrice =
                                    $initialVariant['compare_price']
                                    ?? $product->compare_price
                            )
                                @if(
                                    $initialComparePrice >
                                    ($initialVariant['price'] ?? $product->price)
                                )
                                    <span class="product-sale-tag">
                                        Sale
                                    </span>
                                @endif
                            @endif


                            @if($initialGallery->isNotEmpty())

                                <img
                                    class="product-main-image-element"
                                    src="{{ $initialGallery->first()['url'] }}"
                                    alt="{{ $initialGallery->first()['alt'] ?? $product->name }}"
                                >

                            @else

                                <img
                                    class="product-main-image-element"
                                    src=""
                                    alt="{{ $product->name }}"
                                    hidden
                                >

                                <div class="product-image-placeholder">
                                    <i class="ri-image-line"></i>
                                </div>

                            @endif


                            <button
                                type="button"
                                class="product-image-zoom"
                                data-image-zoom
                                aria-label="Zoom product image"
                            >
                                <i class="ri-search-line"></i>
                            </button>

                        </div>

                    </div>


                    {{-- ====================================================
                        Information
                    ===================================================== --}}

                    <div class="product-information">

                        @if($product->categories->isNotEmpty())

                            <div class="product-category">
                                {{ $product->categories->first()->name }}
                            </div>

                        @endif


                        <h1>
                            {{ $product->name }}
                        </h1>


                        <div class="product-brand-row">

                            @if($product->brand)

                                <span class="product-brand">
                                    {{ $product->brand->name }}
                                </span>

                            @endif


                            @if($product->sku)

                                <span class="product-sku">
                                    SKU: {{ $initialVariant['sku'] ?? $product->sku }}
                                </span>

                            @endif

                        </div>


                        {{-- =================================================
                            Price
                        ================================================== --}}

                        <div class="product-price-wrapper">

                            <span
                                class="product-current-price"
                                data-product-price
                            >
                                ${{ number_format(
                                    $initialVariant['price'] ?? $product->price,
                                    2
                                ) }}
                            </span>


                            @php
                                $initialComparePrice =
                                    $initialVariant['compare_price']
                                    ?? $product->compare_price;

                                $initialCurrentPrice =
                                    $initialVariant['price']
                                    ?? $product->price;
                            @endphp


                            <span
                                class="product-compare-price"
                                data-product-compare-price
                                @if(
                                    !$initialComparePrice ||
                                    $initialComparePrice <= $initialCurrentPrice
                                )
                                    hidden
                                @endif
                            >
                                ${{ number_format(
                                    $initialComparePrice ?? 0,
                                    2
                                ) }}
                            </span>


                            <span
                                class="product-discount"
                                data-product-discount
                                @if(
                                    !$initialComparePrice ||
                                    $initialComparePrice <= $initialCurrentPrice
                                )
                                    hidden
                                @endif
                            >
                                @if(
                                    $initialComparePrice &&
                                    $initialComparePrice > $initialCurrentPrice
                                )
                                    {{ round(
                                        (
                                            (
                                                $initialComparePrice -
                                                $initialCurrentPrice
                                            ) /
                                            $initialComparePrice
                                        ) * 100
                                    ) }}% OFF
                                @endif
                            </span>

                        </div>


                        @if($product->short_description)

                            <div class="product-short-description">
                                {{ $product->short_description }}
                            </div>

                        @endif


                        {{-- =================================================
                            Dynamic Options
                        ================================================== --}}

                        @if($attributes->isNotEmpty())

                            <div
                                class="product-options"
                                data-product-options
                            >

                                @foreach($attributes as $attribute)

                                    <div
                                        class="product-option-group"
                                        data-attribute-group
                                        data-attribute-id="{{ $attribute['id'] }}"
                                        data-attribute-name="{{ $attribute['name'] }}"
                                    >

                                        <div class="product-option-heading">

                                            <span class="product-option-name">
                                                {{ $attribute['name'] }}
                                            </span>

                                            <span
                                                class="product-option-selected"
                                                data-option-selected
                                            >
                                                Select {{ $attribute['name'] }}
                                            </span>

                                        </div>


                                        <div class="product-option-values">

                                            @foreach($attribute['values'] as $attributeValue)

                                                <button
                                                    type="button"
                                                    class="product-option-button"
                                                    data-option-value
                                                    data-attribute-id="{{ $attribute['id'] }}"
                                                    data-value-id="{{ $attributeValue['id'] }}"
                                                    aria-pressed="false"
                                                >
                                                    {{ $attributeValue['label'] }}
                                                </button>

                                            @endforeach

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @endif


                        {{-- =================================================
                            Stock
                        ================================================== --}}

                        <div
                            class="product-stock"
                            data-product-stock
                        >

                            @if($initialVariant)

                                @if($initialVariant['stock'] > 0)

                                    <i class="ri-checkbox-circle-line"></i>

                                    <span>
                                        In Stock
                                    </span>

                                    <small>
                                        {{ $initialVariant['stock'] }}
                                        available
                                    </small>

                                @else

                                    <i class="ri-close-circle-line"></i>

                                    <span>
                                        Out of Stock
                                    </span>

                                @endif

                            @endif

                        </div>


                        {{-- =================================================
                            Actions
                        ================================================== --}}

                        <div class="product-actions">

                            <div class="product-quantity-control">

                                <button
                                    type="button"
                                    data-quantity-decrease
                                    aria-label="Decrease quantity"
                                >
                                    <i class="ri-subtract-line"></i>
                                </button>


                                <input
                                    type="number"
                                    value="1"
                                    min="1"
                                    max="{{ max(1, $initialVariant['stock'] ?? 1) }}"
                                    data-product-quantity
                                    aria-label="Quantity"
                                >


                                <button
                                    type="button"
                                    data-quantity-increase
                                    aria-label="Increase quantity"
                                >
                                    <i class="ri-add-line"></i>
                                </button>

                            </div>


                            <button
                                type="button"
                                class="product-add-cart"
                                data-add-to-cart
                                @if($initialVariant && $initialVariant['stock'] <= 0)
                                    disabled
                                @endif
                            >

                                <i class="ri-shopping-bag-3-line"></i>

                                <span>
                                    Add to Cart
                                </span>

                            </button>


                            <button
                                type="button"
                                class="product-wishlist"
                                data-wishlist
                                aria-label="Add to wishlist"
                                aria-pressed="false"
                            >
                                <i class="ri-heart-line"></i>
                            </button>

                        </div>


                        {{-- =================================================
                            Benefits
                        ================================================== --}}

                        <div class="product-benefits">

                            <div class="product-benefit">

                                <i class="ri-truck-line"></i>

                                <div>

                                    <strong>
                                        Fast Delivery
                                    </strong>

                                    <span>
                                        Quick and reliable shipping
                                    </span>

                                </div>

                            </div>


                            <div class="product-benefit">

                                <i class="ri-refresh-line"></i>

                                <div>

                                    <strong>
                                        Easy Returns
                                    </strong>

                                    <span>
                                        Simple return experience
                                    </span>

                                </div>

                            </div>


                            <div class="product-benefit">

                                <i class="ri-shield-check-line"></i>

                                <div>

                                    <strong>
                                        Secure Shopping
                                    </strong>

                                    <span>
                                        Safe and secure checkout
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =========================================================
                    Product Information Tabs
                ========================================================== --}}

                <div class="product-information-tabs">

                    <div class="product-tabs-navigation">

                        <button
                            type="button"
                            class="product-tab-button is-active"
                            data-tab-button="description"
                        >
                            <i class="ri-file-text-line"></i>
                            Description
                        </button>


                        <button
                            type="button"
                            class="product-tab-button"
                            data-tab-button="specifications"
                        >
                            <i class="ri-list-check-2"></i>
                            Specifications
                        </button>

                    </div>


                    <div class="product-tabs-content">

                        {{-- Description --}}

                        <div
                            class="product-tab-panel is-active"
                            data-tab-panel="description"
                        >

                            @if($product->description)

                                <div class="product-description">
                                    {!! nl2br(e($product->description)) !!}
                                </div>

                            @else

                                <div class="product-empty-content">
                                    No description available.
                                </div>

                            @endif

                        </div>


                        {{-- Specifications --}}

                        <div
                            class="product-tab-panel"
                            data-tab-panel="specifications"
                        >

                            <div class="product-specifications">

                                @if($product->brand)

                                    <div class="product-specification-row">

                                        <span>
                                            Brand
                                        </span>

                                        <strong>
                                            {{ $product->brand->name }}
                                        </strong>

                                    </div>

                                @endif


                                <div class="product-specification-row">

                                    <span>
                                        SKU
                                    </span>

                                    <strong data-product-spec-sku>
                                        {{ $initialVariant['sku'] ?? $product->sku ?? '—' }}
                                    </strong>

                                </div>


                                @if($product->categories->isNotEmpty())

                                    <div class="product-specification-row">

                                        <span>
                                            Categories
                                        </span>

                                        <strong>
                                            {{ $product->categories->pluck('name')->implode(', ') }}
                                        </strong>

                                    </div>

                                @endif


                                @if($product->source)

                                    <div class="product-specification-row">

                                        <span>
                                            Source
                                        </span>

                                        <strong>
                                            {{ $product->source }}
                                        </strong>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ================================================================
            Related Products
        ================================================================== --}}

        @if($relatedProducts->isNotEmpty())

            <section class="related-products-section">

                <div class="container">

                    <div class="related-products-header">

                        <div>

                            <span>
                                You May Also Like
                            </span>

                            <h2>
                                Related Products
                            </h2>

                        </div>


                        <a href="{{ route('shop') }}">
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>


                    <div class="related-products-grid">

                        @foreach($relatedProducts as $relatedProduct)

                            @php
                                $relatedVariant = $relatedProduct->variants
                                    ->where('status', true)
                                    ->first();

                                $relatedPrice =
                                    $relatedVariant?->price
                                    ?? $relatedProduct->price;

                                $relatedComparePrice =
                                    $relatedVariant?->compare_price
                                    ?? $relatedProduct->compare_price;

                                $relatedImage =
                                    $getRelatedImage($relatedProduct);

                                $relatedSale =
                                    $relatedComparePrice &&
                                    $relatedPrice < $relatedComparePrice;
                            @endphp

                            <article class="related-product-card">

                                <div class="related-product-image">

                                    @if($relatedSale)

                                        <span class="related-product-sale">
                                            Sale
                                        </span>

                                    @endif


                                    @if($relatedProduct->featured)

                                        <span class="related-product-featured">
                                            Featured
                                        </span>

                                    @endif


                                    <button
                                        type="button"
                                        class="related-product-wishlist"
                                        data-related-wishlist
                                        aria-label="Add to wishlist"
                                    >
                                        <i class="ri-heart-line"></i>
                                    </button>


                                    <a
                                        href="{{ route('shop.details', $relatedProduct) }}"
                                        class="related-product-image-link"
                                    >

                                        @if($relatedImage)

                                            <img
                                                src="{{ $relatedImage }}"
                                                alt="{{ $relatedProduct->name }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <div class="related-product-placeholder">
                                                <i class="ri-image-line"></i>
                                            </div>

                                        @endif

                                    </a>

                                </div>


                                <div class="related-product-content">

                                    @if($relatedProduct->brand)

                                        <span class="related-product-brand">
                                            {{ $relatedProduct->brand->name }}
                                        </span>

                                    @endif


                                    <h3>

                                        <a href="{{ route('shop.details', $relatedProduct) }}">
                                            {{ $relatedProduct->name }}
                                        </a>

                                    </h3>


                                    <div class="related-product-price">

                                        <span>
                                            ${{ number_format($relatedPrice, 2) }}
                                        </span>

                                        @if($relatedSale)

                                            <del>
                                                ${{ number_format($relatedComparePrice, 2) }}
                                            </del>

                                        @endif

                                    </div>

                                </div>

                            </article>

                        @endforeach

                    </div>

                </div>

            </section>

        @endif


        {{-- ================================================================
            Image Lightbox
        ================================================================== --}}

        <div
            class="product-image-lightbox"
            data-image-lightbox
            hidden
        >

            <div
                class="product-image-lightbox-overlay"
                data-lightbox-close
            ></div>


            <div class="product-image-lightbox-content">

                <button
                    type="button"
                    class="product-image-lightbox-close"
                    data-lightbox-close
                    aria-label="Close image"
                >
                    <i class="ri-close-line"></i>
                </button>


                <img
                    src=""
                    alt="{{ $product->name }}"
                    data-lightbox-image
                >

            </div>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector(
                '.product-details-page'
            );

            if (!page) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Product Data
            |--------------------------------------------------------------------------
            */

            const productName = @json($product->name);

            const productPrice = Number(
                @json($product->price)
            );

            const productComparePrice = @json(
                $product->compare_price
            );

            const thumbnail = @json(
                filled($product->thumbnail)
                    ? $resolveImage($product->thumbnail)
                    : ''
            );

            const productGallery = @json(
                $productGallery->values()
            );

            const variants = @json(
                $variants->values()
            );

            const requiredAttributeIds = @json(
                $attributes
                    ->pluck('id')
                    ->map(
                        static fn ($id): int => (int) $id
                    )
                    ->values()
            );

            const initialSelections = @json(
                $initialSelections
            );


            /*
            |--------------------------------------------------------------------------
            | DOM
            |--------------------------------------------------------------------------
            */

            const galleryThumbnails = page.querySelector(
                '[data-gallery-thumbnails]'
            );

            const mainImage = page.querySelector(
                '.product-main-image-element'
            );

            const imagePlaceholder = page.querySelector(
                '.product-image-placeholder'
            );

            const priceElement = page.querySelector(
                '[data-product-price]'
            );

            const comparePriceElement = page.querySelector(
                '[data-product-compare-price]'
            );

            const discountElement = page.querySelector(
                '[data-product-discount]'
            );

            const stockElement = page.querySelector(
                '[data-product-stock]'
            );

            const skuElement = page.querySelector(
                '.product-sku'
            );

            const specificationSkuElement = page.querySelector(
                '[data-product-spec-sku]'
            );

            const quantityInput = page.querySelector(
                '[data-product-quantity]'
            );

            const quantityDecrease = page.querySelector(
                '[data-quantity-decrease]'
            );

            const quantityIncrease = page.querySelector(
                '[data-quantity-increase]'
            );

            const addToCartButton = page.querySelector(
                '[data-add-to-cart]'
            );

            const wishlistButton = page.querySelector(
                '[data-wishlist]'
            );


            /*
            |--------------------------------------------------------------------------
            | State
            |--------------------------------------------------------------------------
            */

            let selectedAttributes = {
                ...initialSelections,
            };

            let selectedVariant =
                variants[0] || null;


            /*
            |--------------------------------------------------------------------------
            | Price Formatting
            |--------------------------------------------------------------------------
            */

            function formatPrice(value) {
                const number = Number(value);

                if (!Number.isFinite(number)) {
                    return '$0.00';
                }

                return `$${new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }).format(number)}`;
            }


            /*
            |--------------------------------------------------------------------------
            | Image URL
            |--------------------------------------------------------------------------
            */

            function normalizeImageUrl(url) {
                if (!url) {
                    return '';
                }

                return String(url).trim();
            }


            /*
            |--------------------------------------------------------------------------
            | Complete Selection
            |--------------------------------------------------------------------------
            */

            function hasCompleteSelection() {
                return requiredAttributeIds.every(
                    (attributeId) => {
                        const key = String(attributeId);

                        return (
                            selectedAttributes[key] !== undefined &&
                            selectedAttributes[key] !== null &&
                            selectedAttributes[key] !== ''
                        );
                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Exact Variant
            |--------------------------------------------------------------------------
            */

            function findExactVariant() {
                if (!variants.length) {
                    return null;
                }

                if (!requiredAttributeIds.length) {
                    return variants[0] || null;
                }

                if (!hasCompleteSelection()) {
                    return null;
                }

                return variants.find(
                    (variant) => {
                        return requiredAttributeIds.every(
                            (attributeId) => {
                                const key =
                                    String(attributeId);

                                return (
                                    Number(
                                        variant.attributes?.[key]
                                    ) ===
                                    Number(
                                        selectedAttributes[key]
                                    )
                                );
                            }
                        );
                    }
                ) || null;
            }


            /*
            |--------------------------------------------------------------------------
            | ALL Variant Gallery
            |--------------------------------------------------------------------------
            */

            function getAllVariantImages() {
                const images = [];
                const seen = new Set();

                variants.forEach(
                    (variant) => {
                        const variantId =
                            Number(variant.id);

                        /*
                         * Direct ProductVariant.image
                         */
                        if (variant.image) {
                            const imageUrl =
                                normalizeImageUrl(
                                    variant.image
                                );

                            if (
                                imageUrl &&
                                !seen.has(imageUrl)
                            ) {
                                seen.add(imageUrl);

                                images.push({
                                    url: imageUrl,
                                    alt: productName,
                                    variantId,
                                });
                            }
                        }


                        /*
                         * ProductImage records
                         */
                        if (
                            Array.isArray(
                                variant.images
                            )
                        ) {
                            variant.images.forEach(
                                (image) => {
                                    const imageUrl =
                                        normalizeImageUrl(
                                            image.url ||
                                            image.image
                                        );

                                    if (
                                        !imageUrl ||
                                        seen.has(imageUrl)
                                    ) {
                                        return;
                                    }

                                    seen.add(imageUrl);

                                    images.push({
                                        url: imageUrl,
                                        alt:
                                            image.alt ||
                                            productName,
                                        variantId,
                                    });
                                }
                            );
                        }
                    }
                );


                /*
                 * Product-level images.
                 *
                 * These are fallback/general product images.
                 */
                if (
                    Array.isArray(
                        productGallery
                    )
                ) {
                    productGallery.forEach(
                        (image) => {
                            const imageUrl =
                                normalizeImageUrl(
                                    image.url ||
                                    image.image
                                );

                            if (
                                !imageUrl ||
                                seen.has(imageUrl)
                            ) {
                                return;
                            }

                            seen.add(imageUrl);

                            images.push({
                                url: imageUrl,
                                alt:
                                    image.alt ||
                                    productName,
                                variantId: null,
                            });
                        }
                    );
                }


                /*
                 * Thumbnail fallback.
                 */
                if (
                    !images.length &&
                    thumbnail
                ) {
                    images.push({
                        url: thumbnail,
                        alt: productName,
                        variantId: null,
                    });
                }

                return images;
            }


            /*
            |--------------------------------------------------------------------------
            | Selected Variant Images
            |--------------------------------------------------------------------------
            */

            function getVariantImages(variant) {
                if (!variant) {
                    return getAllVariantImages();
                }

                const images = [];
                const seen = new Set();

                /*
                 * Direct variant image.
                 */
                if (variant.image) {
                    const imageUrl =
                        normalizeImageUrl(
                            variant.image
                        );

                    if (imageUrl) {
                        seen.add(imageUrl);

                        images.push({
                            url: imageUrl,
                            alt: productName,
                            variantId: Number(
                                variant.id
                            ),
                        });
                    }
                }


                /*
                 * Variant ProductImage records.
                 */
                if (
                    Array.isArray(
                        variant.images
                    )
                ) {
                    variant.images.forEach(
                        (image) => {
                            const imageUrl =
                                normalizeImageUrl(
                                    image.url ||
                                    image.image
                                );

                            if (
                                !imageUrl ||
                                seen.has(imageUrl)
                            ) {
                                return;
                            }

                            seen.add(imageUrl);

                            images.push({
                                url: imageUrl,
                                alt:
                                    image.alt ||
                                    productName,
                                variantId: Number(
                                    variant.id
                                ),
                            });
                        }
                    );
                }

                return images.length
                    ? images
                    : getAllVariantImages();
            }


            /*
            |--------------------------------------------------------------------------
            | Main Image
            |--------------------------------------------------------------------------
            */

            function setMainImage(imageUrl) {
                if (
                    !mainImage ||
                    !imageUrl
                ) {
                    return;
                }

                mainImage.src = imageUrl;
                mainImage.alt = productName;
                mainImage.hidden = false;

                if (imagePlaceholder) {
                    imagePlaceholder.hidden = true;
                }

                page
                    .querySelectorAll(
                        '.product-thumbnail'
                    )
                    .forEach(
                        (thumbnailElement) => {
                            const active =
                                thumbnailElement.dataset.image ===
                                imageUrl;

                            thumbnailElement.classList.toggle(
                                'is-active',
                                active
                            );

                            thumbnailElement.setAttribute(
                                'aria-pressed',
                                active
                                    ? 'true'
                                    : 'false'
                            );
                        }
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Render ALL Thumbnails
            |--------------------------------------------------------------------------
            */

            function renderGallery(
                images,
                activeUrl = ''
            ) {
                if (!galleryThumbnails) {
                    return;
                }

                galleryThumbnails.innerHTML = '';

                if (!images.length) {
                    if (mainImage) {
                        mainImage.hidden = true;

                        mainImage.removeAttribute(
                            'src'
                        );
                    }

                    if (imagePlaceholder) {
                        imagePlaceholder.hidden = false;
                    }

                    return;
                }

                const selectedImage =
                    activeUrl ||
                    images[0]?.url ||
                    '';


                images.forEach(
                    (image, index) => {
                        if (!image.url) {
                            return;
                        }

                        const button =
                            document.createElement(
                                'button'
                            );

                        button.type = 'button';

                        button.className =
                            'product-thumbnail';

                        button.dataset.image =
                            image.url;

                        button.dataset.variantId =
                            image.variantId
                                ? String(
                                    image.variantId
                                )
                                : '';


                        const isActive =
                            image.url ===
                            selectedImage;

                        if (isActive) {
                            button.classList.add(
                                'is-active'
                            );
                        }


                        button.setAttribute(
                            'aria-label',
                            `View product image ${index + 1}`
                        );

                        button.setAttribute(
                            'aria-pressed',
                            isActive
                                ? 'true'
                                : 'false'
                        );


                        const imageElement =
                            document.createElement(
                                'img'
                            );

                        imageElement.src =
                            image.url;

                        imageElement.alt =
                            image.alt ||
                            productName;

                        imageElement.loading =
                            index === 0
                                ? 'eager'
                                : 'lazy';


                        button.appendChild(
                            imageElement
                        );

                        galleryThumbnails.appendChild(
                            button
                        );
                    }
                );


                setMainImage(
                    selectedImage
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Render Attribute Selection
            |--------------------------------------------------------------------------
            */

            function renderAttributeSelections() {
                page
                    .querySelectorAll(
                        '[data-option-value]'
                    )
                    .forEach(
                        (button) => {
                            const attributeId =
                                String(
                                    button.dataset.attributeId
                                );

                            const valueId =
                                Number(
                                    button.dataset.valueId
                                );

                            const selected =
                                Number(
                                    selectedAttributes[
                                        attributeId
                                        ]
                                ) === valueId;

                            button.classList.toggle(
                                'is-selected',
                                selected
                            );

                            button.setAttribute(
                                'aria-pressed',
                                selected
                                    ? 'true'
                                    : 'false'
                            );
                        }
                    );


                page
                    .querySelectorAll(
                        '[data-attribute-group]'
                    )
                    .forEach(
                        (group) => {
                            const attributeId =
                                String(
                                    group.dataset.attributeId
                                );

                            const selectedValue =
                                Number(
                                    selectedAttributes[
                                        attributeId
                                        ]
                                );

                            const selectedButton =
                                group.querySelector(
                                    `[data-value-id="${selectedValue}"]`
                                );

                            const selectedLabel =
                                group.querySelector(
                                    '[data-option-selected]'
                                );

                            if (!selectedLabel) {
                                return;
                            }

                            if (selectedButton) {
                                selectedLabel.textContent =
                                    selectedButton.textContent.trim();
                            } else {
                                selectedLabel.textContent =
                                    `Select ${group.dataset.attributeName}`;
                            }
                        }
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Option Availability
            |--------------------------------------------------------------------------
            */

            function updateOptionAvailability() {
                page
                    .querySelectorAll(
                        '[data-option-value]'
                    )
                    .forEach(
                        (button) => {
                            const attributeId =
                                String(
                                    button.dataset.attributeId
                                );

                            const valueId =
                                Number(
                                    button.dataset.valueId
                                );

                            const possible =
                                variants.some(
                                    (variant) => {
                                        return requiredAttributeIds.every(
                                            (requiredAttributeId) => {
                                                const key =
                                                    String(
                                                        requiredAttributeId
                                                    );

                                                /*
                                                 * For the option
                                                 * currently being checked,
                                                 * use the candidate value.
                                                 */
                                                if (
                                                    key ===
                                                    attributeId
                                                ) {
                                                    return (
                                                        Number(
                                                            variant.attributes?.[key]
                                                        ) ===
                                                        valueId
                                                    );
                                                }


                                                /*
                                                 * For other attributes,
                                                 * respect current selection.
                                                 */
                                                if (
                                                    selectedAttributes[
                                                        key
                                                        ] !== undefined
                                                ) {
                                                    return (
                                                        Number(
                                                            variant.attributes?.[key]
                                                        ) ===
                                                        Number(
                                                            selectedAttributes[
                                                                key
                                                                ]
                                                        )
                                                    );
                                                }


                                                /*
                                                 * No current selection
                                                 * for this attribute.
                                                 */
                                                return true;
                                            }
                                        );
                                    }
                                );

                            button.disabled =
                                !possible;

                            button.classList.toggle(
                                'is-unavailable',
                                !possible
                            );
                        }
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Product Information
            |--------------------------------------------------------------------------
            */

            function updatePrice(variant) {
                const currentPrice =
                    variant &&
                    variant.price !== null &&
                    variant.price !== undefined
                        ? Number(variant.price)
                        : productPrice;


                const comparePrice =
                    variant &&
                    variant.compare_price !== null &&
                    variant.compare_price !== undefined
                        ? Number(
                            variant.compare_price
                        )
                        : (
                            productComparePrice !== null &&
                            productComparePrice !== undefined
                                ? Number(
                                    productComparePrice
                                )
                                : null
                        );


                if (priceElement) {
                    priceElement.textContent =
                        formatPrice(
                            currentPrice
                        );
                }


                if (comparePriceElement) {
                    if (
                        comparePrice &&
                        comparePrice > currentPrice
                    ) {
                        comparePriceElement.textContent =
                            formatPrice(
                                comparePrice
                            );

                        comparePriceElement.hidden =
                            false;
                    } else {
                        comparePriceElement.hidden =
                            true;
                    }
                }


                if (discountElement) {
                    if (
                        comparePrice &&
                        comparePrice > currentPrice
                    ) {
                        const discount =
                            Math.round(
                                (
                                    (
                                        comparePrice -
                                        currentPrice
                                    ) /
                                    comparePrice
                                ) * 100
                            );

                        discountElement.textContent =
                            `${discount}% OFF`;

                        discountElement.hidden =
                            false;
                    } else {
                        discountElement.hidden =
                            true;
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | SKU
            |--------------------------------------------------------------------------
            */

            function updateSku(variant) {
                const productSku =
                    @json($product->sku ?: '—');

                const sku =
                    variant?.sku ||
                    productSku;


                if (skuElement) {
                    skuElement.textContent =
                        `SKU: ${sku}`;
                }


                if (specificationSkuElement) {
                    specificationSkuElement.textContent =
                        sku;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Stock
            |--------------------------------------------------------------------------
            */

            function updateStock(variant) {
                if (!stockElement) {
                    return;
                }

                if (!variant) {
                    stockElement.innerHTML = '';

                    return;
                }

                const stock =
                    Number(
                        variant.stock || 0
                    );


                if (stock > 0) {
                    stockElement.innerHTML = `
                        <i class="ri-checkbox-circle-line"></i>
                        <span>In Stock</span>
                        <small>${stock} available</small>
                    `;
                } else {
                    stockElement.innerHTML = `
                        <i class="ri-close-circle-line"></i>
                        <span>Out of Stock</span>
                    `;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Quantity
            |--------------------------------------------------------------------------
            */

            function updateQuantity(variant) {
                if (!quantityInput) {
                    return;
                }


                if (!variant) {
                    quantityInput.value = '1';
                    quantityInput.max = '1';
                    quantityInput.disabled = true;

                    if (quantityDecrease) {
                        quantityDecrease.disabled = true;
                    }

                    if (quantityIncrease) {
                        quantityIncrease.disabled = true;
                    }

                    return;
                }


                const stock =
                    Math.max(
                        0,
                        Number(
                            variant.stock || 0
                        )
                    );


                quantityInput.disabled =
                    stock <= 0;

                quantityInput.min = '1';

                quantityInput.max =
                    String(
                        Math.max(
                            1,
                            stock
                        )
                    );


                let quantity =
                    Number(
                        quantityInput.value
                    ) || 1;


                quantity =
                    Math.max(
                        1,
                        Math.min(
                            quantity,
                            stock || 1
                        )
                    );


                quantityInput.value =
                    String(quantity);


                if (quantityDecrease) {
                    quantityDecrease.disabled =
                        stock <= 0 ||
                        quantity <= 1;
                }


                if (quantityIncrease) {
                    quantityIncrease.disabled =
                        stock <= 0 ||
                        quantity >= stock;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Add To Cart State
            |--------------------------------------------------------------------------
            */

            function updateAddToCart(variant) {
                if (!addToCartButton) {
                    return;
                }

                if (variants.length) {
                    addToCartButton.disabled =
                        !variant ||
                        Number(
                            variant.stock || 0
                        ) <= 0;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Product Information Update
            |--------------------------------------------------------------------------
            */

            function updateProductInformation() {
                updatePrice(
                    selectedVariant
                );

                updateSku(
                    selectedVariant
                );

                updateStock(
                    selectedVariant
                );

                updateQuantity(
                    selectedVariant
                );

                updateAddToCart(
                    selectedVariant
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Attribute Selection
            |--------------------------------------------------------------------------
            */

            page.addEventListener(
                'click',
                (event) => {
                    const button =
                        event.target.closest(
                            '[data-option-value]'
                        );

                    if (
                        !button ||
                        !page.contains(button) ||
                        button.disabled
                    ) {
                        return;
                    }


                    const attributeId =
                        String(
                            button.dataset.attributeId
                        );

                    const valueId =
                        Number(
                            button.dataset.valueId
                        );


                    selectedAttributes[
                        attributeId
                        ] = valueId;


                    const exactVariant =
                        findExactVariant();


                    if (exactVariant) {
                        /*
                         * Exact combination exists.
                         */
                        selectedVariant =
                            exactVariant;


                        /*
                         * Keep ALL variant images
                         * in the thumbnail gallery.
                         */
                        const variantImages =
                            getVariantImages(
                                selectedVariant
                            );

                        const mainVariantImage =
                            variantImages[0]?.url ||
                            getAllVariantImages()[0]?.url ||
                            '';


                        renderGallery(
                            getAllVariantImages(),
                            mainVariantImage
                        );


                        updateProductInformation();

                    } else {
                        /*
                         * No exact combination.
                         *
                         * IMPORTANT:
                         * Do not switch to another variant.
                         */
                        selectedVariant = null;

                        updatePrice(null);
                        updateSku(null);
                        updateStock(null);
                        updateQuantity(null);
                        updateAddToCart(null);
                    }


                    renderAttributeSelections();

                    updateOptionAvailability();
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Thumbnail Click
            |--------------------------------------------------------------------------
            */

            galleryThumbnails?.addEventListener(
                'click',
                (event) => {
                    const thumbnailElement =
                        event.target.closest(
                            '.product-thumbnail'
                        );

                    if (
                        !thumbnailElement ||
                        !galleryThumbnails.contains(
                            thumbnailElement
                        )
                    ) {
                        return;
                    }


                    const imageUrl =
                        thumbnailElement.dataset.image;


                    if (!imageUrl) {
                        return;
                    }


                    setMainImage(
                        imageUrl
                    );


                    /*
                     * If the image belongs to a variant,
                     * selecting the image also selects
                     * that variant.
                     */
                    const variantId =
                        Number(
                            thumbnailElement.dataset.variantId ||
                            0
                        );


                    if (!variantId) {
                        return;
                    }


                    const imageVariant =
                        variants.find(
                            (variant) =>
                                Number(
                                    variant.id
                                ) === variantId
                        );


                    if (!imageVariant) {
                        return;
                    }


                    selectedVariant =
                        imageVariant;


                    selectedAttributes = {
                        ...imageVariant.attributes,
                    };


                    renderAttributeSelections();

                    updateOptionAvailability();

                    updateProductInformation();
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Quantity Decrease
            |--------------------------------------------------------------------------
            */

            quantityDecrease?.addEventListener(
                'click',
                () => {
                    if (
                        !quantityInput ||
                        quantityInput.disabled
                    ) {
                        return;
                    }


                    const quantity =
                        Number(
                            quantityInput.value
                        ) || 1;


                    quantityInput.value =
                        String(
                            Math.max(
                                1,
                                quantity - 1
                            )
                        );


                    updateQuantity(
                        selectedVariant
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Quantity Increase
            |--------------------------------------------------------------------------
            */

            quantityIncrease?.addEventListener(
                'click',
                () => {
                    if (
                        !quantityInput ||
                        quantityInput.disabled
                    ) {
                        return;
                    }


                    const quantity =
                        Number(
                            quantityInput.value
                        ) || 1;


                    const max =
                        Number(
                            quantityInput.max ||
                            1
                        );


                    quantityInput.value =
                        String(
                            Math.min(
                                max,
                                quantity + 1
                            )
                        );


                    updateQuantity(
                        selectedVariant
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Quantity Input
            |--------------------------------------------------------------------------
            */

            quantityInput?.addEventListener(
                'input',
                () => {
                    updateQuantity(
                        selectedVariant
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Tabs
            |--------------------------------------------------------------------------
            */

            const tabButtons =
                page.querySelectorAll(
                    '[data-tab-button]'
                );

            const tabPanels =
                page.querySelectorAll(
                    '[data-tab-panel]'
                );


            tabButtons.forEach(
                (button) => {
                    button.addEventListener(
                        'click',
                        () => {
                            const tab =
                                button.dataset.tabButton;


                            tabButtons.forEach(
                                (item) => {
                                    item.classList.toggle(
                                        'is-active',
                                        item === button
                                    );
                                }
                            );


                            tabPanels.forEach(
                                (panel) => {
                                    panel.classList.toggle(
                                        'is-active',
                                        panel.dataset.tabPanel ===
                                        tab
                                    );
                                }
                            );
                        }
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Wishlist
            |--------------------------------------------------------------------------
            */

            wishlistButton?.addEventListener(
                'click',
                () => {
                    const active =
                        wishlistButton.classList.toggle(
                            'is-active'
                        );


                    wishlistButton.setAttribute(
                        'aria-pressed',
                        active
                            ? 'true'
                            : 'false'
                    );


                    const icon =
                        wishlistButton.querySelector(
                            'i'
                        );


                    if (icon) {
                        icon.className =
                            active
                                ? 'ri-heart-fill'
                                : 'ri-heart-line';
                    }
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Related Wishlist
            |--------------------------------------------------------------------------
            */

            page
                .querySelectorAll(
                    '[data-related-wishlist]'
                )
                .forEach(
                    (button) => {
                        button.addEventListener(
                            'click',
                            () => {
                                const active =
                                    button.classList.toggle(
                                        'is-active'
                                    );


                                const icon =
                                    button.querySelector(
                                        'i'
                                    );


                                if (icon) {
                                    icon.className =
                                        active
                                            ? 'ri-heart-fill'
                                            : 'ri-heart-line';
                                }
                            }
                        );
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Add To Cart
            |--------------------------------------------------------------------------
            */

            addToCartButton?.addEventListener(
                'click',
                () => {
                    if (
                        addToCartButton.disabled ||
                        !selectedVariant
                    ) {
                        return;
                    }


                    const quantity =
                        Number(
                            quantityInput?.value ||
                            1
                        );


                    page.dispatchEvent(
                        new CustomEvent(
                            'product:add-to-cart',
                            {
                                bubbles: true,

                                detail: {
                                    productId: @json($product->id),

                                    variantId:
                                        Number(
                                            selectedVariant.id
                                        ),

                                    quantity,

                                    sku:
                                        selectedVariant.sku ||
                                        null,
                                },
                            }
                        )
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Lightbox
            |--------------------------------------------------------------------------
            */

            const lightbox =
                page.querySelector(
                    '[data-image-lightbox]'
                );

            const lightboxImage =
                page.querySelector(
                    '[data-lightbox-image]'
                );

            const imageZoom =
                page.querySelector(
                    '[data-image-zoom]'
                );

            const lightboxCloseButtons =
                page.querySelectorAll(
                    '[data-lightbox-close]'
                );


            function openLightbox() {
                if (
                    !lightbox ||
                    !lightboxImage ||
                    !mainImage ||
                    !mainImage.src ||
                    mainImage.hidden
                ) {
                    return;
                }


                lightboxImage.src =
                    mainImage.src;

                lightboxImage.alt =
                    productName;

                lightbox.hidden = false;

                document.body.style.overflow =
                    'hidden';
            }


            function closeLightbox() {
                if (!lightbox) {
                    return;
                }

                lightbox.hidden = true;

                document.body.style.overflow =
                    '';
            }


            imageZoom?.addEventListener(
                'click',
                openLightbox
            );


            lightboxCloseButtons.forEach(
                (button) => {
                    button.addEventListener(
                        'click',
                        closeLightbox
                    );
                }
            );


            document.addEventListener(
                'keydown',
                (event) => {
                    if (
                        event.key === 'Escape' &&
                        lightbox &&
                        !lightbox.hidden
                    ) {
                        closeLightbox();
                    }
                }
            );


            /*
            |--------------------------------------------------------------------------
            | INITIAL GALLERY
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            |
            | Render ALL active variant images.
            |
            */

            const allGalleryImages =
                getAllVariantImages();


            const initialImage =
                initialSelections &&
                Object.keys(
                    initialSelections
                ).length
                    ? (
                        getVariantImages(
                            selectedVariant
                        )[0]?.url ||
                        allGalleryImages[0]?.url ||
                        ''
                    )
                    : (
                        allGalleryImages[0]?.url ||
                        ''
                    );


            renderGallery(
                allGalleryImages,
                initialImage
            );


            /*
            |--------------------------------------------------------------------------
            | Initial State
            |--------------------------------------------------------------------------
            */

            renderAttributeSelections();

            updateOptionAvailability();

            updateProductInformation();
        });
    </script>

@endpush
