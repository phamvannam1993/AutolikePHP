@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Friends') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <a href="{{route('admin.friend.form')}}" class="btn btn-primary">{{ __('messages.Add New Friend') }}</a>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>{{ __('messages.Index') }}</th>
                                <th>{{ __('messages.Friend') }} ID</th>
                                <th>{{ __('messages.Name') }}</th>
                                <th>{{ __('messages.Created Date') }} </th>
                                <th>{{ __('messages.Handle') }}</th>
                            </tr>
                            @foreach($friendList as $key => $friend)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $friend->_id }}</td>
                                    <td>{{ $friend->name }}</td>
                                    <td>{{ $friend->created_at }}</td>
                                    <td>
                                    	<a class="btn btn-info" href="{{route('admin.friend.detail', ['friendId' =>$friend->_id])}}">{{ __('messages.View Detail') }}</a>
                                        <a href="{{route('admin.friend.delete', ['friendId' =>$friend->_id])}}" class="btn btn-danger">{{ __('messages.Delete') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $friendList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection