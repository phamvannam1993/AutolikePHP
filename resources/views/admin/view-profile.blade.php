@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Thông tin người dùng</h2>
                        <div class="clearfix"></div>
                    </div>
                    <form action="{{route('admin.page.form')}}" method="post">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                    <div class="container">
	
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-page">
	                                    <label class="control-label">user name</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-page">
	                                   <p>{{$userDetail[0]['username']}}</p>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-page">
	                                    <label class="control-label">Token</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-page">
	                                   <p>{{$userDetail[0]['token']}}</p>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

