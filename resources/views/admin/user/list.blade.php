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
                    <a href="{{route('admin.user.add')}}" class="btn btn-primary">Thêm mới người dùng</a>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>STT</th>
                                <th>Full Nam</th>
                                <th>Phone Number</th>
                                <th>Token</th>
                                <th>Action Profile</th>
                                <th>Clone count</th>
                                <th>User nox-vm</th>
                                <th>Debug mode</th>
                                <th>VNP Loading</th>
                                <th>date created</th>
                                <th>date update</th>
                                <th>Xử lý</th>
                            </tr>
                            @foreach($userList as $key => $user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->token }}</td>
                                    <td>{{ isset($actionArr[$user->action_profile]) ? $actionArr[$user->action_profile] : '' }}</td>
                                    <td>{{ $user->clone_count }}</td>
                                    <td><input disabled="" type="checkbox" name="" {{isset($user['user_nox']) && $user['user_nox'] == '1'  ? 'checked' : ''}}></td>
                                     <td>{{$user['debug_mode']}}</td>
                                    <td>{{ $user->vpn_loading }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                    	<a class="btn btn-info" href="{{route('admin.user.update', ['userId' =>$user->_id])}}">Update</a>
                                        <a class="btn btn-info" href="{{route('admin.user.detail', ['userId' =>$user->_id])}}">Detail</a>
                                    	<a class="btn btn-danger" href="{{route('admin.user.delete', ['userId' =>$user->_id])}}">Delete</a>
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