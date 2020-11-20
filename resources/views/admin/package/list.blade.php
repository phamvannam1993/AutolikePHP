@extends('website.layouts.dashboard')
@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Danh sách gói sử dụng</h2>

					<div class="clearfix"></div>
				</div>
				<a href="{{route('admin.package.add')}}" class="btn btn-primary">Thêm mới gói sử dụng</a>
				<div class="x_content">
					<table id="datatable-checkbox" class="table table-bordered">
						<tr>
							<th>STT</th>
							<th>Gói nạp tiền</th>
							<th>Khuyến mãi</th>
							<th>Xử lý</th>
						</tr>
						@foreach($packageList as $key => $package)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ number_format($package->money) }}</td>
								<td>{{ number_format($package->bonus) }}</td>
								<td>
									<a class="btn btn-info" href="{{route('admin.package.update', ['packageId' =>$package->_id])}}">Update</a>
									<a class="btn btn-danger" href="{{route('admin.package.delete', ['packageId' =>$package->_id])}}">Delete</a>
								</td>
							</tr>
						@endforeach
					</table>
					{{ $packageList->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
