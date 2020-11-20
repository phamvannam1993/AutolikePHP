@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 col-xs-offset-3">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Chi tiết giao dịch</h2>
                    <div class="clearfix"></div>
                </div>
                @if (!$transaction)
                    Không tìm thấy giao dịch
                @else
                <div class="x_content">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-right col-xs-3"><strong>Mã giao dịch</strong></td>
                                <td>
                                    <p style="font-size: large;">{{ $transaction->code }}</p>
                                    <small>Cung cấp mã hóa đơn này nếu bạn cần hỗ trợ về đơn hàng.</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-3"><strong>Số tiền</strong></td>
                                <td>
                                    <p style="font-size: large;">{{ number_format($transaction->value) }} đ</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-3"><strong>Thời gian tạo đơn</strong></td>
                                <td>
                                    <p>{{ $transaction->created_at }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-3"><strong>Thời gian cập nhật</strong></td>
                                <td>
                                    <p>{{ $transaction->updated_at }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-3"><strong>Trạng thái</strong></td>
                                <td class="transaction-status">
                                    @if($transaction->status == \App\Models\Transaction::STATUS_PENDING)
                                        <span class="label label-warning" style="font-size: 100%;">
                                        <i class="fa fa-spinner fa-spin"></i>
                                        <strong>
                                            Đang chờ thanh toán.
                                        </strong>
                                    </span>
                                    @elseif ($transaction->status == \App\Models\Transaction::STATUS_EXPIRED)
                                        <span class="label label-danger" style="font-size: 100%;"> Đã bị hủy </span>
                                    @elseif ($transaction->status == \App\Models\Transaction::STATUS_COMPLETED)
                                        <span class="label label-success" style="font-size: 100%;"> Thành công </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-3"><strong>Hướng dẫn thanh toán</strong></td>
                                <td>
                                    <p>Vui lòng chuyển khoản cho tài khoản <strong>Vietcombank </strong> sau:</p>
                                    <p>Ngân hàng: <strong>Ngân hàng ngoại thương Việt Nam</strong></p>
                                    <p>Số tài khoản: <strong>0011004307015</strong></p>
                                    <p>Tên chủ tài khoản: <strong>VU NGOC CUONG</strong></p>
                                    <p>Số tiền: <strong>{{ number_format($transaction->value) }} đ</strong></p>
                                    <p>Nội dung chuyển khoản (memo): <strong>{{ $transaction->code }}</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-3"></td>
                                <td>
                                    <em>
                                        <strong style="color: #3a87ad;">
                                            Chú ý: Giao dịch cần thanh toán trong vòng 15 phút trước khi bị hủy.
                                            Bạn hãy chuyển chính xác số tiền (kể cả số lẻ) và nội dung chuyển tiền như hướng dẫn (phần in đậm).
                                        </strong>
                                    </em>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

<script>
    //get subscribe channel for user
    @php
        $loggedUser = session('dataLogin');
        $loggedUser = \Illuminate\Support\Facades\Auth::user();
        $personalChannel = md5( $loggedUser['userId']. '-' . $loggedUser['created_at']);
    @endphp

    window.onload = function(){
        var personalChannel = '{{ $personalChannel }}';
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var pusher = new Pusher('7e4eaeb1b8ee811d33f2', {
            cluster: 'ap1',
            forceTLS: true
        });
        var channel = pusher.subscribe(personalChannel);
        channel.bind('update-transaction-status', function(data) {
            var receiveData = JSON.parse(JSON.stringify(data));
            if (receiveData.success == 1){
                $('.transaction-status').html('');
                $('.transaction-status').html('<span class="label label-success transaction-status-completed" style="font-size: 100%;"> Thành công </span>');
                toastr.success(receiveData.message);
            }
        });
    }

</script>