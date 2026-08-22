@extends('backend.layouts.backend')

@section('title', 'Category Details')

@section('content')

    <div class="category-details-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="category-details-page__header">

            <div>

            <span class="category-details-page__eyebrow">
                Ecommerce / Categories
            </span>

                <div class="category-details-page__title-row">

                    <div class="category-details-page__title-icon">

                        <i class="ri-smartphone-line"></i>

                    </div>

                    <div>

                        <div class="category-details-page__title">

                            <h1>
                                Electronics
                            </h1>

                            <span class="category-details-status category-details-status--active">
                            <i></i>
                            Active
                        </span>

                        </div>

                        <p>
                            Main product category
                        </p>

                    </div>

                </div>

            </div>


            <div class="category-details-page__actions">

                {{-- Back to Categories --}}
                <a
                    href="{{ route('admin-categories') }}"
                    class="category-details-btn category-details-btn--secondary"
                >

                    <i class="ri-arrow-left-line"></i>

                    Back to Categories

                </a>


                {{-- Edit route will be added later --}}
                <button
                    type="button"
                    class="category-details-btn category-details-btn--primary"
                >

                    <i class="ri-edit-line"></i>

                    Edit Category

                </button>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- OVERVIEW --}}
        {{-- ================================================================ --}}

        <div class="category-details-overview">


            {{-- Category Information --}}
            <div class="category-details-overview__main">

                <div class="category-details-card">

                    <div class="category-details-card__header">

                        <div>

                            <h4>
                                Category Information
                            </h4>

                            <p>
                                Basic information about this category.
                            </p>

                        </div>

                    </div>


                    <div class="category-details-card__body">

                        <div class="category-info-grid">


                            <div class="category-info-item">

                            <span>
                                Category Name
                            </span>

                                <strong>
                                    Electronics
                                </strong>

                            </div>


                            <div class="category-info-item">

                            <span>
                                Slug
                            </span>

                                <strong>
                                    electronics
                                </strong>

                            </div>


                            <div class="category-info-item">

                            <span>
                                Category Type
                            </span>

                                <strong>
                                    Main Category
                                </strong>

                            </div>


                            <div class="category-info-item">

                            <span>
                                Parent Category
                            </span>

                                <strong>
                                    None
                                </strong>

                            </div>


                            <div class="category-info-item category-info-item--full">

                            <span>
                                Description
                            </span>

                                <p>
                                    Explore our collection of electronics including
                                    smartphones, laptops, headphones, accessories
                                    and other technology products.
                                </p>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- Category Image --}}
                <div class="category-details-card">

                    <div class="category-details-card__header">

                        <div>

                            <h4>
                                Category Image
                            </h4>

                            <p>
                                Main image used to represent this category.
                            </p>

                        </div>

                    </div>


                    <div class="category-details-card__body">

                        <div class="category-details-image">

                            <img
                                src="https://placehold.co/800x500"
                                alt="Electronics Category"
                            >

                        </div>

                    </div>

                </div>


                {{-- SEO --}}
                <div class="category-details-card">

                    <div class="category-details-card__header">

                        <div>

                            <h4>
                                SEO
                            </h4>

                            <p>
                                Search engine optimization information.
                            </p>

                        </div>

                    </div>


                    <div class="category-details-card__body">

                        <div class="category-info-grid">


                            <div class="category-info-item category-info-item--full">

                            <span>
                                Meta Title
                            </span>

                                <strong>
                                    Electronics | Baobab Atlas
                                </strong>

                            </div>


                            <div class="category-info-item category-info-item--full">

                            <span>
                                Meta Description
                            </span>

                                <p>
                                    Shop electronics at Baobab Atlas including
                                    smartphones, laptops, headphones and other
                                    technology products.
                                </p>

                            </div>


                            <div class="category-info-item category-info-item--full">

                            <span>
                                Slug
                            </span>

                                <strong>
                                    electronics
                                </strong>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- SIDEBAR --}}
            {{-- ============================================================ --}}

            <aside class="category-details-overview__sidebar">


                {{-- Statistics --}}
                <div class="category-details-card">

                    <div class="category-details-card__header">

                        <div>

                            <h4>
                                Category Overview
                            </h4>

                        </div>

                    </div>


                    <div class="category-details-card__body">

                        <div class="category-stat-list">


                            <div class="category-stat-item">

                                <div class="category-stat-item__icon">
                                    <i class="ri-shopping-bag-3-line"></i>
                                </div>

                                <div>

                                <span>
                                    Products
                                </span>

                                    <strong>
                                        48
                                    </strong>

                                </div>

                            </div>


                            <div class="category-stat-item">

                                <div class="category-stat-item__icon">
                                    <i class="ri-folder-open-line"></i>
                                </div>

                                <div>

                                <span>
                                    Subcategories
                                </span>

                                    <strong>
                                        5
                                    </strong>

                                </div>

                            </div>


                            <div class="category-stat-item">

                                <div class="category-stat-item__icon">
                                    <i class="ri-eye-line"></i>
                                </div>

                                <div>

                                <span>
                                    Status
                                </span>

                                    <strong class="category-stat-item__success">
                                        Active
                                    </strong>

                                </div>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- Category Dates --}}
                <div class="category-details-card">

                    <div class="category-details-card__header">

                        <div>

                            <h4>
                                Category Dates
                            </h4>

                        </div>

                    </div>


                    <div class="category-details-card__body">

                        <div class="category-date-list">


                            <div class="category-date-item">

                            <span>
                                Created
                            </span>

                                <strong>
                                    Aug 01, 2026
                                </strong>

                            </div>


                            <div class="category-date-item">

                            <span>
                                Last Updated
                            </span>

                                <strong>
                                    Aug 15, 2026
                                </strong>

                            </div>


                        </div>

                    </div>

                </div>


                {{-- Category Status --}}
                <div class="category-details-card">

                    <div class="category-details-card__header">

                        <div>

                            <h4>
                                Category Status
                            </h4>

                        </div>

                    </div>


                    <div class="category-details-card__body">

                        <div class="category-status-box">

                            <div class="category-status-box__icon">

                                <i class="ri-checkbox-circle-line"></i>

                            </div>

                            <div>

                                <strong>
                                    Active
                                </strong>

                                <span>
                                This category is currently visible
                                in the store.
                            </span>

                            </div>

                        </div>

                    </div>

                </div>


            </aside>

        </div>


        {{-- ================================================================ --}}
        {{-- SUBCATEGORIES --}}
        {{-- ================================================================ --}}

        <div class="category-details-card">

            <div class="category-details-card__header">

                <div>

                    <h4>
                        Subcategories
                    </h4>

                    <p>
                        Categories that belong to Electronics.
                    </p>

                </div>


                <span class="category-details-count">
                5 Subcategories
            </span>

            </div>


            <div class="category-details-card__body">

                <div class="category-subcategories">


                    {{-- Subcategory 1 --}}
                    <div class="category-subcategory">

                        <div class="category-subcategory__icon">
                            <i class="ri-smartphone-line"></i>
                        </div>

                        <div class="category-subcategory__content">

                            <strong>
                                Smartphones
                            </strong>

                            <span>
                            18 Products
                        </span>

                        </div>

                        <span class="category-details-status category-details-status--active">
                        <i></i>
                        Active
                    </span>

                    </div>


                    {{-- Subcategory 2 --}}
                    <div class="category-subcategory">

                        <div class="category-subcategory__icon">
                            <i class="ri-macbook-line"></i>
                        </div>

                        <div class="category-subcategory__content">

                            <strong>
                                Laptops
                            </strong>

                            <span>
                            12 Products
                        </span>

                        </div>

                        <span class="category-details-status category-details-status--active">
                        <i></i>
                        Active
                    </span>

                    </div>


                    {{-- Subcategory 3 --}}
                    <div class="category-subcategory">

                        <div class="category-subcategory__icon">
                            <i class="ri-headphone-line"></i>
                        </div>

                        <div class="category-subcategory__content">

                            <strong>
                                Headphones
                            </strong>

                            <span>
                            8 Products
                        </span>

                        </div>

                        <span class="category-details-status category-details-status--active">
                        <i></i>
                        Active
                    </span>

                    </div>


                    {{-- Subcategory 4 --}}
                    <div class="category-subcategory">

                        <div class="category-subcategory__icon">
                            <i class="ri-keyboard-line"></i>
                        </div>

                        <div class="category-subcategory__content">

                            <strong>
                                Computer Accessories
                            </strong>

                            <span>
                            6 Products
                        </span>

                        </div>

                        <span class="category-details-status category-details-status--active">
                        <i></i>
                        Active
                    </span>

                    </div>


                    {{-- Subcategory 5 --}}
                    <div class="category-subcategory">

                        <div class="category-subcategory__icon">
                            <i class="ri-camera-line"></i>
                        </div>

                        <div class="category-subcategory__content">

                            <strong>
                                Cameras
                            </strong>

                            <span>
                            4 Products
                        </span>

                        </div>

                        <span class="category-details-status category-details-status--inactive">
                        <i></i>
                        Inactive
                    </span>

                    </div>


                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PRODUCT SUMMARY --}}
        {{-- ================================================================ --}}

        <div class="category-details-card">

            <div class="category-details-card__header">

                <div>

                    <h4>
                        Product Summary
                    </h4>

                    <p>
                        Product distribution within this category.
                    </p>

                </div>

            </div>


            <div class="category-details-card__body">

                <div class="category-product-summary">


                    <div class="category-product-summary__item">

                        <div class="category-product-summary__icon">
                            <i class="ri-checkbox-circle-line"></i>
                        </div>

                        <div>

                        <span>
                            Active Products
                        </span>

                            <strong>
                                42
                            </strong>

                        </div>

                    </div>


                    <div class="category-product-summary__item">

                        <div class="category-product-summary__icon category-product-summary__icon--warning">
                            <i class="ri-draft-line"></i>
                        </div>

                        <div>

                        <span>
                            Draft Products
                        </span>

                            <strong>
                                4
                            </strong>

                        </div>

                    </div>


                    <div class="category-product-summary__item">

                        <div class="category-product-summary__icon category-product-summary__icon--danger">
                            <i class="ri-error-warning-line"></i>
                        </div>

                        <div>

                        <span>
                            Out of Stock
                        </span>

                            <strong>
                                2
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
