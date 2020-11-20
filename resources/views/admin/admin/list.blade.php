@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Danh sách người dùng</h2>

                        <div class="clearfix"></div>
                    </div>
                    <a href="{{route('admin.admin.form')}}" class="btn btn-primary">Thêm mới admin</a>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>STT</th>
                                <th>Full Nam</th>
                                <th>username</th>
                                <th>date created</th>
                                <th>date update</th>
                                <th>Xử lý</th>
                            </tr>
                            @foreach($userList as $key => $user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                    	<a class="btn btn-info" href="{{route('admin.admin.update', ['userId' =>$user->_id])}}">Update</a>
                                    	<a class="btn btn-danger" href="{{route('admin.admin.delete', ['userId' =>$user->_id])}}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $userList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection