@extends('website.layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Danh sách giao dịch</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã giao dịch</th>
                        <th>Người tạo</th>
                        <th>Giá trị</th>
                        <th>Bonus</th>
                        <th>Trạng thái</th>
                        <th>Thời gian</th>
                        <th>Thời gian cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $key => $transaction)
                        <tr>
                            <th scope="row">{{ ($key + ($transactions->currentPage() - 1) * $transactions->perPage() + 1) }}</th>
                            <td>
                                <a href="{{ route('website.transaction.show', ['code' => $transaction->code]) }}" target="_blank" style="text-decoration: underline;">
                                    <strong>
                                        {{ $transaction->code }}
                                    </strong>
                                </a>
                            </td>
                            <td>
                               {{ isset($userArr[$transaction->user_id]) ? $userArr[$transaction->user_id] : '' }}
                            </td>
                            <td>
                                <span class="label label-success" style="font-size: 100%;">{{ number_format($transaction->value) }}</span>
                            </td>
                            <td>
                                <span class="label label-warning" style="font-size: 100%;">{{ number_format($transaction->bonus) }}</span>
                            </td>
                            <td>
                                <span class="view-status-completed-{{ $transaction->code }} label label-success @if($transaction->status !== \App\Models\Transaction::STATUS_COMPLETED) hidden @endif"
                                style="font-size: 100%;">
                                    <strong>
                                        Thành công
                                    </strong>
                                </span>
                                <span class="view-status-pending-{{ $transaction->code }} label label-warning @if($transaction->status !== \App\Models\Transaction::STATUS_PENDING) hidden @endif"
                                      style="font-size: 100%;">
                                     <i class="fa fa-spinner fa-spin"></i>
                                    <strong>
                                        Đang chờ thanh toán.
                                    </strong>
                                </span>
                                <span class="view-status-expired-{{ $transaction->code }} label label-danger @if($transaction->status !== \App\Models\Transaction::STATUS_EXPIRED) hidden @endif"
                                      style="font-size: 100%;">
                                    <strong>
                                        Đã  bị hủy
                                    </strong>
                                </span>
                            </td>
                            <td>{{ $transaction->created_at }}</td>
                            <td>{{ $transaction->updated_at }}</td>
                            <td>
                                <a href="javascript:;" class="view-status-pending-{{ $transaction->code }} btn btn-success @if($transaction->status !== \App\Models\Transaction::STATUS_PENDING) hidden @endif"
                                   id=""
                                   onclick="updateStatus(this, '{{ $transaction->code }}', 'Completed')"
                                >
                                    Phê duyệt
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('pageScripts')
<script>
    function updateStatus(element, code, status) {
        var btn = $(element);
        $.ajax({
            type: "POST",
            url: '{{ route('website.transaction.apiUpdateStatus') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                code: code,
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
                    if (response.data.status == '{{ \App\Models\Transaction::STATUS_COMPLETED }}') {
                        $('.view-status-pending-' + response.data.code).addClass('hidden');
                        $('.view-status-expired-' + response.data.code).addClass('hidden');
                        $('.view-status-completed-' + response.data.code).removeClass('hidden');
                    } else if (response.data.status == '{{ \App\Models\Transaction::STATUS_PENDING }}') {
                        $('.view-status-completed-' + response.data.code).addClass('hidden');
                        $('.view-status-expired-' + response.data.code).addClass('hidden');
                        $('.view-status-pending-' + response.data.code).removeClass('hidden');
                    } else if (response.data.status == '{{ \App\Models\Transaction::STATUS_EXPIRED }}') {
                        $('.view-status-completed-' + response.data.code).addClass('hidden');
                        $('.view-status-pending-' + response.data.code).addClass('hidden');
                        $('.view-status-expired-' + response.data.code).removeClass('hidden');
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