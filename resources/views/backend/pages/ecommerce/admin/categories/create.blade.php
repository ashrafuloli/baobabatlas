@extends('backend.layouts.backend')

@section('title', 'Create Category')

@section('content')

    <div class="category-create-page">

        {{-- PAGE HEADER --}}
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
                href="{{ route('categories') }}"
                class="category-create-page__back-btn"
            >
                <i class="ri-arrow-left-line"></i>
                Back to Categories
            </a>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('admin-categories.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="category-create-form"
        >

            @csrf


            {{-- CATEGORY TYPE --}}
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

                        {{-- MAIN CATEGORY --}}
                        <label class="category-type-option">

                            <input
                                type="radio"
                                name="category_type"
                                value="parent"
                                {{ old('category_type', 'parent') === 'parent' ? 'checked' : '' }}
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


                        {{-- SUBCATEGORY --}}
                        <label class="category-type-option">

                            <input
                                type="radio"
                                name="category_type"
                                value="subcategory"
                                {{ old('category_type') === 'subcategory' ? 'checked' : '' }}
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


                    {{-- PARENT CATEGORY --}}
                    <div
                        class="category-parent-field"
                        id="parentCategoryField"
                    >

                        <label for="parent_id">

                            Parent Category

                            <span>*</span>

                        </label>

                        <select
                            id="parent_id"
                            name="parent_id"
                        >

                            <option value="">
                                Select Parent Category
                            </option>

                            @foreach($parentCategories as $parentCategory)

                                <option
                                    value="{{ $parentCategory->id }}"
                                    {{ old('parent_id') == $parentCategory->id ? 'selected' : '' }}
                                >
                                    {{ $parentCategory->name }}
                                </option>

                            @endforeach

                        </select>

                        <small>
                            Select the main category where this subcategory will belong.
                        </small>

                        @error('parent_id')

                        <div class="category-create-error">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- CATEGORY INFORMATION --}}
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

                        {{-- NAME --}}
                        <div class="category-create-field">

                            <label for="name">

                                Category Name

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="e.g. Smartphones"
                            >

                            @error('name')

                            <div class="category-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Enter a clear and recognizable category name.
                            </small>

                        </div>


                        {{-- SLUG --}}
                        <div class="category-create-field">

                            <label for="slug">
                                Slug
                            </label>

                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                value="{{ old('slug') }}"
                                placeholder="e.g. smartphones"
                                data-manual="{{ old('slug') ? 'true' : 'false' }}"
                            >

                            @error('slug')

                            <div class="category-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Leave blank to generate automatically from category name.
                            </small>

                        </div>


                        {{-- DESCRIPTION --}}
                        <div class="category-create-field category-create-field--full">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                placeholder="Write a short description for this category..."
                            >{{ old('description') }}</textarea>

                            @error('description')

                            <div class="category-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                A short description can help customers understand the category.
                            </small>

                        </div>


                        {{-- SORT ORDER --}}
                        <div class="category-create-field">

                            <label for="sort_order">
                                Sort Order
                            </label>

                            <input
                                type="number"
                                id="sort_order"
                                name="sort_order"
                                value="{{ old('sort_order', 0) }}"
                                min="0"
                            >

                            @error('sort_order')

                            <div class="category-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Lower numbers appear first.
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CATEGORY SETTINGS --}}
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

                        {{-- STATUS --}}
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
                                    value="1"
                                    {{ old('status', true) ? 'checked' : '' }}
                                >

                                <span></span>

                            </label>

                        </div>


                        {{-- FEATURED --}}
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
                                    {{ old('featured') ? 'checked' : '' }}
                                >

                                <span></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CATEGORY IMAGE --}}
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
                                PNG, JPG or WEBP. Maximum size 2MB.
                            </span>

                        </div>

                        <label
                            for="image"
                            class="category-create-image-upload__btn"
                        >

                            <i class="ri-upload-2-line"></i>

                            Choose Image

                        </label>

                        <input
                            type="file"
                            id="image"
                            name="category_image"
                            accept=".jpg,.jpeg,.png,.webp"
                            hidden
                        >

                    </div>

                    <div
                        class="category-create-image-preview"
                        id="categoryImagePreview"
                    ></div>

                    @error('image')

                    <div class="category-create-error">
                        {{ $message }}
                    </div>

                    @enderror

                </div>

            </div>


            {{-- SEO --}}
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

                        {{-- META TITLE --}}
                        <div class="category-create-field category-create-field--full">

                            <label for="meta_title">
                                Meta Title
                            </label>

                            <input
                                type="text"
                                id="meta_title"
                                name="meta_title"
                                value="{{ old('meta_title') }}"
                                maxlength="60"
                                placeholder="e.g. Smartphones | Baobab Atlas"
                            >

                            @error('meta_title')

                            <div class="category-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Recommended length is around 50–60 characters.
                            </small>

                        </div>


                        {{-- META DESCRIPTION --}}
                        <div class="category-create-field category-create-field--full">

                            <label for="meta_description">
                                Meta Description
                            </label>

                            <textarea
                                id="meta_description"
                                name="meta_description"
                                rows="5"
                                maxlength="160"
                                placeholder="Write a short description for search engines..."
                            >{{ old('meta_description') }}</textarea>

                            @error('meta_description')

                            <div class="category-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Recommended length is around 150–160 characters.
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FORM ACTIONS --}}
            <div class="category-create-actions">

                <a
                    href="{{ route('categories') }}"
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


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const page = document.querySelector('.category-create-page');

            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CATEGORY TYPE
            |--------------------------------------------------------------------------
            */

            const typeInputs = page.querySelectorAll(
                'input[name="category_type"]'
            );

            const parentField = page.querySelector(
                '#parentCategoryField'
            );

            const parentSelect = page.querySelector(
                '#parent_id'
            );


            function toggleParentField() {

                const selected = page.querySelector(
                    'input[name="category_type"]:checked'
                );

                if (!selected || !parentField) {
                    return;
                }


                if (selected.value === 'subcategory') {

                    parentField.style.display = 'block';

                    if (parentSelect) {
                        parentSelect.required = true;
                    }

                } else {

                    parentField.style.display = 'none';

                    if (parentSelect) {
                        parentSelect.required = false;
                        parentSelect.value = '';
                    }

                }

            }


            typeInputs.forEach(function (input) {

                input.addEventListener(
                    'change',
                    toggleParentField
                );

            });


            toggleParentField();


            /*
            |--------------------------------------------------------------------------
            | AUTO SLUG
            |--------------------------------------------------------------------------
            */

            const nameInput = page.querySelector('#name');

            const slugInput = page.querySelector('#slug');


            if (nameInput && slugInput) {

                nameInput.addEventListener(
                    'input',
                    function () {

                        /*
                        |--------------------------------------------------------------------------
                        | Don't overwrite manually entered slug
                        |--------------------------------------------------------------------------
                        */

                        if (
                            slugInput.dataset.manual === 'true'
                        ) {
                            return;
                        }


                        slugInput.value = this.value
                            .toLowerCase()
                            .trim()
                            .replace(/[^a-z0-9]+/g, '-')
                            .replace(/^-+|-+$/g, '');

                    }
                );


                slugInput.addEventListener(
                    'input',
                    function () {

                        this.dataset.manual =
                            this.value.trim().length > 0
                                ? 'true'
                                : 'false';

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | IMAGE PREVIEW
            |--------------------------------------------------------------------------
            */

            const imageInput = page.querySelector('#image');

            const imagePreview = page.querySelector(
                '#categoryImagePreview'
            );


            if (imageInput && imagePreview) {

                imageInput.addEventListener(
                    'change',
                    function () {

                        imagePreview.innerHTML = '';


                        const file = this.files[0];


                        if (!file) {
                            return;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Validate Image
                        |--------------------------------------------------------------------------
                        */

                        if (!file.type.startsWith('image/')) {

                            this.value = '';

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | File Size - 2MB
                        |--------------------------------------------------------------------------
                        */

                        if (file.size > 2 * 1024 * 1024) {

                            alert(
                                'Image size must be less than 2MB.'
                            );

                            this.value = '';

                            return;

                        }


                        const reader = new FileReader();


                        reader.onload = function (event) {

                            const image =
                                document.createElement('img');


                            image.src =
                                event.target.result;


                            image.alt =
                                'Category preview';


                            imagePreview.appendChild(
                                image
                            );

                        };


                        reader.readAsDataURL(file);

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | FORM SUBMIT
            |--------------------------------------------------------------------------
            */

            const form = page.querySelector(
                '.category-create-form'
            );


            if (form) {

                /*
                |--------------------------------------------------------------------------
                | Make sure form submits to STORE route
                |--------------------------------------------------------------------------
                */

                form.setAttribute(
                    'action',
                    '{{ route('admin-categories.store') }}'
                );


                form.setAttribute(
                    'method',
                    'POST'
                );


                /*
                |--------------------------------------------------------------------------
                | Submit Handler
                |--------------------------------------------------------------------------
                */

                form.addEventListener(
                    'submit',
                    function (event) {

                        /*
                        |--------------------------------------------------------------------------
                        | Ensure subcategory has parent category
                        |--------------------------------------------------------------------------
                        */

                        const selectedType =
                            page.querySelector(
                                'input[name="category_type"]:checked'
                            );


                        if (
                            selectedType &&
                            selectedType.value === 'subcategory' &&
                            parentSelect &&
                            !parentSelect.value
                        ) {

                            event.preventDefault();

                            parentSelect.focus();

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Prevent Double Submit
                        |--------------------------------------------------------------------------
                        */

                        const submitButton =
                            form.querySelector(
                                '.category-create-actions__submit'
                            );


                        if (
                            submitButton &&
                            submitButton.disabled
                        ) {

                            event.preventDefault();

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | IMPORTANT:
                        | Force correct POST URL before submission
                        |--------------------------------------------------------------------------
                        */

                        form.action =
                            '{{ route('admin-categories.store') }}';


                        form.method =
                            'POST';


                        /*
                        |--------------------------------------------------------------------------
                        | Disable button
                        |--------------------------------------------------------------------------
                        */

                        if (submitButton) {

                            submitButton.disabled = true;


                            submitButton.innerHTML = `
                            <i class="ri-loader-4-line"></i>
                            Creating...
                        `;

                        }

                    }
                );

            }

        });

    </script>
@endpush
