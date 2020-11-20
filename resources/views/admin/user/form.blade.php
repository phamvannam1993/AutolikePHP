<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Autolike</title>

    <!-- Bootstrap -->
    <link href="{{url('css')}}/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('css')}}/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{url('css')}}/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{url('css')}}/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{url('css')}}/custom.min.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
                <form action="" method="post">
                    <h1>Đăng ký</h1>
                    <div class="alert alert-danger message" style="{{$messageError ? '' : 'display:none'}}">
                        <strong style="font-weight: 500;" id="messageError">{{$messageError ? $messageError : ''}}.</strong>
                    </div>
                    {{ csrf_field() }}
                    <div>
                        <input type="text" class="form-control" name="user[username]" placeholder="Số điện thoại" required="true" value="{{ isset($userDetail['username']) ? $userDetail['username'] : '' }}"/>
                    </div>
                    <div>
                        <input type="text" class="form-control" name="user[fullname]" placeholder="Họ và tên" required="true" value="{{ isset($userDetail['fullname']) ? $userDetail['fullname'] : '' }}"/>
                    </div>
                    <div>
                        <input type="password" class="form-control" name="user[password]" value="{{ isset($userDetail['password']) ? $userDetail['password'] : '' }}" placeholder="Mật khẩu" required="true" />
                    </div>
                    <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="6LeJGNwUAAAAAB7KLnuOfsYdVALHuJ9lWqgNzm53"></div>
                    <div>
                        <button class="btn btn-default submit" type="submit">Đăng ký</button>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">Bạn đã có tài khoản ?
                            <a href="{{ route('admin.login') }}" class="to_register"> Đăng nhập </a>
                        </p>
                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-thumbs-o-up"></i> Like4.Vip</h1>
                            <p>©{{date('Y')}} Bản quyền Website thuộc về Like4.Vip</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>

