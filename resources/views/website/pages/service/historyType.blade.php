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
                            <th>Thành viên</th>
                            <th>UID/PageID</th>
                            <th>Số lượt thành công</th>
                            <th>Tổng số lượt</th>
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
                                    {{ isset($userArr[$service->user_id]) ? $userArr[$service->user_id] : '' }}
                                </td>
                                <td>
                                    <a href="https://www.facebook.com/{{ $service->fanpage_id }}" target="_blank" style="text-decoration: underline;">
                                        {{ $service->fanpage_id }}
                                    </a>
                                </td>
                                <td>{{ $service->number -  $service->number_likes}}</td>
                                <td>{{ $service->number }}</td>
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
</script>
@endpush