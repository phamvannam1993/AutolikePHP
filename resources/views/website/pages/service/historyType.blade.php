@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách dịch vụ - {{ $type }}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã giao dịch</th>
                            <th>UID/PageID</th>
                            <th>Số lượt thành công</th>
                            <th>Tổng số lượt</th>
                            <th>Ngày bắt đầu</th>
                            <th>Thời gian Hủy/ Hoàn thành</th>
                            <th>Thao tác</th>
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
                                    {{ $service->number -  $service->number_likes}}
                                </td>
                                <td>{{ $service->number }}</td>
                                <td>
                                    {{date('Y-m-d H:i:s', strtotime($service->created_at))}}
                                </td>
                                <td>{{ $service->cancelled_at }}</td>
                                <td>
                                    @if ($service->number -  $service->number_likes < $service->number && $service->status != \App\Models\Service::STATUS_CANCEL)
                                    <span class="cancel-service-{{ $service->code }} label label-success"
                                          id=""
                                          style="font-size: 100%;"
                                          onclick="cancelService(this, '{{ $service->code }}')"
                                    >
                                        <strong>
                                            Hủy
                                        </strong>
                                    </span>
                                    @endif
                                </td>
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

    function cancelService(element, serviceCode) {
        var btn = $(element);
        $.ajax({
            type: "POST",
            url: '{{ route('website.service.apiCancel') }}',
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
                    $('.cancel-service-' + response.data.code).addClass('hidden');
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