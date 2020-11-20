<div class="x_content">
    <div class="x_content" style="overflow: auto;">
        <table id="datatable-checkbox" class="table table-bordered">
            <tr>
                <th>{{__('messages.Index')}}</th>
                <th>{{__('messages.UID')}}</th>
                <th>{{__('messages.Type')}}</th>
                <th>{{__('messages.Data')}}</th>
                <th>{{__('messages.Device Name')}}</th>
                <th>{{__('messages.Model')}}</th>
                <th>{{__('messages.Created Date')}}</th>
            </tr>
            @foreach($actionFacebooks as $key => $actionFacebook)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $actionFacebook->uid }}</td>
                    <td>{{ $actionFacebook->type }}</td>
                    <td>{{ $actionFacebook->action }}</td>
                    <td>{{ $name }}</td>
                    @if(!empty($actionFacebook->device))
                        <?php $deviceArr = json_decode($actionFacebook->device); ?>
                        <td>{{ isset($deviceArr->model) ? $deviceArr->model :'' }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ date('Y/m/d H:i:s', strtotime($actionFacebook->created_at)) }}</td>
                </tr>
            @endforeach
        </table>
        {{ $actionFacebooks->links() }}
    </div>
</div>