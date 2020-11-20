<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Like4.Vip </title>

    <!-- Bootstrap -->
    <link href="{{ config('app.asset_url') }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ config('app.asset_url') }}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ config('app.asset_url') }}/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ config('app.asset_url') }}/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ config('app.asset_url') }}/build/css/custom.min.css" rel="stylesheet">

    <!-- Fix style  -->
    <style>
        .alert-danger, .alert-error {
            color: #FFF;
        }
    </style>
</head>
<body class="login">
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form action="{{ route('website.auth.doLogin') }}" method="post">
                        <h1>Đăng nhập tài khoản</h1>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong style="font-weight: 500;">{{ $errors->first() }}</strong>
                            </div>
                        @endif
                        {{ csrf_field() }}
                        <div>
                            <input type="text" name="phone" class="form-control"
                                   placeholder="Số điện thoại" required=""
                                   value="{{ old('phone') }}"
                            />
                        </div>
                        <div>
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required="" />
                        </div>
                        <div>
                            <button class="btn btn-default submit" type="submit">Đăng nhập</button>
                            {{--<a class="reset_pass" href="#">Lost your password?</a>--}}
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Bạn chưa có tài khoản?
                                <a href="{{ route('website.auth.register') }}" class="to_register"> Đăng ký </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <h1><i class="fa fa-thumbs-o-up"></i> Like4.Vip</h1>
                                <p>©2018 Bản quyền Website thuộc về Like4.Vip</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
