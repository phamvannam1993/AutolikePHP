<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>auto-like.xyz</title>

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
                <form action="{{route('admin.login')}}" method="post">
                    <h1>Login Account</h1>
                    <div class="alert alert-danger message" style="{{$messageError ? '' : 'display:none'}}">
                        <strong style="font-weight: 500;" id="messageError">{{$messageError ? $messageError : ''}}.</strong>
                    </div>
                    <div class="alert alert-success  messageSuccess" style="display: none">
                        <strong style="font-weight: 500;" id="messageSuccess"></strong>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div>
                        <input type="text" name="username" class="form-control"
                               placeholder="Phone Number" id="PhoneNumber" value="{{ isset($dataLogin['username']) ? $dataLogin['username'] : ''}}" required
                        />
                    </div>
                    <div>
                        <input type="password" value="{{ isset($dataLogin['password']) ? $dataLogin['password'] : ''}}" name="password" class="form-control" placeholder="Mật khẩu" required="" />
                    </div>
                    <br>
                    <div>
                        <button class="btn btn-primary submit" type="submit" id="login">Login</button>
                        <button class="btn btn-default submit" type="button" id="ForgotPassword">Forgot Password</button>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
			    <p class="change_link">Bạn chưa có tài khoản?
                                <a href="{{route('admin.user.register')}}" class="to_register"> Đăng ký </a>
                            </p>
                        <div class="clearfix"></div>
                        <br />
                        <div>
                            <h1><i class="fa fa-thumbs-o-up"></i>auto-like.xyz</h1>
                            <p>©<?= date('Y')?> Copyright Website belongs to auto-like.xyz</p>
                        </div>
                    </div>
                </form>
                <input type="hidden" value="{{route('admin.send.sms')}}" id="sendSMS">
            </section>
        </div>
    </div>
</div>
<script src="{{ url('js') }}/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{ url('js') }}/bootstrap.min.js"></script>
<script src="{{ url('js') }}/custom.min.js"></script>
<script>
    $('#ForgotPassword').click(function () {
        var url = $('#sendSMS').val();
        var PhoneNumber = $('#PhoneNumber').val();
        if(PhoneNumber == '') {
            $('#messageError').text('Phone number is not empty.');
            $('#PhoneNumber').focus();
            $('.message').show();
            return false;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: {
                PhoneNumber: PhoneNumber
            },
            success: function (response) {
                var json = $.parseJSON(response);
                $('.message').hide();
                $('.messageSuccess').hide();
                if(json.code == 0){
                    $('.message').show();
                    $('#messageError').text(json.message);
                } else {
                    $('.messageSuccess').show();
                    $('#messageSuccess').text(json.message);
                }

            },
            error: function (response) {

            }
        });
    })
    
    $('#changeEnglish').change(function () {
        var english = $(this).val()
        var url = "{!! route('user.change-language', ['']) !!}" + '/'+english
        location.href = url
    })
</script>
</body>