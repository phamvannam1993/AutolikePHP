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
                            <th>UID/PageID</th>
                            <th>Số likes</th>
                            <th>Số bài post</th>
                            <th>Thanh toán</th>
                            <th>Ghi chú</th>
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
                                    <span class="label label-info" style="font-size: 100%;">
                                        {{$dataService[$service->code]['number_like_per_post']}}
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-warning" style="font-size: 100%;">
                                         {{$dataService[$service->code]['number_post']}}
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-success" style="font-size: 100%;">
                                        <strong>
                                            {{ number_format($service->price) }} đ
                                        </strong>
                                    </span>
                                </td>
                                <td>
                                @if($dataService[$service->code]['status'] == 1)
                                    <span class="btn btn-primary">Hoàn tiền</span>
                                @elseif($dataService[$service->code]['status'] == 3)
                                    <span class="btn btn-danger">Dừng dịch vụ</span>
                                @else
                                    <span class="btn btn-success">Hoàn thành</span>
                                @endif
                                </td>
                                <td>
                                    <a href="javascript:;" class="btn btn-success">
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                            @if (isset($dataLogService[$service->code]))
                                <tr id="detail-service-{{ $service->code }}" class="collapse">
                                    <!-- header -->
                                    <td colspan="1"></td>
                                    <td colspan="4">
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
</script>
@endpush