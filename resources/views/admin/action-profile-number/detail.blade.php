@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Action List') }}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <form action="{{route('admin.action-profile-number.detail', ['actionProfileId' => $actionProfileId, 'actionProfileNumberId' => $actionProfileNumberId])}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="container">
                            @foreach($actionListArr as $key => $value)
                                <div class="form-inline"  style="margin-bottom: 20px">
                                    <label class="form-check-label" for="check1" style="width: 330px">
                                        <input disabled="" type="checkbox" class="form-check-input" {{ in_array($value['key'], $actionList) ? 'checked' : ''}} name="action[]" value="{{$value['key']}}"> {{$value['value']}}
                                    </label>
                                    <label class="form-check-label" for="check1" style="width: 430px">
                                    @if($value['key'] < 9 || $value['key'] == '16' || $value['key'] == '17')<input disabled="" type="number" name="setting[{{$value['key']}}][time_out]" value="{{isset($dataSetting[$value['key']]['time_out']) ? $dataSetting[$value['key']]['time_out'] : $defautValue[$value['key']]}}" class="form-control" id="pwd">@if($value['key'] == 7 || $value['key'] == 8) {{ __('messages.Share 1 post/profile daily') }} @endif @endif
                                    </label>
                                    <label class="re-run">re-run : <input type="number" disabled="" value="{{isset($dataSetting[$value['key']]['re_run']) ? $dataSetting[$value['key']]['re_run'] : 60}}" name="setting[{{$value['key']}}][re_run]" class="form-control" id="email" ></label>
                                </div> 
                                @if($value['key'] == 6 || $value['key'] == 7 || $value['key'] == 8)
                                    <div class="form-inline" style="margin: 20px">
                                        <label class="form-check-label" for="check1" style="width: 310px;">
                                            <input type="checkbox" disabled="" class="form-check-input" name="setting[{{$value['key']}}][check_friend]" {{isset($dataSetting[$value['key']]['check_friend']) && $dataSetting[$value['key']]['check_friend'] == 1 ? 'checked' : ''}} value="{{$value['key']}}"> @if($value['key'] == 6) {{ __('messages.Perform join group when available') }} @else {{ __('messages.Perform share when available') }} @endif
                                        </label>
                                        <label class="form-check-label" for="check1">
                                            <input type="number" disabled="" class="form-control" value="{{isset($dataSetting[$value['key']]['friend']) ? $dataSetting[$value['key']]['friend'] : $defautValue[$value['key']]}}" name="setting[{{$value['key']}}][friend]">
                                        </label>
                                    </div>
                                    <div class="form-inline" style="margin: 20px"> 
                                        <label class="form-check-label" for="check1" style="width: 310px;">
                                            <input type="checkbox" disabled="" class="form-check-input" name="setting[{{$value['key']}}][actions]" value="{{$value['key']}}" {{isset($dataSetting[$value['key']]['actions']) && $dataSetting[$value['key']]['actions'] == 1 ? 'checked' : ''}}> @if($value['key'] == 6) {{ __('messages.Perform join group after making') }} @else {{ __('messages.Perform share after') }} @endif
                                        </label>
                                         <label class="form-check-label" for="check1">
                                            <input type="number" disabled="" class="form-control" name="setting[{{$value['key']}}][actions]" value="{{isset($dataSetting[$value['key']]['actions']) ? $dataSetting[$value['key']]['actions'] : ''}}">
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

