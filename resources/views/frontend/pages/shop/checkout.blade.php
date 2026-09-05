@extends('frontend.layouts.frontend')

@section('title', 'Checkout')

@section('contents')

    @php
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Profile Contact Information
        |--------------------------------------------------------------------------
        */

        $userName = trim((string) data_get($user, 'name'));

        $userFirstName = trim((string) data_get($user, 'first_name'));
        $userLastName = trim((string) data_get($user, 'last_name'));

        if (
            $userFirstName === '' &&
            $userLastName === '' &&
            $userName !== ''
        ) {
            $nameParts = preg_split('/\s+/', $userName, 2);

            $userFirstName = $nameParts[0] ?? '';
            $userLastName = $nameParts[1] ?? '';
        }

        $userEmail = trim((string) data_get($user, 'email'));
        $userPhone = trim((string) data_get($user, 'phone'));

        /*
        |--------------------------------------------------------------------------
        | Profile Completion
        |--------------------------------------------------------------------------
        */

        $profileMissingFields = [];

        if ($userEmail === '') {
            $profileMissingFields[] = 'email';
        }

        if ($userFirstName === '') {
            $profileMissingFields[] = 'first name';
        }

        if ($userLastName === '') {
            $profileMissingFields[] = 'last name';
        }

        if ($userPhone === '') {
            $profileMissingFields[] = 'phone number';
        }

        $profileComplete = empty($profileMissingFields);

        /*
        |--------------------------------------------------------------------------
        | Saved Addresses
        |--------------------------------------------------------------------------
        */

        $addresses = $addresses ?? collect();

        $defaultAddress = $default_address ?? null;

        $selectedAddressId = old(
            'address_id',
            $defaultAddress?->id
        );

        /*
        |--------------------------------------------------------------------------
        | Default Address Values
        |--------------------------------------------------------------------------
        */

        $savedFirstName = trim(
            (string) data_get($defaultAddress, 'first_name')
        );

        $savedLastName = trim(
            (string) data_get($defaultAddress, 'last_name')
        );

        $savedPhone = trim(
            (string) data_get($defaultAddress, 'phone')
        );

        $savedCountry = strtoupper(
            trim((string) data_get($defaultAddress, 'country'))
        );

        $savedAddress = trim(
            (string) data_get($defaultAddress, 'address')
        );

        $savedApartment = trim(
            (string) data_get($defaultAddress, 'apartment')
        );

        $savedCity = trim(
            (string) data_get($defaultAddress, 'city')
        );

        $savedState = trim(
            (string) data_get($defaultAddress, 'state')
        );

        $savedPostalCode = trim(
            (string) data_get($defaultAddress, 'postal_code')
        );

        $savedAddressLabel = trim(
            (string) data_get($defaultAddress, 'label')
        );

        /*
        |--------------------------------------------------------------------------
        | Checkout Address Values
        |--------------------------------------------------------------------------
        */

        $checkoutFirstName = old(
            'first_name',
            $savedFirstName !== ''
                ? $savedFirstName
                : $userFirstName
        );

        $checkoutLastName = old(
            'last_name',
            $savedLastName !== ''
                ? $savedLastName
                : $userLastName
        );

        $checkoutPhone = old(
            'phone',
            $savedPhone !== ''
                ? $savedPhone
                : $userPhone
        );

        $checkoutCountry = old(
            'country',
            $savedCountry
        );

        $checkoutAddress = old(
            'address',
            $savedAddress
        );

        $checkoutApartment = old(
            'apartment',
            $savedApartment
        );

        $checkoutCity = old(
            'city',
            $savedCity
        );

        $checkoutState = old(
            'state',
            $savedState
        );

        $checkoutPostalCode = old(
            'postal_code',
            $savedPostalCode
        );

        $checkoutAddressLabel = old(
            'address_label',
            $savedAddressLabel !== ''
                ? $savedAddressLabel
                : 'Home'
        );

        $saveAddress = old(
            'save_address',
            false
        );

        /*
        |--------------------------------------------------------------------------
        | Country Name
        |--------------------------------------------------------------------------
        */

        $savedCountryName = config(
            'countries.' . $savedCountry,
            $savedCountry
        );
    @endphp

    <div class="checkout-page">

        <div class="container">

            {{-- =====================================================
                BREADCRUMB
            ====================================================== --}}
            <div class="checkout-breadcrumb">

                <a href="{{ route('my-cart') }}">
                    Cart
                </a>

                <span class="breadcrumb-separator">
                    <i class="ri-arrow-right-s-line"></i>
                </span>

                <span>
                    Checkout
                </span>

            </div>


            {{-- =====================================================
                PAGE HEADER
            ====================================================== --}}
            <div class="checkout-page__header">

                <div class="checkout-page__header-content">

                    <span class="checkout-page__eyebrow">
                        Secure Checkout
                    </span>

                    <h1>
                        Checkout
                    </h1>

                    <p>
                        Enter your delivery details and review your order before payment.
                    </p>

                </div>

            </div>


            {{-- =====================================================
                PROFILE COMPLETION NOTICE
            ====================================================== --}}
            @if(!$profileComplete)

                <div class="checkout-profile-notice">

                    <div class="checkout-profile-notice__icon">
                        <i class="ri-user-settings-line"></i>
                    </div>

                    <div class="checkout-profile-notice__content">

                        <strong>
                            Complete your profile
                        </strong>

                        <span>
                            Please add your
                            {{ implode(', ', $profileMissingFields) }}
                            before continuing with checkout.
                        </span>

                    </div>

                    <a
                        href="{{ route('profile') }}"
                        class="checkout-profile-notice__action"
                    >
                        Complete Profile
                        <i class="ri-arrow-right-line"></i>
                    </a>

                </div>

            @endif


            {{-- =====================================================
                MAIN CHECKOUT LAYOUT
            ====================================================== --}}
            <div class="checkout-layout">

                {{-- =================================================
                    LEFT COLUMN
                ================================================== --}}
                <div class="checkout-main">


                    {{-- =================================================
                        CONTACT INFORMATION
                    ================================================== --}}
                    <section class="checkout-card">

                        <div class="checkout-card__header">

                            <span class="checkout-card__eyebrow">
                                Contact Information
                            </span>

                            <h2>
                                Your Details
                            </h2>

                            <p>
                                These details are taken from your profile.
                            </p>

                        </div>

                        <div class="checkout-card__body">

                            <div class="checkout-form">

                                {{-- Email --}}
                                <div class="form-group form-group--full">

                                    <label for="checkout-email">

                                        Email Address

                                        @if($userEmail === '')
                                            <span class="field-add-label">
                                                Add in profile
                                            </span>
                                        @endif

                                    </label>

                                    <div class="input-with-icon">

                                        <i class="ri-mail-line"></i>

                                        <input
                                            type="email"
                                            id="checkout-email"
                                            name="email"
                                            placeholder="you@example.com"
                                            value="{{ $userEmail }}"
                                            autocomplete="email"
                                            readonly
                                        >

                                        @if($userEmail !== '')

                                            <span class="field-locked">
                                                <i class="ri-lock-line"></i>
                                            </span>

                                        @else

                                            <a
                                                href="{{ route('profile') }}"
                                                class="field-action"
                                                title="Add email in profile"
                                            >
                                                Add
                                            </a>

                                        @endif

                                    </div>

                                </div>


                                {{-- First Name --}}
                                <div class="form-group">

                                    <label for="checkout-first-name">

                                        First Name

                                        @if($userFirstName === '')
                                            <span class="field-add-label">
                                                Add in profile
                                            </span>
                                        @endif

                                    </label>

                                    <div class="input-with-icon">

                                        <input
                                            type="text"
                                            id="checkout-first-name"
                                            name="first_name"
                                            placeholder="John"
                                            value="{{ $userFirstName }}"
                                            autocomplete="given-name"
                                            readonly
                                        >

                                        @if($userFirstName !== '')

                                            <span class="field-locked">
                                                <i class="ri-lock-line"></i>
                                            </span>

                                        @else

                                            <a
                                                href="{{ route('profile') }}"
                                                class="field-action"
                                                title="Add first name in profile"
                                            >
                                                Add
                                            </a>

                                        @endif

                                    </div>

                                </div>


                                {{-- Last Name --}}
                                <div class="form-group">

                                    <label for="checkout-last-name">

                                        Last Name

                                        @if($userLastName === '')
                                            <span class="field-add-label">
                                                Add in profile
                                            </span>
                                        @endif

                                    </label>

                                    <div class="input-with-icon">

                                        <input
                                            type="text"
                                            id="checkout-last-name"
                                            name="last_name"
                                            placeholder="Doe"
                                            value="{{ $userLastName }}"
                                            autocomplete="family-name"
                                            readonly
                                        >

                                        @if($userLastName !== '')

                                            <span class="field-locked">
                                                <i class="ri-lock-line"></i>
                                            </span>

                                        @else

                                            <a
                                                href="{{ route('profile') }}"
                                                class="field-action"
                                                title="Add last name in profile"
                                            >
                                                Add
                                            </a>

                                        @endif

                                    </div>

                                </div>


                                {{-- Phone --}}
                                <div class="form-group form-group--full">

                                    <label for="checkout-phone">

                                        Phone Number

                                        @if($userPhone === '')
                                            <span class="field-add-label">
                                                Add in profile
                                            </span>
                                        @endif

                                    </label>

                                    <div class="input-with-icon">

                                        <i class="ri-phone-line"></i>

                                        <input
                                            type="tel"
                                            id="checkout-phone"
                                            name="phone"
                                            placeholder="+1 555 123 4567"
                                            value="{{ $userPhone }}"
                                            autocomplete="tel"
                                            readonly
                                        >

                                        @if($userPhone !== '')

                                            <span class="field-locked">
                                                <i class="ri-lock-line"></i>
                                            </span>

                                        @else

                                            <a
                                                href="{{ route('profile') }}"
                                                class="field-action"
                                                title="Add phone number in profile"
                                            >
                                                Add
                                            </a>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        SHIPPING ADDRESS
                    ================================================== --}}
                    <section class="checkout-card">

                        <div class="checkout-card__header">

                            <div class="checkout-card__header-main">

                                <span class="checkout-card__eyebrow">
                                    Delivery Information
                                </span>

                                <h2>
                                    Shipping Address
                                </h2>

                                <p>
                                    Choose a saved address or add a new delivery address.
                                </p>

                            </div>

                        </div>


                        <div class="checkout-card__body">

                            {{-- =========================================
                                SAVED ADDRESS OPTIONS
                            ========================================== --}}
                            @if($addresses->isNotEmpty())

                                <div class="checkout-address-options">

                                    <div class="checkout-address-options__header">

                                        <strong>
                                            Saved Addresses
                                        </strong>

                                        <span>
                                            {{ $addresses->count() }}
                                            {{ $addresses->count() === 1 ? 'address' : 'addresses' }}
                                        </span>

                                    </div>


                                    <div class="checkout-address-list">

                                        @foreach($addresses as $address)

                                            @php
                                                $addressCountry = strtoupper(
                                                    trim((string) $address->country)
                                                );

                                                $addressCountryName = config(
                                                    'countries.' . $addressCountry,
                                                    $addressCountry
                                                );

                                                $addressFullName = trim(
                                                    $address->first_name . ' ' . $address->last_name
                                                );

                                                $addressLine = trim(
                                                    $address->address .
                                                    (
                                                        $address->apartment
                                                            ? ', ' . $address->apartment
                                                            : ''
                                                    )
                                                );

                                                $addressLocation = trim(
                                                    $address->city .
                                                    (
                                                        $address->state
                                                            ? ', ' . $address->state
                                                            : ''
                                                    ) .
                                                    (
                                                        $address->postal_code
                                                            ? ' ' . $address->postal_code
                                                            : ''
                                                    )
                                                );
                                            @endphp

                                            <label
                                                class="checkout-address-option {{ (int) $selectedAddressId === (int) $address->id ? 'is-selected' : '' }}"
                                                data-address-option
                                                data-address-id="{{ $address->id }}"
                                                data-first-name="{{ $address->first_name }}"
                                                data-last-name="{{ $address->last_name }}"
                                                data-phone="{{ $address->phone }}"
                                                data-country="{{ $addressCountry }}"
                                                data-address="{{ $address->address }}"
                                                data-apartment="{{ $address->apartment }}"
                                                data-city="{{ $address->city }}"
                                                data-state="{{ $address->state }}"
                                                data-postal-code="{{ $address->postal_code }}"
                                                data-label="{{ $address->label }}"
                                            >

                                                <input
                                                    type="radio"
                                                    name="address_id"
                                                    value="{{ $address->id }}"
                                                    @checked(
                                                        (int) $selectedAddressId ===
                                                        (int) $address->id
                                                    )
                                                >

                                                <span class="checkout-address-option__radio">
                                                    <span></span>
                                                </span>

                                                <span class="checkout-address-option__icon">
                                                    <i class="ri-map-pin-2-line"></i>
                                                </span>

                                                <span class="checkout-address-option__content">

                                                    <span class="checkout-address-option__top">

                                                        <strong>
                                                            {{ $address->label ?: 'Saved Address' }}
                                                        </strong>

                                                        @if($address->is_default)

                                                            <small>
                                                                Default
                                                            </small>

                                                        @endif

                                                    </span>

                                                    <span>
                                                        {{ $addressFullName }}
                                                    </span>

                                                    <span>
                                                        {{ $addressLine }}
                                                    </span>

                                                    <span>
                                                        {{ $addressLocation }}
                                                    </span>

                                                    <span>
                                                        {{ $addressCountryName }}
                                                    </span>

                                                </span>

                                                <span class="checkout-address-option__check">
                                                    <i class="ri-check-line"></i>
                                                </span>

                                            </label>

                                        @endforeach


                                        {{-- =================================
                                            ADD NEW ADDRESS
                                        ================================== --}}
                                        <label
                                            class="checkout-address-option checkout-address-option--new {{ $selectedAddressId === null ? 'is-selected' : '' }}"
                                            data-new-address-option
                                        >

                                            <input
                                                type="radio"
                                                name="address_id"
                                                value=""
                                                @checked($selectedAddressId === null)
                                            >

                                            <span class="checkout-address-option__radio">
                                                <span></span>
                                            </span>

                                            <span class="checkout-address-option__icon">
                                                <i class="ri-add-line"></i>
                                            </span>

                                            <span class="checkout-address-option__content">

                                                <span class="checkout-address-option__top">

                                                    <strong>
                                                        Add New Address
                                                    </strong>

                                                </span>

                                                <span>
                                                    Use a different shipping address for this order.
                                                </span>

                                            </span>

                                            <span class="checkout-address-option__check">
                                                <i class="ri-check-line"></i>
                                            </span>

                                        </label>

                                    </div>

                                </div>

                            @else

                                {{-- No Saved Address --}}
                                <div class="checkout-no-address">

                                    <div class="checkout-no-address__icon">
                                        <i class="ri-map-pin-add-line"></i>
                                    </div>

                                    <div class="checkout-no-address__content">

                                        <strong>
                                            No saved address
                                        </strong>

                                        <span>
                                            Add your shipping address below to continue.
                                        </span>

                                    </div>

                                </div>

                            @endif


                            {{-- =========================================
                                SELECTED ADDRESS PREVIEW
                            ========================================== --}}
                            @if($defaultAddress !== null)

                                <div
                                    class="checkout-saved-address {{ $selectedAddressId === null ? 'is-hidden' : '' }}"
                                    data-saved-address
                                >

                                    <div class="checkout-saved-address__icon">

                                        <i class="ri-map-pin-2-line"></i>

                                    </div>

                                    <div class="checkout-saved-address__content">

                                        <div class="checkout-saved-address__top">

                                            <strong data-selected-address-label>
                                                {{ $savedAddressLabel !== ''
                                                    ? $savedAddressLabel
                                                    : 'Saved Address' }}
                                            </strong>

                                            <span
                                                class="checkout-saved-address__default"
                                                data-selected-address-default
                                            >
                                                Default
                                            </span>

                                        </div>

                                        <span data-selected-address-name>
                                            {{ trim($checkoutFirstName . ' ' . $checkoutLastName) }}
                                        </span>

                                        <span data-selected-address-line>
                                            {{ $checkoutAddress }}

                                            @if($checkoutApartment !== '')
                                                , {{ $checkoutApartment }}
                                            @endif
                                        </span>

                                        <span data-selected-address-location>
                                            {{ $checkoutCity }}

                                            @if($checkoutState !== '')
                                                , {{ $checkoutState }}
                                            @endif

                                            {{ $checkoutPostalCode }}
                                        </span>

                                        <span data-selected-address-country>
                                            {{ $savedCountryName }}
                                        </span>

                                    </div>

                                </div>

                            @endif


                            {{-- =========================================
                                NEW ADDRESS FORM
                            ========================================== --}}
                            <div
                                class="checkout-address-form {{ $selectedAddressId !== null && $addresses->isNotEmpty() ? 'is-hidden' : '' }}"
                                data-address-form
                            >

                                <div class="checkout-address-form__header">

                                    <div>

                                        <strong>
                                            New Shipping Address
                                        </strong>

                                        <span>
                                            Enter the delivery address for this order.
                                        </span>

                                    </div>

                                </div>


                                <div class="checkout-form">

                                    {{-- Address Label --}}
                                    <div class="form-group form-group--full">

                                        <label for="checkout-address-label">

                                            Address Label

                                            <span>
                                                Optional
                                            </span>

                                        </label>

                                        <div class="input-with-icon">

                                            <i class="ri-bookmark-line"></i>

                                            <input
                                                type="text"
                                                id="checkout-address-label"
                                                name="address_label"
                                                placeholder="Home, Office..."
                                                value="{{ $checkoutAddressLabel }}"
                                                maxlength="50"
                                            >

                                        </div>

                                    </div>


                                    {{-- First Name --}}
                                    <div class="form-group">

                                        <label for="checkout-address-first-name">
                                            First Name
                                        </label>

                                        <input
                                            type="text"
                                            id="checkout-address-first-name"
                                            name="shipping_first_name"
                                            placeholder="John"
                                            value="{{ $checkoutFirstName }}"
                                            autocomplete="given-name"
                                        >

                                    </div>


                                    {{-- Last Name --}}
                                    <div class="form-group">

                                        <label for="checkout-address-last-name">
                                            Last Name
                                        </label>

                                        <input
                                            type="text"
                                            id="checkout-address-last-name"
                                            name="shipping_last_name"
                                            placeholder="Doe"
                                            value="{{ $checkoutLastName }}"
                                            autocomplete="family-name"
                                        >

                                    </div>


                                    {{-- Phone --}}
                                    <div class="form-group form-group--full">

                                        <label for="checkout-address-phone">
                                            Phone Number
                                        </label>

                                        <div class="input-with-icon">

                                            <i class="ri-phone-line"></i>

                                            <input
                                                type="tel"
                                                id="checkout-address-phone"
                                                name="shipping_phone"
                                                placeholder="+1 555 123 4567"
                                                value="{{ $checkoutPhone }}"
                                                autocomplete="tel"
                                            >

                                        </div>

                                    </div>


                                    {{-- Country --}}
                                    <div class="form-group form-group--full">

                                        <label for="checkout-country">
                                            Country
                                        </label>

                                        <div class="select-wrapper">

                                            <select
                                                id="checkout-country"
                                                name="country"
                                                autocomplete="country"
                                            >

                                                <option value="">
                                                    Select Country
                                                </option>

                                                @foreach(config('countries', []) as $code => $country)

                                                    <option
                                                        value="{{ $code }}"
                                                        @selected($checkoutCountry === $code)
                                                    >
                                                        {{ $country }}
                                                    </option>

                                                @endforeach

                                            </select>

                                            <i class="ri-arrow-down-s-line"></i>

                                        </div>

                                    </div>


                                    {{-- Street Address --}}
                                    <div class="form-group form-group--full">

                                        <label for="checkout-address">
                                            Street Address
                                        </label>

                                        <div class="input-with-icon">

                                            <i class="ri-map-pin-line"></i>

                                            <input
                                                type="text"
                                                id="checkout-address"
                                                name="address"
                                                placeholder="123 Main Street"
                                                value="{{ $checkoutAddress }}"
                                                autocomplete="street-address"
                                            >

                                        </div>

                                    </div>


                                    {{-- Apartment --}}
                                    <div class="form-group">

                                        <label for="checkout-apartment">

                                            Apartment / Suite

                                            <span>
                                                Optional
                                            </span>

                                        </label>

                                        <input
                                            type="text"
                                            id="checkout-apartment"
                                            name="apartment"
                                            placeholder="Apartment 4B"
                                            value="{{ $checkoutApartment }}"
                                            autocomplete="address-line2"
                                        >

                                    </div>


                                    {{-- City --}}
                                    <div class="form-group">

                                        <label for="checkout-city">
                                            City
                                        </label>

                                        <input
                                            type="text"
                                            id="checkout-city"
                                            name="city"
                                            placeholder="New York"
                                            value="{{ $checkoutCity }}"
                                            autocomplete="address-level2"
                                        >

                                    </div>


                                    {{-- State --}}
                                    <div class="form-group">

                                        <label for="checkout-state">
                                            State / Province
                                        </label>

                                        <input
                                            type="text"
                                            id="checkout-state"
                                            name="state"
                                            placeholder="New York"
                                            value="{{ $checkoutState }}"
                                            autocomplete="address-level1"
                                        >

                                    </div>


                                    {{-- Postal Code --}}
                                    <div class="form-group">

                                        <label for="checkout-postal-code">
                                            ZIP / Postal Code
                                        </label>

                                        <input
                                            type="text"
                                            id="checkout-postal-code"
                                            name="postal_code"
                                            placeholder="10001"
                                            value="{{ $checkoutPostalCode }}"
                                            autocomplete="postal-code"
                                        >

                                    </div>


                                    {{-- Save Address --}}
                                    <div class="form-group form-group--full">

                                        <label class="checkout-checkbox">

                                            <input
                                                type="checkbox"
                                                name="save_address"
                                                value="1"
                                                @checked($saveAddress)
                                            >

                                            <span class="checkout-checkbox__mark"></span>

                                            <span class="checkout-checkbox__text">
                                                Save this address for future orders
                                            </span>

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        SHIPPING METHOD
                    ================================================== --}}
                    <section class="checkout-card d-none">

                        <div class="checkout-card__header">

                            <span class="checkout-card__eyebrow">
                                Delivery Options
                            </span>

                            <h2>
                                Shipping Method
                            </h2>

                        </div>

                        <div class="checkout-card__body">

                            <div class="shipping-methods">

                                <label class="shipping-method is-selected">

                                    <input
                                        type="radio"
                                        name="shipping_method"
                                        value="standard"
                                        checked
                                    >

                                    <span class="shipping-method__radio"></span>

                                    <span class="shipping-method__icon">
                                        <i class="ri-truck-line"></i>
                                    </span>

                                    <span class="shipping-method__content">

                                        <strong>
                                            Standard Shipping
                                        </strong>

                                        <small>
                                            Standard delivery
                                        </small>

                                    </span>

                                    <span class="shipping-method__price">
                                        Free
                                    </span>

                                </label>


                                <label class="shipping-method">

                                    <input
                                        type="radio"
                                        name="shipping_method"
                                        value="express"
                                    >

                                    <span class="shipping-method__radio"></span>

                                    <span class="shipping-method__icon">
                                        <i class="ri-flashlight-line"></i>
                                    </span>

                                    <span class="shipping-method__content">

                                        <strong>
                                            Express Shipping
                                        </strong>

                                        <small>
                                            Faster delivery
                                        </small>

                                    </span>

                                    <span class="shipping-method__price">
                                        $12.99
                                    </span>

                                </label>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        ORDER NOTES
                    ================================================== --}}
                    <section class="checkout-card">

                        <div class="checkout-card__header">

                            <span class="checkout-card__eyebrow">
                                Additional Information
                            </span>

                            <h2>
                                Order Notes
                            </h2>

                        </div>

                        <div class="checkout-card__body">

                            <div class="checkout-form">

                                <div class="form-group form-group--full">

                                    <label for="checkout-notes">

                                        Special Instructions

                                        <span>
                                            Optional
                                        </span>

                                    </label>

                                    <textarea
                                        id="checkout-notes"
                                        name="notes"
                                        placeholder="Add any special instructions for your order..."
                                    >{{ old('notes') }}</textarea>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        SECURITY NOTICE
                    ================================================== --}}
                    <div class="checkout-security">

                        <div class="checkout-security__icon">
                            <i class="ri-shield-check-line"></i>
                        </div>

                        <div class="checkout-security__content">

                            <strong>
                                Secure Checkout
                            </strong>

                            <span>
                                Your personal information is protected and securely transmitted.
                            </span>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    RIGHT COLUMN
                ====================================================== --}}
                <aside class="checkout-sidebar">


                    {{-- =================================================
                        ORDER SUMMARY
                    ================================================== --}}
                    <section class="order-summary">

                        <div class="order-summary__header">

                            <div>

                                <span class="order-summary__eyebrow">
                                    Your Order
                                </span>

                                <h2>
                                    Order Summary
                                </h2>

                            </div>

                            <a href="{{ route('my-cart') }}">
                                Edit
                            </a>

                        </div>


                        {{-- Products --}}
                        <div class="order-summary__products">

                            @foreach($items as $item)

                                @php
                                    $variant = $item->variant;
                                    $product = $item->product;

                                    $image = null;

                                    if (
                                        $variant !== null &&
                                        $variant->image
                                    ) {
                                        $image = $variant->image;
                                    }

                                    if (
                                        $image === null &&
                                        $variant !== null
                                    ) {
                                        $variantImage =
                                            $variant->images->first();

                                        if ($variantImage?->image) {
                                            $image =
                                                $variantImage->image;
                                        }
                                    }

                                    if ($image === null) {
                                        $productImage =
                                            $product->images->first();

                                        if ($productImage?->image) {
                                            $image =
                                                $productImage->image;
                                        }
                                    }

                                    $variantLabel = '';

                                    if ($variant !== null) {
                                        $variantLabel =
                                            $variant->values
                                                ->map(
                                                    function ($value) {
                                                        return $value
                                                            ->attributeValue
                                                            ?->name;
                                                    }
                                                )
                                                ->filter()
                                                ->implode(' / ');
                                    }

                                    $checkoutUnitPrice =
                                        (float)
                                        $item->checkout_unit_price;

                                    $checkoutTotal =
                                        (float)
                                        $item->checkout_total;
                                @endphp

                                <div
                                    class="summary-product"
                                    data-item-id="{{ $item->id }}"
                                    data-unit-price="{{ $checkoutUnitPrice }}"
                                >

                                    <div class="summary-product__image">

                                        @if($image)

                                            <img
                                                src="{{ $image }}"
                                                alt="{{ $product->name }}"
                                            >

                                        @else

                                            <span>
                                                No Image
                                            </span>

                                        @endif

                                        <b>
                                            {{ $item->quantity }}
                                        </b>

                                    </div>


                                    <div class="summary-product__content">

                                        <strong>
                                            {{ $product->name }}
                                        </strong>

                                        @if($variantLabel !== '')

                                            <span>
                                                {{ $variantLabel }}
                                            </span>

                                        @endif

                                    </div>


                                    <div class="summary-product__price">

                                        ${{ number_format($checkoutTotal, 2) }}

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- Totals --}}
                        <div class="order-summary__totals">

                            <div class="summary-row">

                                <span>
                                    Subtotal
                                </span>

                                <strong class="summary-subtotal">
                                    ${{ number_format($subtotal, 2) }}
                                </strong>

                            </div>


                            <div class="summary-row">

                                <span>
                                    Shipping
                                </span>

                                <strong class="summary-shipping">

                                    @if($shipping > 0)
                                        ${{ number_format($shipping, 2) }}
                                    @else
                                        Free
                                    @endif

                                </strong>

                            </div>


                            <div class="summary-row">

                                <span>
                                    Discount
                                </span>

                                <strong class="summary-discount-value is-discount">
                                    -${{ number_format($discount, 2) }}
                                </strong>

                            </div>


                            <div class="summary-row">

                                <span>
                                    Tax
                                </span>

                                <strong class="summary-tax">
                                    ${{ number_format($tax, 2) }}
                                </strong>

                            </div>

                        </div>


                        {{-- Total --}}
                        <div class="order-summary__total">

                            <strong>
                                Total
                            </strong>

                            <strong class="summary-total">
                                ${{ number_format($total, 2) }}
                            </strong>

                        </div>


                        {{-- Continue --}}
                        <button
                            type="button"
                            class="checkout-submit"
                            @disabled(!$profileComplete)
                        >

                            <span>
                                Continue to Payment
                            </span>

                            <i class="ri-arrow-right-line"></i>

                        </button>


                        {{-- Terms --}}
                        <div class="checkout-terms">

                            <p>
                                By continuing, you agree to our

                                <a href="#">
                                    Terms &amp; Conditions
                                </a>

                                and

                                <a href="#">
                                    Privacy Policy
                                </a>.

                            </p>

                        </div>

                    </section>


                    {{-- Sidebar Security --}}
                    <div class="checkout-sidebar-security">

                        <div class="checkout-sidebar-security__icon">
                            <i class="ri-shield-check-line"></i>
                        </div>

                        <div class="checkout-sidebar-security__content">

                            <strong>
                                Safe &amp; Secure
                            </strong>

                            <span>
                                Your data is encrypted and protected.
                            </span>

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const checkoutPage =
                    document.querySelector(
                        '.checkout-page'
                    );


                if (!checkoutPage) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Toast Message
                |--------------------------------------------------------------------------
                */

                const showMessage = function (
                    message,
                    type = 'error'
                ) {

                    if (
                        window.AppToast &&
                        typeof window.AppToast.fire === 'function'
                    ) {

                        window.AppToast.fire({
                            icon: type,
                            title: message
                        });

                        return;
                    }


                    console[
                        type === 'error'
                            ? 'error'
                            : 'log'
                        ](message);

                };


                /*
                |--------------------------------------------------------------------------
                | Button Loading
                |--------------------------------------------------------------------------
                */

                const setButtonLoading =
                    function (
                        button,
                        loading
                    ) {

                        if (!button) {
                            return;
                        }


                        if (loading) {

                            if (
                                !button.dataset.originalHtml
                            ) {

                                button.dataset.originalHtml =
                                    button.innerHTML;

                            }


                            button.disabled = true;

                            button.classList.add(
                                'is-processing'
                            );

                            button.innerHTML =
                                '<i class="ri-loader-4-line ri-spin"></i>' +
                                '<span>Processing...</span>';

                            return;

                        }


                        button.disabled = false;

                        button.classList.remove(
                            'is-processing'
                        );


                        if (
                            button.dataset.originalHtml
                        ) {

                            button.innerHTML =
                                button.dataset.originalHtml;

                        }

                    };


                /*
                |--------------------------------------------------------------------------
                | Shipping Method Selection
                |--------------------------------------------------------------------------
                */

                const shippingMethods =
                    checkoutPage.querySelectorAll(
                        '.shipping-method'
                    );


                shippingMethods.forEach(
                    function (method) {

                        const radio =
                            method.querySelector(
                                'input[type="radio"]'
                            );


                        if (!radio) {
                            return;
                        }


                        radio.addEventListener(
                            'change',
                            function () {

                                if (!radio.checked) {
                                    return;
                                }


                                shippingMethods.forEach(
                                    function (item) {

                                        item.classList.remove(
                                            'is-selected'
                                        );

                                    }
                                );


                                method.classList.add(
                                    'is-selected'
                                );

                            }
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Country Select
                |--------------------------------------------------------------------------
                */

                const countrySelect =
                    checkoutPage.querySelector(
                        '#checkout-country'
                    );


                if (countrySelect) {

                    const updateCountryState =
                        function () {

                            countrySelect.classList.toggle(
                                'has-value',
                                countrySelect.value !== ''
                            );

                        };


                    countrySelect.addEventListener(
                        'change',
                        updateCountryState
                    );


                    updateCountryState();

                }


                /*
                |--------------------------------------------------------------------------
                | Address Elements
                |--------------------------------------------------------------------------
                */

                const addressOptions =
                    checkoutPage.querySelectorAll(
                        '[data-address-option]'
                    );

                const newAddressOption =
                    checkoutPage.querySelector(
                        '[data-new-address-option]'
                    );

                const addressForm =
                    checkoutPage.querySelector(
                        '[data-address-form]'
                    );

                const savedAddress =
                    checkoutPage.querySelector(
                        '[data-saved-address]'
                    );

                const selectedAddressLabel =
                    checkoutPage.querySelector(
                        '[data-selected-address-label]'
                    );

                const selectedAddressDefault =
                    checkoutPage.querySelector(
                        '[data-selected-address-default]'
                    );

                const selectedAddressName =
                    checkoutPage.querySelector(
                        '[data-selected-address-name]'
                    );

                const selectedAddressLine =
                    checkoutPage.querySelector(
                        '[data-selected-address-line]'
                    );

                const selectedAddressLocation =
                    checkoutPage.querySelector(
                        '[data-selected-address-location]'
                    );

                const selectedAddressCountry =
                    checkoutPage.querySelector(
                        '[data-selected-address-country]'
                    );


                /*
                |--------------------------------------------------------------------------
                | Address Form Fields
                |--------------------------------------------------------------------------
                */

                const addressFields = {

                    firstName:
                        checkoutPage.querySelector(
                            '#checkout-address-first-name'
                        ),

                    lastName:
                        checkoutPage.querySelector(
                            '#checkout-address-last-name'
                        ),

                    phone:
                        checkoutPage.querySelector(
                            '#checkout-address-phone'
                        ),

                    country:
                        checkoutPage.querySelector(
                            '#checkout-country'
                        ),

                    address:
                        checkoutPage.querySelector(
                            '#checkout-address'
                        ),

                    apartment:
                        checkoutPage.querySelector(
                            '#checkout-apartment'
                        ),

                    city:
                        checkoutPage.querySelector(
                            '#checkout-city'
                        ),

                    state:
                        checkoutPage.querySelector(
                            '#checkout-state'
                        ),

                    postalCode:
                        checkoutPage.querySelector(
                            '#checkout-postal-code'
                        ),

                    label:
                        checkoutPage.querySelector(
                            '#checkout-address-label'
                        ),

                };


                /*
                |--------------------------------------------------------------------------
                | Get Country Name
                |--------------------------------------------------------------------------
                */

                const countries =
                    @json(config('countries', []));


                const getCountryName =
                    function (code) {

                        if (!code) {
                            return '';
                        }

                        return countries[code] || code;

                    };


                /*
                |--------------------------------------------------------------------------
                | Clear Address Selection
                |--------------------------------------------------------------------------
                */

                const clearAddressSelection =
                    function () {

                        addressOptions.forEach(
                            function (option) {

                                option.classList.remove(
                                    'is-selected'
                                );

                            }
                        );


                        if (newAddressOption) {

                            newAddressOption.classList.add(
                                'is-selected'
                            );

                        }

                    };


                /*
                |--------------------------------------------------------------------------
                | Fill Address Form
                |--------------------------------------------------------------------------
                */

                const fillAddressForm =
                    function (option) {

                        if (!option) {
                            return;
                        }


                        if (addressFields.firstName) {

                            addressFields.firstName.value =
                                option.dataset.firstName || '';

                        }


                        if (addressFields.lastName) {

                            addressFields.lastName.value =
                                option.dataset.lastName || '';

                        }


                        if (addressFields.phone) {

                            addressFields.phone.value =
                                option.dataset.phone || '';

                        }


                        if (addressFields.country) {

                            addressFields.country.value =
                                option.dataset.country || '';

                            addressFields.country.dispatchEvent(
                                new Event('change')
                            );

                        }


                        if (addressFields.address) {

                            addressFields.address.value =
                                option.dataset.address || '';

                        }


                        if (addressFields.apartment) {

                            addressFields.apartment.value =
                                option.dataset.apartment || '';

                        }


                        if (addressFields.city) {

                            addressFields.city.value =
                                option.dataset.city || '';

                        }


                        if (addressFields.state) {

                            addressFields.state.value =
                                option.dataset.state || '';

                        }


                        if (addressFields.postalCode) {

                            addressFields.postalCode.value =
                                option.dataset.postalCode || '';

                        }


                        if (addressFields.label) {

                            addressFields.label.value =
                                option.dataset.label || 'Home';

                        }

                    };


                /*
                |--------------------------------------------------------------------------
                | Update Saved Address Preview
                |--------------------------------------------------------------------------
                */

                const updateSavedAddressPreview =
                    function (option) {

                        if (!option) {
                            return;
                        }


                        const firstName =
                            option.dataset.firstName || '';

                        const lastName =
                            option.dataset.lastName || '';

                        const fullName =
                            `${firstName} ${lastName}`
                                .trim();


                        const address =
                            option.dataset.address || '';

                        const apartment =
                            option.dataset.apartment || '';

                        const city =
                            option.dataset.city || '';

                        const state =
                            option.dataset.state || '';

                        const postalCode =
                            option.dataset.postalCode || '';

                        const country =
                            option.dataset.country || '';

                        const label =
                            option.dataset.label ||
                            'Saved Address';


                        const addressLine =
                            [
                                address,
                                apartment
                                    ? apartment
                                    : ''
                            ]
                                .filter(Boolean)
                                .join(', ');


                        const locationLine =
                            [
                                city,
                                state
                                    ? state
                                    : '',
                                postalCode
                            ]
                                .filter(Boolean)
                                .join(
                                    state
                                        ? ', '
                                        : ' '
                                );


                        if (selectedAddressLabel) {

                            selectedAddressLabel.textContent =
                                label;

                        }


                        if (selectedAddressName) {

                            selectedAddressName.textContent =
                                fullName;

                        }


                        if (selectedAddressLine) {

                            selectedAddressLine.textContent =
                                addressLine;

                        }


                        if (selectedAddressLocation) {

                            selectedAddressLocation.textContent =
                                locationLine;

                        }


                        if (selectedAddressCountry) {

                            selectedAddressCountry.textContent =
                                getCountryName(country);

                        }


                        if (selectedAddressDefault) {

                            const isDefault =
                                option.querySelector(
                                    '.checkout-address-option__top small'
                                );


                            selectedAddressDefault.classList.toggle(
                                'is-hidden',
                                !isDefault
                            );

                        }

                    };


                /*
                |--------------------------------------------------------------------------
                | Select Saved Address
                |--------------------------------------------------------------------------
                */

                const selectSavedAddress =
                    function (option) {

                        if (!option) {
                            return;
                        }


                        addressOptions.forEach(
                            function (item) {

                                item.classList.remove(
                                    'is-selected'
                                );

                            }
                        );


                        if (newAddressOption) {

                            newAddressOption.classList.remove(
                                'is-selected'
                            );

                        }


                        option.classList.add(
                            'is-selected'
                        );


                        const radio =
                            option.querySelector(
                                'input[type="radio"]'
                            );


                        if (radio) {

                            radio.checked = true;

                        }


                        fillAddressForm(
                            option
                        );


                        updateSavedAddressPreview(
                            option
                        );


                        if (addressForm) {

                            addressForm.classList.add(
                                'is-hidden'
                            );

                        }


                        if (savedAddress) {

                            savedAddress.classList.remove(
                                'is-hidden'
                            );

                        }

                    };


                /*
                |--------------------------------------------------------------------------
                | Select New Address
                |--------------------------------------------------------------------------
                */

                const selectNewAddress =
                    function () {

                        clearAddressSelection();


                        if (newAddressOption) {

                            const radio =
                                newAddressOption.querySelector(
                                    'input[type="radio"]'
                                );


                            if (radio) {

                                radio.checked = true;

                            }

                        }


                        if (savedAddress) {

                            savedAddress.classList.add(
                                'is-hidden'
                            );

                        }


                        if (addressForm) {

                            addressForm.classList.remove(
                                'is-hidden'
                            );

                        }

                    };


                /*
                |--------------------------------------------------------------------------
                | Saved Address Click
                |--------------------------------------------------------------------------
                */

                addressOptions.forEach(
                    function (option) {

                        const radio =
                            option.querySelector(
                                'input[type="radio"]'
                            );


                        option.addEventListener(
                            'click',
                            function () {

                                selectSavedAddress(
                                    option
                                );

                            }
                        );


                        if (radio) {

                            radio.addEventListener(
                                'change',
                                function () {

                                    if (!radio.checked) {
                                        return;
                                    }


                                    selectSavedAddress(
                                        option
                                    );

                                }
                            );

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | New Address Click
                |--------------------------------------------------------------------------
                */

                if (newAddressOption) {

                    newAddressOption.addEventListener(
                        'click',
                        function () {

                            selectNewAddress();

                        }
                    );


                    const radio =
                        newAddressOption.querySelector(
                            'input[type="radio"]'
                        );


                    if (radio) {

                        radio.addEventListener(
                            'change',
                            function () {

                                if (!radio.checked) {
                                    return;
                                }


                                selectNewAddress();

                            }
                        );

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Required Fields
                |--------------------------------------------------------------------------
                */

                const requiredFields = [

                    {
                        selector: '#checkout-email',
                        message:
                            'Please add your email address in your profile.'
                    },

                    {
                        selector: '#checkout-first-name',
                        message:
                            'Please add your first name in your profile.'
                    },

                    {
                        selector: '#checkout-last-name',
                        message:
                            'Please add your last name in your profile.'
                    },

                    {
                        selector: '#checkout-phone',
                        message:
                            'Please add your phone number in your profile.'
                    },

                    {
                        selector: '#checkout-country',
                        message:
                            'Please select your country.'
                    },

                    {
                        selector: '#checkout-address',
                        message:
                            'Please enter your shipping address.'
                    },

                    {
                        selector: '#checkout-city',
                        message:
                            'Please enter your city.'
                    },

                    {
                        selector: '#checkout-state',
                        message:
                            'Please enter your state or province.'
                    },

                    {
                        selector: '#checkout-postal-code',
                        message:
                            'Please enter your postal code.'
                    }

                ];


                /*
                |--------------------------------------------------------------------------
                | Validate Checkout
                |--------------------------------------------------------------------------
                */

                const validateCheckout =
                    function () {

                        if (
                            !@json($profileComplete)
                        ) {

                            showMessage(
                                'Please complete your profile before continuing.',
                                'warning'
                            );


                            return false;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Determine New Address Mode
                        |--------------------------------------------------------------------------
                        */

                        const newAddressSelected =
                            newAddressOption &&
                            newAddressOption.classList.contains(
                                'is-selected'
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Saved Address Selected
                        |--------------------------------------------------------------------------
                        */

                        if (
                            !newAddressSelected &&
                            addressOptions.length > 0
                        ) {

                            const selectedOption =
                                checkoutPage.querySelector(
                                    '[data-address-option].is-selected'
                                );


                            if (selectedOption) {

                                return true;

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Validate New Address
                        |--------------------------------------------------------------------------
                        */

                        for (
                            const field of requiredFields
                            ) {

                            /*
                            |--------------------------------------------------------------------------
                            | Profile Fields
                            |--------------------------------------------------------------------------
                            */

                            if (
                                field.selector === '#checkout-email' ||
                                field.selector === '#checkout-first-name' ||
                                field.selector === '#checkout-last-name' ||
                                field.selector === '#checkout-phone'
                            ) {

                                continue;

                            }


                            const element =
                                checkoutPage.querySelector(
                                    field.selector
                                );


                            if (!element) {
                                continue;
                            }


                            if (
                                element.value.trim() === ''
                            ) {

                                element.focus();


                                showMessage(
                                    field.message,
                                    'error'
                                );


                                return false;

                            }

                        }


                        return true;

                    };


                /*
                |--------------------------------------------------------------------------
                | Checkout Button
                |--------------------------------------------------------------------------
                */

                const checkoutButton =
                    checkoutPage.querySelector(
                        '.checkout-submit'
                    );


                if (checkoutButton) {

                    checkoutButton.addEventListener(
                        'click',
                        function () {

                            if (
                                checkoutButton.disabled
                            ) {
                                return;
                            }


                            if (
                                !validateCheckout()
                            ) {
                                return;
                            }


                            setButtonLoading(
                                checkoutButton,
                                true
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Payment Integration
                            |--------------------------------------------------------------------------
                            |
                            | Actual checkout/order/payment backend
                            | will be connected here.
                            |
                            */

                            window.setTimeout(
                                function () {

                                    setButtonLoading(
                                        checkoutButton,
                                        false
                                    );


                                    showMessage(
                                        'Checkout details are valid. Payment step is ready to be connected.',
                                        'success'
                                    );

                                },
                                500
                            );

                        }
                    );

                }

            }
        );
    </script>

@endpush
