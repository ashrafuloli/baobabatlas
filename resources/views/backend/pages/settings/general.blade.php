@extends('backend.layouts.backend')

@section('title', 'General Settings')

@section('content')

    <div class="settings-general-page">

        {{-- =========================================================
            Page Header
        ========================================================= --}}
        <div class="settings-header">

            <div class="settings-header-content">

                <div class="settings-header-text">

                    <h1>
                        General Settings
                    </h1>

                    <p>
                        Manage your website and basic system preferences.
                    </p>

                </div>


                {{-- Header Controls --}}
                <div class="settings-header-actions">

                    {{-- Theme Toggle --}}
                    <button
                        type="button"
                        class="theme-toggle"
                        id="themeToggle"
                        aria-label="Toggle theme"
                    >

                    <span class="theme-icon light-icon">
                        <i class="ri-sun-line"></i>
                    </span>

                        <span class="theme-icon dark-icon">
                        <i class="ri-moon-line"></i>
                    </span>

                        <span class="theme-toggle-text">
                        <span class="light-text">
                            Light
                        </span>

                        <span class="dark-text">
                            Dark
                        </span>
                    </span>

                    </button>


                    {{-- Language --}}
                    <div class="language-dropdown">

                        <button
                            type="button"
                            class="language-toggle"
                            id="languageToggle"
                        >

                            <i class="ri-global-line"></i>

                            <span>
                            English
                        </span>

                            <i class="ri-arrow-down-s-line"></i>

                        </button>


                        <div
                            class="language-menu"
                            id="languageMenu"
                        >

                            <button
                                type="button"
                                class="language-option active"
                                data-language="en"
                            >

                            <span class="language-name">
                                English
                            </span>

                                <i class="ri-check-line"></i>

                            </button>


                            <button
                                type="button"
                                class="language-option"
                                data-language="fr"
                            >

                            <span class="language-name">
                                Français
                            </span>

                                <i class="ri-check-line"></i>

                            </button>


                            <button
                                type="button"
                                class="language-option"
                                data-language="pt"
                            >

                            <span class="language-name">
                                Português
                            </span>

                                <i class="ri-check-line"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Settings Form
        ========================================================= --}}
        <form
            action="#"
            method="POST"
            enctype="multipart/form-data"
            class="settings-form"
        >

            @csrf


            {{-- =====================================================
                Website Information
            ===================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-global-line"></i>
                        </div>

                        <div>

                            <h2>
                                Website Information
                            </h2>

                            <p>
                                Manage your website's basic information.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Website Name --}}
                        <div class="form-group">

                            <label for="website_name">
                                Website Name
                            </label>

                            <input
                                type="text"
                                id="website_name"
                                name="website_name"
                                class="form-control"
                                value="{{ old('website_name', 'Baobab Atlas') }}"
                                placeholder="Enter website name"
                            >

                        </div>


                        {{-- Website URL --}}
                        <div class="form-group">

                            <label for="website_url">
                                Website URL
                            </label>

                            <input
                                type="url"
                                id="website_url"
                                name="website_url"
                                class="form-control"
                                value="{{ old('website_url', url('/')) }}"
                                placeholder="https://example.com"
                            >

                        </div>


                        {{-- Tagline --}}
                        <div class="form-group full-width">

                            <label for="website_tagline">
                                Website Tagline
                            </label>

                            <input
                                type="text"
                                id="website_tagline"
                                name="website_tagline"
                                class="form-control"
                                value="{{ old(
                                'website_tagline',
                                'Connecting Guinea to the World'
                            ) }}"
                                placeholder="Enter website tagline"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Branding
            ===================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-image-line"></i>
                        </div>

                        <div>

                            <h2>
                                Branding
                            </h2>

                            <p>
                                Manage your website logo and favicon.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="branding-grid">


                        {{-- Website Logo --}}
                        <div class="branding-item">

                            <label>
                                Website Logo
                            </label>

                            <div class="upload-box">

                                <div class="upload-preview logo-preview">

                                    <img
                                        src="{{ asset('logo.png') }}"
                                        alt="Website Logo"
                                    >

                                </div>


                                <div class="upload-content">

                                    <strong>
                                        Website Logo
                                    </strong>

                                    <span>
                                    PNG, JPG or SVG
                                </span>

                                    <label
                                        for="website_logo"
                                        class="upload-button"
                                    >

                                        <i class="ri-upload-2-line"></i>

                                        Choose File

                                    </label>

                                    <input
                                        type="file"
                                        id="website_logo"
                                        name="website_logo"
                                        accept=".png,.jpg,.jpeg,.svg"
                                        hidden
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- Favicon --}}
                        <div class="branding-item">

                            <label>
                                Favicon
                            </label>

                            <div class="upload-box">

                                <div class="upload-preview favicon-preview">

                                    <img
                                        src="{{ asset('favicon.ico') }}"
                                        alt="Website Favicon"
                                    >

                                </div>


                                <div class="upload-content">

                                    <strong>
                                        Website Favicon
                                    </strong>

                                    <span>
                                    ICO, PNG or SVG
                                </span>

                                    <label
                                        for="website_favicon"
                                        class="upload-button"
                                    >

                                        <i class="ri-upload-2-line"></i>

                                        Choose File

                                    </label>

                                    <input
                                        type="file"
                                        id="website_favicon"
                                        name="website_favicon"
                                        accept=".ico,.png,.svg"
                                        hidden
                                    >

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Contact Information
            ===================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-contacts-line"></i>
                        </div>

                        <div>

                            <h2>
                                Contact Information
                            </h2>

                            <p>
                                Manage your business contact information.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Email --}}
                        <div class="form-group">

                            <label for="contact_email">
                                Contact Email
                            </label>

                            <input
                                type="email"
                                id="contact_email"
                                name="contact_email"
                                class="form-control"
                                value="{{ old('contact_email') }}"
                                placeholder="contact@example.com"
                            >

                        </div>


                        {{-- Phone --}}
                        <div class="form-group">

                            <label for="contact_phone">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                id="contact_phone"
                                name="contact_phone"
                                class="form-control"
                                value="{{ old('contact_phone') }}"
                                placeholder="+224 000 000 000"
                            >

                        </div>


                        {{-- Address --}}
                        <div class="form-group full-width">

                            <label for="contact_address">
                                Address
                            </label>

                            <textarea
                                id="contact_address"
                                name="contact_address"
                                class="form-control"
                                rows="3"
                                placeholder="Enter business address"
                            >{{ old('contact_address') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Regional Settings
            ===================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-earth-line"></i>
                        </div>

                        <div>

                            <h2>
                                Regional Settings
                            </h2>

                            <p>
                                Configure timezone, date and currency preferences.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Timezone --}}
                        <div class="form-group">

                            <label for="timezone">
                                Timezone
                            </label>

                            <select
                                id="timezone"
                                name="timezone"
                                class="form-control"
                            >

                                <option value="UTC">
                                    UTC
                                </option>

                                <option value="Africa/Conakry">
                                    Africa / Conakry
                                </option>

                                <option value="Africa/Accra">
                                    Africa / Accra
                                </option>

                                <option value="Africa/Lagos">
                                    Africa / Lagos
                                </option>

                                <option value="Africa/Dakar">
                                    Africa / Dakar
                                </option>

                            </select>

                        </div>


                        {{-- Date Format --}}
                        <div class="form-group">

                            <label for="date_format">
                                Date Format
                            </label>

                            <select
                                id="date_format"
                                name="date_format"
                                class="form-control"
                            >

                                <option value="Y-m-d">
                                    YYYY-MM-DD
                                </option>

                                <option value="d/m/Y">
                                    DD/MM/YYYY
                                </option>

                                <option value="m/d/Y">
                                    MM/DD/YYYY
                                </option>

                            </select>

                        </div>


                        {{-- Time Format --}}
                        <div class="form-group">

                            <label for="time_format">
                                Time Format
                            </label>

                            <select
                                id="time_format"
                                name="time_format"
                                class="form-control"
                            >

                                <option value="12">
                                    12 Hour
                                </option>

                                <option value="24">
                                    24 Hour
                                </option>

                            </select>

                        </div>


                        {{-- Currency --}}
                        <div class="form-group">

                            <label for="currency">
                                Default Currency
                            </label>

                            <select
                                id="currency"
                                name="currency"
                                class="form-control"
                            >

                                <option value="USD">
                                    USD — US Dollar
                                </option>

                                <option value="GNF">
                                    GNF — Guinean Franc
                                </option>

                                <option value="EUR">
                                    EUR — Euro
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                System Preferences
            ===================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-settings-3-line"></i>
                        </div>

                        <div>

                            <h2>
                                System Preferences
                            </h2>

                            <p>
                                Configure basic system behaviour.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="preference-list">


                        {{-- Website Status --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Website Status
                                </h3>

                                <p>
                                    Allow customers to access the website.
                                </p>

                            </div>


                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="website_status"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Maintenance --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Maintenance Mode
                                </h3>

                                <p>
                                    Temporarily disable customer access while maintenance is in progress.
                                </p>

                            </div>


                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="maintenance_mode"
                                    value="1"
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Customer Registration --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Customer Registration
                                </h3>

                                <p>
                                    Allow new customers to create an account.
                                </p>

                            </div>


                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="customer_registration"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Save Actions
            ===================================================== --}}
            <div class="settings-actions">

                <button
                    type="reset"
                    class="cancel-button"
                >

                    Cancel

                </button>


                <button
                    type="submit"
                    class="save-button"
                >

                    <i class="ri-save-line"></i>

                    Save Changes

                </button>

            </div>

        </form>

    </div>


    {{-- =========================================================
        Theme & Language JS
    ========================================================= --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Theme Toggle
            |--------------------------------------------------------------------------
            */

            const themeToggle = document.getElementById('themeToggle');

            const savedTheme = localStorage.getItem('backend-theme');

            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }


            if (themeToggle) {

                themeToggle.addEventListener('click', function () {

                    document.body.classList.toggle('dark-mode');

                    const isDark =
                        document.body.classList.contains('dark-mode');

                    localStorage.setItem(
                        'backend-theme',
                        isDark ? 'dark' : 'light'
                    );

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Language Dropdown
            |--------------------------------------------------------------------------
            */

            const languageToggle =
                document.getElementById('languageToggle');

            const languageMenu =
                document.getElementById('languageMenu');


            if (languageToggle && languageMenu) {

                languageToggle.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        languageMenu.classList.toggle('show');

                    }
                );


                document.addEventListener(
                    'click',
                    function () {

                        languageMenu.classList.remove('show');

                    }
                );


                const languageOptions =
                    languageMenu.querySelectorAll(
                        '.language-option'
                    );


                languageOptions.forEach(function (option) {

                    option.addEventListener(
                        'click',
                        function () {

                            const language =
                                this.dataset.language;

                            const languageName =
                                this.querySelector(
                                    '.language-name'
                                ).textContent;


                            languageOptions.forEach(
                                function (item) {

                                    item.classList.remove(
                                        'active'
                                    );

                                }
                            );


                            this.classList.add('active');


                            languageToggle.querySelector(
                                'span'
                            ).textContent = languageName;


                            languageMenu.classList.remove(
                                'show'
                            );


                            localStorage.setItem(
                                'backend-language',
                                language
                            );

                        }
                    );

                });

            }

        });

    </script>

@endsection
