@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách khuyến mãi</h2>
                    <div class="clearfix"></div>
                </div>
                <a href="{{route('admin.fee.form')}}" class="btn btn-primary">Thêm mới khuyến mãi</a>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Thưởng chiết khấu (%)</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input  class="form-control" type="number" id="bonus" name="bonus" value="{{!empty($feeItem) ? $feeItem['bonus'] : 0}}">
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Khoảng tiền</th>
                            <th>Thưởng</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feeList as $key => $fee)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ number_format($fee->money) }} đ</td>
                                <td>{{ $fee->bonus }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{route('admin.fee.update', ['feeId' =>$fee->_id])}}">Cập nhật</a>
                                    <a class="btn btn-danger" href="{{route('admin.fee.delete', ['feeId' =>$fee->_id])}}">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $feeList->links() }}
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
