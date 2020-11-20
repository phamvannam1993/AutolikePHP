@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Pages') }}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <a href="{{route('admin.page.form')}}" class="btn btn-primary">{{ __('messages.Add New Page') }}</a>
                    <div class="x_content">
                        <table id="datatable-checkbox" class="table table-bordered">
                            <tr>
                                <th>{{ __('messages.Index') }}</th>
                                <th>{{ __('messages.Page Id') }}</th>
                                <th>{{ __('messages.Created Date') }} </th>
                                <th>{{ __('messages.Handle') }}</th>
                            </tr>
                            @foreach($pageList as $key => $page)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $page->_id }}</td>
                                    <td>{{ $page->created_at }}</td>
                                    <td>
                                    	<a class="btn btn-info" href="{{route('admin.page.detail', ['pageId' =>$page->_id])}}">{{ __('messages.View Detail') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $pageList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection