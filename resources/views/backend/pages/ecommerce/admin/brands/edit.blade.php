@extends('backend.layouts.backend')

@section('title', 'Edit Brand')

@section('content')

    <div class="brand-edit-page">

        {{-- PAGE HEADER --}}
        <div class="brand-edit-page__header">

            <div>

                <span class="brand-edit-page__eyebrow">
                    Ecommerce / Brands
                </span>

                <h1>
                    Edit Brand
                </h1>

                <p>
                    Update the information, settings, logo, and SEO details of this brand.
                </p>

            </div>

            <a
                href="{{ route('admin-brands') }}"
                class="brand-edit-page__back-btn"
            >

                <i class="ri-arrow-left-line"></i>

                Back to Brands

            </a>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('admin-brands.update', $brand->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="brand-edit-form"
        >

            @csrf

            @method('PUT')


            {{-- BRAND INFORMATION --}}
            <div class="brand-edit-card">

                <div class="brand-edit-card__header">

                    <div>

                        <h4>
                            Brand Information
                        </h4>

                        <p>
                            Update the basic information for this brand.
                        </p>

                    </div>

                </div>


                <div class="brand-edit-card__body">

                    <div class="brand-edit-grid">

                        {{-- NAME --}}
                        <div class="brand-edit-field">

                            <label for="name">

                                Brand Name

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $brand->name) }}"
                                placeholder="e.g. Apple"
                            >

                            @error('name')

                            <div class="brand-edit-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Enter a clear and recognizable brand name.
                            </small>

                        </div>


                        {{-- SLUG --}}
                        <div class="brand-edit-field">

                            <label for="slug">
                                Slug
                            </label>

                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                value="{{ old('slug', $brand->slug) }}"
                                placeholder="e.g. apple"
                                data-manual="{{ old('slug', $brand->slug) ? 'true' : 'false' }}"
                            >

                            @error('slug')

                            <div class="brand-edit-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Leave blank to generate automatically from brand name.
                            </small>

                        </div>


                        {{-- DESCRIPTION --}}
                        <div class="brand-edit-field brand-edit-field--full">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                placeholder="Write a short description for this brand..."
                            >{{ old('description', $brand->description) }}</textarea>

                            @error('description')

                            <div class="brand-edit-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                A short description can help customers learn more about the brand.
                            </small>

                        </div>


                        {{-- SORT ORDER --}}
                        <div class="brand-edit-field">

                            <label for="sort_order">
                                Sort Order
                            </label>

                            <input
                                type="number"
                                id="sort_order"
                                name="sort_order"
                                value="{{ old('sort_order', $brand->sort_order) }}"
                                min="0"
                            >

                            @error('sort_order')

                            <div class="brand-edit-error">
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
            <div class="brand-edit-card">

                <div class="brand-edit-card__header">

                    <div>

                        <h4>
                            Brand Settings
                        </h4>

                        <p>
                            Configure how this brand behaves in your store.
                        </p>

                    </div>

                </div>


                <div class="brand-edit-card__body">

                    <div class="brand-edit-settings">

                        {{-- STATUS --}}
                        <div class="brand-edit-setting">

                            <div class="brand-edit-setting__content">

                                <div class="brand-edit-setting__icon">

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


                            <label class="brand-edit-switch">

                                <input
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    {{ old('status', $brand->status) ? 'checked' : '' }}
                                >

                                <span></span>

                            </label>

                        </div>


                        {{-- FEATURED --}}
                        <div class="brand-edit-setting">

                            <div class="brand-edit-setting__content">

                                <div class="brand-edit-setting__icon">

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


                            <label class="brand-edit-switch">

                                <input
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                    {{ old('featured', $brand->featured) ? 'checked' : '' }}
                                >

                                <span></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- BRAND LOGO --}}
            <div class="brand-edit-card">

                <div class="brand-edit-card__header">

                    <div>

                        <h4>
                            Brand Logo
                        </h4>

                        <p>
                            Update the logo used to represent this brand.
                        </p>

                    </div>

                </div>


                <div class="brand-edit-card__body">

                    {{-- UPLOAD --}}
                    <div class="brand-edit-logo-upload">

                        <div class="brand-edit-logo-upload__icon">

                            <i class="ri-image-add-line"></i>

                        </div>


                        <div class="brand-edit-logo-upload__content">

                            <strong>
                                {{ $brand->logo ? 'Replace Brand Logo' : 'Upload Brand Logo' }}
                            </strong>

                            <span>
                                PNG, JPG or WEBP. Maximum size 2MB.
                            </span>

                        </div>


                        <label
                            for="brand_logo"
                            class="brand-edit-logo-upload__btn"
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


                    {{-- NEW LOGO PREVIEW --}}
                    <div
                        class="brand-edit-logo-preview"
                        id="brandLogoPreview"
                    >
                        {{-- EXISTING LOGO --}}
                        @if($brand->logo)
                            <img
                                src="{{ asset($brand->logo) }}"
                                alt="{{ $brand->name }}"
                            >
                        @endif
                    </div>


                    @error('brand_logo')

                    <div class="brand-edit-error">
                        {{ $message }}
                    </div>

                    @enderror

                </div>

            </div>


            {{-- SEO --}}
            <div class="brand-edit-card">

                <div class="brand-edit-card__header">

                    <div>

                        <h4>
                            SEO
                        </h4>

                        <p>
                            Update search engine information for this brand.
                        </p>

                    </div>

                </div>


                <div class="brand-edit-card__body">

                    <div class="brand-edit-grid">

                        {{-- META TITLE --}}
                        <div class="brand-edit-field brand-edit-field--full">

                            <label for="meta_title">
                                Meta Title
                            </label>

                            <input
                                type="text"
                                id="meta_title"
                                name="meta_title"
                                value="{{ old('meta_title', $brand->meta_title) }}"
                                maxlength="60"
                                placeholder="e.g. Apple Products | Baobab Atlas"
                            >

                            @error('meta_title')

                            <div class="brand-edit-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Recommended length is around 50–60 characters.
                            </small>

                        </div>


                        {{-- META DESCRIPTION --}}
                        <div class="brand-edit-field brand-edit-field--full">

                            <label for="meta_description">
                                Meta Description
                            </label>

                            <textarea
                                id="meta_description"
                                name="meta_description"
                                rows="5"
                                maxlength="160"
                                placeholder="Write a short description for search engines..."
                            >{{ old('meta_description', $brand->meta_description) }}</textarea>

                            @error('meta_description')

                            <div class="brand-edit-error">
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
            <div class="brand-edit-actions">

                <a
                    href="{{ route('admin-brands') }}"
                    class="brand-edit-actions__cancel"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="brand-edit-actions__submit"
                >

                    <i class="ri-save-line"></i>

                    Update Brand

                </button>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const page =
                document.querySelector('.brand-edit-page');

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
                                    'New brand logo preview';


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
                    '.brand-edit-form'
                );


            if (form) {

                /*
                |--------------------------------------------------------------------------
                | Make sure form submits to UPDATE route
                |--------------------------------------------------------------------------
                */

                form.setAttribute(
                    'action',
                    '{{ route('admin-brands.update', $brand->id) }}'
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
                                '.brand-edit-actions__submit'
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
                        | Force correct UPDATE URL before submission
                        |--------------------------------------------------------------------------
                        */

                        form.action =
                            '{{ route('admin-brands.update', $brand->id) }}';


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
                                Updating...
                            `;

                        }

                    }
                );

            }

        });

    </script>

@endpush
