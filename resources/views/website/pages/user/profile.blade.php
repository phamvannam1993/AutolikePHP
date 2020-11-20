@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Profile <small>Thiết lập thông tin cá nhân</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="">
                    <br />
                    <form id="update-form" data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Họ và tên<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="fullname" required="required" class="form-control col-md-7 col-xs-12" value="{{ $requester->fullname }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Số điện thoại<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="" class="form-control col-md-7 col-xs-12" value="{{ $requester->username }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tên ngân hàng<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="bank_name" class="form-control col-md-7 col-xs-12" value="{{ $requester->bank_name }}" placeholder="Ví dụ: Vietcombank">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tên chủ tài khoản<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="bank_account_name" class="form-control col-md-7 col-xs-12" value="{{ $requester->bank_account_name }}" placeholder="Ví dụ: NGUYEN VAN NAM">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Số tài khoản<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="bank_account_number" class="form-control col-md-7 col-xs-12" value="{{ $requester->bank_account_number }}" placeholder="Ví dụ: 123456789">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mã invite<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="invite_code" class="form-control col-md-7 col-xs-12" value="{{ $requester->invite_code }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Link mời<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="invite_code" class="form-control col-md-7 col-xs-12 {{$requester->invite_code ? '' : 'hidden'}}" value="{{ route('admin.user.register') }}?referrer_code={{ $requester->invite_code }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Người giới thiệu<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="invite_code" class="form-control col-md-7 col-xs-12" value="{{ (!empty($userReferDetail)) ? $userReferDetail->fullname : '' }}" disabled>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a class="btn btn-info" href="{{route('user.changePassword')}}">Cập nhật mật khẩu</a>
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
    $("#update-form").bind('submit', function (event) {
        var btn = $("#update-form").find('button[type="submit"]');
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '{{ route('website.user.updateProfile') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $( "#update-form" ).serialize(),
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