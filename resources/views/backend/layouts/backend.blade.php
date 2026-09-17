@include('backend.components.header')

<div class="dashboard-layout">
    @include('backend.components.sidebar')
    <div class="dashboard-overlay"></div>

    <div class="dashboard-main">
        <div class="dashboard-topbar d-xl-none">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="topbar-left">
                                <a class="d-logo" href="{{ route('home') }}">
                                    <img
                                        src="{{ setting('website_logo') ? asset(setting('website_logo')) : asset('logo.png') }}"
                                        alt="{{ setting('website_name', config('app.name')) }}"
                                    >
                                </a>
                            </div>

                            <div class="topbar-right">
                                <div class="open-menu d-inline-flex d-xl-none">
                                    <i class="ri-menu-unfold-4-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')
    </div>
</div>

@include('backend.components.footer')
