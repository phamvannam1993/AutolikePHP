<div class="x_content">
    <div class="x_content" style="overflow: auto;">
        <table id="datatable-checkbox" class="table table-bordered">
            <tr>
                <th>STT</th>
                <th>Model</th>
                <th>DeviceName</th>
                <th>UID</th>
                <th>Type</th>
                <th  style="width: 300px;">Data</th>
                <th>IP</th>
                <th>Created Date</th>
            </tr>
            @foreach($actionFacebooks as $key => $actionFacebook)
                <tr>
                    <td>{{ $key+1 }}</td>
                    @if(!empty($actionFacebook->device))
                        <?php $deviceArr = json_decode($actionFacebook->device); ?>
                        <td>{{ isset($deviceArr->model) ? $deviceArr->model :'' }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ isset($dataDevice[$actionFacebook->device_id]) ? $dataDevice[$actionFacebook->device_id] : '' }}</td>
                    <td>{{ $actionFacebook->uid }}</td>
                    <td>{{ $actionFacebook->type }}</td>
                    <td>{{ $actionFacebook->action }}</td>
                    <td>{{ $actionFacebook->ip }}</td>
                    <td>{{ date('Y/m/d H:i:s', strtotime($actionFacebook->created_at)) }}</td>
                </tr>
            @endforeach
        </table>
        {{ $actionFacebooks->links() }}
    </div>
</div>