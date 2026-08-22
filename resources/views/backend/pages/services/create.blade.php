@extends('backend.layouts.backend')

@section('title', 'Create Service')

@section('content')

    <div class="service-create-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="service-create-header">

            <div class="service-create-header__content">

                <a
                    href="{{ route('services') }}"
                    class="service-create-back"
                >
                    <i class="fa-regular fa-arrow-left"></i>

                    <span>
                    Back to Services
                </span>
                </a>

                <span class="service-create-eyebrow">
                Service Management
            </span>

                <h1>
                    Create Service
                </h1>

                <p>
                    Add a new service that clients can select when creating a shipment request.
                </p>

            </div>

        </div>


        {{-- ==========================================================
        | Form Layout
        =========================================================== --}}

        <form
            action="#"
            method="POST"
            enctype="multipart/form-data"
            class="service-create-layout"
        >

            @csrf


            {{-- ======================================================
            | Main Content
            ======================================================= --}}

            <div class="service-create-main">


                {{-- ==================================================
                | Basic Information
                =================================================== --}}

                <section class="service-form-card">

                    <div class="service-form-card__header">

                        <div>

                            <h2>
                                Basic Information
                            </h2>

                            <p>
                                Enter the main information about this service.
                            </p>

                        </div>

                    </div>


                    <div class="service-form-card__body">

                        <div class="service-form-grid">


                            {{-- Service Name --}}

                            <div class="service-form-field service-form-field--full">

                                <label for="name">
                                    Service Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. Freight Forwarding"
                                    required
                                >

                                <small>
                                    This name will be visible to clients.
                                </small>

                            </div>


                            {{-- Slug --}}

                            <div class="service-form-field">

                                <label for="slug">
                                    Slug
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="slug"
                                    name="slug"
                                    value="{{ old('slug') }}"
                                    placeholder="freight-forwarding"
                                    required
                                >

                                <small>
                                    Use lowercase letters and hyphens.
                                </small>

                            </div>


                            {{-- Sort Order --}}

                            <div class="service-form-field">

                                <label for="sort_order">
                                    Sort Order
                                </label>

                                <input
                                    type="number"
                                    id="sort_order"
                                    name="sort_order"
                                    value="{{ old('sort_order', 0) }}"
                                    min="0"
                                    placeholder="0"
                                >

                                <small>
                                    Lower numbers appear first.
                                </small>

                            </div>


                            {{-- Short Description --}}

                            <div class="service-form-field service-form-field--full">

                                <label for="short_description">
                                    Short Description
                                    <span>*</span>
                                </label>

                                <textarea
                                    id="short_description"
                                    name="short_description"
                                    rows="3"
                                    maxlength="300"
                                    placeholder="Write a short description of this service..."
                                    required
                                >{{ old('short_description') }}</textarea>

                                <small>
                                    Keep this short. It may appear on service cards and request forms.
                                </small>

                            </div>


                            {{-- Description --}}

                            <div class="service-form-field service-form-field--full">

                                <label for="description">
                                    Full Description
                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    rows="7"
                                    placeholder="Describe the service in more detail..."
                                >{{ old('description') }}</textarea>

                                <small>
                                    Provide additional information about what this service includes.
                                </small>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ==================================================
                | Pricing
                =================================================== --}}

                <section class="service-form-card">

                    <div class="service-form-card__header">

                        <div>

                            <h2>
                                Pricing
                            </h2>

                            <p>
                                Configure the default price clients will see when selecting this service.
                            </p>

                        </div>

                    </div>


                    <div class="service-form-card__body">

                        <div class="service-form-grid">


                            {{-- Price Type --}}

                            <div class="service-form-field">

                                <label for="price_type">
                                    Price Type
                                    <span>*</span>
                                </label>

                                <div class="service-form-select">

                                    <select
                                        id="price_type"
                                        name="price_type"
                                        required
                                    >

                                        <option value="fixed">
                                            Fixed Price
                                        </option>

                                        <option value="starting_from">
                                            Starting From
                                        </option>

                                        <option value="custom">
                                            Custom Quote
                                        </option>

                                    </select>

                                    <i class="fa-regular fa-chevron-down"></i>

                                </div>

                                <small>
                                    Choose how the service price should be displayed.
                                </small>

                            </div>


                            {{-- Price --}}

                            <div class="service-form-field">

                                <label for="price">
                                    Base Price
                                </label>

                                <div class="service-form-input-group">

                                <span>
                                    $
                                </span>

                                    <input
                                        type="number"
                                        id="price"
                                        name="price"
                                        value="{{ old('price') }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="0.00"
                                    >

                                </div>

                                <small>
                                    Leave empty if the service requires a custom quote.
                                </small>

                            </div>


                            {{-- Currency --}}

                            <div class="service-form-field">

                                <label for="currency">
                                    Currency
                                    <span>*</span>
                                </label>

                                <div class="service-form-select">

                                    <select
                                        id="currency"
                                        name="currency"
                                        required
                                    >

                                        <option value="USD">
                                            USD — US Dollar
                                        </option>

                                        <option value="EUR">
                                            EUR — Euro
                                        </option>

                                        <option value="GBP">
                                            GBP — British Pound
                                        </option>

                                        <option value="BDT">
                                            BDT — Bangladeshi Taka
                                        </option>

                                    </select>

                                    <i class="fa-regular fa-chevron-down"></i>

                                </div>

                            </div>


                            {{-- Billing Unit --}}

                            <div class="service-form-field">

                                <label for="billing_unit">
                                    Billing Unit
                                </label>

                                <div class="service-form-select">

                                    <select
                                        id="billing_unit"
                                        name="billing_unit"
                                    >

                                        <option value="shipment">
                                            Per Shipment
                                        </option>

                                        <option value="package">
                                            Per Package
                                        </option>

                                        <option value="kg">
                                            Per KG
                                        </option>

                                        <option value="hour">
                                            Per Hour
                                        </option>

                                        <option value="day">
                                            Per Day
                                        </option>

                                    </select>

                                    <i class="fa-regular fa-chevron-down"></i>

                                </div>

                            </div>

                        </div>


                        {{-- Pricing Notice --}}

                        <div class="service-pricing-notice">

                            <div class="service-pricing-notice__icon">

                                <i class="fa-regular fa-circle-info"></i>

                            </div>

                            <div>

                                <strong>
                                    Pricing flexibility
                                </strong>

                                <p>
                                    The base price can be used as the default request price.
                                    Admins can adjust the final price when reviewing a request.
                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ==================================================
                | Service Image
                =================================================== --}}

                <section class="service-form-card">

                    <div class="service-form-card__header">

                        <div>

                            <h2>
                                Service Image
                            </h2>

                            <p>
                                Add an image to visually represent this service.
                            </p>

                        </div>

                    </div>


                    <div class="service-form-card__body">

                        <div class="service-image-upload">

                            <div class="service-image-upload__preview">

                                <i class="fa-regular fa-image"></i>

                            </div>


                            <div class="service-image-upload__content">

                                <label
                                    for="image"
                                    class="service-image-upload__button"
                                >
                                    <i class="fa-regular fa-upload"></i>

                                    Choose Image
                                </label>

                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept="image/jpeg,image/png,image/webp"
                                >

                                <p>
                                    JPG, PNG or WEBP. Maximum file size 2MB.
                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ==================================================
                | Status & Visibility
                =================================================== --}}

                <section class="service-form-card">

                    <div class="service-form-card__header">

                        <div>

                            <h2>
                                Status & Visibility
                            </h2>

                            <p>
                                Control how this service is displayed and used.
                            </p>

                        </div>

                    </div>


                    <div class="service-form-card__body">

                        <div class="service-settings">


                            {{-- Active --}}

                            <label class="service-setting">

                                <input
                                    type="checkbox"
                                    name="status"
                                    value="active"
                                    checked
                                >

                                <span class="service-setting__toggle"></span>

                                <span class="service-setting__content">

                                <strong>
                                    Active Service
                                </strong>

                                <small>
                                    Clients can select this service when creating a request.
                                </small>

                            </span>

                            </label>


                            {{-- Featured --}}

                            <label class="service-setting">

                                <input
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                >

                                <span class="service-setting__toggle"></span>

                                <span class="service-setting__content">

                                <strong>
                                    Featured Service
                                </strong>

                                <small>
                                    Highlight this service in the client service selection.
                                </small>

                            </span>

                            </label>

                        </div>

                    </div>

                </section>

            </div>


            {{-- ======================================================
            | Sidebar
            ======================================================= --}}

            <aside class="service-create-sidebar">


                {{-- ==================================================
                | Publish Card
                =================================================== --}}

                <div class="service-publish-card">

                    <div class="service-publish-card__header">

                        <h2>
                            Publish Service
                        </h2>

                    </div>


                    <div class="service-publish-card__body">

                        <div class="service-publish-status">

                            <span class="service-publish-status__dot"></span>

                            <div>

                                <strong>
                                    Active
                                </strong>

                                <small>
                                    Ready for clients
                                </small>

                            </div>

                        </div>


                        <p>
                            Once published, this service will become available for clients when creating shipment requests.
                        </p>

                    </div>


                    <div class="service-publish-card__footer">

                        <button
                            type="submit"
                            class="service-publish-btn"
                        >

                            <i class="fa-regular fa-check"></i>

                            <span>
                            Create Service
                        </span>

                        </button>


                        <a
                            href="{{ route('services') }}"
                            class="service-cancel-btn"
                        >
                            Cancel
                        </a>

                    </div>

                </div>


                {{-- ==================================================
                | Tips
                =================================================== --}}

                <div class="service-tips-card">

                    <div class="service-tips-card__header">

                        <div class="service-tips-card__icon">

                            <i class="fa-regular fa-lightbulb"></i>

                        </div>

                        <h2>
                            Service Tips
                        </h2>

                    </div>


                    <ul>

                        <li>
                            Use a clear and recognizable service name.
                        </li>

                        <li>
                            Keep the short description concise.
                        </li>

                        <li>
                            Set a base price clients can easily understand.
                        </li>

                        <li>
                            Use a high-quality image that represents the service.
                        </li>

                    </ul>

                </div>

            </aside>

        </form>

    </div>

@endsection
