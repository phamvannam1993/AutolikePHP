@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{__('messages.Page Detail')}}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <a href="{{route('admin.page.form')}}" class="btn btn-primary">{{__('messages.Page Edit')}}</a>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>{{__('messages.Index')}}</th>
                                <th>{{__('messages.Page Id')}}</th>
                            </tr>
                            @foreach($pageUidList as $key => $pageUid)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $pageUid->uid }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $pageUidList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection