<div class="x_content">
    <table id="datatable-checkbox" class="table table-bordered">
        <tr>
            <th>{{__('messages.Index')}}</th>
            <th></th>
            <th>{{__('messages.UID')}}</th>
            <th>{{__('messages.Device Name')}}</th>
            <th>{{__('messages.Firstname')}}</th>
            <th>{{__('messages.Lastname')}}</th>
            <th>{{__('messages.birthday')}}</th>
            <th>{{__('messages.sex')}}</th>
            <th>{{__('messages.action')}}</th>
            <th>{{__('messages.Cycle')}}</th>
            <th>{{__('messages.Created Date')}}</th>
            <th>{{__('messages.Store Date')}}</th>
            <th>{{__('messages.Last Updated Data')}}</th>
            <th>{{__('messages.Detail')}}</th>
        </tr>
        @foreach($cloneFacebooks as $key => $cloneFacebook)
            <tr>
                <td>{{ $key+1 }}</td>
                <td><input type="checkbox" name="uids[]" value="{{ $cloneFacebook->uid }}"></td>
                <td><a style="color: blue;" href="https://www.facebook.com/{{$cloneFacebook->uid}}" target="_blank">{{ $cloneFacebook->uid }}</a></td>
                <td>{{ isset($DeviceListArr[$cloneFacebook->device_id]) ? $DeviceListArr[$cloneFacebook->device_id] : '' }}</td>
                <td>{{ $cloneFacebook->firstname }}</td>
                <td>{{ $cloneFacebook->lastname }}</td>
                <td>{{ $cloneFacebook->birthday }}</td>
                <td>{{ $cloneFacebook->sex }}</td>
                <td>{{ $cloneFacebook->action }}</td>
                <td>{{ $cloneFacebook->cycle }}</td>
                <td>{{ $cloneFacebook->created_date }}</td>
                <td>{{ $cloneFacebook->created_at }}</td>
                <td>{{ $cloneFacebook->updated_at }}</td>
                <td>
                    <a class="btn btn-info" href="{{route('admin.action-facebook.ActionFacebook', ['uid' =>$cloneFacebook->uid])}}">{{__('messages.Detail')}}</a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $cloneFacebooks->links() }}
</div>