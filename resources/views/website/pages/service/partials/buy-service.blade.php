<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h1>MUA DỊCH VỤ</h1>
                <div class="clearfix"></div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <!-- price element -->
                        <div class="col-md-4">
                            <div class="pricing">
                                <div class="title">
                                    <h2>Gói viplike {{ number_format($settings['viplike_like_per_day']->value) }} likes</h2>
                                    <h1>Giá chỉ {{ number_format($settings['viplike_cost_per_day']->value) }}đ / ngày</h1>
                                    {{--<span>10 bài post</span>--}}
                                </div>
                                <div class="x_content">
                                    <div class="">
                                        <div class="pricing_features">
                                            <ul class="list-unstyled text-left">
                                                <li><i class="fa fa-check text-success"></i> Bạn nhận được <strong>{{ number_format($settings['viplike_like_per_day']->value) }} likes </strong> / 1 post</li>
                                                <li><i class="fa fa-check text-success"></i> Áp dụng cho <strong> {{ number_format($settings['viplike_post_per_day']->value) }} bài post</strong> / ngày</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pricing_footer">
                                        <input type="text" required="required" name="1_fanpage_id" class="form-control" placeholder="Nhập ID fanpage hoặc trang cá nhân">
                                        <p>
                                            <button href="javascript:void(0);" class="btn btn-warning btn-block"
                                               role="button" style="margin-bottom: 0px;"
                                               type="submit"
                                               onclick="buyService(this, 1)"
                                            >
                                                Mua ngay
                                            </button>
                                        </p>
                                        <p style="padding-top: 0px;">
                                            <a href="javascript:void(0);">Xem điều khoản dịch vụ</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pricing">
                                <div class="title">
                                    <h2>Gói viplike {{ number_format($settings['viplike_like_per_day']->value) }} likes</h2>
                                    <h1>Giá chỉ {{ number_format($settings['viplike_cost_per_month']->value) }}đ / tháng</h1>
                                    {{--<span>10 bài post</span>--}}
                                </div>
                                <div class="x_content">
                                    <div class="">
                                        <div class="pricing_features">
                                            <ul class="list-unstyled text-left">
                                                <li><i class="fa fa-check text-success"></i> Bạn nhận được <strong>{{ number_format($settings['viplike_like_per_day']->value) }} likes </strong> / 1 post</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pricing_footer">
                                        <input type="text" required="required" name="2_fanpage_id" class="form-control" placeholder="Nhập ID fanpage hoặc trang cá nhân">
                                        <p>
                                            <button href="javascript:void(0);" class="btn btn-warning btn-block"
                                                    role="button" style="margin-bottom: 0px;"
                                                    type="submit"
                                                    onclick="buyService(this, 2)"
                                            >
                                                Mua ngay
                                            </button>
                                        </p>
                                        <p style="padding-top: 0px;">
                                            <a href="javascript:void(0);">Xem điều khoản dịch vụ</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pricing">
                                <div class="title">
                                    <h2>Gói SUB / Follow</h2>
                                    <h1>Giá chỉ {{$addfriend}}đ / 1 lượt</h1>
                                </div>
                                <div class="x_content">
                                    <div class="">
                                        <div class="pricing_features">
                                            <ul class="list-unstyled text-left">
                                                <li><i class="fa fa-check text-success"></i> {{$addfriend}} đ / 1 lượt AddFriend/Sub/Follow</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pricing_footer">
                                        <input type="text" required="required" name="addfriend_fanpage_id" class="form-control" placeholder="Nhập ID fanpage hoặc tài khoản">
                                        <input type="number" required="required" name="addfriend_number" class="form-control" min="1" placeholder="Nhập số lượng cần mua, tối thiểu 100" value="100">
                                        <p>
                                            <button href="javascript:void(0);" class="btn btn-warning btn-block"
                                               role="button" style="margin-bottom: 0px;"
                                               type="submit"
                                               onclick="buyOtherService(this, 'addfriend')"
                                            >
                                                Mua ngay
                                            </button>
                                        </p>
                                        <p style="padding-top: 0px;">
                                            <a href="javascript:void(0);">Xem điều khoản dịch vụ</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- price element -->

                        <div class="col-md-4">
                            <div class="pricing">
                                <div class="title">
                                    <h2>Gói Like Fanpage</h2>
                                    <h1>Giá chỉ {{$likePage}}đ / 1 lượt</h1>
                                </div>
                                <div class="x_content">
                                    <div class="">
                                        <div class="pricing_features">
                                            <ul class="list-unstyled text-left">
                                                <li><i class="fa fa-check text-success"></i> {{$likePage}} đ / 1 lượt like Fanpage</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pricing_footer">
                                        <input type="text" required="required" name="likepage_fanpage_id" class="form-control" placeholder="Nhập ID fanpage">
                                        <input type="number" required="required" name="likepage_number" class="form-control" min="1" placeholder="Nhập số lượng cần mua, tối thiểu 100" value="100">
                                        <p>
                                            <button href="javascript:void(0);" class="btn btn-warning btn-block"
                                               role="button" style="margin-bottom: 0px;"
                                               type="submit"
                                               onclick="buyOtherService(this, 'likepage')"
                                            >
                                                Mua ngay
                                            </button>
                                        </p>
                                        <p style="padding-top: 0px;">
                                            <a href="javascript:void(0);">Xem điều khoản dịch vụ</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- price element -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('pageStyles')
<style>
    .actionBar {
        text-align: center;
    }
    .pricing_features {
        line-height: 25px;
        padding-top: 10px;
        font-size: 16px;
        min-height: 120px;
    }
    .pricing .title h2 {
        text-transform: none;
    }

    button.btn.btn-warning.btn-block, input.form-control, .pricing_footer a {
        font-size: 16px;
    }

</style>

@endpush

@push('pageScripts')
<script>
    function buyService(element, type) {
        var fanpageId = $('input[name="'+type+'_fanpage_id"]').val();
        if (!fanpageId) {
            toastr.error("Bạn cần nhập Fanpage ID");
            $('input[name="'+type+'_fanpage_id"]').focus();
            return;
        }
        var btn = $(element);
        $.ajax({
            type: "POST",
            url: '{{ route('website.service.apiCreate') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                fanpage_id: fanpageId,
                type:type
            },
            beforeSend: function() {
                btn.prop('disabled', true);
                btn.prepend('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
                if (response.success == 1) {
                    //remove content fanpage id in input field
                    $('.animated .count').text(response.data.balance)
                    $('input[name="'+type+'_fanpage_id"]').val('');
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
    }

    function buyOtherService(element, type) {
        var fanpageId = $('input[name="' + type + '_fanpage_id"]').val();
        var number = $('input[name="' + type + '_number"]').val();
        if (!fanpageId) {
            toastr.error("Bạn cần nhập Fanpage ID");
            return;
        }
        var btn = $(element);
        $.ajax({
            type: "POST",
            url: '{{ route('website.service.apiCreate') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                fanpage_id: fanpageId,
                type: type,
                number: number
            },
            beforeSend: function() {
                btn.prop('disabled', true);
                btn.prepend('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
                if (response.success == 1) {
                    //remove content fanpage id in input field
                    $('.animated .count').text(response.data.balance)
                    $('input[name="fanpage_id"]').val('');
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
    }
</script>
@endpush