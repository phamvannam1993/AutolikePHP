@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách dịch vụ</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group date">
                                <input type="text" class="form-control" id="datepicker" value="{{ $date }}">
                                <span class="input-group-addon">
                               <span class="fa fa-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã giao dịch</th>
                            <th>Thành viên</th>
                            <th>UID/PageID</th>
                            <th>Số likes</th>
                            <th>Số bài post</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th>Ghi chú</th>
                            <th>Thời gian cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $key => $service)
                            <tr data-toggle="collapse" data-target="#detail-service-{{ $service->code }}">
                                <th scope="row">{{ ($key + ($services->currentPage() - 1) * $services->perPage() + 1) }}</th>
                                <td>
                                    <strong>
                                        {{ $service->code }}
                                    </strong>
                                </td>
                                <td>
                                    {{ isset($userArr[$service->user_id]) ? $userArr[$service->user_id] : '' }}
                                </td>
                                <td>
                                    <a href="https://www.facebook.com/{{ $service->fanpage_id }}" target="_blank" style="text-decoration: underline;">
                                        {{ $service->fanpage_id }}
                                    </a>
                                </td>
                                <td>
                                    <span class="label label-info" style="font-size: 100%;">
                                        {{ isset($dataService[ $service->code]['number_post']) ? $dataService[ $service->code]['number_like_per_post'] : 0 }}
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-warning" style="font-size: 100%;">
                                        {{ isset($dataService[ $service->code]['number_post']) ? $dataService[ $service->code]['number_post'] : 0 }}
                                    </span>
                                </td>
                                <td>
                                    <span class="view-service-status-active-{{ $service->code }} label label-success @if($service->status == \App\Models\Service::STATUS_PAUSE) hidden @endif"
                                          id=""
                                          style="font-size: 100%;"
                                    >
                                        <i class="fa fa-thumbs-o-up"></i>
                                        <strong>
                                            Đang hoạt động
                                        </strong>
                                    </span>
                                    <span class="view-service-status-pause-{{ $service->code }} label label-warning @if ($service->status == \App\Models\Service::STATUS_ACTIVE) hidden @endif"
                                          style="font-size: 100%;"
                                    >
                                        <i class="fa fa-pause"></i>
                                        <strong>
                                            Đã tạm dừng
                                        </strong>
                                    </span>
                                </td>
                                <td>{{ $service->created_at }}</td>
                                <td>{{ $service->note }}</td>
                                <td>{{ $service->updated_at }}</td>
                                <td>
                                    <a href="javascript:;" class="view-service-status-pause-{{ $service->code }} btn btn-success @if($service->status == \App\Models\Service::STATUS_ACTIVE) hidden @endif"
                                       id=""
                                       onclick="updateServiceStatus(this, '{{ $service->code }}', 'Active')"
                                    >
                                        Kích hoạt
                                    </a>
                                    <a href="javascript:;" class="view-service-status-active-{{ $service->code }} btn btn-warning @if($service->status == \App\Models\Service::STATUS_PAUSE) hidden @endif"
                                       onclick="updateServiceStatus(this, '{{ $service->code }}', 'Pause')"
                                    >
                                        Tạm dừng
                                    </a>
                                </td>
                            </tr>
                            @if (isset($dataLogService[$service->code]))
                                <tr id="detail-service-{{ $service->code }}" class="collapse">
                                    <!-- header -->
                                    <td colspan="1"></td>
                                    <td colspan="9">
                                        <div class="row" style="padding-bottom: 5px;">
                                            <div class="col-sm-2 text-center">
                                                <strong>STT</strong>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <strong>Bài post</strong>
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <strong>Số like trong ngày</strong>
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <strong>Thời gian tạo</strong>
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <strong>Thời gian cập nhật</strong>
                                            </div>
                                        </div>
                                        @foreach($dataLogService[$service->code] as $key => $dataPost)
                                            <div class="row" style="padding-bottom: 10px;">
                                                <div class="col-sm-2 text-center">
                                                    {{ $loop->iteration }}
                                                </div>
                                                <div class="col-sm-4 text-center">
                                                    <a href="{{ $dataPost['link_post'] }}" target="_blank" style="text-decoration: underline;">{{ $dataPost['id'] }}</a>
                                                </div>
                                                <div class="col-sm-2 text-center">
                                                    <span class="label label-info" style="font-size: 100%;">
                                                        <i class="fa fa-thumbs-o-up"></i> <strong>{{ count($dataPost['uid_liker']) }}</strong>
                                                    </span>
                                                </div>
                                                <div class="col-sm-2 text-center">
                                                    <p>{{date('Y/m/d H:i:s', strtotime($dataPost['post_time']))}}</p>
                                                </div>
                                                <div class="col-sm-2 text-center">
                                                    <p>{{date('Y/m/d H:i:s', strtotime($dataPost['updated_time']))}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td colspan="1"></td>
                                    <!-- header -->
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pageScripts')
<script>

    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: new Date(),
            dayNames: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            monthNames: [
                'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9',
                'Tháng 10', 'Tháng 11', 'Tháng 12'
            ]
        })
        .change(changeDatePicker)
        .on('changeDate', changeDatePicker);
    });

    function changeDatePicker() {
        var dateValue = $('#datepicker').datepicker('getDate');
        dateValue = $.datepicker.formatDate("yy-mm-dd", dateValue);
        window.location.href = '{{ route('website.service.index') }}?date=' + dateValue;
    }

    function updateServiceStatus(element, serviceCode, status) {
        var btn = $(element);
        $.ajax({
            type: "POST",
            url: '{{ route('website.service.apiUpdateStatus') }}',
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
                    if (response.data.status == '{{ \App\Models\Service::STATUS_PAUSE }}') {
                        $('.view-service-status-active-' + response.data.code).addClass('hidden');
                        $('.view-service-status-pause-' + response.data.code).removeClass('hidden');
                    } else {
                        $('.view-service-status-pause-' + response.data.code).addClass('hidden');
                        $('.view-service-status-active-' + response.data.code).removeClass('hidden');
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