@extends('website.layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Import <small>Nhập dữ liệu cho API - MongoDB - Redis</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="import" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group row">
                        <label class="control-label col-md-2" for="first-name">Lựa chọn loại dữ liệu<span class="required">*</span>
                        </label>
                        <div class="col-md-10">
                            <select class="form-control" name="type_data">
                                <option value="facebook_bot">BOT chạy like Facebook</option>
                                <option value="facebook_id">Facebook ID</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-2" for="first-name">Dữ liệu<span class="required">*</span>
                        </label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="data" rows="5"
placeholder="Mẫu data BOT Facebook Likes: uid|password|cookie|token - Mỗi dòng là 1 data BOT
Mẫu data Facebook ID: uid - Mỗi dòng là 1 ID Facebook.
"></textarea>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Import</button>
                        </div>
                    </div>
                    <p>Hướng dẫn phân loại:</p>
                    <p>Facebook ID: Danh sách tất cả ID facebook sử dụng cho việc kết bạn, nuôi BOT</p>
                    <p>Bot data: Data BOT phục vụ Like, bao gồm ID, pass, cookie, <token></token></p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('pageScripts')
<script>
    $("#import").bind('submit', function (event) {
        var btn = $("#import").find('button[type="submit"]');
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '{{ route('website.import.apiImportData') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $("#import").serialize(),
                beforeSend: function() {
                btn.prop('disabled', true);
                btn.prepend('<i class="fa fa-spinner fa-spin"></i> ');
            },
            success: function(response) {
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
                if (response.success == 1) {
                    $('textarea[name="data"]').val('');
                    toastr.success(response.message);
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