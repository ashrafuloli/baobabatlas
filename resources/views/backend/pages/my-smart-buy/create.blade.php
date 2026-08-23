@extends('backend.layouts.backend')

@section('content')

    <div class="smart-buy-customer-create-page">

        {{--======================================================
            Page Header
        =======================================================--}}
        <div class="page-header">

            <div class="page-header-content">

                <div>

                    <a
                        href="{{ route('my-smart-buy') }}"
                        class="back-link"
                    >
                        <i class="ri-arrow-left-line"></i>
                        <span>My Smart Buy Requests</span>
                    </a>

                    <span class="page-eyebrow">
                        Smart Buy
                    </span>

                    <h1 class="page-title">
                        Start a Smart Buy Request
                    </h1>

                    <p class="page-description">
                        Can't find what you're looking for?
                        Send us the product link and we'll buy it for you.
                    </p>

                </div>

            </div>

        </div>


        {{--======================================================
            Smart Buy Message
        =======================================================--}}
        <div class="smart-buy-message">

            <div class="message-icon">
                <i class="ri-shopping-bag-3-line"></i>
            </div>

            <div class="message-content">

                <strong>
                    YOU FIND IT. WE BUY IT. WE SHIP IT.
                </strong>

                <p>
                    Find a product on any international website,
                    send us the link, and Baobab Atlas will review
                    your request and prepare a quote.
                </p>

            </div>

        </div>


        {{--======================================================
            Form
        =======================================================--}}
        <form
            class="smart-buy-form"
            action="{{ route('my-smart-buy-store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="form-layout">


                {{--================================================
                    Main Form
                =================================================--}}
                <div class="form-main">


                    {{--================================================
                        Product Information
                    =================================================--}}
                    <div class="form-card product-information-card">

                        <div class="card-header">

                            <div>

                                <span class="card-eyebrow">
                                    Step 01
                                </span>

                                <h2>
                                    Product Information
                                </h2>

                                <p>
                                    Tell us about the product you want
                                    Baobab Atlas to purchase.
                                </p>

                            </div>

                        </div>


                        {{-- Product Items Container --}}
                        <div
                            id="smartBuyItems"
                            class="smart-buy-items"
                        >


                            {{-- First Product Item --}}
                            <div
                                class="smart-buy-item"
                                data-item-index="0"
                            >

                                <div class="smart-buy-item-header">

                                    <div class="smart-buy-item-title">

                                        <span class="item-number">
                                            Item 01
                                        </span>

                                        <div>

                                            <h3>
                                                Product Details
                                            </h3>

                                            <p>
                                                Enter the details for this product.
                                            </p>

                                        </div>

                                    </div>


                                    <button
                                        type="button"
                                        class="remove-item-button"
                                        aria-label="Remove product"
                                    >

                                        <i class="ri-delete-bin-line"></i>

                                        <span>
                                            Remove
                                        </span>

                                    </button>

                                </div>


                                <div class="form-grid">


                                    {{-- Product URL --}}
                                    <div class="form-group full-width">

                                        <label>
                                            Product URL
                                            <span>*</span>
                                        </label>

                                        <div class="input-with-icon">

                                            <i class="ri-link"></i>

                                            <input
                                                type="url"
                                                name="items[0][product_url]"
                                                placeholder="https://example.com/product"
                                                value="{{ old('items.0.product_url') }}"
                                                required
                                            >

                                        </div>

                                        <small>
                                            Paste the complete link to the product
                                            from the retailer's website.
                                        </small>

                                    </div>


                                    {{-- Product Name --}}
                                    <div class="form-group full-width">

                                        <label>
                                            Product Name / Description
                                            <span>*</span>
                                        </label>

                                        <input
                                            type="text"
                                            name="items[0][product_name]"
                                            placeholder="e.g. iPhone 16 Pro 256GB"
                                            value="{{ old('items.0.product_name') }}"
                                            required
                                        >

                                    </div>


                                    {{-- Quantity --}}
                                    <div class="form-group">

                                        <label>
                                            Quantity
                                            <span>*</span>
                                        </label>

                                        <input
                                            type="number"
                                            name="items[0][quantity]"
                                            min="1"
                                            value="{{ old('items.0.quantity', 1) }}"
                                            required
                                        >

                                    </div>


                                    {{-- Size --}}
                                    <div class="form-group">

                                        <label>

                                            Size

                                            <span class="optional">
                                                Optional
                                            </span>

                                        </label>

                                        <input
                                            type="text"
                                            name="items[0][size]"
                                            placeholder="e.g. Large, 42, 256GB"
                                            value="{{ old('items.0.size') }}"
                                        >

                                    </div>


                                    {{-- Color --}}
                                    <div class="form-group">

                                        <label>

                                            Color

                                            <span class="optional">
                                                Optional
                                            </span>

                                        </label>

                                        <input
                                            type="text"
                                            name="items[0][color]"
                                            placeholder="e.g. Black"
                                            value="{{ old('items.0.color') }}"
                                        >

                                    </div>


                                    {{-- Product Image --}}
                                    <div class="form-group full-width">

                                        <label>

                                            Product Image

                                            <span class="optional">
                                                Optional
                                            </span>

                                        </label>

                                        <div class="upload-box">

                                            <input
                                                type="file"
                                                class="product-image-input"
                                                name="items[0][product_image]"
                                                accept="image/jpeg,image/png,image/webp"
                                            >

                                            <div class="upload-content">

                                                <div class="upload-icon">

                                                    <i class="ri-image-add-line"></i>

                                                </div>

                                                <div>

                                                    <strong>
                                                        Upload product image
                                                    </strong>

                                                    <span>
                                                        JPG, PNG or WEBP · Max 2MB
                                                    </span>

                                                </div>

                                                <span class="browse-text">
                                                    Browse
                                                </span>

                                            </div>

                                            <div class="image-preview-wrapper">

                                                <img
                                                    class="product-image-preview"
                                                    src=""
                                                    alt="Product preview"
                                                >

                                                <button
                                                    type="button"
                                                    class="remove-image-button"
                                                    aria-label="Remove image"
                                                >
                                                    <i class="ri-close-line"></i>
                                                </button>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Notes --}}
                                    <div class="form-group full-width">

                                        <label>

                                            Additional Notes

                                            <span class="optional">
                                                Optional
                                            </span>

                                        </label>

                                        <textarea
                                            name="items[0][notes]"
                                            rows="5"
                                            placeholder="Add any details that may help us identify the exact product you want..."
                                        >{{ old('items.0.notes') }}</textarea>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Add Another Item --}}
                        <div class="add-item-wrapper">

                            <button
                                type="button"
                                id="addSmartBuyItem"
                                class="add-item-button"
                            >

                                <i class="ri-add-line"></i>

                                <span>
                                    Add Another Item
                                </span>

                            </button>

                            <p>
                                Add another product to this Smart Buy request.
                            </p>

                        </div>

                    </div>


                    {{--================================================
                        Customer Information
                    =================================================--}}
                    <div class="form-card">

                        <div class="card-header">

                            <div>

                                <span class="card-eyebrow">
                                    Step 02
                                </span>

                                <h2>
                                    Customer Information
                                </h2>

                                <p>
                                    Confirm your contact information so
                                    we can contact you about your request.
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            {{-- First Name --}}
                            <div class="form-group">

                                <label for="first_name">
                                    First Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    value="{{ old('first_name', auth()->user()->first_name ?? '') }}"
                                    placeholder="First name"
                                    required
                                >

                            </div>


                            {{-- Last Name --}}
                            <div class="form-group">

                                <label for="last_name">
                                    Last Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    value="{{ old('last_name', auth()->user()->last_name ?? '') }}"
                                    placeholder="Last name"
                                    required
                                >

                            </div>


                            {{-- Phone --}}
                            <div class="form-group">

                                <label for="phone">
                                    Phone / WhatsApp
                                    <span>*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="ri-whatsapp-line"></i>

                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                        placeholder="+224 XXX XXX XXX"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- Email --}}
                            <div class="form-group">

                                <label for="email">
                                    Email Address
                                    <span>*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="ri-mail-line"></i>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}"
                                        placeholder="you@example.com"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    {{--================================================
                        Delivery Information
                    =================================================--}}
                    <div class="form-card">

                        <div class="card-header">

                            <div>

                                <span class="card-eyebrow">
                                    Step 03
                                </span>

                                <h2>
                                    Delivery Information
                                </h2>

                                <p>
                                    Tell us where you want your product
                                    delivered.
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            {{-- Country --}}
                            <div class="form-group">

                                <label for="country">
                                    Country
                                    <span>*</span>
                                </label>

                                <select
                                    id="country"
                                    name="country"
                                    required
                                >

                                    <option value="">
                                        Select country
                                    </option>

                                    @foreach(config('countries') as $code => $country)

                                        <option value="{{ $code }}">
                                            {{ $country }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- City --}}
                            <div class="form-group">

                                <label for="city">
                                    City
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    value="{{ old('city') }}"
                                    placeholder="e.g. Conakry"
                                    required
                                >

                            </div>


                            {{-- ZIP --}}
                            <div class="form-group">

                                <label for="zip_code">

                                    ZIP / Postal Code

                                    <span class="optional">
                                        Optional
                                    </span>

                                </label>

                                <input
                                    type="text"
                                    id="zip_code"
                                    name="zip_code"
                                    value="{{ old('zip_code') }}"
                                    placeholder="Postal code"
                                >

                            </div>


                            {{-- Address --}}
                            <div class="form-group full-width">

                                <label for="delivery_address">

                                    Delivery Address
                                    <span>*</span>

                                </label>

                                <textarea
                                    id="delivery_address"
                                    name="delivery_address"
                                    rows="4"
                                    placeholder="Enter your complete delivery address..."
                                    required
                                >{{ old('delivery_address') }}</textarea>

                            </div>

                        </div>

                    </div>


                    {{--================================================
                        Submit
                    =================================================--}}
                    <div class="form-actions">

                        <a
                            href="{{ route('smart-buy') }}"
                            class="cancel-button"
                        >
                            Cancel
                        </a>


                        <button
                            type="submit"
                            class="submit-button"
                        >

                            <i class="ri-send-plane-line"></i>

                            <span>
                                Submit Smart Buy Request
                            </span>

                        </button>

                    </div>


                </div>


                {{--================================================
                    Sidebar
                =================================================--}}
                <aside class="form-sidebar">


                    {{-- How It Works --}}
                    <div class="sidebar-card">

                        <div class="sidebar-card-header">

                            <div class="sidebar-icon">
                                <i class="ri-route-line"></i>
                            </div>

                            <div>

                                <span>
                                    How It Works
                                </span>

                                <h3>
                                    Simple & Easy
                                </h3>

                            </div>

                        </div>


                        <div class="how-it-works">


                            <div class="how-step">

                                <span class="step-number">
                                    01
                                </span>

                                <div>

                                    <strong>
                                        Find Your Product
                                    </strong>

                                    <p>
                                        Find the product you want on
                                        an international website.
                                    </p>

                                </div>

                            </div>


                            <div class="how-step">

                                <span class="step-number">
                                    02
                                </span>

                                <div>

                                    <strong>
                                        Send Us the Link
                                    </strong>

                                    <p>
                                        Paste the product URL and
                                        provide the required details.
                                    </p>

                                </div>

                            </div>


                            <div class="how-step">

                                <span class="step-number">
                                    03
                                </span>

                                <div>

                                    <strong>
                                        Receive Your Quote
                                    </strong>

                                    <p>
                                        We'll review your request and
                                        prepare a complete quote.
                                    </p>

                                </div>

                            </div>


                            <div class="how-step">

                                <span class="step-number">
                                    04
                                </span>

                                <div>

                                    <strong>
                                        Accept & Pay
                                    </strong>

                                    <p>
                                        Review the quote and pay securely
                                        when you're ready.
                                    </p>

                                </div>

                            </div>


                            <div class="how-step">

                                <span class="step-number">
                                    05
                                </span>

                                <div>

                                    <strong>
                                        We Buy & Ship
                                    </strong>

                                    <p>
                                        Baobab Atlas purchases and ships
                                        your product to Guinea.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Important Notice --}}
                    <div class="sidebar-notice">

                        <div class="notice-icon">
                            <i class="ri-information-line"></i>
                        </div>

                        <div>

                            <strong>
                                Before You Submit
                            </strong>

                            <p>
                                Make sure the product link is correct
                                and the product options such as size,
                                color, and quantity are accurate.
                            </p>

                        </div>

                    </div>


                    {{-- Trust --}}
                    <div class="trust-card">

                        <div class="trust-icon">
                            <i class="ri-shield-check-line"></i>
                        </div>

                        <div>

                            <strong>
                                Shop With Confidence
                            </strong>

                            <p>
                                Baobab Atlas will review your request
                                before you are asked to pay.
                            </p>

                        </div>

                    </div>

                </aside>

            </div>

        </form>

    </div>


    {{--======================================================
        Smart Buy Item Template
    =======================================================--}}
    <template id="smartBuyItemTemplate">

        <div
            class="smart-buy-item"
            data-item-index="__INDEX__"
        >

            <div class="smart-buy-item-header">

                <div class="smart-buy-item-title">

                    <span class="item-number">
                        Item __NUMBER__
                    </span>

                    <div>

                        <h3>
                            Product Details
                        </h3>

                        <p>
                            Enter the details for this product.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="remove-item-button"
                    aria-label="Remove product"
                >

                    <i class="ri-delete-bin-line"></i>

                    <span>
                        Remove
                    </span>

                </button>

            </div>


            <div class="form-grid">


                <div class="form-group full-width">

                    <label>
                        Product URL
                        <span>*</span>
                    </label>

                    <div class="input-with-icon">

                        <i class="ri-link"></i>

                        <input
                            type="url"
                            name="items[__INDEX__][product_url]"
                            placeholder="https://example.com/product"
                            required
                        >

                    </div>

                    <small>
                        Paste the complete link to the product
                        from the retailer's website.
                    </small>

                </div>


                <div class="form-group full-width">

                    <label>
                        Product Name / Description
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        name="items[__INDEX__][product_name]"
                        placeholder="e.g. Nike Air Max 90"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Quantity
                        <span>*</span>
                    </label>

                    <input
                        type="number"
                        name="items[__INDEX__][quantity]"
                        min="1"
                        value="1"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>

                        Size

                        <span class="optional">
                            Optional
                        </span>

                    </label>

                    <input
                        type="text"
                        name="items[__INDEX__][size]"
                        placeholder="e.g. Large, 42, 256GB"
                    >

                </div>


                <div class="form-group">

                    <label>

                        Color

                        <span class="optional">
                            Optional
                        </span>

                    </label>

                    <input
                        type="text"
                        name="items[__INDEX__][color]"
                        placeholder="e.g. Black"
                    >

                </div>


                <div class="form-group full-width">

                    <label>

                        Product Image

                        <span class="optional">
                            Optional
                        </span>

                    </label>

                    <div class="upload-box">

                        <input
                            type="file"
                            class="product-image-input"
                            name="items[__INDEX__][product_image]"
                            accept="image/jpeg,image/png,image/webp"
                        >

                        <div class="upload-content">

                            <div class="upload-icon">

                                <i class="ri-image-add-line"></i>

                            </div>


                            <div>

                                <strong>
                                    Upload product image
                                </strong>

                                <span>
                                    JPG, PNG or WEBP · Max 2MB
                                </span>

                            </div>


                            <span class="browse-text">
                                Browse
                            </span>

                        </div>


                        <div class="image-preview-wrapper">

                            <img
                                class="product-image-preview"
                                src=""
                                alt="Product preview"
                            >

                            <button
                                type="button"
                                class="remove-image-button"
                                aria-label="Remove image"
                            >
                                <i class="ri-close-line"></i>
                            </button>

                        </div>

                    </div>

                </div>


                <div class="form-group full-width">

                    <label>

                        Additional Notes

                        <span class="optional">
                            Optional
                        </span>

                    </label>

                    <textarea
                        name="items[__INDEX__][notes]"
                        rows="5"
                        placeholder="Add any details that may help us identify the exact product you want..."
                    ></textarea>

                </div>

            </div>

        </div>

    </template>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const itemsContainer = document.getElementById('smartBuyItems');
            const addItemButton = document.getElementById('addSmartBuyItem');
            const itemTemplate = document.getElementById('smartBuyItemTemplate');


            /*
            |--------------------------------------------------------------------------
            | Update Item Numbers & Field Names
            |--------------------------------------------------------------------------
            */

            function updateItems() {

                const items = itemsContainer.querySelectorAll(
                    '.smart-buy-item'
                );

                items.forEach(function (item, index) {

                    const itemNumber = String(
                        index + 1
                    ).padStart(2, '0');

                    item.dataset.itemIndex = index;


                    const itemNumberElement = item.querySelector(
                        '.item-number'
                    );

                    if (itemNumberElement) {

                        itemNumberElement.textContent =
                            'Item ' + itemNumber;

                    }


                    const fields = item.querySelectorAll(
                        'input, textarea, select'
                    );

                    fields.forEach(function (field) {

                        if (!field.name) {
                            return;
                        }

                        field.name = field.name.replace(
                            /items\[\d+\]/,
                            'items[' + index + ']'
                        );

                    });


                    const removeButton = item.querySelector(
                        '.remove-item-button'
                    );

                    if (removeButton) {

                        if (items.length === 1) {

                            removeButton.style.display = 'none';

                        } else {

                            removeButton.style.display = 'inline-flex';

                        }

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Add New Item
            |--------------------------------------------------------------------------
            */

            addItemButton.addEventListener(
                'click',
                function () {

                    const nextIndex =
                        itemsContainer.querySelectorAll(
                            '.smart-buy-item'
                        ).length;

                    const itemNumber = String(
                        nextIndex + 1
                    ).padStart(2, '0');


                    let template = itemTemplate.innerHTML;

                    template = template
                        .replaceAll('__INDEX__', nextIndex)
                        .replaceAll('__NUMBER__', itemNumber);


                    itemsContainer.insertAdjacentHTML(
                        'beforeend',
                        template
                    );


                    updateItems();


                    const newItem =
                        itemsContainer.lastElementChild;

                    if (newItem) {

                        newItem.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Remove Item
            |--------------------------------------------------------------------------
            */

            itemsContainer.addEventListener(
                'click',
                function (event) {

                    const removeButton =
                        event.target.closest(
                            '.remove-item-button'
                        );


                    if (removeButton) {

                        const item =
                            removeButton.closest(
                                '.smart-buy-item'
                            );


                        if (item) {

                            item.remove();

                            updateItems();

                        }

                        return;

                    }


                    const removeImageButton =
                        event.target.closest(
                            '.remove-image-button'
                        );


                    if (removeImageButton) {

                        const uploadBox =
                            removeImageButton.closest(
                                '.upload-box'
                            );

                        if (!uploadBox) {
                            return;
                        }


                        const imageInput =
                            uploadBox.querySelector(
                                '.product-image-input'
                            );

                        const previewWrapper =
                            uploadBox.querySelector(
                                '.image-preview-wrapper'
                            );

                        const previewImage =
                            uploadBox.querySelector(
                                '.product-image-preview'
                            );


                        if (imageInput) {
                            imageInput.value = '';
                        }


                        if (previewImage) {
                            previewImage.src = '';
                        }


                        if (previewWrapper) {
                            previewWrapper.classList.remove(
                                'has-image'
                            );
                        }

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Product Image Preview
            |--------------------------------------------------------------------------
            */

            itemsContainer.addEventListener(
                'change',
                function (event) {

                    const imageInput =
                        event.target.closest(
                            '.product-image-input'
                        );


                    if (!imageInput) {
                        return;
                    }


                    const file =
                        imageInput.files[0];


                    if (!file) {
                        return;
                    }


                    const allowedTypes = [
                        'image/jpeg',
                        'image/png',
                        'image/webp'
                    ];


                    const maxFileSize =
                        2 * 1024 * 1024;


                    if (
                        !allowedTypes.includes(file.type)
                    ) {

                        imageInput.value = '';

                        if (typeof showToast === 'function') {

                            showToast(
                                'Only JPG, PNG or WEBP images are allowed.',
                                'error'
                            );

                        } else {

                            alert(
                                'Only JPG, PNG or WEBP images are allowed.'
                            );

                        }

                        return;

                    }


                    if (
                        file.size > maxFileSize
                    ) {

                        imageInput.value = '';

                        if (typeof showToast === 'function') {

                            showToast(
                                'Image size must not exceed 2MB.',
                                'error'
                            );

                        } else {

                            alert(
                                'Image size must not exceed 2MB.'
                            );

                        }

                        return;

                    }


                    const uploadBox =
                        imageInput.closest(
                            '.upload-box'
                        );


                    const previewWrapper =
                        uploadBox.querySelector(
                            '.image-preview-wrapper'
                        );


                    const previewImage =
                        uploadBox.querySelector(
                            '.product-image-preview'
                        );


                    const reader =
                        new FileReader();


                    reader.onload = function (e) {

                        previewImage.src =
                            e.target.result;

                        previewWrapper.classList.add(
                            'has-image'
                        );

                    };


                    reader.readAsDataURL(file);

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Initial Setup
            |--------------------------------------------------------------------------
            */

            updateItems();

        });

    </script>

@endsection
