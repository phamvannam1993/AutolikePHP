<!DOCTYPE html>
<html lang="en">
@include('website.layouts.partials.head')
@stack('pageStyles')
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            @include('website.layouts.partials.sidebar')
            @include('website.layouts.partials.top-navigation')
            <div class="right_col" role="main">
                @yield('content')
            </div>
            @include('website.layouts.partials.footer')
        </div>
    </div>
    @include('website.layouts.partials.scripts')
    @stack('pageScripts')
</body>
</html>