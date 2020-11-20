@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Friend Detail') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>{{ __('messages.Index') }}</th>
                                <th>{{ __('messages.Group Friend Name') }}</th>
                                <th>{{ __('messages.Friend Name') }}</th>
                                <th>{{ __('messages.Handle') }}</th>
                            </tr>
                            @foreach($friendUidList as $key => $friendUid)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $friendUid->uid }}</td>
                                    <td>{{ $name }}</td>
                                    <td><a href="{{route('admin.friend.uid.delete', ['friendId' =>$friendId, 'friendUid' => $friendUid['_id']])}}" class="btn btn-danger">{{ __('messages.Delete') }}</a></td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $friendUidList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection