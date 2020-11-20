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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mã giao dịch</th>
                                <th>UID/PageID</th>
                                <th>Dịch vụ</th>
                                <th>Trạng thái</th>
                                <th>Ngày mua dịch vụ</th>
                                <th>Ngày kết thúc dịch vụ</th>
                                <th>Ngày được cộng thêm</th>
                                <th>Thời gian cập nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $key => $service)
                            <tr data-toggle="collapse" data-target="#detail-service-{{ $service->code }}">
                                <th scope="row">{{ ($key + ($services->currentPage() - 1) * $services->perPage() + 1) }}</th>
                                <td>
                                    <a href="javascript:;">
                                        <strong>
                                            {{ $service->code }}
                                        </strong>
                                    </a>
                                </td>
                                <td>
                                    <a href="https://www.facebook.com/{{ $service->fanpage_id }}" target="_blank" style="text-decoration: underline;">
                                        {{ $service->fanpage_id }}
                                    </a>
                                </td>
                                <td>
                                    @if($service->time_used == 1)
                                        Ngày
                                    @else
                                        Tháng
                                    @endif
                                </td>
                                <td>
                                    @if($service->time_used == 2 && $service->day_deff == 0)
                                        <span class="label label-success" style="font-size: 100%;">
                                            <i class="fa fa-thumbs-o-up"></i>
                                            <strong>
                                                Đã hoàn thành
                                            </strong>
                                        </span>
                                    @else
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
                                    @endif
                                </td>
                                <td>{{date('Y-m-d', strtotime($service->created_at)) }}</td>
                                <td>
                                    @if($service->time_used == 2)
                                        <?php $day_deff = 2 + $service->day_add; ?>
                                        {{date('Y-m-d', strtotime($service->created_at .' + '.$day_deff.' days'))}}
                                    @endif
                                </td>
                                <td>
                                    @if($service->time_used == 2)
                                        {{isset($service->day_add) ? $service->day_add : 0 }} ngày
                                    @endif
                                </td>
                                <td>{{ $service->updated_at }}</td>
                            </tr>
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