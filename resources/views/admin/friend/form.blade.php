@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Add New Friend') }}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <form action="{{route('admin.friend.form')}}" method="post">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                    <div class="container">
	                    	@if($messageError)
			                    <div class="alert alert-danger">
			                        <strong style="font-weight: 500;">{{$messageError}}.</strong>
			                    </div>
		                    @endif
	                        <div class="row" style="padding-top: 30px;">
	                            <div class="col-sm-4">
	                                <div class="form-friend">
	                                    <label class="control-label">{{ __('messages.Group Friend Name') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-friend">
	                                    <input required="" value="{{ isset($friend['name']) ? $friend['name'] : ''}}" class="form-control" name="friend[name]">
	                                </div>
	                            </div>
	                        </div>
								<br>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-friend">
	                                    <label class="control-label">{{ __('messages.Id List') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-friend">
	                                    <textarea class="form-control" rows="10" name="friend[uids]" required="">{{ isset($friend['uids']) ? $friend['uids'] : ''}}</textarea>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                        	<input type="submit" value="Save" class="btn btn-primary">
	                        	<a href="{{route('admin.friend.list')}}" class="btn btn-info">{{ __('messages.Cancel') }}</a>
	                        </div>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

