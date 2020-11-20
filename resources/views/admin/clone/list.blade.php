@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Danh sách nhóm</h2>

                        <div class="clearfix"></div>
                    </div>
                    <a href="{{route('admin.group.form')}}" class="btn btn-primary">Thêm mới nhóm</a>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>STT</th>
                                <th>Group ID</th>
                                <th>Name</th>
                                <th>CreatedDate </th>
                                <th>Xử lý</th>
                            </tr>
                            @foreach($groupList as $key => $group)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $group->_id }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->created_at }}</td>
                                    <td>
                                    	<a class="btn btn-info" href="{{route('admin.group.detail', ['groupId' =>$group->_id])}}">View Detail</a>
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