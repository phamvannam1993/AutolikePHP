@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách gift code</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="title_right">
                            <form method="get">
                                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search">
                                        <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã code</th>
                            <th>Giá trị</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thời gian cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($giftCodes as $key => $giftCode)
                            <tr>
                                <th scope="row">{{ ($key + ($giftCodes->currentPage() - 1) * $giftCodes->perPage() + 1) }}</th>
                                <td>
                                    <a href="javascript:;">
                                        <strong>
                                            {{ $giftCode->code }}
                                        </strong>
                                    </a>
                                </td>
                                <td>
                                    <span class="label label-info" style="font-size: 100%;">
                                        {{ number_format($giftCode->value) }}
                                    </span>
                                </td>
                                <td>
                                    @if($giftCode->status !== \App\Models\GiftCode::STATUS_USED)
                                        <span class="view-status-active-{{ $giftCode->code }} label label-success @if($giftCode->status == \App\Models\GiftCode::STATUS_PAUSE) hidden @endif"
                                              id=""
                                              style="font-size: 100%;"
                                        >
                                            <strong>
                                                Đang hoạt động
                                            </strong>
                                        </span>
                                        <span class="view-status-pause-{{ $giftCode->code }} label label-warning @if ($giftCode->status == \App\Models\GiftCode::STATUS_ACTIVE) hidden @endif"
                                              style="font-size: 100%;"
                                        >
                                            <i class="fa fa-pause"></i>
                                            <strong>
                                                Đã tạm dừng
                                            </strong>
                                        </span>
                                    @else
                                        <span class="view-status-used-{{ $giftCode->code }} label label-danger"
                                              style="font-size: 100%;"
                                        >
                                            <i class="fa fa-stop"></i>
                                            <strong>
                                                Đã được sử dụng
                                            </strong>
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $giftCode->created_at }}</td>
                                <td>{{ $giftCode->updated_at }}</td>
                                <td>
                                    @if($giftCode->status !== \App\Models\GiftCode::STATUS_USED)
                                        <a href="javascript:;" class="view-status-pause-{{ $giftCode->code }} btn btn-success @if($giftCode->status == \App\Models\GiftCode::STATUS_ACTIVE) hidden @endif"
                                           id=""
                                           onclick="updateStatus(this, '{{ $giftCode->code }}', 'Active')"
                                        >
                                            Kích hoạt
                                        </a>
                                        <a href="javascript:;" class="view-status-active-{{ $giftCode->code }} btn btn-warning @if($giftCode->status == \App\Models\GiftCode::STATUS_PAUSE) hidden @endif"
                                           onclick="updateStatus(this, '{{ $giftCode->code }}', 'Pause')"
                                        >
                                            Tạm dừng
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $giftCodes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pageScripts')
    <script>
        function updateStatus(element, serviceCode, status) {
            var btn = $(element);
            $.ajax({
                type: "POST",
                url: '{{ route('website.gift-code.apiUpdateStatus') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    code: serviceCode,
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
                        if (response.data.status == '{{ \App\Models\GiftCode::STATUS_PAUSE }}') {
                            $('.view-status-active-' + response.data.code).addClass('hidden');
                            $('.view-status-pause-' + response.data.code).removeClass('hidden');
                            $('.view-status-used-' + response.data.code).addClass('hidden');
                        } else if (response.data.status == '{{ \App\Models\GiftCode::STATUS_USED }}') {
                            $('.view-status-active-' + response.data.code).addClass('hidden');
                            $('.view-status-pause-' + response.data.code).addClass('hidden');
                            $('.view-status-used-' + response.data.code).removeClass('hidden');
                        } else {
                            $('.view-status-active-' + response.data.code).removeClass('hidden');
                            $('.view-status-pause-' + response.data.code).addClass('hidden');
                            $('.view-status-used-' + response.data.code).addClass('hidden');
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