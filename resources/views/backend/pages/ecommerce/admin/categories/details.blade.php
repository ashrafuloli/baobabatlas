@extends('backend.layouts.backend')

@section('title', 'Category Details')

@section('content')

    <div class="category-details-page">

        {{-- PAGE HEADER --}}
        <div class="category-details-page__header">

            <div class="category-details-page__heading">

                <span class="category-details-page__eyebrow">
                    Ecommerce / Categories
                </span>

                <h1>
                    Category Details
                </h1>

                <p>
                    View category information, settings, hierarchy and SEO details.
                </p>

            </div>

            <div class="category-details-page__header-actions">

                <a
                    href="{{ route('admin-categories') }}"
                    class="category-details-page__back-btn"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Categories</span>
                </a>

                <a
                    href="{{ route('admin-categories.edit', ['category' => $category->id]) }}"
                    class="category-details-page__edit-btn"
                >
                    <i class="ri-edit-line"></i>
                    <span>Edit Category</span>
                </a>

            </div>

        </div>


        {{-- MAIN GRID --}}
        <div class="category-details-page__layout">

            {{-- LEFT CONTENT --}}
            <div class="category-details-page__main">

                {{-- CATEGORY OVERVIEW --}}
                <section class="category-details-page__card">

                    <div class="category-details-page__card-header">

                        <div>

                            <h4>
                                Category Overview
                            </h4>

                            <p>
                                Basic information about this category.
                            </p>

                        </div>

                        <span class="category-details-page__card-icon">
                            <i class="ri-folder-info-line"></i>
                        </span>

                    </div>

                    <div class="category-details-page__card-body">

                        <div class="category-details-page__overview">

                            {{-- IMAGE --}}
                            <div class="category-details-page__image">

                                @if($category->image)

                                    <img
                                        src="{{ asset($category->image) }}"
                                        alt="{{ $category->name }}"
                                    >

                                @else

                                    <div class="category-details-page__image-placeholder">
                                        <i class="ri-folder-2-line"></i>
                                    </div>

                                @endif

                            </div>


                            {{-- INFO --}}
                            <div class="category-details-page__overview-content">

                                <div class="category-details-page__category-name">

                                    <h2>
                                        {{ $category->name }}
                                    </h2>

                                    @if($category->status)

                                        <span class="category-details-page__badge category-details-page__badge--success">
                                            <i class="ri-checkbox-circle-line"></i>
                                            Active
                                        </span>

                                    @else

                                        <span class="category-details-page__badge category-details-page__badge--danger">
                                            <i class="ri-close-circle-line"></i>
                                            Inactive
                                        </span>

                                    @endif

                                </div>

                                <div class="category-details-page__slug">

                                    <i class="ri-link"></i>

                                    <span>
                                        /{{ $category->slug }}
                                    </span>

                                </div>

                                @if($category->description)

                                    <p class="category-details-page__description">
                                        {{ $category->description }}
                                    </p>

                                @else

                                    <p class="category-details-page__description category-details-page__description--empty">
                                        No description has been added for this category.
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>

                </section>


                {{-- CATEGORY HIERARCHY --}}
                <section class="category-details-page__card">

                    <div class="category-details-page__card-header">

                        <div>

                            <h4>
                                Category Hierarchy
                            </h4>

                            <p>
                                View where this category belongs in the category structure.
                            </p>

                        </div>

                        <span class="category-details-page__card-icon">
                            <i class="ri-node-tree"></i>
                        </span>

                    </div>

                    <div class="category-details-page__card-body">

                        <div class="category-details-page__hierarchy">

                            {{-- PARENT --}}
                            <div class="category-details-page__hierarchy-item">

                                <div class="category-details-page__hierarchy-icon">
                                    <i class="ri-folder-2-line"></i>
                                </div>

                                <div class="category-details-page__hierarchy-content">

                                    <span>
                                        Parent Category
                                    </span>

                                    @if($category->parent)

                                        <strong>
                                            {{ $category->parent->name }}
                                        </strong>

                                    @else

                                        <strong>
                                            Top Level Category
                                        </strong>

                                    @endif

                                </div>

                            </div>


                            <div class="category-details-page__hierarchy-line"></div>


                            {{-- CURRENT CATEGORY --}}
                            <div class="category-details-page__hierarchy-item category-details-page__hierarchy-item--current">

                                <div class="category-details-page__hierarchy-icon">
                                    <i class="ri-folder-open-line"></i>
                                </div>

                                <div class="category-details-page__hierarchy-content">

                                    <span>
                                        Current Category
                                    </span>

                                    <strong>
                                        {{ $category->name }}
                                    </strong>

                                </div>

                                <span class="category-details-page__current-label">
                                    Current
                                </span>

                            </div>


                            @if($category->children->count())

                                <div class="category-details-page__hierarchy-line"></div>

                                {{-- CHILDREN --}}
                                <div class="category-details-page__children">

                                    <div class="category-details-page__children-title">
                                        <i class="ri-arrow-down-s-line"></i>
                                        Subcategories
                                    </div>

                                    <div class="category-details-page__children-list">

                                        @foreach($category->children as $child)

                                            <div class="category-details-page__child">

                                                <div class="category-details-page__child-icon">
                                                    <i class="ri-folder-line"></i>
                                                </div>

                                                <div>

                                                    <strong>
                                                        {{ $child->name }}
                                                    </strong>

                                                    <span>
                                                        /{{ $child->slug }}
                                                    </span>

                                                </div>

                                                @if($child->status)

                                                    <span class="category-details-page__child-status">
                                                        Active
                                                    </span>

                                                @else

                                                    <span class="category-details-page__child-status category-details-page__child-status--inactive">
                                                        Inactive
                                                    </span>

                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                </section>


                {{-- DESCRIPTION --}}
                <section class="category-details-page__card">

                    <div class="category-details-page__card-header">

                        <div>

                            <h4>
                                Description
                            </h4>

                            <p>
                                Category description shown to customers.
                            </p>

                        </div>

                        <span class="category-details-page__card-icon">
                            <i class="ri-file-text-line"></i>
                        </span>

                    </div>

                    <div class="category-details-page__card-body">

                        @if($category->description)

                            <div class="category-details-page__description-box">
                                {!! nl2br(e($category->description)) !!}
                            </div>

                        @else

                            <div class="category-details-page__empty-state">

                                <i class="ri-file-text-line"></i>

                                <span>
                                    No description available.
                                </span>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- SEO --}}
                <section class="category-details-page__card">

                    <div class="category-details-page__card-header">

                        <div>

                            <h4>
                                SEO Information
                            </h4>

                            <p>
                                Search engine information configured for this category.
                            </p>

                        </div>

                        <span class="category-details-page__card-icon">
                            <i class="ri-search-eye-line"></i>
                        </span>

                    </div>

                    <div class="category-details-page__card-body">

                        <div class="category-details-page__seo">

                            <div class="category-details-page__seo-item">

                                <span>
                                    Meta Title
                                </span>

                                @if($category->meta_title)

                                    <strong>
                                        {{ $category->meta_title }}
                                    </strong>

                                @else

                                    <strong class="category-details-page__muted">
                                        Not configured
                                    </strong>

                                @endif

                                <small>
                                    {{ strlen($category->meta_title ?? '') }} / 60 characters
                                </small>

                            </div>


                            <div class="category-details-page__seo-item">

                                <span>
                                    Meta Description
                                </span>

                                @if($category->meta_description)

                                    <strong>
                                        {{ $category->meta_description }}
                                    </strong>

                                @else

                                    <strong class="category-details-page__muted">
                                        Not configured
                                    </strong>

                                @endif

                                <small>
                                    {{ strlen($category->meta_description ?? '') }} / 160 characters
                                </small>

                            </div>

                        </div>

                    </div>

                </section>

            </div>


            {{-- SIDEBAR --}}
            <aside class="category-details-page__sidebar">

                {{-- STATUS --}}
                <section class="category-details-page__card">

                    <div class="category-details-page__card-header">

                        <div>

                            <h4>
                                Category Status
                            </h4>

                            <p>
                                Current category settings.
                            </p>

                        </div>

                    </div>

                    <div class="category-details-page__card-body">

                        <div class="category-details-page__status-list">

                            {{-- STATUS --}}
                            <div class="category-details-page__status-item">

                                <div class="category-details-page__status-label">

                                    <span class="category-details-page__status-icon">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </span>

                                    <span>
                                        Status
                                    </span>

                                </div>

                                @if($category->status)

                                    <span class="category-details-page__badge category-details-page__badge--success">
                                        Active
                                    </span>

                                @else

                                    <span class="category-details-page__badge category-details-page__badge--danger">
                                        Inactive
                                    </span>

                                @endif

                            </div>


                            {{-- FEATURED --}}
                            <div class="category-details-page__status-item">

                                <div class="category-details-page__status-label">

                                    <span class="category-details-page__status-icon">
                                        <i class="ri-star-line"></i>
                                    </span>

                                    <span>
                                        Featured
                                    </span>

                                </div>

                                @if($category->featured)

                                    <span class="category-details-page__badge category-details-page__badge--warning">
                                        Featured
                                    </span>

                                @else

                                    <span class="category-details-page__badge category-details-page__badge--muted">
                                        No
                                    </span>

                                @endif

                            </div>


                            {{-- TYPE --}}
                            <div class="category-details-page__status-item">

                                <div class="category-details-page__status-label">

                                    <span class="category-details-page__status-icon">
                                        <i class="ri-folder-settings-line"></i>
                                    </span>

                                    <span>
                                        Category Type
                                    </span>

                                </div>

                                <strong class="category-details-page__status-value">

                                    {{ $category->parent_id ? 'Subcategory' : 'Main Category' }}

                                </strong>

                            </div>


                            {{-- SORT ORDER --}}
                            <div class="category-details-page__status-item">

                                <div class="category-details-page__status-label">

                                    <span class="category-details-page__status-icon">
                                        <i class="ri-sort-asc"></i>
                                    </span>

                                    <span>
                                        Sort Order
                                    </span>

                                </div>

                                <strong class="category-details-page__status-value">
                                    {{ $category->sort_order }}
                                </strong>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- PRODUCTS --}}
                <section class="category-details-page__card">

                    <div class="category-details-page__card-header">

                        <div>

                            <h4>
                                Products
                            </h4>

                            <p>
                                Products assigned to this category.
                            </p>

                        </div>

                        <span class="category-details-page__card-icon">
                            <i class="ri-shopping-bag-3-line"></i>
                        </span>

                    </div>

                    <div class="category-details-page__card-body">

                        <div class="category-details-page__product-stat">

                            <div class="category-details-page__product-stat-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>

                            <div>

                                <strong>
                                    {{ $category->products_count ?? $category->products->count() }}
                                </strong>

                                <span>
                                    Products assigned
                                </span>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- RECORD INFORMATION --}}
                <section class="category-details-page__card">

                    <div class="category-details-page__card-header">

                        <div>

                            <h4>
                                Record Information
                            </h4>

                        </div>

                        <span class="category-details-page__card-icon">
                            <i class="ri-information-line"></i>
                        </span>

                    </div>

                    <div class="category-details-page__card-body">

                        <div class="category-details-page__record">

                            <div>

                                <span>
                                    Category ID
                                </span>

                                <strong>
                                    #{{ $category->id }}
                                </strong>

                            </div>

                            <div>

                                <span>
                                    Created
                                </span>

                                <strong>
                                    {{ $category->created_at?->format('d M Y, h:i A') }}
                                </strong>

                            </div>

                            <div>

                                <span>
                                    Last Updated
                                </span>

                                <strong>
                                    {{ $category->updated_at?->format('d M Y, h:i A') }}
                                </strong>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- QUICK ACTIONS --}}
                <section class="category-details-page__card">

                    <div class="category-details-page__card-header">

                        <div>

                            <h4>
                                Quick Actions
                            </h4>

                            <p>
                                Manage this category.
                            </p>

                        </div>

                    </div>

                    <div class="category-details-page__card-body">

                        <div class="category-details-page__quick-actions">

                            <a
                                href="{{ route('admin-categories.edit', ['category' => $category->id]) }}"
                                class="category-details-page__quick-action category-details-page__quick-action--edit"
                            >
                                <i class="ri-edit-line"></i>
                                <span>Edit Category</span>
                            </a>

                            <a
                                href="{{ route('admin-categories') }}"
                                class="category-details-page__quick-action"
                            >
                                <i class="ri-list-check-2"></i>
                                <span>All Categories</span>
                            </a>

                        </div>

                    </div>

                </section>

            </aside>

        </div>

    </div>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const page = document.querySelector(
                '.category-details-page'
            );

            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | IMAGE FALLBACK
            |--------------------------------------------------------------------------
            */

            const categoryImages = page.querySelectorAll(
                '.category-details-page__image img'
            );


            categoryImages.forEach(function (image) {

                image.addEventListener(
                    'error',
                    function () {

                        const wrapper = image.parentElement;

                        if (!wrapper) {
                            return;
                        }

                        wrapper.innerHTML = `
                            <div class="category-details-page__image-placeholder">
                                <i class="ri-folder-2-line"></i>
                            </div>
                        `;

                    }
                );

            });


            /*
            |--------------------------------------------------------------------------
            | QUICK ACTION HOVER
            |--------------------------------------------------------------------------
            */

            const quickActions = page.querySelectorAll(
                '.category-details-page__quick-action'
            );


            quickActions.forEach(function (action) {

                action.addEventListener(
                    'mouseenter',
                    function () {
                        this.classList.add(
                            'is-hovered'
                        );
                    }
                );


                action.addEventListener(
                    'mouseleave',
                    function () {
                        this.classList.remove(
                            'is-hovered'
                        );
                    }
                );

            });

        });

    </script>

@endpush
