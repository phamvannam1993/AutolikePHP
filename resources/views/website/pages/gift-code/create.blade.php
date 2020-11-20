@extends('website.layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Gift code <small>Tạo gift code cho hệ thống</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="">
                    <br />
                    <form id="create-gift-code" data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Số lượng code <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="number" required="required" class="form-control col-md-7 col-xs-12" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Giá trị (đ)<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="value" required="required" class="form-control col-md-7 col-xs-12 number" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Danh sách code sinh<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea id="list_gift_code_generated" class="form-control col-md-7 col-xs-12" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Tạo mới</button>
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
    $("#create-gift-code").bind('submit', function (event) {
        var btn = $("#create-gift-code").find('button[type="submit"]');
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '{{ route('website.gift-code.apiCreate') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $("#create-gift-code" ).serialize(),
            beforeSend: function() {
                btn.prop('disabled', true);
                btn.prepend('<i class="fa fa-spinner fa-spin"></i> ');
            },
            success: function(response) {
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
                if (response.success == 1) {
                    $('#list_gift_code_generated').html(response.data);
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


    $('body').on('keydown', 'input.number', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.number', function () {
        var value = $(this).val();
        $(this).val(formatDecimal(value));
    });

    function formatDecimal(value) {
        if(value == '') {
            return '';
        }
        value = value.replace(/\,/g, '');
        while (value.length > 1 && value[0] == '0' && value[1] != '.') value = value.substring(1);
        if (value != '' && value != '0') {
            if (value[value.length - 1] != '.') {
                if (value.indexOf('.00') > 0) value = value.substring(0, value.length - 3);
                value = addCommas(value);
                return value;
            }
            else return value;
        }
        else return 0;
    }

    function checkKeyCodeNumber(e){
        return !((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 ||  e.keyCode == 35 || e.keyCode == 36 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46);
    }

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

</script>
@endpush