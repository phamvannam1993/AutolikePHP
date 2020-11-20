<div class="x_content">
    <div class="x_content" style="overflow: auto;">
        <table id="datatable-checkbox" class="table table-bordered">
            <tr>
                <th>{{ __('messages.Index') }}</th>
                <th>{{ __('messages.UID') }}</th>
                <th>{{ __('messages.action') }}</th>
                <th>{{ __('messages.device') }}</th>
                <th>{{ __('messages.package') }}</th>
                <th>{{ __('messages.Action Name') }}</th>
                <th>{{ __('messages.Content') }}</th>
            </tr>
            @foreach($actionFacebooks as $key => $actionFacebook)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $actionFacebook->uid }}</td>
                    <td>{{ $actionFacebook->action }}</td>
                    <td>{{ json_encode($actionFacebook->device) }}</td>
                    <td>{{ $actionFacebook->package }}</td>
                    <td>{{ $actionFacebook->action_name }}</td>
                    <td>{{ $actionFacebook->content }}</td>
                </tr>
            @endforeach
        </table>
        {{ $actionFacebooks->links() }}
    </div>
</div>