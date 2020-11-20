@extends('website.layouts.dashboard')
@section('content')
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count">{{ number_format($number_user) }}</div>
                <h3>Thành viên</h3>
                <p>Số thành viên trong hệ thống</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-gavel"></i></div>
                <div class="count">{{ number_format($number_transaction) }}</div>
                <h3>Giao dịch</h3>
                <p>Số lượt nạp tiền của các thành viên trong hệ thống</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-money"></i></div>
                <div class="count">{{ number_format($total_transaction_value) }}</div>
                <h3>VNĐ</h3>
                <p>Tổng giá trị tiền nạp của các thành viên trong hệ thống</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-cart-plus"></i></div>
                <div class="count">{{ number_format($number_service) }}</div>
                <h3>Lượt mua dịch vụ</h3>
                <p>Tổng số lượt mua gói dịch vụ của hệ thống</p>
            </div>
        </div>
    </div>
@endsection