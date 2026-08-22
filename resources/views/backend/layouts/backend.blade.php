@include('backend.components.header')

<div class="dashboard-layout">
    @include('backend.components.sidebar')
    <div class="dashboard-overlay"></div>
    <div class="dashboard-main">
{{--        @include('backend.components.topbar')--}}

        @yield('content')
    </div>
</div>

@include('backend.components.footer')
