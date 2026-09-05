@extends('backend.layouts.backend')

@section('title', 'Profile Settings')

@section('content')

    <section class="profile-settings">

        {{--=================================
        Page Header
        =================================--}}
        <div class="profile-settings__header">

            <div class="profile-settings__heading">

                <span class="profile-settings__eyebrow">
                    My Account
                </span>

                <h1>
                    Profile Settings
                </h1>

                <p>
                    Manage your personal information, profile, and account security.
                </p>

            </div>

        </div>


        {{--=================================
        Main Profile Form
        =================================--}}
        <form
            action="{{ route('profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="profile-settings__form"
        >

            @csrf

            @method('PUT')


            {{--=================================
            Profile Summary
            =================================--}}
            <div class="profile-card profile-summary">

                <div class="profile-summary__user">

                    <div class="profile-avatar">

                        <img
                            id="profilePreview"
                            src="{{ $user->profile_image ? asset($user->profile_image) : asset('backend/images/default-avatar.png') }}"
                            alt="{{ $user->first_name ?? 'User' }}"
                        >

                        <button
                            type="button"
                            class="profile-avatar__edit"
                            id="profilePhotoTrigger"
                            aria-label="Change profile photo"
                        >
                            <i class="ri-camera-line"></i>
                        </button>

                    </div>


                    <div class="profile-summary__info">

                        <h2>
                            {{ $user->first_name }}
                            {{ $user->last_name }}
                        </h2>

                        <div class="profile-summary__meta">

                            <span>
                                <i class="ri-mail-line"></i>
                                {{ $user->email }}
                            </span>

                            <span>
                                <i class="ri-calendar-line"></i>

                                Member since
                                {{ optional($user->created_at)->format('F Y') }}

                            </span>

                        </div>

                    </div>

                </div>


                <div class="profile-summary__action">

                    <input
                        type="file"
                        id="profilePhoto"
                        name="profile_image"
                        accept=".jpg,.jpeg,.png,.webp"
                        hidden
                    >

                    <button
                        type="button"
                        class="btn btn--primary"
                        id="profilePhotoButton"
                    >
                        <i class="ri-image-edit-line"></i>

                        <span>
                            Change Photo
                        </span>
                    </button>

                    <small>
                        JPG, PNG or WEBP · Max 2MB
                    </small>

                </div>

            </div>


            {{--=================================
            Personal Information
            =================================--}}
            <div class="profile-card">

                <div class="profile-card__header">

                    <div class="section-icon">
                        <i class="ri-user-line"></i>
                    </div>

                    <div>

                        <h2>
                            Personal Information
                        </h2>

                        <p>
                            Update your basic account information.
                        </p>

                    </div>

                </div>


                <div class="profile-card__body">

                    <div class="profile-form-grid">

                        {{-- First Name --}}
                        <div class="form-group">

                            <label for="first_name">
                                First Name
                                <span>*</span>
                            </label>

                            <div class="input-wrapper">

                                <i class="ri-user-line"></i>

                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    placeholder="Enter first name"
                                    autocomplete="given-name"
                                    required
                                >

                            </div>

                        </div>


                        {{-- Last Name --}}
                        <div class="form-group">

                            <label for="last_name">
                                Last Name
                                <span>*</span>
                            </label>

                            <div class="input-wrapper">

                                <i class="ri-user-line"></i>

                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    placeholder="Enter last name"
                                    autocomplete="family-name"
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

                            <div class="input-wrapper">

                                <i class="ri-mail-line"></i>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="Enter email address"
                                    autocomplete="email"
                                    required
                                >

                            </div>

                        </div>


                        {{-- Phone --}}
                        <div class="form-group">

                            <label for="phone">
                                Phone Number
                            </label>

                            <div class="input-wrapper">

                                <i class="ri-phone-line"></i>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    placeholder="Enter phone number"
                                    autocomplete="tel"
                                >

                            </div>

                        </div>


                        {{-- Address --}}
                        <div class="form-group form-group--full">

                            <label for="address">
                                Address
                            </label>

                            <div class="input-wrapper">

                                <i class="ri-map-pin-line"></i>

                                <input
                                    type="text"
                                    id="address"
                                    name="address"
                                    value="{{ old('address', $user->address) }}"
                                    placeholder="Enter your address"
                                    autocomplete="street-address"
                                >

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{--=================================
            Security
            =================================--}}
            <div class="profile-card">

                <div class="profile-card__header">

                    <div class="section-icon section-icon--security">

                        <i class="ri-shield-keyhole-line"></i>

                    </div>

                    <div>

                        <h2>
                            Security
                        </h2>

                        <p>
                            Update your password to keep your account secure.
                        </p>

                    </div>

                </div>


                <div class="profile-card__body">

                    <div class="profile-form-grid">

                        {{-- New Password --}}
                        <div class="form-group">

                            <label for="new_password">
                                New Password
                            </label>

                            <div class="input-wrapper input-wrapper--password">

                                <i class="ri-lock-2-line"></i>

                                <input
                                    type="password"
                                    id="new_password"
                                    name="new_password"
                                    placeholder="Enter new password"
                                    autocomplete="new-password"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="new_password"
                                    aria-label="Show password"
                                >
                                    <i class="ri-eye-line"></i>
                                </button>

                            </div>

                            <span class="form-help">
                                Leave blank if you don't want to change your password.
                            </span>

                        </div>


                        {{-- Confirm Password --}}
                        <div class="form-group">

                            <label for="password_confirmation">
                                Confirm Password
                            </label>

                            <div class="input-wrapper input-wrapper--password">

                                <i class="ri-lock-password-line"></i>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Confirm new password"
                                    autocomplete="new-password"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="password_confirmation"
                                    aria-label="Show password"
                                >
                                    <i class="ri-eye-line"></i>
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{--=================================
            Form Actions
            =================================--}}
            <div class="profile-settings__actions">

                <a
                    href="{{ url()->previous() }}"
                    class="btn btn--secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn--primary"
                >
                    <i class="ri-save-line"></i>

                    <span>
                        Save Changes
                    </span>
                </button>

            </div>

        </form>


        {{--=================================
        Shipping Addresses
        =================================--}}
        <div class="profile-card profile-addresses">

            <div class="profile-card__header">

                <div class="section-icon">

                    <i class="ri-map-pin-user-line"></i>

                </div>

                <div>

                    <h2>
                        Shipping Addresses
                    </h2>

                    <p>
                        Manage your saved shipping addresses.
                    </p>

                </div>

            </div>


            <div class="profile-card__body">

                {{-- Add Address --}}
                <div class="address-add">

                    <button
                        type="button"
                        class="btn btn--primary"
                        id="addAddressButton"
                    >
                        <i class="ri-add-line"></i>

                        <span>
                            Add New Address
                        </span>
                    </button>

                </div>


                {{-- Add Address Form --}}
                <div
                    class="address-form-wrapper"
                    id="addAddressForm"
                    hidden
                >

                    <form
                        action="{{ route('profile.addresses.store') }}"
                        method="POST"
                        class="address-form"
                    >

                        @csrf

                        <div class="address-form__header">

                            <div>

                                <h3>
                                    Add New Address
                                </h3>

                                <p>
                                    Save an address for faster checkout.
                                </p>

                            </div>

                            <button
                                type="button"
                                class="address-form__close"
                                data-close-address-form
                                aria-label="Close"
                            >
                                <i class="ri-close-line"></i>
                            </button>

                        </div>


                        <div class="profile-form-grid">

                            {{-- Label --}}
                            <div class="form-group">

                                <label for="address_label">
                                    Address Label
                                    <span>*</span>
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-price-tag-3-line"></i>

                                    <input
                                        type="text"
                                        id="address_label"
                                        name="label"
                                        placeholder="Home, Office..."
                                        maxlength="50"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- Phone --}}
                            <div class="form-group">

                                <label for="address_phone">
                                    Phone
                                    <span>*</span>
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-phone-line"></i>

                                    <input
                                        type="tel"
                                        id="address_phone"
                                        name="phone"
                                        value="{{ $user->phone }}"
                                        placeholder="Phone number"
                                        maxlength="30"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- First Name --}}
                            <div class="form-group">

                                <label for="address_first_name">
                                    First Name
                                    <span>*</span>
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-user-line"></i>

                                    <input
                                        type="text"
                                        id="address_first_name"
                                        name="first_name"
                                        value="{{ $user->first_name }}"
                                        placeholder="First name"
                                        maxlength="100"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- Last Name --}}
                            <div class="form-group">

                                <label for="address_last_name">
                                    Last Name
                                    <span>*</span>
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-user-line"></i>

                                    <input
                                        type="text"
                                        id="address_last_name"
                                        name="last_name"
                                        value="{{ $user->last_name }}"
                                        placeholder="Last name"
                                        maxlength="100"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- Country --}}
                            <div class="form-group">

                                <label for="address_country">
                                    Country
                                    <span>*</span>
                                </label>

                                <div class="input-wrapper input-wrapper--select">

                                    <i class="ri-global-line"></i>

                                    <select
                                        id="address_country"
                                        name="country"
                                        required
                                    >
                                        <option value="">
                                            Select country
                                        </option>

                                        @foreach(config('countries', []) as $code => $country)
                                            <option
                                                value="{{ $code }}"
                                                {{ old('country') === $code ? 'selected' : '' }}
                                            >
                                                {{ $country }}
                                            </option>
                                        @endforeach

                                    </select>

                                    <i class="ri-arrow-down-s-line select-arrow"></i>

                                </div>

                            </div>

                            {{-- City --}}
                            <div class="form-group">

                                <label for="address_city">
                                    City
                                    <span>*</span>
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-building-2-line"></i>

                                    <input
                                        type="text"
                                        id="address_city"
                                        name="city"
                                        placeholder="City"
                                        maxlength="100"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- Address --}}
                            <div class="form-group form-group--full">

                                <label for="address_line">
                                    Address
                                    <span>*</span>
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-map-pin-line"></i>

                                    <input
                                        type="text"
                                        id="address_line"
                                        name="address"
                                        placeholder="Street address"
                                        maxlength="255"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- Apartment --}}
                            <div class="form-group">

                                <label for="address_apartment">
                                    Apartment / Suite
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-home-4-line"></i>

                                    <input
                                        type="text"
                                        id="address_apartment"
                                        name="apartment"
                                        placeholder="Apartment, suite, unit..."
                                        maxlength="255"
                                    >

                                </div>

                            </div>


                            {{-- State --}}
                            <div class="form-group">

                                <label for="address_state">
                                    State
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-map-2-line"></i>

                                    <input
                                        type="text"
                                        id="address_state"
                                        name="state"
                                        placeholder="State / Province"
                                        maxlength="100"
                                    >

                                </div>

                            </div>


                            {{-- Postal Code --}}
                            <div class="form-group">

                                <label for="address_postal_code">
                                    Postal Code
                                    <span>*</span>
                                </label>

                                <div class="input-wrapper">

                                    <i class="ri-mail-line"></i>

                                    <input
                                        type="text"
                                        id="address_postal_code"
                                        name="postal_code"
                                        placeholder="Postal code"
                                        maxlength="20"
                                        required
                                    >

                                </div>

                            </div>

                        </div>


                        <label class="address-default-check">

                            <input
                                type="checkbox"
                                name="is_default"
                                value="1"
                            >

                            <span>
                                Set as default address
                            </span>

                        </label>


                        <div class="address-form__actions">

                            <button
                                type="button"
                                class="btn btn--secondary"
                                data-close-address-form
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="btn btn--primary"
                            >
                                <i class="ri-save-line"></i>

                                <span>
                                    Save Address
                                </span>
                            </button>

                        </div>

                    </form>

                </div>


                {{-- Saved Addresses --}}
                @if($addresses->isNotEmpty())

                    <div class="address-list">

                        @foreach($addresses as $address)

                            <div
                                class="address-item {{ $address->is_default ? 'is-default' : '' }}"
                            >

                                <div class="address-item__top">

                                    <div class="address-item__title">

                                        <i class="ri-map-pin-2-line"></i>

                                        <h3>
                                            {{ $address->label }}
                                        </h3>

                                        @if($address->is_default)

                                            <span class="address-badge">
                                                Default
                                            </span>

                                        @endif

                                    </div>


                                    <div class="address-item__actions">

                                        @if(!$address->is_default)

                                            <form
                                                action="{{ route('profile.addresses.default', $address) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="address-action address-action--default"
                                                >
                                                    <i class="ri-check-line"></i>

                                                    <span>
                                                        Set Default
                                                    </span>
                                                </button>

                                            </form>

                                        @endif


                                        <button
                                            type="button"
                                            class="address-action address-action--edit"
                                            data-edit-address="{{ $address->id }}"
                                        >
                                            <i class="ri-edit-line"></i>

                                            <span>
                                                Edit
                                            </span>
                                        </button>


                                        <form
                                            action="{{ route('profile.addresses.destroy', $address) }}"
                                            method="POST"
                                            class="address-delete-form"
                                            data-delete-address
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="address-action address-action--delete"
                                            >
                                                <i class="ri-delete-bin-line"></i>

                                                <span>
                                                    Delete
                                                </span>
                                            </button>

                                        </form>

                                    </div>

                                </div>


                                <div class="address-item__details">

                                    <strong>
                                        <b>Name: </b>{{ $address->first_name }}
                                        {{ $address->last_name }}
                                    </strong>

                                    <span>
                                       <b>Phone: </b> {{ $address->phone }}
                                    </span>

                                    <span>
                                        <b>Address: </b> {{ $address->address }}

                                        @if($address->apartment)
                                            , <b>Apartment: </b>{{ $address->apartment }}
                                        @endif
                                    </span>

                                    <span>
                                        <b>City: </b>{{ $address->city }}

                                        @if($address->state)
                                            , <b>State: </b> {{ $address->state }}
                                        @endif

                                        , <b>Postal Code: </b> {{ $address->postal_code }}
                                    </span>

                                    <span>
                                        <b>Country: </b>{{ $address->country }}
                                    </span>

                                </div>


                                {{-- Edit Address Form --}}
                                <div
                                    class="address-edit-wrapper"
                                    data-edit-form="{{ $address->id }}"
                                    hidden
                                >

                                    <form
                                        action="{{ route('profile.addresses.update', $address) }}"
                                        method="POST"
                                        class="address-form"
                                    >

                                        @csrf

                                        @method('PUT')


                                        <div class="address-form__header">

                                            <div>

                                                <h3>
                                                    Edit Address
                                                </h3>

                                                <p>
                                                    Update your saved address details.
                                                </p>

                                            </div>

                                            <button
                                                type="button"
                                                class="address-form__close"
                                                data-close-edit="{{ $address->id }}"
                                                aria-label="Close"
                                            >
                                                <i class="ri-close-line"></i>
                                            </button>

                                        </div>


                                        <div class="profile-form-grid">

                                            {{-- Label --}}
                                            <div class="form-group">

                                                <label>
                                                    Address Label
                                                    <span>*</span>
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-price-tag-3-line"></i>

                                                    <input
                                                        type="text"
                                                        name="label"
                                                        value="{{ $address->label }}"
                                                        maxlength="50"
                                                        required
                                                    >

                                                </div>

                                            </div>


                                            {{-- Phone --}}
                                            <div class="form-group">

                                                <label>
                                                    Phone
                                                    <span>*</span>
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-phone-line"></i>

                                                    <input
                                                        type="tel"
                                                        name="phone"
                                                        value="{{ $address->phone }}"
                                                        maxlength="30"
                                                        required
                                                    >

                                                </div>

                                            </div>


                                            {{-- First Name --}}
                                            <div class="form-group">

                                                <label>
                                                    First Name
                                                    <span>*</span>
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-user-line"></i>

                                                    <input
                                                        type="text"
                                                        name="first_name"
                                                        value="{{ $address->first_name }}"
                                                        maxlength="100"
                                                        required
                                                    >

                                                </div>

                                            </div>


                                            {{-- Last Name --}}
                                            <div class="form-group">

                                                <label>
                                                    Last Name
                                                    <span>*</span>
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-user-line"></i>

                                                    <input
                                                        type="text"
                                                        name="last_name"
                                                        value="{{ $address->last_name }}"
                                                        maxlength="100"
                                                        required
                                                    >

                                                </div>

                                            </div>


                                            {{-- Country --}}
                                            <div class="form-group">

                                                <label>
                                                    Country
                                                    <span>*</span>
                                                </label>

                                                <div class="input-wrapper input-wrapper--select">

                                                    <i class="ri-global-line"></i>

                                                    <select
                                                        name="country"
                                                        required
                                                    >
                                                        <option value="">
                                                            Select country
                                                        </option>

                                                        @foreach(config('countries', []) as $code => $country)
                                                            <option
                                                                value="{{ $code }}"
                                                                {{ $address->country === $code ? 'selected' : '' }}
                                                            >
                                                                {{ $country }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                    <i class="ri-arrow-down-s-line select-arrow"></i>

                                                </div>

                                            </div>


                                            {{-- City --}}
                                            <div class="form-group">

                                                <label>
                                                    City
                                                    <span>*</span>
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-building-2-line"></i>

                                                    <input
                                                        type="text"
                                                        name="city"
                                                        value="{{ $address->city }}"
                                                        maxlength="100"
                                                        required
                                                    >

                                                </div>

                                            </div>


                                            {{-- Address --}}
                                            <div class="form-group form-group--full">

                                                <label>
                                                    Address
                                                    <span>*</span>
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-map-pin-line"></i>

                                                    <input
                                                        type="text"
                                                        name="address"
                                                        value="{{ $address->address }}"
                                                        maxlength="255"
                                                        required
                                                    >

                                                </div>

                                            </div>


                                            {{-- Apartment --}}
                                            <div class="form-group">

                                                <label>
                                                    Apartment / Suite
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-home-4-line"></i>

                                                    <input
                                                        type="text"
                                                        name="apartment"
                                                        value="{{ $address->apartment }}"
                                                        maxlength="255"
                                                    >

                                                </div>

                                            </div>


                                            {{-- State --}}
                                            <div class="form-group">

                                                <label>
                                                    State
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-map-2-line"></i>

                                                    <input
                                                        type="text"
                                                        name="state"
                                                        value="{{ $address->state }}"
                                                        maxlength="100"
                                                    >

                                                </div>

                                            </div>


                                            {{-- Postal Code --}}
                                            <div class="form-group">

                                                <label>
                                                    Postal Code
                                                    <span>*</span>
                                                </label>

                                                <div class="input-wrapper">

                                                    <i class="ri-mail-line"></i>

                                                    <input
                                                        type="text"
                                                        name="postal_code"
                                                        value="{{ $address->postal_code }}"
                                                        maxlength="20"
                                                        required
                                                    >

                                                </div>

                                            </div>

                                        </div>


                                        <label class="address-default-check">

                                            <input
                                                type="checkbox"
                                                name="is_default"
                                                value="1"
                                                {{ $address->is_default ? 'checked' : '' }}
                                            >

                                            <span>
                                                Set as default address
                                            </span>

                                        </label>


                                        <div class="address-form__actions">

                                            <button
                                                type="button"
                                                class="btn btn--secondary"
                                                data-close-edit="{{ $address->id }}"
                                            >
                                                Cancel
                                            </button>

                                            <button
                                                type="submit"
                                                class="btn btn--primary"
                                            >
                                                <i class="ri-save-line"></i>

                                                <span>
                                                    Update Address
                                                </span>
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="address-empty">

                        <div class="address-empty__icon">
                            <i class="ri-map-pin-line"></i>
                        </div>

                        <h3>
                            No Saved Addresses
                        </h3>

                        <p>
                            Add a shipping address to make checkout faster.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </section>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const profileSettings =
                document.querySelector('.profile-settings');

            if (!profileSettings) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Profile Photo
            |--------------------------------------------------------------------------
            */

            const photoInput =
                profileSettings.querySelector('#profilePhoto');

            const photoButton =
                profileSettings.querySelector('#profilePhotoButton');

            const photoTrigger =
                profileSettings.querySelector('#profilePhotoTrigger');

            const profilePreview =
                profileSettings.querySelector('#profilePreview');


            function openPhotoPicker() {

                if (photoInput) {
                    photoInput.click();
                }
            }


            if (photoButton) {

                photoButton.addEventListener(
                    'click',
                    openPhotoPicker,
                );

            }


            if (photoTrigger) {

                photoTrigger.addEventListener(
                    'click',
                    openPhotoPicker,
                );

            }


            if (photoInput) {

                photoInput.addEventListener(
                    'change',
                    function () {

                        const file = this.files[0];

                        if (!file) {
                            return;
                        }


                        if (file.size > 2 * 1024 * 1024) {

                            this.value = '';

                            if (
                                window.AppToast &&
                                typeof window.AppToast.fire === 'function'
                            ) {
                                window.AppToast.fire({
                                    icon: 'error',
                                    title: 'Profile image must be 2MB or smaller.',
                                });
                            }

                            return;
                        }


                        const reader =
                            new FileReader();


                        reader.onload =
                            function (event) {

                                if (profilePreview) {
                                    profilePreview.src =
                                        event.target.result;
                                }

                            };


                        reader.readAsDataURL(file);

                    },
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Password Toggle
            |--------------------------------------------------------------------------
            */

            const passwordToggles =
                profileSettings.querySelectorAll(
                    '.password-toggle',
                );


            passwordToggles.forEach(
                function (toggle) {

                    toggle.addEventListener(
                        'click',
                        function () {

                            const targetId =
                                this.dataset.target;

                            const input =
                                document.getElementById(
                                    targetId,
                                );

                            const icon =
                                this.querySelector('i');


                            if (!input || !icon) {
                                return;
                            }


                            if (input.type === 'password') {

                                input.type = 'text';

                                icon.classList.remove(
                                    'ri-eye-line',
                                );

                                icon.classList.add(
                                    'ri-eye-off-line',
                                );

                                this.setAttribute(
                                    'aria-label',
                                    'Hide password',
                                );

                            } else {

                                input.type = 'password';

                                icon.classList.remove(
                                    'ri-eye-off-line',
                                );

                                icon.classList.add(
                                    'ri-eye-line',
                                );

                                this.setAttribute(
                                    'aria-label',
                                    'Show password',
                                );

                            }

                        },
                    );

                },
            );


            /*
            |--------------------------------------------------------------------------
            | Add Address
            |--------------------------------------------------------------------------
            */

            const addAddressButton =
                profileSettings.querySelector(
                    '#addAddressButton',
                );

            const addAddressForm =
                profileSettings.querySelector(
                    '#addAddressForm',
                );


            if (addAddressButton && addAddressForm) {

                addAddressButton.addEventListener(
                    'click',
                    function () {

                        addAddressForm.hidden = false;

                        addAddressButton.hidden = true;

                        addAddressForm.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest',
                        });

                    },
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Close Add Address Form
            |--------------------------------------------------------------------------
            */

            const closeAddressButtons =
                profileSettings.querySelectorAll(
                    '[data-close-address-form]',
                );


            closeAddressButtons.forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            if (addAddressForm) {
                                addAddressForm.hidden = true;
                            }

                            if (addAddressButton) {
                                addAddressButton.hidden = false;
                            }

                        },
                    );

                },
            );


            /*
            |--------------------------------------------------------------------------
            | Edit Address
            |--------------------------------------------------------------------------
            */

            const editButtons =
                profileSettings.querySelectorAll(
                    '[data-edit-address]',
                );


            editButtons.forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const addressId =
                                this.dataset.editAddress;

                            const editForm =
                                profileSettings.querySelector(
                                    '[data-edit-form="' +
                                    addressId +
                                    '"]',
                                );

                            if (!editForm) {
                                return;
                            }

                            editForm.hidden = false;

                            editForm.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest',
                            });

                        },
                    );

                },
            );


            /*
            |--------------------------------------------------------------------------
            | Close Edit Address
            |--------------------------------------------------------------------------
            */

            const closeEditButtons =
                profileSettings.querySelectorAll(
                    '[data-close-edit]',
                );


            closeEditButtons.forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const addressId =
                                this.dataset.closeEdit;

                            const editForm =
                                profileSettings.querySelector(
                                    '[data-edit-form="' +
                                    addressId +
                                    '"]',
                                );

                            if (editForm) {
                                editForm.hidden = true;
                            }

                        },
                    );

                },
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Address Confirmation
            |--------------------------------------------------------------------------
            */

            const deleteForms =
                profileSettings.querySelectorAll(
                    '[data-delete-address]',
                );


            deleteForms.forEach(
                function (form) {

                    form.addEventListener(
                        'submit',
                        function (event) {

                            event.preventDefault();


                            const submitDelete =
                                function () {
                                    form.submit();
                                };


                            if (
                                window.Swal &&
                                typeof window.Swal.fire === 'function'
                            ) {

                                window.Swal.fire({
                                    icon: 'warning',
                                    title: 'Delete this address?',
                                    text: 'This saved address will be permanently removed.',
                                    showCancelButton: true,
                                    confirmButtonText: 'Delete',
                                    cancelButtonText: 'Cancel',
                                }).then(
                                    function (result) {

                                        if (result.isConfirmed) {
                                            submitDelete();
                                        }

                                    },
                                );

                                return;
                            }


                            if (
                                window.confirm(
                                    'Are you sure you want to delete this address?',
                                )
                            ) {
                                submitDelete();
                            }

                        },
                    );

                },
            );

        });
    </script>

@endpush
