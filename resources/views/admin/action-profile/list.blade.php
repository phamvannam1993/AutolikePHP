@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Action Profile') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>{{ __('messages.Index') }}</th>
                                <th>{{ __('messages.Action Profile') }} ID</th>
                                <th>{{ __('messages.Name') }}</th>
                                <th>{{ __('messages.Created Date') }} </th>
                                <th>{{ __('messages.Handle') }}</th>
                            </tr>
                            @foreach($actionProfileList as $key => $actionProfile)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $actionProfile->_id }}</td>
                                    <td>{{ $actionProfile->name }}</td>
                                    <td>{{ $actionProfile->created_at }}</td>
                                    <td>
                                    	<a class="btn btn-info" href="{{route('admin.action-profile.detail', ['actionProfileId' => $actionProfile->_id])}}">{{ __('messages.View Detail') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $actionProfileList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection