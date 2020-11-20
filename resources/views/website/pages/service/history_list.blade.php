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
                            <th>Ngày</th>
                            <th>CTV/Users</th>
                            <th>Mã gói</th>
                            <th>Dịch vụ</th>
                            <th>Số tiền</th>
                            <th>Thời gian hoàn thành</th>
                            <th>Ghi chú</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataLog as $key => $log)
                            <tr data-toggle="collapse">
                                <td>{{$key + 1}}</td>
                                <td>{{$date}}</td>
                                <td>{{$dataUser[$log['service']['user_id']]}}</td>
                                <td>{{$log['service']['code']}}</td>
                                <td>
                                    {{$log['service']['type']}}
                                </td>
                                <td>
                                    {{number_format($log['service']['price'])}}
                                </td>
                                @if($log['status'] == 0)
                                    <td></td>
                                    <td><span class="btn btn-info">Đang thực hiện</span></td>
                                @else
                                    <td>{{ date('Y-m-d H:i', strtotime($log['updated_at'])) }}</td>
                                    <td>
                                        @if($log['status'] == 1)
                                            <span class="btn btn-primary">Hoàn tiền</span>
                                        @elseif($log['status'] == 3)
                                            <span class="btn btn-danger">Dừng dịch vụ</span>
                                        @else
                                            <span class="btn btn-success">Hoàn thành</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $listLog->links() }}
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
        window.location.href = '{{ route('website.service.history') }}?date=' + dateValue;
    }
</script>
@endpush