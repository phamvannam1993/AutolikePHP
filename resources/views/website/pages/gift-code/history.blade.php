@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Lịch sử sử dụng gift code</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="title_right">
                            <form method="get">
                                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search">
                                        <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã code</th>
                            <th>Thành viên</th>
                            <th>Giá trị</th>
                            <th>Thời gian sử dụng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($giftCodeUseds as $key => $giftCodeUsed)
                            <tr>
                                <th scope="row">{{ ($key + ($giftCodeUseds->currentPage() - 1) * $giftCodeUseds->perPage() + 1) }}</th>
                                <td>
                                    <a href="javascript:;">
                                        <strong>
                                            {{ $giftCodeUsed->gift_code }}
                                        </strong>
                                    </a>
                                </td>
                                <td>
                                    {{ isset($userArr[$giftCodeUsed->user_id]) ? $userArr[$giftCodeUsed->user_id] : '' }}
                                </td>
                                <td>
                                    <span class="label label-info" style="font-size: 100%;">
                                        {{ number_format($giftCodeUsed->value) }}
                                    </span>
                                </td>
                                <td>{{ $giftCodeUsed->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $giftCodeUseds->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection