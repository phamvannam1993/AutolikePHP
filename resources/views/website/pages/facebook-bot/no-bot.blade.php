@extends('website.layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Kết quả</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-4">
                    <div class="form-group">
                        <form method="get" action="{{ route('website.fb-bot.showRedirect') }}">
                            {{ csrf_field() }}
                            <input type="text" class="form-control" name="uid" placeholder="Nhập mã UID và gõ enter">
                        </form>
                    </div>
                </div>
                <div class="col-sm-12">Không tìm thấy token trong cơ sở dữ liệu</div>
            </div>
        </div>
    </div>
</div>
@endsection