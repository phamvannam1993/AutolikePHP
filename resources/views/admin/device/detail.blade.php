@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Device Detail</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="container">
                        <ul class="nav nav-tabs">
                            <li class="{{$tab == 'general' ? 'active' : 'tab' }}" ><a href="{{route('admin.device.detail', ['deviceId' => $detailDevice['_id'], 'tab' => 'general'])}}">{{__('messages.General')}}</a></li>
                            <li class="{{$tab == 'clone-store' ? 'active' : 'tab' }}" data-id="1" id="tab1"><a  href="{{route('admin.device.detail', ['deviceId' => $detailDevice['_id'], 'tab' => 'clone-store'])}}">{{__('messages.Clones')}}</a></li>
                            <li class="{{$tab == 'active-log' ? 'active' : 'tab' }}" data-id="2" id="tab2"><a href="{{route('admin.device.detail', ['deviceId' => $detailDevice['_id'], 'tab' => 'active-log'])}}">{{__('messages.Activities Log')}}</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="General" class="tab-pane fade {{$tab == 'general' ? 'in active' : '' }}">
                                <div class="row" style="padding-top: 30px;">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('messages.Device Name')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{$detailDevice['name']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('messages.Phone Number')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{$detailDevice['phone_number']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('messages.Clone Name')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{$detailDevice['clone_name']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('messages.Group Profile')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{isset($groupProfile[$detailDevice['group_profile']]) ? $groupProfile[$detailDevice['group_profile']] : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('messages.Action profile')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{isset($actionProfile[$detailDevice['action_profile']]) ? $actionProfile[$detailDevice['action_profile']] : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('messages.Page')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <p>{{isset($detailDevice['page']) ? $detailDevice['page'] : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if($detailDevice['device'])
                                    @foreach($detailDevice['device'] as $key => $value)
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">{{$key}}</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <p>{{$value}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="tab-pane fade {{$tab == 'clone-store' ? 'in active' : '' }}">
                                <div class="x_content">
                                    <table id="datatable-checkbox" class="table table-bordered">
                                        <tr>
                                            <th>{{__('messages.Index')}}</th>
                                            <th>UID</th>
                                            <th>{{__('messages.Device Name')}}</th>
                                            <th>{{__('messages.Firstname')}}</th>
                                            <th>{{__('messages.Lastname')}}</th>
                                            <th>{{__('messages.birthday')}}</th>
                                            <th>{{__('messages.sex')}}</th>
                                            <th>{{__('messages.action')}}</th>
                                            <th>{{__('messages.Cycle')}}</th>
                                            <th style="background: #9da74e;color: #221d20">Fr</th>
                                            <th style="background: #e1ddb7;color: #221d20">Gr</th>
                                            <th>{{__('messages.Created Date')}}</th>
                                            <th>{{__('messages.Store Date')}}</th>
                                            <th>{{__('messages.Last Updated Data')}}</th>
                                        </tr>
                                        @foreach($cloneFacebooks as $key => $cloneFacebook)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td><a style="color: blue;" href="https://www.facebook.com/{{$cloneFacebook->uid}}" target="_blank">{{ $cloneFacebook->uid }}</a></td>
                                                <td>{{ isset($DeviceListArr[$cloneFacebook->device_id]) ? $DeviceListArr[$cloneFacebook->device_id] : '' }}</td>
                                                <td>{{ $cloneFacebook->firstname }}</td>
                                                <td>{{ $cloneFacebook->lastname }}</td>
                                                <td>{{ $cloneFacebook->birthday }}</td>
                                                <td>{{ $cloneFacebook->sex }}</td>
                                                <td>{{ $cloneFacebook->action }}</td>
                                                <td>{{ $cloneFacebook->cycle }}</td>
                                                <td style="background: #9da74e;color: #221d20">{{ $cloneFacebook->friend_count }}</td>
                                                <td style="background: #e1ddb7;color: #221d20">{{ $cloneFacebook->group_count }}</td>
                                                <td>{{ $cloneFacebook->created_date }}</td>
                                                <td>{{ $cloneFacebook->created_at }}</td>
                                                <td>{{ $cloneFacebook->updated_at }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    {{ $tab == 'clone-store' ? $cloneFacebooks->links() : '' }}
                                </div>
                            </div>
                            <div class="tab-pane fade {{$tab == 'active-log' ? 'in active' : '' }}">
                                <div class="x_content">
                                    <div class="x_content" style="overflow: auto;">
                                        <table id="datatable-checkbox" class="table table-bordered">
                                            <tr>
                                                <th>{{__('messages.Index')}}</th>
                                                <th>{{__('messages.Model')}}</th>
                                                <th>{{__('messages.Device Name')}}</th>
                                                <th>UID</th>
                                                <th>{{__('messages.Type')}}</th>
                                                <th style="width: 300px;">{{__('messages.Data')}}</th>
                                                <th>{{__('messages.IP')}}</th>
                                                <th>{{__('messages.Created Date')}}</th>
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
                                                    <td>{{ $name }}</td>
                                                    <td>{{ $actionFacebook->uid }}</td>
                                                    <td>{{ $actionFacebook->type }}</td>
                                                    <td>{{ $actionFacebook->action }}</td>
                                                    <td>{{ $actionFacebook->ip }}</td>
                                                    <td>{{ date('Y/m/d H:i:s', strtotime($actionFacebook->created_at)) }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        {{ $tab == 'active-log' ? $actionFacebooks->links() : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="getAtionUrl" value="{{route('action.getDevice')}}">
    <input type="hidden" id="uid" value="{{$detailDevice['_id']}}">
@endsection

