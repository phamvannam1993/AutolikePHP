@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <form action="{{route('admin.number-action-profile.form', ['actionProfileId' => $actionProfileId])}}" method="post">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                    <div class="container">
	                        <div class="row" style="padding-top: 30px;">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">Tên Action</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <input required="" value="" class="form-control" name="actionProfileNumber[name]">
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                        	<input type="submit" value="Save" class="btn btn-primary">
	                        	<a href="{{route('admin.action-profile.list')}}" class="btn btn-info">Cancle</a>
	                        </div>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

