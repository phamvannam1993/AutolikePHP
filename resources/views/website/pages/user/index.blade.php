@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách cộng tác viên</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ và tên</th>
                            <th>Trạng thái</th>
                            <th>Ngày đăng kí</th>
                            <th>Đăng nhập lần cuối</th>
                            <th>Ghi chú</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $user->fullname }}</td>
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
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->last_time_login }}</td>
                                <td></td>
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
</script>
@endpush