@extends('website.layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Thay đổi mật khẩu</h2>
					<div class="clearfix"></div>
				</div>
				<form action="{{route('user.changePassword')}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="container">
						@if($message && $code == 0)
							<div class="alert alert-danger">
								<strong style="font-weight: 500;">{{$message}}.</strong>
							</div>
						@elseif($message)
							<div class="alert alert-success">
								<strong style="font-weight: 500;">{{$message}}.</strong>
							</div>
						@endif
						<div class="row" style="padding-top: 30px;">
							<div class="col-sm-4">
								<div class="form-friend">
									<label class="control-label">Mật khẩu đăng nhập</label>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-friend">
									<input required="" type="password" value="{{ isset($user['password']) ? $user['password'] : ''}}" class="form-control" name="user[password]">
								</div>
							</div>
						</div>
						<div class="row" style="padding-top: 30px;">
							<div class="col-sm-4">
								<div class="form-friend">
									<label class="control-label">Mật khẩu mới</label>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-friend">
									<input required="" type="password" value="{{ isset($user['password_new']) ? $user['password_new'] : ''}}" class="form-control" name="user[password_new]">
								</div>
							</div>
						</div>
						<div class="row" style="padding-top: 30px;">
							<div class="col-sm-4">
								<div class="form-friend">
									<label class="control-label">Mật khẩu xác nhận</label>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-friend">
									<input required="" type="password" value="{{ isset($user['password_confirm']) ? $user['password_confirm'] : ''}}" class="form-control" name="user[password_confirm]">
								</div>
							</div>
						</div>
						<div class="row">
							<input type="submit" value="Save" class="btn btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
