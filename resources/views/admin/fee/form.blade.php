@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thêm mới khuyến mãi</h2>
                    <div class="clearfix"></div>
                </div>
                <form action="{{route('admin.fee.form')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="feeId" value="{{isset($feeDetail['_id']) ? $feeDetail['_id'] : 0}}">
                    <div class="container">
                        @if($messageError)
                            <div class="alert alert-danger">
                                <strong style="font-weight: 500;">{{$messageError}}.</strong>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Khoảng tiền</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input  class="form-control" type="number" required="" name="fee[money]" value="{{isset($feeDetail['money']) ? $feeDetail['money'] : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Thưởng</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input  class="form-control" type="number" required="" name="fee[bonus]" value="{{isset($feeDetail['bonus']) ? $feeDetail['bonus'] : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <input type="submit" value="Save" class="btn btn-primary">
                            <a href="{{route('admin.fee.list')}}" class="btn btn-info">Cancle</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


