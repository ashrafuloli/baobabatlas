@extends('backend.layouts.backend')

@section('title', 'Product Details')

@section('content')
    <div class="product-details-page">
        <div class="product-details-page__container">
            {{-- Header --}}
            <div class="product-details-page__header">
                <div class="product-details-page__header-content">
                    <div class="product-details-page__breadcrumb">
                        <a href="{{ route('admin-products') }}">
                            <i class="ri-shopping-bag-3-line"></i>
                            Products
                        </a>

                        <i class="ri-arrow-right-s-line"></i>

                        <span>{{ $product->name }}</span>
                    </div>

                    <div class="product-details-page__title-row">
                        <div>
                            <h1>{{ $product->name }}</h1>

                            <div class="product-details-page__meta">
                                <span>
                                    <i class="ri-hashtag"></i>
                                    {{ $product->sku ?: 'No SKU' }}
                                </span>

                                <span>
                                    <i class="ri-price-tag-3-line"></i>
                                    {{ ucfirst($product->source) }}
                                </span>

                                <span>
                                    <i class="ri-calendar-line"></i>
                                    {{ $product->created_at?->format('M d, Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="product-details-page__header-actions">
                            <a
                                href="{{ route('admin-products.edit', $product) }}"
                                class="product-details-page__button product-details-page__button--primary"
                            >
                                <i class="ri-edit-line"></i>
                                Edit Product
                            </a>

                            <a
                                href="{{ route('admin-products') }}"
                                class="product-details-page__button product-details-page__button--light"
                            >
                                <i class="ri-arrow-left-line"></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status Bar --}}
            <div class="product-details-page__status-bar">
                <div class="product-details-page__status-list">
                    <div class="product-details-page__status-item">
                        <span
                            class="product-details-page__status-dot {{ $product->status ? 'is-active' : 'is-inactive' }}"
                        ></span>

                        <span>
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="product-details-page__status-item">
                        <i class="ri-star-line"></i>

                        <span>
                            {{ $product->featured ? 'Featured Product' : 'Regular Product' }}
                        </span>
                    </div>

                    @if ($product->brand)
                        <div class="product-details-page__status-item">
                            <i class="ri-price-tag-3-line"></i>
                            <span>{{ $product->brand->name }}</span>
                        </div>
                    @endif
                </div>

                <div class="product-details-page__slug">
                    <span>Slug:</span>
                    <strong>{{ $product->slug }}</strong>
                </div>
            </div>

            {{-- Main Grid --}}
            <div class="product-details-page__grid">
                {{-- Left Column --}}
                <div class="product-details-page__main">
                    {{-- Product Overview --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Product Overview</h2>
                                <p>Basic information and product description.</p>
                            </div>

                            <i class="ri-information-line"></i>
                        </div>

                        <div class="product-details-page__overview">
                            <div class="product-details-page__thumbnail">
                                @if ($product->thumbnail)
                                    <img
                                        src="{{ asset($product->thumbnail) }}"
                                        alt="{{ $product->name }}"
                                    >
                                @else
                                    <div class="product-details-page__thumbnail-placeholder">
                                        <i class="ri-image-line"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="product-details-page__overview-content">
                                <div class="product-details-page__field">
                                    <span class="product-details-page__field-label">
                                        Product Name
                                    </span>

                                    <strong>{{ $product->name }}</strong>
                                </div>

                                <div class="product-details-page__field-grid">
                                    <div class="product-details-page__field">
                                        <span class="product-details-page__field-label">
                                            SKU
                                        </span>

                                        <strong>
                                            {{ $product->sku ?: '—' }}
                                        </strong>
                                    </div>

                                    <div class="product-details-page__field">
                                        <span class="product-details-page__field-label">
                                            Brand
                                        </span>

                                        <strong>
                                            {{ $product->brand?->name ?: 'No Brand' }}
                                        </strong>
                                    </div>

                                    <div class="product-details-page__field">
                                        <span class="product-details-page__field-label">
                                            Source
                                        </span>

                                        <strong>
                                            {{ ucfirst($product->source) }}
                                        </strong>
                                    </div>

                                    <div class="product-details-page__field">
                                        <span class="product-details-page__field-label">
                                            Sort Order
                                        </span>

                                        <strong>
                                            {{ $product->sort_order }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($product->short_description)
                            <div class="product-details-page__description-block">
                                <span class="product-details-page__field-label">
                                    Short Description
                                </span>

                                <p>{{ $product->short_description }}</p>
                            </div>
                        @endif

                        @if ($product->description)
                            <div class="product-details-page__description-block">
                                <span class="product-details-page__field-label">
                                    Description
                                </span>

                                <div class="product-details-page__rich-content">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        @endif
                    </section>

                    {{-- Pricing --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Pricing</h2>
                                <p>Product pricing and cost information.</p>
                            </div>

                            <i class="ri-money-dollar-circle-line"></i>
                        </div>

                        <div class="product-details-page__pricing-grid">
                            <div class="product-details-page__price-box product-details-page__price-box--main">
                                <span>Sale Price</span>

                                <strong>
                                    {{ number_format((float) $product->price, 2) }}
                                </strong>
                            </div>

                            <div class="product-details-page__price-box">
                                <span>Compare Price</span>

                                <strong>
                                    @if ($product->compare_price !== null)
                                        {{ number_format((float) $product->compare_price, 2) }}
                                    @else
                                        —
                                    @endif
                                </strong>
                            </div>

                            <div class="product-details-page__price-box">
                                <span>Cost Price</span>

                                <strong>
                                    @if ($product->cost_price !== null)
                                        {{ number_format((float) $product->cost_price, 2) }}
                                    @else
                                        —
                                    @endif
                                </strong>
                            </div>

                            @if (
                                $product->compare_price !== null &&
                                (float) $product->compare_price > (float) $product->price
                            )
                                @php
                                    $discount = (
                                        (
                                            (float) $product->compare_price -
                                            (float) $product->price
                                        ) /
                                        (float) $product->compare_price
                                    ) * 100;
                                @endphp

                                <div class="product-details-page__price-box product-details-page__price-box--discount">
                                    <span>Discount</span>

                                    <strong>
                                        {{ number_format($discount, 0) }}%
                                    </strong>
                                </div>
                            @endif
                        </div>
                    </section>

                    {{-- Categories --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Categories</h2>
                                <p>Categories assigned to this product.</p>
                            </div>

                            <i class="ri-folder-3-line"></i>
                        </div>

                        @if ($product->categories->isNotEmpty())
                            <div class="product-details-page__tags">
                                @foreach ($product->categories as $category)
                                    <span class="product-details-page__tag">
                                        <i class="ri-folder-line"></i>
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="product-details-page__empty">
                                <i class="ri-folder-unknow-line"></i>
                                <span>No categories assigned.</span>
                            </div>
                        @endif
                    </section>

                    {{-- Variants --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Variants</h2>
                                <p>
                                    {{ $product->variants->count() }}
                                    {{ $product->variants->count() === 1 ? 'variant' : 'variants' }}
                                    available.
                                </p>
                            </div>

                            <i class="ri-list-check-3"></i>
                        </div>

                        @if ($product->variants->isNotEmpty())
                            <div class="product-details-page__variants">
                                @foreach ($product->variants as $variant)
                                    <div
                                        class="product-details-page__variant"
                                        data-variant
                                    >
                                        <div class="product-details-page__variant-image">
                                            @if ($variant->image)
                                                <img
                                                    src="{{ asset($variant->image) }}"
                                                    alt="{{ $product->name }}"
                                                >
                                            @else
                                                <div>
                                                    <i class="ri-image-line"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="product-details-page__variant-info">
                                            <div class="product-details-page__variant-top">
                                                <strong>
                                                    {{ $variant->sku ?: 'Variant #' . $variant->id }}
                                                </strong>

                                                <span
                                                    class="product-details-page__variant-status {{ $variant->status ? 'is-active' : 'is-inactive' }}"
                                                >
                                                    {{ $variant->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>

                                            @if ($variant->values->isNotEmpty())
                                                <div class="product-details-page__variant-values">
                                                    @foreach ($variant->values as $variantValue)
                                                        <span>
                                                            {{ $variantValue->attribute?->name }}:
                                                            <strong>
                                                                {{ $variantValue->attributeValue?->label ?? $variantValue->attributeValue?->value }}
                                                            </strong>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="product-details-page__variant-price">
                                            <span>Price</span>
                                            <strong>
                                                {{ number_format((float) $variant->price, 2) }}
                                            </strong>
                                        </div>

                                        <div class="product-details-page__variant-stock">
                                            <span>Stock</span>

                                            <strong
                                                class="{{ $variant->stock <= 0 ? 'is-out' : ($variant->stock <= 5 ? 'is-low' : '') }}"
                                            >
                                                {{ $variant->stock }}
                                            </strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="product-details-page__no-variants">
                                <div>
                                    <i class="ri-stack-line"></i>
                                </div>

                                <strong>No variants</strong>

                                <p>
                                    This product does not have any variants.
                                </p>
                            </div>
                        @endif
                    </section>

                    {{-- Gallery --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Product Gallery</h2>
                                <p>Additional product images.</p>
                            </div>

                            <i class="ri-gallery-line"></i>
                        </div>

                        @if ($product->images->isNotEmpty())
                            <div class="product-details-page__gallery">
                                @foreach ($product->images as $image)
                                    <button
                                        type="button"
                                        class="product-details-page__gallery-item"
                                        data-gallery-image
                                        data-image="{{ asset($image->image) }}"
                                        aria-label="View product image"
                                    >
                                        <img
                                            src="{{ asset( $image->image) }}"
                                            alt="{{ $image->alt_text ?: $product->name }}"
                                        >

                                        @if ($image->is_primary)
                                            <span class="product-details-page__primary-badge">
                                                Primary
                                            </span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <div class="product-details-page__empty">
                                <i class="ri-gallery-upload-line"></i>
                                <span>No gallery images available.</span>
                            </div>
                        @endif
                    </section>

                    {{-- Video --}}
                    @if ($product->video_url)
                        <section class="product-details-page__card">
                            <div class="product-details-page__card-header">
                                <div>
                                    <h2>Product Video</h2>
                                    <p>Product demonstration video.</p>
                                </div>

                                <i class="ri-youtube-line"></i>
                            </div>

                            <div class="product-details-page__video">
                                <iframe
                                    src="{{ $product->video_url }}"
                                    title="{{ $product->name }} video"
                                    loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </section>
                    @endif

                    {{-- SEO --}}
                    @if ($product->meta_title || $product->meta_description)
                        <section class="product-details-page__card">
                            <div class="product-details-page__card-header">
                                <div>
                                    <h2>SEO Information</h2>
                                    <p>Search engine optimization details.</p>
                                </div>

                                <i class="ri-search-eye-line"></i>
                            </div>

                            <div class="product-details-page__seo">
                                <div class="product-details-page__seo-field">
                                    <span class="product-details-page__field-label">
                                        Meta Title
                                    </span>

                                    <strong>
                                        {{ $product->meta_title ?: '—' }}
                                    </strong>
                                </div>

                                <div class="product-details-page__seo-field">
                                    <span class="product-details-page__field-label">
                                        Meta Description
                                    </span>

                                    <p>
                                        {{ $product->meta_description ?: '—' }}
                                    </p>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>

                {{-- Right Sidebar --}}
                <aside class="product-details-page__sidebar">
                    {{-- Quick Summary --}}
                    <section class="product-details-page__card product-details-page__card--sticky">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Quick Summary</h2>
                                <p>Product statistics.</p>
                            </div>
                        </div>

                        <div class="product-details-page__summary">
                            <div class="product-details-page__summary-item">
                                <div class="product-details-page__summary-icon">
                                    <i class="ri-stack-line"></i>
                                </div>

                                <div>
                                    <span>Variants</span>
                                    <strong>{{ $product->variants->count() }}</strong>
                                </div>
                            </div>

                            <div class="product-details-page__summary-item">
                                <div class="product-details-page__summary-icon">
                                    <i class="ri-image-2-line"></i>
                                </div>

                                <div>
                                    <span>Gallery Images</span>
                                    <strong>{{ $product->images->count() }}</strong>
                                </div>
                            </div>

                            <div class="product-details-page__summary-item">
                                <div class="product-details-page__summary-icon">
                                    <i class="ri-folder-line"></i>
                                </div>

                                <div>
                                    <span>Categories</span>
                                    <strong>{{ $product->categories->count() }}</strong>
                                </div>
                            </div>

                            <div class="product-details-page__summary-item">
                                <div class="product-details-page__summary-icon">
                                    <i class="ri-calendar-check-line"></i>
                                </div>

                                <div>
                                    <span>Last Updated</span>
                                    <strong>
                                        {{ $product->updated_at?->format('M d, Y') }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Product Status --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Status</h2>
                                <p>Current product state.</p>
                            </div>
                        </div>

                        <div class="product-details-page__status-card">
                            <div class="product-details-page__status-card-icon {{ $product->status ? 'is-active' : 'is-inactive' }}">
                                <i class="{{ $product->status ? 'ri-checkbox-circle-line' : 'ri-close-circle-line' }}"></i>
                            </div>

                            <div>
                                <strong>
                                    {{ $product->status ? 'Product is Active' : 'Product is Inactive' }}
                                </strong>

                                <span>
                                    {{ $product->status
                                        ? 'Customers can see this product.'
                                        : 'This product is hidden from customers.' }}
                                </span>
                            </div>
                        </div>

                        <div class="product-details-page__feature-card">
                            <i class="{{ $product->featured ? 'ri-star-fill' : 'ri-star-line' }}"></i>

                            <div>
                                <strong>
                                    {{ $product->featured ? 'Featured Product' : 'Not Featured' }}
                                </strong>

                                <span>
                                    {{ $product->featured
                                        ? 'This product is marked as featured.'
                                        : 'This product is not marked as featured.' }}
                                </span>
                            </div>
                        </div>
                    </section>

                    {{-- Inventory --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Inventory</h2>
                                <p>Current stock overview.</p>
                            </div>

                            <i class="ri-archive-stack-line"></i>
                        </div>

                        @php
                            $totalStock = $product->variants->sum('stock');
                        @endphp

                        @if ($product->variants->isNotEmpty())
                            <div class="product-details-page__inventory-total">
                                <span>Total Variant Stock</span>

                                <strong>{{ $totalStock }}</strong>
                            </div>

                            <div class="product-details-page__inventory-list">
                                @foreach ($product->variants->take(5) as $variant)
                                    <div class="product-details-page__inventory-item">
                                        <span>
                                            {{ $variant->sku ?: 'Variant #' . $variant->id }}
                                        </span>

                                        <strong
                                            class="{{ $variant->stock <= 0 ? 'is-out' : ($variant->stock <= 5 ? 'is-low' : '') }}"
                                        >
                                            {{ $variant->stock }}
                                        </strong>
                                    </div>
                                @endforeach
                            </div>

                            @if ($product->variants->count() > 5)
                                <div class="product-details-page__inventory-more">
                                    +{{ $product->variants->count() - 5 }} more variants
                                </div>
                            @endif
                        @else
                            <div class="product-details-page__inventory-total">
                                <span>Product Stock</span>

                                <strong>—</strong>
                            </div>

                            <p class="product-details-page__inventory-note">
                                This product uses variants for inventory management.
                            </p>
                        @endif
                    </section>

                    {{-- Timestamps --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Timeline</h2>
                                <p>Product activity dates.</p>
                            </div>

                            <i class="ri-time-line"></i>
                        </div>

                        <div class="product-details-page__timeline">
                            <div>
                                <span class="product-details-page__timeline-dot"></span>

                                <div>
                                    <span>Created</span>
                                    <strong>
                                        {{ $product->created_at?->format('M d, Y · h:i A') }}
                                    </strong>
                                </div>
                            </div>

                            <div>
                                <span class="product-details-page__timeline-dot"></span>

                                <div>
                                    <span>Last Updated</span>
                                    <strong>
                                        {{ $product->updated_at?->format('M d, Y · h:i A') }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Actions --}}
                    <section class="product-details-page__card">
                        <div class="product-details-page__card-header">
                            <div>
                                <h2>Actions</h2>
                                <p>Manage this product.</p>
                            </div>

                            <i class="ri-settings-3-line"></i>
                        </div>

                        <div class="product-details-page__actions">
                            <a
                                href="{{ route('admin-products.edit', $product) }}"
                                class="product-details-page__action product-details-page__action--primary"
                            >
                                <i class="ri-edit-line"></i>
                                Edit Product
                            </a>

                            <form
                                action="{{ route('admin-products.destroy', $product) }}"
                                method="POST"
                                data-delete-form
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="product-details-page__action product-details-page__action--danger"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                    Delete Product
                                </button>
                            </form>
                        </div>
                    </section>
                </aside>
            </div>
        </div>

        {{-- Gallery Lightbox --}}
        <div
            class="product-details-page__lightbox"
            data-lightbox
            aria-hidden="true"
        >
            <div class="product-details-page__lightbox-overlay" data-lightbox-close></div>

            <div class="product-details-page__lightbox-content">
                <button
                    type="button"
                    class="product-details-page__lightbox-close"
                    data-lightbox-close
                    aria-label="Close image preview"
                >
                    <i class="ri-close-line"></i>
                </button>

                <button
                    type="button"
                    class="product-details-page__lightbox-nav product-details-page__lightbox-nav--prev"
                    data-lightbox-prev
                    aria-label="Previous image"
                >
                    <i class="ri-arrow-left-s-line"></i>
                </button>

                <img
                    src=""
                    alt="{{ $product->name }}"
                    data-lightbox-image
                >

                <button
                    type="button"
                    class="product-details-page__lightbox-nav product-details-page__lightbox-nav--next"
                    data-lightbox-next
                    aria-label="Next image"
                >
                    <i class="ri-arrow-right-s-line"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector('.product-details-page');

            if (!page) {
                return;
            }

            const galleryItems = Array.from(
                page.querySelectorAll('[data-gallery-image]')
            );

            const lightbox = page.querySelector('[data-lightbox]');
            const lightboxImage = page.querySelector('[data-lightbox-image]');
            const previousButton = page.querySelector('[data-lightbox-prev]');
            const nextButton = page.querySelector('[data-lightbox-next]');
            const closeButtons = page.querySelectorAll('[data-lightbox-close]');

            let currentIndex = 0;

            const openLightbox = (index) => {
                if (!galleryItems.length || !lightbox || !lightboxImage) {
                    return;
                }

                currentIndex = index;

                lightboxImage.src = galleryItems[currentIndex].dataset.image || '';
                lightbox.classList.add('is-visible');
                lightbox.setAttribute('aria-hidden', 'false');

                document.body.classList.add('product-details-lightbox-open');
            };

            const closeLightbox = () => {
                if (!lightbox) {
                    return;
                }

                lightbox.classList.remove('is-visible');
                lightbox.setAttribute('aria-hidden', 'true');

                document.body.classList.remove('product-details-lightbox-open');
            };

            const showPrevious = () => {
                if (!galleryItems.length) {
                    return;
                }

                currentIndex =
                    (currentIndex - 1 + galleryItems.length) %
                    galleryItems.length;

                lightboxImage.src =
                    galleryItems[currentIndex].dataset.image || '';
            };

            const showNext = () => {
                if (!galleryItems.length) {
                    return;
                }

                currentIndex =
                    (currentIndex + 1) %
                    galleryItems.length;

                lightboxImage.src =
                    galleryItems[currentIndex].dataset.image || '';
            };

            galleryItems.forEach((item, index) => {
                item.addEventListener('click', () => {
                    openLightbox(index);
                });
            });

            closeButtons.forEach((button) => {
                button.addEventListener('click', closeLightbox);
            });

            previousButton?.addEventListener('click', showPrevious);
            nextButton?.addEventListener('click', showNext);

            document.addEventListener('keydown', (event) => {
                if (!lightbox?.classList.contains('is-visible')) {
                    return;
                }

                if (event.key === 'Escape') {
                    closeLightbox();
                }

                if (event.key === 'ArrowLeft') {
                    showPrevious();
                }

                if (event.key === 'ArrowRight') {
                    showNext();
                }
            });

            page.querySelectorAll('[data-delete-form]').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    const confirmed = window.confirm(
                        'Are you sure you want to delete this product? This action cannot be undone.'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush
