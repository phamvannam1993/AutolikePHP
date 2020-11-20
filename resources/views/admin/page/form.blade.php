@extends('admin.base')

@section('main')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ __('messages.Add New Page') }}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <form action="{{route('admin.page.form')}}" method="post">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                    <div class="container">
	                    	@if($messageError)
			                    <div class="alert alert-danger">
			                        <strong style="font-weight: 500;">{{$messageError}}.</strong>
			                    </div>
		                    @endif
	                        <input type="hidden" name="page[id]" value="{{isset( $page['_id']) ? $page['_id'] : 0 }}">
	                        <br>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <div class="form-page">
	                                    <label class="control-label">{{ __('messages.Ids') }}</label>
	                                </div>
	                            </div>
	                            <div class="col-sm-4">
	                                <div class="form-page">
	                                    <input type="text" class="form-control" value="<?= isset($idList[0]) ? $idList[0] : ''?>" name="page[ids][]">
	                                </div>
	                            </div>
	                        </div>
							<?php for ($i = 1; $i < 10; $i++) { ?>
								<br>
								<div class="row">
									<div class="col-sm-4">
									</div>
									<div class="col-sm-4">
										<div class="form-page">
											<input type="text" class="form-control" value="<?= isset($idList[$i]) ? $idList[$i] : ''?>" name="page[ids][]">
										</div>
									</div>
								</div>
							<?php } ?>
	                        <div class="row">
	                        	<input type="submit" value="Save" class="btn btn-primary">
	                        	<a href="{{route('admin.page.list')}}" class="btn btn-info">{{ __('messages.Cancel') }}</a>
	                        </div>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

