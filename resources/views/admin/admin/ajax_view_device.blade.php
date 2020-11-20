<div class="x_content">
    <table id="datatable-checkbox" class="table table-bordered">
        <tr>
            <th>STT</th>
            <th>Tên thiết bị</th>
            <th>Số điện thoại</th>
            <th>Tên clone</th>
            <th>Group Profile</th>
            <th>Action Profile</th>
            <th>page</th>
        </tr>
        @foreach($deviceList as $key => $device)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $device->name }}</td>
                <td>{{ $device->phone_number }}</td>
                <td>{{ $device->clone_name }}</td>
                <td>{{ isset($groupArr[$device->group_profile]) ? $groupArr[$device->group_profile] : '' }}</td>
                <td>{{ isset($actionArr[$device->action_profile]) ? $actionArr[$device->action_profile] : '' }}</td>
                <td>{{ $device->page }}</td>
            </tr>
        @endforeach
    </table>
    {{ $deviceList->links() }}
</div>
</div>
