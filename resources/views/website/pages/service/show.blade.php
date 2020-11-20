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
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã bài post</th>
                            <th>Sớ lượng likes</th>
                            <th>Nội dung</th>
                            <th>Thời gian tạo</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $key => $post)
                            <tr>
                                <td>
                                    <a href="javascript:;">
                                        <strong>
                                            {{ $key }}
                                        </strong>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:;">
                                        <strong>
                                            {{ $post['uid'] }}
                                        </strong>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:;">
                                        <strong>
                                            {{ $post['number_likes'] }}
                                        </strong>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:;">
                                        <strong>
                                            {{ $post['post_detail'] }}
                                        </strong>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:;">
                                        <strong>
                                            {{ $post['created_at'] }}
                                        </strong>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection