<!DOCTYPE html>
<html lang="en">
@include('website.layouts.partials.head')
@stack('pageStyles')
<body class="nav-md">
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v4.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat"
         attribution=setup_tool
         page_id="218204305776169"
         logged_in_greeting="Xin chào, chúng tôi có thể giúp gì cho bạn?"
         logged_out_greeting="Xin chào, chúng tôi có thể giúp gì cho bạn?">
    </div>
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