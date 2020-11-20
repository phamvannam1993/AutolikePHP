<div class="x_content">
    <div class="x_content" style="overflow: auto;">
        <table id="datatable-checkbox" class="table table-bordered">
            <tr>
                <th>{{ __('messages.Index') }}</th>
                <th>{{ __('messages.UID') }}</th>
                <th>{{ __('messages.Image') }}</th>
                <th>{{ __('messages.Upload') }}</th>
            </tr>
            @foreach($actionFacebooks as $key => $actionFacebook)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $actionFacebook->uid }}</td>
                    <td><img src="{{ $actionFacebook->link }}" width="100"></td>
                    <td>{{ $actionFacebook->upload }}</td>
                </tr>
            @endforeach
        </table>
        {{ $actionFacebooks->links() }}
    </div>
</div>