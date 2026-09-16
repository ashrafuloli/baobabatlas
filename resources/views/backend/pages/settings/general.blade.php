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
                <div class="settings-header-actions d-none">

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


        <form
            action="{{ route('settings.update') }}"
            method="POST"
            class="settings-form"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            {{-- =====================================================
                Website Information
            ====================================================== --}}
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
                                value="{{ old(
                                    'website_name',
                                    $settings['website_name'] ?? ''
                                ) }}"
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
                                value="{{ old(
                                    'website_url',
                                    $settings['website_url'] ?? url('/')
                                ) }}"
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
                                    $settings['website_tagline'] ?? ''
                                ) }}"
                                placeholder="Enter website tagline"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Branding
            ====================================================== --}}
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

                                    @if (!empty($settings['website_logo']))

                                        <img
                                            src="{{ asset($settings['website_logo']) }}"
                                            alt="{{ $settings['website_name'] ?? 'Website Logo' }}"
                                        >

                                    @else

                                        <span>
                                            No Logo
                                        </span>

                                    @endif

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

                                    @if (!empty($settings['favicon']))

                                        <img
                                            src="{{ asset($settings['favicon']) }}"
                                            alt="Website Favicon"
                                        >

                                    @else

                                        <span>
                                            No Favicon
                                        </span>

                                    @endif

                                </div>


                                <div class="upload-content">

                                    <strong>
                                        Website Favicon
                                    </strong>

                                    <span>
                                        ICO or PNG
                                    </span>

                                    <label
                                        for="favicon"
                                        class="upload-button"
                                    >

                                        <i class="ri-upload-2-line"></i>

                                        Choose File

                                    </label>

                                    <input
                                        type="file"
                                        id="favicon"
                                        name="favicon"
                                        accept=".ico,.png"
                                        hidden
                                    >

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- =====================================================
                System Preferences
            ====================================================== --}}
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
                                    type="hidden"
                                    name="maintenance_mode"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="maintenance_mode"
                                    value="1"
                                    @checked(
                                        old(
                                            'maintenance_mode',
                                            $settings['maintenance_mode'] ?? '0'
                                        ) === '1'
                                    )
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
                                    type="hidden"
                                    name="customer_registration"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="customer_registration"
                                    value="1"
                                    @checked(
                                        old(
                                            'customer_registration',
                                            $settings['customer_registration'] ?? '1'
                                        ) === '1'
                                    )
                                >

                                <span class="slider"></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Actions
            ====================================================== --}}
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

@endsection


@push('scripts')
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
@endpush
