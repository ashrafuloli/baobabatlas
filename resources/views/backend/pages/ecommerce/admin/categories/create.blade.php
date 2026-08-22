@extends('backend.layouts.backend')

@section('title', 'Create Category')

@section('content')

    <div class="category-create-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="category-create-page__header">

            <div>

            <span class="category-create-page__eyebrow">
                Ecommerce / Categories
            </span>

                <h1>
                    Create Category
                </h1>

                <p>
                    Create a new category or subcategory to organize your ecommerce products.
                </p>

            </div>


            <a
                href="{{ route('admin-categories') }}"
                class="category-create-page__back-btn"
            >

                <i class="ri-arrow-left-line"></i>

                Back to Categories

            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- FORM --}}
        {{-- ================================================================ --}}

        <form
            action="#"
            method="POST"
            enctype="multipart/form-data"
            class="category-create-form"
        >

            @csrf


            {{-- ============================================================ --}}
            {{-- CATEGORY TYPE --}}
            {{-- ============================================================ --}}

            <div class="category-create-card">

                <div class="category-create-card__header">

                    <div>

                        <h4>
                            Category Type
                        </h4>

                        <p>
                            Choose whether this will be a main category or a subcategory.
                        </p>

                    </div>

                </div>


                <div class="category-create-card__body">

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
                                    Create a top-level category without a parent.
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
                                    Create a category under an existing parent category.
                                </span>

                            </span>

                        </span>

                        </label>

                    </div>


                    {{-- Parent Category --}}
                    <div class="category-parent-field">

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
                            Select the main category where this subcategory will belong.
                        </small>

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- CATEGORY INFORMATION --}}
            {{-- ============================================================ --}}

            <div class="category-create-card">

                <div class="category-create-card__header">

                    <div>

                        <h4>
                            Category Information
                        </h4>

                        <p>
                            Add the basic information for your new category.
                        </p>

                    </div>

                </div>


                <div class="category-create-card__body">

                    <div class="category-create-grid">


                        {{-- Category Name --}}
                        <div class="category-create-field">

                            <label for="name">

                                Category Name

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="e.g. Smartphones"
                            >

                            <small>
                                Enter a clear and recognizable category name.
                            </small>

                        </div>


                        {{-- Slug --}}
                        <div class="category-create-field">

                            <label for="slug">

                                Slug

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                placeholder="e.g. smartphones"
                            >

                            <small>
                                Use lowercase letters, numbers and hyphens.
                            </small>

                        </div>


                        {{-- Description --}}
                        <div class="category-create-field category-create-field--full">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                placeholder="Write a short description for this category..."
                            ></textarea>

                            <small>
                                A short description can help customers understand the category.
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- CATEGORY SETTINGS --}}
            {{-- ============================================================ --}}

            <div class="category-create-card">

                <div class="category-create-card__header">

                    <div>

                        <h4>
                            Category Settings
                        </h4>

                        <p>
                            Configure how this category behaves in your store.
                        </p>

                    </div>

                </div>


                <div class="category-create-card__body">

                    <div class="category-create-settings">


                        {{-- Status --}}
                        <div class="category-create-setting">

                            <div class="category-create-setting__content">

                                <div class="category-create-setting__icon">

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


                            <label class="category-create-switch">

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
                        <div class="category-create-setting">

                            <div class="category-create-setting__content">

                                <div class="category-create-setting__icon">

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


                            <label class="category-create-switch">

                                <input
                                    type="checkbox"
                                    name="featured"
                                    value="1"
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

            <div class="category-create-card">

                <div class="category-create-card__header">

                    <div>

                        <h4>
                            Category Image
                        </h4>

                        <p>
                            Add an image to visually represent this category.
                        </p>

                    </div>

                </div>


                <div class="category-create-card__body">

                    <div class="category-create-image-upload">

                        <div class="category-create-image-upload__icon">

                            <i class="ri-image-add-line"></i>

                        </div>


                        <div class="category-create-image-upload__content">

                            <strong>
                                Upload Category Image
                            </strong>

                            <span>
                            PNG, JPG or WEBP. Recommended size 800 × 800px.
                        </span>

                        </div>


                        <label
                            for="category_image"
                            class="category-create-image-upload__btn"
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


            {{-- ============================================================ --}}
            {{-- SEO --}}
            {{-- ============================================================ --}}

            <div class="category-create-card">

                <div class="category-create-card__header">

                    <div>

                        <h4>
                            SEO
                        </h4>

                        <p>
                            Add search engine information for this category.
                        </p>

                    </div>

                </div>


                <div class="category-create-card__body">

                    <div class="category-create-grid">


                        {{-- Meta Title --}}
                        <div class="category-create-field category-create-field--full">

                            <label for="meta_title">
                                Meta Title
                            </label>

                            <input
                                type="text"
                                id="meta_title"
                                name="meta_title"
                                placeholder="e.g. Smartphones | Baobab Atlas"
                            >

                            <small>
                                Recommended length is around 50–60 characters.
                            </small>

                        </div>


                        {{-- Meta Description --}}
                        <div class="category-create-field category-create-field--full">

                            <label for="meta_description">
                                Meta Description
                            </label>

                            <textarea
                                id="meta_description"
                                name="meta_description"
                                rows="5"
                                placeholder="Write a short description for search engines..."
                            ></textarea>

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

            <div class="category-create-actions">

                <a
                    href="{{ route('admin-categories') }}"
                    class="category-create-actions__cancel"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="category-create-actions__submit"
                >

                    <i class="ri-save-line"></i>

                    Create Category

                </button>

            </div>

        </form>

    </div>

@endsection
