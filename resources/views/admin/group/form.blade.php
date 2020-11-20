@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{__('messages.Add New Group Profile')}}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <form action="{{route('admin.group.form')}}" method="post">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                    <div class="container">
	                    	@if($messageError)
			                    <div class="alert alert-danger">
			                        <strong style="font-weight: 500;">{{$messageError}}.</strong>
			                    </div>
		                    @endif
	                        <div class="row" style="padding-top: 30px;">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">{{__('messages.Group Name')}}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <input required="" value="{{ isset($group['name']) ? $group['name'] : ''}}" class="form-control" name="group[name]">
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">{{__('messages.Ids')}}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <textarea class="form-control" rows="10" name="group[uids]" required="">{{ isset($group['uids']) ? $group['uids'] : ''}}</textarea>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                        	<input type="submit" value="Save" class="btn btn-primary">
	                        	<a href="{{route('admin.group.list')}}" class="btn btn-info">{{__('messages.Cancel')}}</a>
	                        </div>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

