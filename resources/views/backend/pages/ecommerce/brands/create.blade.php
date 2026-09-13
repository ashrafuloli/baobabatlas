@extends('backend.layouts.backend')

@section('title', 'Create Brand')

@section('content')

    <div class="brand-create-page">

        {{-- PAGE HEADER --}}
        <div class="brand-create-page__header">

            <div>

                <span class="brand-create-page__eyebrow">
                    Ecommerce / Brands
                </span>

                <h1>
                    Create Brand
                </h1>

                <p>
                    Create a new brand to organize and manage your ecommerce products.
                </p>

            </div>

            <a
                href="{{ route('admin-brands') }}"
                class="brand-create-page__back-btn"
            >

                <i class="ri-arrow-left-line"></i>

                Back to Brands

            </a>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('admin-brands.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="brand-create-form"
        >

            @csrf


            {{-- BRAND INFORMATION --}}
            <div class="brand-create-card">

                <div class="brand-create-card__header">

                    <div>

                        <h4>
                            Brand Information
                        </h4>

                        <p>
                            Add the basic information for your new brand.
                        </p>

                    </div>

                </div>


                <div class="brand-create-card__body">

                    <div class="brand-create-grid">

                        {{-- NAME --}}
                        <div class="brand-create-field">

                            <label for="name">

                                Brand Name

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="e.g. Apple"
                            >

                            @error('name')

                            <div class="brand-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Enter a clear and recognizable brand name.
                            </small>

                        </div>


                        {{-- SLUG --}}
                        <div class="brand-create-field">

                            <label for="slug">
                                Slug
                            </label>

                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                value="{{ old('slug') }}"
                                placeholder="e.g. apple"
                                data-manual="{{ old('slug') ? 'true' : 'false' }}"
                            >

                            @error('slug')

                            <div class="brand-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Leave blank to generate automatically from brand name.
                            </small>

                        </div>


                        {{-- DESCRIPTION --}}
                        <div class="brand-create-field brand-create-field--full">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                placeholder="Write a short description for this brand..."
                            >{{ old('description') }}</textarea>

                            @error('description')

                            <div class="brand-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                A short description can help customers learn more about the brand.
                            </small>

                        </div>


                        {{-- SORT ORDER --}}
                        <div class="brand-create-field">

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

                            <div class="brand-create-error">
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


            {{-- BRAND SETTINGS --}}
            <div class="brand-create-card">

                <div class="brand-create-card__header">

                    <div>

                        <h4>
                            Brand Settings
                        </h4>

                        <p>
                            Configure how this brand behaves in your store.
                        </p>

                    </div>

                </div>


                <div class="brand-create-card__body">

                    <div class="brand-create-settings">

                        {{-- STATUS --}}
                        <div class="brand-create-setting">

                            <div class="brand-create-setting__content">

                                <div class="brand-create-setting__icon">

                                    <i class="ri-checkbox-circle-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Brand Status
                                    </strong>

                                    <span>
                                        Make this brand available in your store.
                                    </span>

                                </div>

                            </div>


                            <label class="brand-create-switch">

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
                        <div class="brand-create-setting">

                            <div class="brand-create-setting__content">

                                <div class="brand-create-setting__icon">

                                    <i class="ri-star-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Featured Brand
                                    </strong>

                                    <span>
                                        Display this brand in featured sections.
                                    </span>

                                </div>

                            </div>


                            <label class="brand-create-switch">

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


            {{-- BRAND LOGO --}}
            <div class="brand-create-card">

                <div class="brand-create-card__header">

                    <div>

                        <h4>
                            Brand Logo
                        </h4>

                        <p>
                            Add a logo to visually represent this brand.
                        </p>

                    </div>

                </div>


                <div class="brand-create-card__body">

                    <div class="brand-create-logo-upload">

                        <div class="brand-create-logo-upload__icon">

                            <i class="ri-image-add-line"></i>

                        </div>


                        <div class="brand-create-logo-upload__content">

                            <strong>
                                Upload Brand Logo
                            </strong>

                            <span>
                                PNG, JPG or WEBP. Maximum size 2MB.
                            </span>

                        </div>


                        <label
                            for="brand_logo"
                            class="brand-create-logo-upload__btn"
                        >

                            <i class="ri-upload-2-line"></i>

                            Choose Logo

                        </label>


                        <input
                            type="file"
                            id="brand_logo"
                            name="brand_logo"
                            accept=".jpg,.jpeg,.png,.webp"
                            hidden
                        >

                    </div>


                    <div
                        class="brand-create-logo-preview"
                        id="brandLogoPreview"
                    ></div>


                    @error('brand_logo')

                    <div class="brand-create-error">
                        {{ $message }}
                    </div>

                    @enderror

                </div>

            </div>


            {{-- SEO --}}
            <div class="brand-create-card">

                <div class="brand-create-card__header">

                    <div>

                        <h4>
                            SEO
                        </h4>

                        <p>
                            Add search engine information for this brand.
                        </p>

                    </div>

                </div>


                <div class="brand-create-card__body">

                    <div class="brand-create-grid">

                        {{-- META TITLE --}}
                        <div class="brand-create-field brand-create-field--full">

                            <label for="meta_title">
                                Meta Title
                            </label>

                            <input
                                type="text"
                                id="meta_title"
                                name="meta_title"
                                value="{{ old('meta_title') }}"
                                maxlength="60"
                                placeholder="e.g. Apple Products | Baobab Atlas"
                            >

                            @error('meta_title')

                            <div class="brand-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Recommended length is around 50–60 characters.
                            </small>

                        </div>


                        {{-- META DESCRIPTION --}}
                        <div class="brand-create-field brand-create-field--full">

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

                            <div class="brand-create-error">
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
            <div class="brand-create-actions">

                <a
                    href="{{ route('admin-brands') }}"
                    class="brand-create-actions__cancel"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="brand-create-actions__submit"
                >

                    <i class="ri-save-line"></i>

                    Create Brand

                </button>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const page =
                document.querySelector('.brand-create-page');

            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | AUTO SLUG
            |--------------------------------------------------------------------------
            */

            const nameInput =
                page.querySelector('#name');

            const slugInput =
                page.querySelector('#slug');


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


                        slugInput.value =
                            this.value
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
            | LOGO PREVIEW
            |--------------------------------------------------------------------------
            */

            const logoInput =
                page.querySelector('#brand_logo');

            const logoPreview =
                page.querySelector('#brandLogoPreview');


            if (logoInput && logoPreview) {

                logoInput.addEventListener(
                    'change',
                    function () {

                        logoPreview.innerHTML = '';


                        const file =
                            this.files[0];


                        if (!file) {
                            return;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Validate Image
                        |--------------------------------------------------------------------------
                        */

                        if (!file.type.startsWith('image/')) {

                            alert(
                                'Please select a valid image file.'
                            );

                            this.value = '';

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | File Size - 2MB
                        |--------------------------------------------------------------------------
                        */

                        if (
                            file.size >
                            2 * 1024 * 1024
                        ) {

                            alert(
                                'Logo size must be less than 2MB.'
                            );

                            this.value = '';

                            return;

                        }


                        const reader =
                            new FileReader();


                        reader.onload =
                            function (event) {

                                const image =
                                    document.createElement('img');


                                image.src =
                                    event.target.result;


                                image.alt =
                                    'Brand logo preview';


                                logoPreview.appendChild(
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

            const form =
                page.querySelector(
                    '.brand-create-form'
                );


            if (form) {

                /*
                |--------------------------------------------------------------------------
                | Make sure form submits to STORE route
                |--------------------------------------------------------------------------
                */

                form.setAttribute(
                    'action',
                    '{{ route('admin-brands.store') }}'
                );


                form.setAttribute(
                    'method',
                    'POST'
                );


                /*
                |--------------------------------------------------------------------------
                | Prevent Double Submit
                |--------------------------------------------------------------------------
                */

                form.addEventListener(
                    'submit',
                    function (event) {

                        const submitButton =
                            form.querySelector(
                                '.brand-create-actions__submit'
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
                        | Force correct POST URL before submission
                        |--------------------------------------------------------------------------
                        */

                        form.action =
                            '{{ route('admin-brands.store') }}';


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
