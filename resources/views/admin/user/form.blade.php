@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thêm mới người dùng</h2>
                    <div class="clearfix"></div>
                </div>
                <form action="{{route('admin.user.form')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="userId" value="{{isset($userDetail['_id']) ? $userDetail['_id'] : 0}}">
                    <div class="container">
                        @if($messageError)
                            <div class="alert alert-danger">
                                <strong style="font-weight: 500;">{{$messageError}}.</strong>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Họ và tên</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input  class="form-control" required="" name="user[fullname]" value="{{isset($userDetail['fullname']) ? $userDetail['fullname'] : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Phone Number</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input  class="form-control" required="" name="user[username]" value="{{isset($userDetail['username']) ? $userDetail['username'] : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">password</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="user[password]" value="{{isset($userDetail['pass_show']) ? $userDetail['pass_show'] : ''}}">
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


