@extends('admin.base')

@section('main')
	<div class="right_col" role="main">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>{{ __('messages.Add New Clone') }}</h2>
						<div class="clearfix"></div>
					</div>
					<form action="{{route('admin.clone.form')}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="container">
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group">
										<label class="control-label">{{ __('messages.Country') }}</label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<select class="form-control" name="country" {{ isset($deviceDetail['_id']) ? 'disabled' : ''}}>
											<option value="VN">{{ __('messages.vietnam') }}</option>
											<option value="EN">{{ __('messages.english') }}</option>
											<option value="TL">{{ __('messages.ThaiLand') }}</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group">
										<label class="control-label">{{ __('messages.Clones') }}</label>
									</div>
								</div>
								<div class="col-sm-10">
									<div class="form-group">
										<textarea class="form-control" rows="10" name="clones" required=""></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<input type="submit" value="{{ __('messages.Save') }}" class="btn btn-primary">
								<a href="{{route('admin.clone-facebook.cloneFacebook')}}" class="btn btn-info">{{ __('messages.Cancel') }}</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

