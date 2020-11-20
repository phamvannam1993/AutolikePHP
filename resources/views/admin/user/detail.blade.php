@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Thông tin chi tiết</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#General">General</a></li>
                            <li class="tab" data-id="1" id="tab1"><a data-toggle="tab"  href="#Device">Device</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="General" class="tab-pane fade in active">
                                <div class="row" style="padding-top: 30px;">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{$userDetail['fullname']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">username</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{$userDetail['username']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Token</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{$userDetail['token']}}</p>
                                        </div>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Clone Count</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{$userDetail['clone_count']}}</p>
                                        </div>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">User nox-vm</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>
                                                <input disabled="" type="checkbox" name="" {{isset($userDetail['user_nox']) && $userDetail['user_nox'] == '1'  ? 'checked' : ''}}>

                                                
                                            </p>
                                        </div>
                                    </div>
                                </div>  
                            </div>  
                            <div id="Device" class="tab-pane fade tabAction1" data-id="1">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="getAtionUrl" value="{{route('admin.user.device')}}">
    <input type="hidden" id="uid" value="{{$userDetail['_id']}}">
@endsection

