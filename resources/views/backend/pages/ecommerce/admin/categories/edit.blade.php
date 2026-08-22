@extends('backend.layouts.backend')

@section('title', 'Edit Category')

@section('content')

    <div class="category-edit-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="category-edit-page__header">

            <div>

            <span class="category-edit-page__eyebrow">
                Ecommerce / Categories
            </span>

                <h1>
                    Edit Category
                </h1>

                <p>
                    Update category information, settings, media and SEO.
                </p>

            </div>


            <div class="category-edit-page__header-actions">

                <a
                    href="{{ route('admin-category-details', $category) }}"
                    class="category-edit-page__back-btn"
                >

                    <i class="ri-arrow-left-line"></i>

                    Back to Details

                </a>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- FORM --}}
        {{-- ================================================================ --}}

        <form
            action="#"
            method="POST"
            enctype="multipart/form-data"
            class="category-edit-form"
        >

            @csrf

            {{-- Later use @method('PUT') when update route is created --}}


            {{-- ============================================================ --}}
            {{-- CATEGORY TYPE --}}
            {{-- ============================================================ --}}

            <div class="category-edit-card">

                <div class="category-edit-card__header">

                    <div>

                        <h4>
                            Category Type
                        </h4>

                        <p>
                            Choose whether this category is a main category or a subcategory.
                        </p>

                    </div>

                </div>


                <div class="category-edit-card__body">

                    <div class="category-type-options">


                        {{-- Main Category --}}
                        <label class="category-type-option">

                            <input
                                type="radio"
                                name="category_type"
                                value="parent"
                                checked
                            >

                            <span class="category-type-option__box">

                            <span class="category-type-option__radio">

                                <i class="ri-check-line"></i>

                            </span>


                            <span class="category-type-option__icon">

                                <i class="ri-folder-2-line"></i>

                            </span>


                            <span class="category-type-option__content">

                                <strong>
                                    Main Category
                                </strong>

                                <span>
                                    Top-level category without a parent category.
                                </span>

                            </span>

                        </span>

                        </label>


                        {{-- Subcategory --}}
                        <label class="category-type-option">

                            <input
                                type="radio"
                                name="category_type"
                                value="subcategory"
                            >

                            <span class="category-type-option__box">

                            <span class="category-type-option__radio">

                                <i class="ri-check-line"></i>

                            </span>


                            <span class="category-type-option__icon">

                                <i class="ri-folder-open-line"></i>

                            </span>


                            <span class="category-type-option__content">

                                <strong>
                                    Subcategory
                                </strong>

                                <span>
                                    Place this category under an existing parent category.
                                </span>

                            </span>

                        </span>

                        </label>

                    </div>


                    {{-- Parent Category --}}
                    <div class="category-edit-parent-field">

                        <label for="parent_category">

                            Parent Category

                            <span>*</span>

                        </label>


                        <select
                            id="parent_category"
                            name="parent_category"
                        >

                            <option value="">
                                Select Parent Category
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


                        <small>
                            Select the parent category for this subcategory.
                        </small>

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- CATEGORY INFORMATION --}}
            {{-- ============================================================ --}}

            <div class="category-edit-card">

                <div class="category-edit-card__header">

                    <div>

                        <h4>
                            Category Information
                        </h4>

                        <p>
                            Update the basic information for this category.
                        </p>

                    </div>

                </div>


                <div class="category-edit-card__body">

                    <div class="category-edit-grid">


                        {{-- Category Name --}}
                        <div class="category-edit-field">

                            <label for="name">

                                Category Name

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="Electronics"
                                placeholder="e.g. Electronics"
                            >

                            <small>
                                Enter a clear and recognizable category name.
                            </small>

                        </div>


                        {{-- Slug --}}
                        <div class="category-edit-field">

                            <label for="slug">

                                Slug

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                value="electronics"
                                placeholder="e.g. electronics"
                            >

                            <small>
                                Use lowercase letters, numbers and hyphens.
                            </small>

                        </div>


                        {{-- Description --}}
                        <div class="category-edit-field category-edit-field--full">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                placeholder="Write a short description..."
                            >Explore our collection of electronics including smartphones, laptops, headphones, accessories and other technology products.</textarea>

                            <small>
                                Keep the category description clear and useful for customers.
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- CATEGORY SETTINGS --}}
            {{-- ============================================================ --}}

            <div class="category-edit-card">

                <div class="category-edit-card__header">

                    <div>

                        <h4>
                            Category Settings
                        </h4>

                        <p>
                            Control the visibility and featured status of this category.
                        </p>

                    </div>

                </div>


                <div class="category-edit-card__body">

                    <div class="category-edit-settings">


                        {{-- Status --}}
                        <div class="category-edit-setting">

                            <div class="category-edit-setting__content">

                                <div class="category-edit-setting__icon">

                                    <i class="ri-checkbox-circle-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Category Status
                                    </strong>

                                    <span>
                                    Make this category available in your store.
                                </span>

                                </div>

                            </div>


                            <label class="category-edit-switch">

                                <input
                                    type="checkbox"
                                    name="status"
                                    value="active"
                                    checked
                                >

                                <span></span>

                            </label>

                        </div>


                        {{-- Featured --}}
                        <div class="category-edit-setting">

                            <div class="category-edit-setting__content">

                                <div class="category-edit-setting__icon">

                                    <i class="ri-star-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Featured Category
                                    </strong>

                                    <span>
                                    Display this category in featured sections.
                                </span>

                                </div>

                            </div>


                            <label class="category-edit-switch">

                                <input
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                    checked
                                >

                                <span></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- CATEGORY IMAGE --}}
            {{-- ============================================================ --}}

            <div class="category-edit-card">

                <div class="category-edit-card__header">

                    <div>

                        <h4>
                            Category Image
                        </h4>

                        <p>
                            Update the image used to represent this category.
                        </p>

                    </div>

                </div>


                <div class="category-edit-card__body">

                    <div class="category-edit-image-section">


                        {{-- Current Image --}}
                        <div class="category-edit-current-image">

                            <div class="category-edit-current-image__label">
                                Current Image
                            </div>


                            <div class="category-edit-current-image__preview">

                                <img
                                    src="https://placehold.co/800x500"
                                    alt="Electronics Category"
                                >

                            </div>

                        </div>


                        {{-- Upload --}}
                        <div class="category-edit-upload">

                            <div class="category-edit-upload__icon">

                                <i class="ri-image-add-line"></i>

                            </div>


                            <div class="category-edit-upload__content">

                                <strong>
                                    Replace Category Image
                                </strong>

                                <span>
                                PNG, JPG or WEBP. Recommended size 800 × 800px.
                            </span>

                            </div>


                            <label
                                for="category_image"
                                class="category-edit-upload__btn"
                            >

                                <i class="ri-upload-2-line"></i>

                                Choose Image

                            </label>


                            <input
                                type="file"
                                id="category_image"
                                name="category_image"
                                accept=".jpg,.jpeg,.png,.webp"
                                hidden
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- SEO --}}
            {{-- ============================================================ --}}

            <div class="category-edit-card">

                <div class="category-edit-card__header">

                    <div>

                        <h4>
                            SEO
                        </h4>

                        <p>
                            Update search engine information for this category.
                        </p>

                    </div>

                </div>


                <div class="category-edit-card__body">

                    <div class="category-edit-grid">


                        {{-- Meta Title --}}
                        <div class="category-edit-field category-edit-field--full">

                            <label for="meta_title">
                                Meta Title
                            </label>

                            <input
                                type="text"
                                id="meta_title"
                                name="meta_title"
                                value="Electronics | Baobab Atlas"
                                placeholder="e.g. Electronics | Baobab Atlas"
                            >

                            <small>
                                Recommended length is around 50–60 characters.
                            </small>

                        </div>


                        {{-- Meta Description --}}
                        <div class="category-edit-field category-edit-field--full">

                            <label for="meta_description">
                                Meta Description
                            </label>

                            <textarea
                                id="meta_description"
                                name="meta_description"
                                rows="5"
                                placeholder="Write a short description for search engines..."
                            >Shop electronics at Baobab Atlas including smartphones, laptops, headphones and other technology products.</textarea>

                            <small>
                                Recommended length is around 150–160 characters.
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- FORM ACTIONS --}}
            {{-- ============================================================ --}}

            <div class="category-edit-actions">

                <a
                    href="{{ route('admin-category-details', $category) }}"
                    class="category-edit-actions__cancel"
                >

                    Cancel

                </a>


                <button
                    type="submit"
                    class="category-edit-actions__submit"
                >

                    <i class="ri-save-line"></i>

                    Save Changes

                </button>

            </div>

        </form>

    </div>

@endsection
