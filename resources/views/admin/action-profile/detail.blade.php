@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Action Profile List')}}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>{{ __('messages.Index')}}</th>
                                <th>{{ __('messages.Action Profile Name')}}</th>
                                <th>{{ __('messages.Action Name')}}</th>
                                <th>{{ __('messages.Action List')}}</th>
                                <th>{{ __('messages.Handle')}}</th>
                            </tr>
                            @foreach($actionProfileNumberList as $key => $actionProfileNumber)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $name }}</td>
                                    <td>{{ $actionProfileNumber->name }}</td>
                                    <?php $listAction  = ''; ?>
                                    @if(!empty($actionProfileNumber->action_list))
                                        @foreach(json_decode($actionProfileNumber->action_list) as $key=>$value)
                                            <?php $listAction = $actionListArr[$value].', '.$listAction; ?>
                                        @endforeach
                                    @endif
                                    <td>{{ $listAction }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{route('admin.action-profile-number.detail', ['actionProfileId' => $actionProfileId, 'actionProfileNumberId' => $actionProfileNumber->_id])}}">{{ __('messages.View Detail')}}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $actionProfileNumberList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection