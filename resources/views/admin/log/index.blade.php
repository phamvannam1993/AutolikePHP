@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách log</h2>
                    <div class="clearfix"></div>
                </div>
                <form method="get" action="">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="text" placeholder="service_code" name="service_code" class="form-control" value="{{$service_code}}">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="text" placeholder="fbid" name="fbid" class="form-control" value="{{$fbid}}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Tìm kiếm">
                        </div>
                    </div>
                </form>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>uid</th>
                                <th>service_code</th>
                                <th>fbid</th>
                                <th>action</th>
                                <th>DateTime</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($logList as $key => $log)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ $log['uid'] }}</td>
                                <td>{{ $log['service_code'] }}</td>
                                <td>{{ $log['fbid'] }}</td>
                                <td>{{ $log['action'] }}</td>
                                <td>{{ $log['created_at'] }}</td>
                                <td>{{ $log['comment'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $logList->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('pageScripts')
    <script>
        $('#bonus').change(function () {
            var bonus = $(this).val()
            updateServiceStatus(bonus)
        })
        function updateServiceStatus(bonus) {
            $.ajax({
                type: "POST",
                url: '{{ route('admin.fee.updateFee') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    bonus: bonus
                },
                success: function(response) {
                    toastr.success('Cập nhật thành công');
                }
            });
        }
    </script>
@endpush
