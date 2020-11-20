@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Devices</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>STT</th>
                                <th>Device Name</th>
                                <th>{{ __('messages.Model') }}</th>
                                <th>{{ __('messages.Phone Number') }}</th>
                                <th>{{ __('messages.Clone Name') }}</th>
                                <th>{{ __('messages.Clone Number') }}</th>
                                <th>{{ __('messages.Group Profile') }}</th>
                                <th>{{ __('messages.Action Profile') }}</th>
                                <th>{{ __('messages.Friend Profile') }}</th>
                                <th>{{ __('messages.Friend UID') }}</th>
                                <th>{{ __('messages.Page') }}</th>
                                <th>{{ __('messages.Time Out') }}</th>
                                <th>{{ __('messages.Reset 3G') }}</th>
                                <th>{{ __('messages.Handle') }}</th>
                            </tr>
                            @foreach($deviceList as $key => $device)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $device->name }}</td>
                                    <td>{{ $device->model }}</td>
                                    <td>{{ $device->phone_number }}</td>
                                    <td>{{ isset($arrName[$device->clone_name]) ? $arrName[$device->clone_name] : '' }}</td>
                                    <td>{{ $device->cloneNumber}}</td>
                                    <td>{{ isset($groupArr[$device->group_profile]) ? $groupArr[$device->group_profile] : '' }}</td>
                                    <td>{{ isset($actionArr[$device->action_profile]) ? $actionArr[$device->action_profile] : '' }}</td>
                                    <td>{{ isset($friendArr[$device->friend_profile]) ? $friendArr[$device->friend_profile] : '' }}</td>
                                    <td>{{ $device->friend_uid }}</td>
                                    <td>{{ $device->page }}</td>                                  
                                    <td>{{ $device->time_out }}</td>
                                    <td>{{ $device->reset_3g }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{route('admin.device.detail', ['deviceId' =>$device->_id, 'tab' => 'general'])}}">{{ __('messages.View Detail') }}</a>
                                        <a class="btn btn-danger" href="{{route('admin.device.delete', ['deviceId' =>$device->_id])}}">{{ __('messages.Delete') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $deviceList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection