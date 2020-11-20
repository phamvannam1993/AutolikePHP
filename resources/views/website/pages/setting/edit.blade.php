@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Setting <small>Thiết lập các cài đặt của hệ thống</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form id="update-setting" data-parsley-validate class="form-horizontal form-label-left">
                        @foreach($settings as $setting)
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">{{ $setting->name }} <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="{{ $setting->key }}" required="required" class="form-control col-md-7 col-xs-12" value="{{ $setting->value }}">
                            </div>
                        </div>
                        @endforeach
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pageScripts')
<script>
    $("#update-setting").bind('submit', function (event) {
        var btn = $("#update-setting").find('button[type="submit"]');
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '{{ route('website.setting.update') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $( "#update-setting" ).serialize(),
            beforeSend: function() {
                btn.prop('disabled', true);
                btn.prepend('<i class="fa fa-spinner fa-spin"></i> ');
            },
            success: function(response) {
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
                if (response.success == 1) {
                    toastr.success(response.message);
                    setTimeout(function(){ location.reload(); }, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            complete: function(){
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
            }
        });
    });
</script>
@endpush