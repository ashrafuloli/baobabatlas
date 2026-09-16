<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        @yield('title', setting('website_name', config('app.name')))
    </title>

    <!-- favicon -->
    <link
        rel="shortcut icon"
        type="image/x-icon"
        href="{{ setting('favicon') ? asset(setting('favicon')) : asset('favicon.png') }}"
    >

    <!-- csrf -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Vendors Css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/animate/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/remixicon/remixicon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fontawesome-pro/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/aos/aos.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fancybox/fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2/sweetalert2.min.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/spacing.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/frontend.css')}}">
</head>

<body>

<div class="frontend-header">
    @php
        $headerCart = auth()->check()
            ? auth()->user()->cart
            : \App\Models\Cart::query()
                ->where('session_id', session()->getId())
                ->first();

        $headerCartCount =
            $headerCart?->totalQuantity() ?? 0;
    @endphp

    {{-- Header --}}
    <header class="header-area">
        <div class="container">
            <div class="header-main">

                {{-- Logo --}}
                <div class="logo-wrap">
                    <a href="{{ route('home') }}">
                        <img
                                src="{{ setting('website_logo') ? asset(setting('website_logo')) : asset('logo.png') }}"
                                alt="{{ setting('website_name', config('app.name')) }}"
                        >
                    </a>
                </div>


                <div class="header-desktop">
                    <nav class="main-menu" aria-label="Main navigation">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">
                                    Home
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('service') }}">
                                    Service
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('tracking') }}">
                                    Tracking
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('shop') }}">
                                    Marketplace
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('partners') }}">
                                    Partners
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('about') }}">
                                    About
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                {{-- Desktop Navigation --}}
                <div class="header-desktop">
                    <div class="header-actions">

                        {{-- Language --}}
                        <div class="header-dropdown language-dropdown d-none">
                            <button
                                    type="button"
                                    class="header-icon-btn dropdown-trigger"
                                    aria-label="Select language"
                                    aria-expanded="false"
                            >
                                <span>EN</span>
                                <i class="ri-arrow-down-s-line"></i>
                            </button>

                            <div class="header-dropdown-menu">
                                <button type="button" data-language="en">
                                    English
                                </button>

                                <button type="button" data-language="fr">
                                    Français
                                </button>
                            </div>
                        </div>

                        {{-- Search --}}
                        <button
                                type="button"
                                class="header-icon-btn desktop-search-trigger"
                                aria-label="Search"
                        >
                            <i class="ri-search-line"></i>
                        </button>

                        {{-- Account --}}
                        <div class="header-account header-dropdown">
                            <button
                                    type="button"
                                    class="header-icon-btn dropdown-trigger"
                                    aria-label="Account"
                                    aria-expanded="false"
                            >
                                <i class="ri-user-3-line"></i>
                            </button>

                            <div class="header-dropdown-menu account-menu">
                                @if(auth()->check())
                                    <a href="{{ route('my-account') }}">
                                        My Account
                                    </a>

                                    <a href="{{ route('dashboard') }}">
                                        My Dashboard
                                    </a>

                                    <form
                                            action="{{ route('logout') }}"
                                            method="POST"
                                    >
                                        @csrf

                                        <button
                                                type="submit"
                                                class="logout-btn"
                                                data-logout-button
                                        >
                                            Logout
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}">
                                        Login
                                    </a>

                                    @if(setting('customer_registration', '1') === '1')
                                        <a href="{{ route('register') }}">
                                            Register
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- Cart --}}
                        <a href="{{ route('my-cart') }}" class="header-cart-trigger" aria-label="Shopping cart">
                            <i class="ri-shopping-bag-3-line"></i>
                            <span
                                    class="header-cart-count"
                                    data-cart-count
                            >
                                {{ $headerCartCount }}
                            </span>
                        </a>

                        {{-- Quote --}}
                        <a
                                href="{{ route('contact') }}"
                                class="header-quote"
                        >
                            Get a Quote
                        </a>
                    </div>
                </div>

                {{-- Mobile Actions --}}
                <div class="header-mobile-actions">

                    {{-- Language --}}
                    <div class="header-dropdown language-dropdown d-none">
                        <button
                                type="button"
                                class="header-icon-btn dropdown-trigger"
                                aria-label="Select language"
                                aria-expanded="false"
                        >
                            <span>EN</span>
                            <i class="ri-arrow-down-s-line"></i>
                        </button>

                        <div class="header-dropdown-menu">
                            <button type="button" data-language="en">
                                English
                            </button>

                            <button type="button" data-language="fr">
                                Français
                            </button>
                        </div>
                    </div>

                    {{-- Account --}}
                    <div class="header-account header-dropdown">
                        <button
                                type="button"
                                class="header-icon-btn dropdown-trigger"
                                aria-label="Account"
                                aria-expanded="false"
                        >
                            <i class="ri-user-3-line"></i>
                        </button>

                        <div class="header-dropdown-menu account-menu">
                            @if(auth()->check())
                                <a href="{{ route('my-account') }}">
                                    My Account
                                </a>

                                <a href="{{ route('dashboard') }}">
                                    My Dashboard
                                </a>

                                <form
                                        action="{{ route('logout') }}"
                                        method="POST"
                                >
                                    @csrf

                                    <button
                                            type="submit"
                                            class="logout-btn"
                                            data-logout-button
                                    >
                                        Logout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}">
                                    Login
                                </a>

                                @if(setting('customer_registration', '1') === '1')
                                    <a href="{{ route('register') }}">
                                        Register
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Cart --}}
                    <a href="{{ route('my-cart') }}" class="header-cart-trigger" aria-label="Shopping cart">
                        <i class="ri-shopping-bag-3-line"></i>

                        <span class="header-cart-count" data-cart-count>
                            {{ $headerCartCount }}
                        </span>
                    </a>

                    {{-- Hamburger --}}
                    <button
                            type="button"
                            class="mobile-menu-trigger"
                            data-mobile-menu-open
                            aria-label="Open menu"
                    >
                        <i class="ri-menu-line"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Search --}}
            <div class="mobile-search">
                <form
                        action="{{ route('shop') }}"
                        method="GET"
                        class="mobile-search-form"
                >
                    <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="What are you looking for?"
                            aria-label="Search products"
                            autocomplete="off"
                            data-mobile-search-input
                    >

                    <button
                            type="button"
                            class="mobile-search-clear"
                            data-mobile-search-clear
                            aria-label="Clear search"
                    >
                        <i class="ri-close-line"></i>
                    </button>

                    <button
                            type="submit"
                            class="mobile-search-submit"
                            aria-label="Search"
                    >
                        <i class="ri-search-line"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>


    {{-- Desktop Search --}}
    <div class="desktop-search-panel" data-desktop-search>
        <div class="container">
            <div class="desktop-search-inner">

                <form
                        action="{{ route('shop') }}"
                        method="GET"
                        class="desktop-search-form"
                >
                    <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="What are you looking for?"
                            aria-label="Search products"
                            autocomplete="off"
                            data-desktop-search-input
                    >

                    <button
                            type="button"
                            class="desktop-search-clear"
                            data-desktop-search-clear
                            aria-label="Clear search"
                    >
                        <i class="ri-close-line"></i>
                    </button>

                    <button
                            type="submit"
                            class="desktop-search-submit"
                            aria-label="Search"
                    >
                        <i class="ri-search-line"></i>
                    </button>
                </form>

                <button
                        type="button"
                        class="desktop-search-panel-close"
                        data-desktop-search-close
                        aria-label="Close search"
                >
                    <i class="ri-close-line"></i>
                </button>

            </div>
        </div>
    </div>


    {{-- Mobile Offcanvas --}}
    <div
            class="offcanvas-wrapper"
            data-mobile-menu
    >
        <div class="offcanvas-sidebar">

            <div class="offcanvas-header">
                <div class="offcanvas-logo">
                    <img
                            src="{{ setting('website_logo') ? asset(setting('website_logo')) : asset('logo.png') }}"
                            alt="{{ setting('website_name', config('app.name')) }}"
                    >
                </div>

                <button
                        type="button"
                        class="offcanvas-close"
                        data-mobile-menu-close
                        aria-label="Close menu"
                >
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <nav
                    class="offcanvas-menu"
                    aria-label="Mobile navigation"
            >
                <ul>
                    <li>
                        <a href="{{ route('home') }}">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('service') }}">
                            Service
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('tracking') }}">
                            Tracking
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('shop') }}">
                            Marketplace
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('partners') }}">
                            Partners
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('about') }}">
                            About
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- Only Quote button on mobile --}}
            <div class="offcanvas-footer">
                <a
                        href="{{ route('contact') }}"
                        class="offcanvas-quote"
                >
                    Get a Quote
                </a>
            </div>
        </div>

        <div
                class="offcanvas-overlay"
                data-mobile-menu-close
        ></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const header = document.querySelector('.frontend-header');

        if (!header) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const dropdowns =
            header.querySelectorAll('.header-dropdown');

        const mobileMenu =
            header.querySelector('[data-mobile-menu]');

        const mobileMenuOpen =
            header.querySelector('[data-mobile-menu-open]');

        const mobileMenuClose =
            header.querySelectorAll(
                '[data-mobile-menu-close]'
            );

        const cartDrawer =
            header.querySelector('[data-cart-drawer]');

        const cartOpenButtons =
            header.querySelectorAll(
                '[data-cart-drawer-open]'
            );

        const cartCloseButtons =
            header.querySelectorAll(
                '[data-cart-drawer-close]'
            );

        const desktopSearch =
            header.querySelector('[data-desktop-search]');

        const desktopSearchTrigger =
            header.querySelector('.desktop-search-trigger');

        const desktopSearchInput =
            header.querySelector(
                '[data-desktop-search-input]'
            );

        const desktopSearchClear =
            header.querySelector(
                '[data-desktop-search-clear]'
            );

        const desktopSearchClose =
            header.querySelector(
                '[data-desktop-search-close]'
            );

        const mobileSearchInput =
            header.querySelector(
                '[data-mobile-search-input]'
            );

        const mobileSearchClear =
            header.querySelector(
                '[data-mobile-search-clear]'
            );


        /*
        |--------------------------------------------------------------------------
        | Dropdown Helpers
        |--------------------------------------------------------------------------
        */

        const closeDropdowns = () => {
            dropdowns.forEach((dropdown) => {
                dropdown.classList.remove('active');

                const trigger =
                    dropdown.querySelector(
                        '.dropdown-trigger'
                    );

                if (trigger) {
                    trigger.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                }
            });
        };


        /*
        |--------------------------------------------------------------------------
        | Mobile Menu Helpers
        |--------------------------------------------------------------------------
        */

        const closeMobileMenu = () => {
            if (!mobileMenu) {
                return;
            }

            mobileMenu.classList.remove('active');

            if (mobileMenuOpen) {
                mobileMenuOpen.setAttribute(
                    'aria-expanded',
                    'false'
                );
            }
        };


        /*
        |--------------------------------------------------------------------------
        | Cart Helpers
        |--------------------------------------------------------------------------
        */

        const closeCartDrawer = () => {
            if (!cartDrawer) {
                return;
            }

            cartDrawer.classList.remove('active');
        };


        /*
        |--------------------------------------------------------------------------
        | Desktop Search Helpers
        |--------------------------------------------------------------------------
        */

        const updateDesktopSearchClear = () => {
            if (
                !desktopSearchInput
                || !desktopSearchClear
            ) {
                return;
            }

            const hasValue =
                desktopSearchInput.value.trim() !== '';

            desktopSearchClear.classList.toggle(
                'active',
                hasValue
            );
        };


        const closeDesktopSearch = () => {
            if (!desktopSearch) {
                return;
            }

            desktopSearch.classList.remove('active');

            updateDesktopSearchClear();
        };


        /*
        |--------------------------------------------------------------------------
        | Mobile Search Helpers
        |--------------------------------------------------------------------------
        */

        const updateMobileSearchClear = () => {
            if (
                !mobileSearchInput
                || !mobileSearchClear
            ) {
                return;
            }

            const hasValue =
                mobileSearchInput.value.trim() !== '';

            mobileSearchClear.classList.toggle(
                'active',
                hasValue
            );
        };


        /*
        |--------------------------------------------------------------------------
        | Dropdowns
        |--------------------------------------------------------------------------
        */

        dropdowns.forEach((dropdown) => {
            const trigger =
                dropdown.querySelector(
                    '.dropdown-trigger'
                );

            if (!trigger) {
                return;
            }

            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();

                const wasActive =
                    dropdown.classList.contains('active');

                closeDropdowns();
                closeDesktopSearch();

                if (!wasActive) {
                    dropdown.classList.add('active');

                    trigger.setAttribute(
                        'aria-expanded',
                        'true'
                    );
                }
            });
        });


        /*
        |--------------------------------------------------------------------------
        | Language Switcher
        |--------------------------------------------------------------------------
        */

        const languageButtons =
            header.querySelectorAll('[data-language]');

        const languageTriggers =
            header.querySelectorAll(
                '.language-dropdown .dropdown-trigger'
            );

        let savedLanguage = 'en';

        try {
            savedLanguage =
                localStorage.getItem(
                    'baobab_language'
                ) || 'en';
        } catch (error) {
            savedLanguage = 'en';
        }


        const updateLanguageUI = (language) => {
            languageTriggers.forEach((trigger) => {
                const label =
                    trigger.querySelector('span');

                if (label) {
                    label.textContent =
                        language.toUpperCase();
                }
            });

            languageButtons.forEach((button) => {
                button.classList.toggle(
                    'active',
                    button.dataset.language === language
                );
            });
        };


        updateLanguageUI(savedLanguage);


        languageButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();

                const language =
                    button.dataset.language;

                if (!language) {
                    return;
                }

                try {
                    localStorage.setItem(
                        'baobab_language',
                        language
                    );
                } catch (error) {
                    // Ignore localStorage errors.
                }

                updateLanguageUI(language);
                closeDropdowns();
            });
        });


        /*
        |--------------------------------------------------------------------------
        | Desktop Search
        |--------------------------------------------------------------------------
        */

        if (
            desktopSearchTrigger
            && desktopSearch
        ) {
            desktopSearchTrigger.addEventListener(
                'click',
                (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    const wasActive =
                        desktopSearch.classList.contains(
                            'active'
                        );

                    closeDropdowns();

                    if (wasActive) {
                        closeDesktopSearch();

                        return;
                    }

                    desktopSearch.classList.add(
                        'active'
                    );

                    if (desktopSearchInput) {
                        window.setTimeout(() => {
                            desktopSearchInput.focus();
                        }, 100);
                    }
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Desktop Search Input
        |--------------------------------------------------------------------------
        */

        if (desktopSearchInput) {
            desktopSearchInput.addEventListener(
                'input',
                updateDesktopSearchClear
            );

            desktopSearchInput.addEventListener(
                'keydown',
                (event) => {
                    if (event.key === 'Escape') {
                        closeDesktopSearch();

                        if (desktopSearchTrigger) {
                            desktopSearchTrigger.focus();
                        }
                    }
                }
            );

            updateDesktopSearchClear();
        }


        /*
        |--------------------------------------------------------------------------
        | Desktop Search Clear
        |--------------------------------------------------------------------------
        */

        if (
            desktopSearchClear
            && desktopSearchInput
        ) {
            desktopSearchClear.addEventListener(
                'click',
                (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    desktopSearchInput.value = '';

                    updateDesktopSearchClear();

                    desktopSearchInput.focus();
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Desktop Search Panel Close
        |--------------------------------------------------------------------------
        */

        if (desktopSearchClose) {
            desktopSearchClose.addEventListener(
                'click',
                (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    closeDesktopSearch();

                    if (desktopSearchTrigger) {
                        desktopSearchTrigger.focus();
                    }
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile Search Input
        |--------------------------------------------------------------------------
        */

        if (mobileSearchInput) {
            mobileSearchInput.addEventListener(
                'input',
                updateMobileSearchClear
            );

            updateMobileSearchClear();
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile Search Clear
        |--------------------------------------------------------------------------
        */

        if (
            mobileSearchClear
            && mobileSearchInput
        ) {
            mobileSearchClear.addEventListener(
                'click',
                (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    mobileSearchInput.value = '';

                    updateMobileSearchClear();

                    mobileSearchInput.focus();
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile Menu
        |--------------------------------------------------------------------------
        */

        if (
            mobileMenuOpen
            && mobileMenu
        ) {
            mobileMenuOpen.addEventListener(
                'click',
                (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    const wasActive =
                        mobileMenu.classList.contains(
                            'active'
                        );

                    closeDropdowns();
                    closeDesktopSearch();
                    closeCartDrawer();

                    mobileMenu.classList.toggle(
                        'active',
                        !wasActive
                    );

                    mobileMenuOpen.setAttribute(
                        'aria-expanded',
                        (!wasActive).toString()
                    );
                }
            );
        }


        mobileMenuClose.forEach((button) => {
            button.addEventListener(
                'click',
                (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    closeMobileMenu();
                }
            );
        });


        /*
        |--------------------------------------------------------------------------
        | Mobile Navigation Links
        |--------------------------------------------------------------------------
        */

        const mobileLinks =
            header.querySelectorAll(
                '.offcanvas-menu a, .offcanvas-quote'
            );

        mobileLinks.forEach((link) => {
            link.addEventListener(
                'click',
                closeMobileMenu
            );
        });


        /*
        |--------------------------------------------------------------------------
        | Outside Click
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            (event) => {
                const target = event.target;

                if (!(target instanceof Node)) {
                    return;
                }

                if (!header.contains(target)) {
                    closeDropdowns();
                    closeDesktopSearch();

                    return;
                }

                const clickedDropdown =
                    target.closest(
                        '.header-dropdown'
                    );

                const clickedSearch =
                    target.closest(
                        '.desktop-search-panel'
                    );

                const clickedSearchTrigger =
                    target.closest(
                        '.desktop-search-trigger'
                    );

                if (
                    !clickedDropdown
                    && !clickedSearch
                    && !clickedSearchTrigger
                ) {
                    closeDropdowns();
                }
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Escape Key
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            (event) => {
                if (event.key !== 'Escape') {
                    return;
                }

                closeDropdowns();
                closeDesktopSearch();
                closeMobileMenu();
                closeCartDrawer();
            }
        );
    });
</script>
