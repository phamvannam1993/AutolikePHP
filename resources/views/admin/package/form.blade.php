@extends('website.layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thêm mới gói sử dụng</h2>
                    <div class="clearfix"></div>
                </div>
                <form action="{{route('admin.package.form')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="packageId" value="{{isset($packageDetail['_id']) ? $packageDetail['_id'] : 0}}">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Gói nạp tiền</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input  class="form-control" type="number" required="" name="package[money]" value="{{isset($packageDetail['money']) ? $packageDetail['money'] : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Khuyến mãi</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input  class="form-control" type="number" required="" name="package[bonus]" value="{{isset($packageDetail['bonus']) ? $packageDetail['bonus'] : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <input type="submit" value="Save" class="btn btn-primary">
                            <a href="{{route('admin.user.list')}}" class="btn btn-info">Cancle</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


