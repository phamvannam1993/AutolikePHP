<div class="x_content">
    <div class="x_content" style="overflow: auto;">
        <table id="datatable-checkbox" class="table table-bordered">
            <tr>
                <th>{{ __('messages.Index') }}</th>
                <th>{{ __('messages.UID') }}</th>
                <th>{{ __('messages.Friend UID') }}</th>
                <th>{{ __('messages.Request') }}</th>
                <th>{{ __('messages.IP') }}</th>
                <th>{{ __('messages.Created Date') }}</th>
            </tr>
            @foreach($actionFacebooks as $key => $actionFacebook)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $actionFacebook->uid }}</td>
                    <td>{{ $actionFacebook->friend_uid }}</td>
                    <td>{{ $actionFacebook->joined }}</td>
                    <td>{{ $actionFacebook->ip }}</td>
                    <td>{{ date('Y-m-d H:i:s', strtotime($actionFacebook->created_at))}}</td>
                </tr>
            @endforeach
        </table>
        {{ $actionFacebooks->links() }}
    </div>
</div>