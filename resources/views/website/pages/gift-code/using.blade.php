@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Gift code <small>Nhập mã gift code</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="{{ route('website.gift-code.apply') }}" id="update-setting" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mã gift code <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="code" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('code') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                                <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="6LeJGNwUAAAAAB7KLnuOfsYdVALHuJ9lWqgNzm53"></div>
                                @if ($errors->any())
                                    <div class="alert alert-danger" style="color:#fff;">
                                        <strong>{{ $errors->first() }}</strong>
                                    </div>
                                @endif

                                @if(session()->has('message'))
                                    <div class="alert alert-success"  style="color:#fff;">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Nhận thưởng</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection