@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Group Profile Detail</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>{{__('messages.Index')}}</th>
                                <th>{{__('messages.Group Uid')}}</th>
                                <th>{{__('messages.Group Name')}}</th>
                                <th>{{__('messages.Handle')}}</th>
                            </tr>
                            @foreach($groupUidList as $key => $groupUid)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $groupUid->uid }}</td>
                                    <td>{{ $name }}</td>
                                    <td><a href="{{route('admin.group.delete', ['groupId' =>$groupId, 'groupUid' => $groupUid['_id']])}}" class="btn btn-danger">{{__('messages.Delete')}}</a></td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $groupUidList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection