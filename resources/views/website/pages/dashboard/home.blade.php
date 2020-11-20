@extends('website.layouts.dashboard')
@section('content')
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-briefcase"></i></div>
                <div class="count">{{ isset(session('dataLogin')['balance']) ? number_format(session('dataLogin')['balance']) : '0' }}</div>
                <h3>VNĐ</h3>
                <p>Số dư tài khoản</p>
            </div>
        </div>
    </div>
    @if($type == 1)
        @include('website.pages.dashboard.partials.pricing')
    @elseif($type == 2)
        @include('website.pages.service.partials.buy-service')
    @else
        @include('website.pages.dashboard.partials.pricing')
        @include('website.pages.service.partials.buy-service')
    @endif
@endsection