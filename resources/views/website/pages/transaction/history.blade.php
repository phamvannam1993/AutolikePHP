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
                                <td><span class="label label-success" style="font-size: 100%;">{{ number_format($transaction->value) }}</span></td>
                                <td><span class="label label-warning" style="font-size: 100%;">{{ number_format($transaction->bonus) }}</span></td>
                                <td>
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
                                <td>{{ $transaction->created_at }}</td>
                                <td>{{ $transaction->updated_at }}</td>
                                <td>
                                    <a href="{{ route('website.transaction.show', ['code' => $transaction->code]) }}" class="btn btn-success" target="_blank">Chi tiết</a>
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