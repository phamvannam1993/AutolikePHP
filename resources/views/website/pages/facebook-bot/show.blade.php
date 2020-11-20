@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách event của UID: <strong>{{ $token->uid }} - {{ $token->status }}</strong></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <form method="get" action="{{ route('website.fb-bot.showRedirect') }}">
                                {{ csrf_field() }}
                                <input type="text" class="form-control" name="uid" placeholder="Nhập mã UID và gõ enter">
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Uid</th>
                            <th>Service Code</th>
                            <th>Fanpage</th>
                            <th>Bài post</th>
                            <th>Thời gian</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logsEvent as $key => $event)
                            <tr>
                                <td>{{ ($key + 1) }}</td>
                                <td>{{ $event->uid }}</td>
                                <td>{{ $event->service_code }}</td>
                                <td>{{ $event->fbid }}</td>
                                <td>{{ $event->post_id }}</td>
                                <td>{{ $event->action_time }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $logsEvent->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection