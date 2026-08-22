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
                        href="{{ route('smart-buy') }}"
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
            Form Layout
        =======================================================--}}
        <form
            action="#"
            method="POST"
            enctype="multipart/form-data"
            class="smart-buy-form"
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
                    <div class="form-card">

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


                        <div class="form-grid">


                            {{-- Product URL --}}
                            <div class="form-group full-width">

                                <label for="product_url">
                                    Product URL
                                    <span>*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="ri-link"></i>

                                    <input
                                        type="url"
                                        id="product_url"
                                        name="product_url"
                                        placeholder="https://example.com/product"
                                        value="{{ old('product_url') }}"
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

                                <label for="product_name">
                                    Product Name / Description
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="product_name"
                                    name="product_name"
                                    placeholder="e.g. iPhone 16 Pro 256GB"
                                    value="{{ old('product_name') }}"
                                    required
                                >

                            </div>


                            {{-- Quantity --}}
                            <div class="form-group">

                                <label for="quantity">
                                    Quantity
                                    <span>*</span>
                                </label>

                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    min="1"
                                    value="{{ old('quantity', 1) }}"
                                    required
                                >

                            </div>


                            {{-- Size --}}
                            <div class="form-group">

                                <label for="size">
                                    Size
                                    <span class="optional">
                                    Optional
                                </span>
                                </label>

                                <input
                                    type="text"
                                    id="size"
                                    name="size"
                                    placeholder="e.g. Large, 42, 256GB"
                                    value="{{ old('size') }}"
                                >

                            </div>


                            {{-- Color --}}
                            <div class="form-group">

                                <label for="color">
                                    Color
                                    <span class="optional">
                                    Optional
                                </span>
                                </label>

                                <input
                                    type="text"
                                    id="color"
                                    name="color"
                                    placeholder="e.g. Black"
                                    value="{{ old('color') }}"
                                >

                            </div>


                            {{-- Product Image --}}
                            <div class="form-group full-width">

                                <label for="product_image">
                                    Product Image
                                    <span class="optional">
                                    Optional
                                </span>
                                </label>

                                <div class="upload-box">

                                    <input
                                        type="file"
                                        id="product_image"
                                        name="product_image"
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

                                </div>

                            </div>


                            {{-- Notes --}}
                            <div class="form-group full-width">

                                <label for="notes">
                                    Additional Notes
                                    <span class="optional">
                                    Optional
                                </span>
                                </label>

                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="5"
                                    placeholder="Add any details that may help us identify the exact product you want..."
                                >{{ old('notes') }}</textarea>

                            </div>

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

                                    <option value="guinea">
                                        Guinea
                                    </option>

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

@endsection
