@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách thành viên</h2>
                    <div class="clearfix"></div>
                </div>
                <a href="{{route('admin.user.form')}}" class="btn btn-primary">Thêm mới thành viên</a>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ và tên</th>
                            <th>Số điện thoại</th>
                            <th>Tổng tiền nạp</th>
                            <th>Số tiền đã tiêu</th>
                            <th>Số dư</th>
                            <th>Trạng thái</th>
                            <th>referrer code</th>
                            <th>Đăng nhập lần cuối</th>
                            <th>Ngày đăng kí</th>
                            <th>Thao tác</th>
                            <th>Lịch sử giao dịch</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ isset($user->deposit_amount) ? number_format($user->deposit_amount) : 0 }} đ</td>
                                <td>{{ isset($user->balance_use) ? number_format($user->balance_use) : 0 }} đ</td>
                                <td>{{ number_format($user->balance) }} đ</td>
                                <td>
                                    <span class="view-status-active-{{ $user->id }} label label-success @if($user->status == \App\Models\User::STATUS_BLOCK) hidden @endif" style="font-size: 100%;">
                                        <i class="fa fa-thumbs-o-up"></i>
                                        <strong>
                                            Đang hoạt động
                                        </strong>
                                    </span>
                                        <span class="view-status-block-{{ $user->id }} label label-warning @if ($user->status == \App\Models\User::STATUS_ACTIVE) hidden @endif" style="font-size: 100%;">
                                        <i class="fa fa-pause"></i>
                                        <strong>
                                            Tạm khóa
                                        </strong>
                                    </span>
                                </td>
                                <td>{{ $user->invite_code }}</td>
                                <td>{{ $user->last_time_login }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a href="javascript:;" class="view-status-block-{{ $user->id }} btn btn-success @if($user->status == \App\Models\User::STATUS_ACTIVE) hidden @endif"
                                       id=""
                                       onclick="updateUserStatus(this, '{{ $user->id }}', 'Active')"
                                    >
                                        Kích hoạt
                                    </a>
                                    <a href="javascript:;" class="view-status-active-{{ $user->id }} btn btn-warning @if($user->status == \App\Models\User::STATUS_BLOCK) hidden @endif"
                                       onclick="updateUserStatus(this, '{{ $user->id }}', 'Block')"
                                    >
                                        Khóa
                                    </a>
                                    <?php $user->agency_status = isset($user->agency_status) ? $user->agency_status : '2';?>
                                    <a href="javascript:;" class="view-status-agency-block-{{ $user->id }} btn btn-success @if($user->agency_status == '2') hidden @endif"
                                       id=""
                                       onclick="updateUserAgency(this, '{{ $user->id }}', '2')"
                                    >
                                        Thêm quyền quản lý
                                    </a>
                                    <a href="javascript:;" class="view-status-agency-active-{{ $user->id }} btn btn-warning @if($user->agency_status == '1') hidden @endif"
                                       onclick="updateUserAgency(this, '{{ $user->id }}', '1')"
                                    >
                                        Bỏ quyền quản lý
                                    </a>
                                </td>
                                <td> <a class="btn btn-info" href="{{route('website.user.history', ['userId' =>$user->_id])}}">lịch sử giao dịch</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pageScripts')
<script>
    function updateUserStatus(element, userId, status) {
        var btn = $(element);
        $.ajax({
            type: "POST",
            url: '{{ route('website.user.apiUpdateStatus') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: userId,
                status: status
            },
            beforeSend: function() {
                btn.prop('disabled', true);
                btn.prepend('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
                if (response.success == 1) {
                    if (response.data.status == '{{ \App\Models\User::STATUS_BLOCK }}') {
                        $('.view-status-active-' + response.data._id).addClass('hidden');
                        $('.view-status-block-' + response.data._id).removeClass('hidden');
                    } else {
                        $('.view-status-block-' + response.data._id).addClass('hidden');
                        $('.view-status-active-' + response.data._id).removeClass('hidden');
                    }
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            complete: function(){
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
            }
        });
    }
    function updateUserAgency(element, userId, status) {
        var btn = $(element);
        $.ajax({
            type: "POST",
            url: '{{ route('website.user.updateRole') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: userId,
                status: status
            },
            beforeSend: function() {
                btn.prop('disabled', true);
                btn.prepend('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
                if (response.success == 1) {
                    if (response.data.agency_status == '1') {
                        $('.view-status-agency-active-' + response.data._id).addClass('hidden');
                        $('.view-status-agency-block-' + response.data._id).removeClass('hidden');
                    } else {
                        $('.view-status-agency-block-' + response.data._id).addClass('hidden');
                        $('.view-status-agency-active-' + response.data._id).removeClass('hidden');
                    }
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            complete: function(){
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
            }
        });
    }
</script>
@endpush