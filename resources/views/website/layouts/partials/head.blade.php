<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>autolike</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ url('css') }}/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('css') }}/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ url('css') }}/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ url('css') }}/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ url('css') }}/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ url('css') }}/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ url('css') }}/daterangepicker.css" rel="stylesheet">

    <!-- Toastr -->
    <link href="{{ url('css') }}/toastr.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ url('css') }}/custom.min.css" rel="stylesheet">

    <!-- Custom Personal Style -->
    <link href="{{ url('css') }}/main.css" rel="stylesheet">

    <!-- Date picker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @yield('css')
</head>
