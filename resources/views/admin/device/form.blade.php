@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Add New Device') }}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <form action="{{route('admin.device.form')}}" method="post">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" value="{{ isset($deviceDetail['_id']) ? $deviceDetail['_id'] : 0}}" name="deviceId">
	                    <div class="container">
							<div class="row" style="padding-top: 30px;">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="control-label">{{ __('messages.Device Name') }}</label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<input required="" value="{{ isset($deviceDetail['name']) ? $deviceDetail['name'] : ''}}" class="form-control" {{ isset($deviceDetail['_id']) ? 'disabled' : ''}} name="device[name]">
									</div>
								</div>
							</div>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">{{ __('messages.Phone Number') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <input required="" value="{{ isset($deviceDetail['phone_number']) ? $deviceDetail['phone_number'] : ''}}" {{ isset($deviceDetail['_id']) ? 'disabled' : ''}} class="form-control" name="device[phone_number]">
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">{{ __('messages.Clone Name') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <select class="form-control" name="device[clone_name]" {{ isset($deviceDetail['_id']) ? 'disabled' : ''}}>
	                                    	<option value="vi" {{ isset($deviceDetail['clone_name']) && $deviceDetail['clone_name'] == 'vn'  ? 'selected' : ''}}>{{ __('messages.vietnam') }}</option>
	                                    	<option value="en" {{ isset($deviceDetail['clone_name']) && $deviceDetail['clone_name'] == 'en'  ? 'selected' : ''}}>{{ __('messages.english') }}</option>
	                                    	<option value="tl" {{ isset($deviceDetail['clone_name']) && $deviceDetail['clone_name'] == 'tl'  ? 'selected' : ''}}>{{ __('messages.ThaiLand') }}</option>
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">{{ __('messages.Group Profile') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <select class="form-control" name="device[group_profile]">
	                                     	@if($groupList)
	                                     		@foreach($groupList as $group)
	                                    			<option value="{{$group['_id']}}" {{ isset($deviceDetail['group_profile']) && $deviceDetail['group_profile'] == $group['_id']  ? 'selected' : ''}}>{{$group['name']}}</option>
	                                    		@endforeach
	                                    	@endif
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">{{ __('messages.Friend  Profile') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <select class="form-control" name="device[friend_profile]">
	                                     	@if($friendList)
	                                     		@foreach($friendList as $friend)
	                                    			<option value="{{$friend['_id']}}" {{ isset($deviceDetail['friend_profile']) && $deviceDetail['friend_profile'] == $friend['_id']  ? 'selected' : ''}}>{{$friend['name']}}</option>
	                                    		@endforeach
	                                    	@endif
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">{{ __('messages.Action Profile') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                     <select class="form-control" name="device[action_profile]">
	                                     	@if($actionProfile)
	                                     		@foreach($actionProfile as $action)
	                                    			<option value="{{$action['_id']}}" {{ isset($deviceDetail['action_profile']) && $deviceDetail['group_profile'] == $action['_id']  ? 'selected' : ''}}>{{$action['name']}}</option>
	                                    		@endforeach
	                                    	@endif
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                    <label class="control-label">{{ __('messages.Page') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-group">
	                                     <select class="form-control" name="device[page]">
	                                     	@if($pageUidList)
	                                     		@foreach($pageUidList as $page)
	                                    			<option value="{{$page['uid']}}" {{ isset($deviceDetail['page']) && $deviceDetail['page'] == $page['uid']  ? 'selected' : ''}}>{{$page['uid']}}</option>
	                                    		@endforeach
	                                    	@endif
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="control-label">{{ __('messages.Time Out') }}</label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<input required="" value="{{ isset($deviceDetail['time_out']) ? $deviceDetail['time_out'] : ''}}" class="form-control" name="device[time_out]">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="control-label">{{ __('messages.Reset 3G') }}</label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<input required="" value="{{ isset($deviceDetail['reset_3g']) ? $deviceDetail['reset_3g'] : ''}}" class="form-control" name="device[reset_3g]">
									</div>
								</div>
							</div>
	                        <div class="row">
	                        	<input type="submit" value="{{ __('messages.Save') }}" class="btn btn-primary">
	                        	<a href="{{route('admin.device.list')}}" class="btn btn-info">{{ __('messages.Cancel') }}</a>
	                        </div>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

