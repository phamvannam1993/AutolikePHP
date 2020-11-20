@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Group Profile') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <a href="{{route('admin.group.form')}}" class="btn btn-primary">{{ __('messages.Add New Group Profile') }}</a>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>{{ __('messages.Index') }}</th>
                                <th>{{ __('messages.Group ID') }}</th>
                                <th>{{ __('messages.Group Name') }}</th>
                                <th>{{ __('messages.Created Date') }} </th>
                                <th>{{ __('messages.Handle') }}</th>
                            </tr>
                            @foreach($groupList as $key => $group)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $group->_id }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->created_at }}</td>
                                    <td>
                                    	<a class="btn btn-info" href="{{route('admin.group.detail', ['groupId' =>$group->_id])}}">{{ __('messages.View Detail') }}</a>
                                         <a href="{{route('admin.group.profile.delete', ['groupId' =>$group->_id])}}" class="btn btn-danger">{{ __('messages.Delete') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $groupList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection