<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Nạp tiền</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="pricing">
                                <div class="title">
                                    <h2>Gói 1</h2>
                                    <h1>100.000 VNĐ</h1>
                                    <button onclick="makeTransaction(this, 100)" class="btn btn-warning btn-block" role="button">
                                        <i></i> Nạp ngay
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="pricing">
                                <div class="title">
                                    <h2>Gói 2</h2>
                                    <h1>200.000 VNĐ</h1>
                                    <button onclick="makeTransaction(this, 200)" class="btn btn-warning btn-block" role="button">Nạp ngay</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="pricing">
                                <div class="title">
                                    <h2>Gói 3</h2>
                                    <h1>500.000 VNĐ</h1>
                                    <button onclick="makeTransaction(this, 500)" class="btn btn-warning btn-block" role="button">Nạp ngay</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="pricing ui-ribbon-container">
                                <div class="ui-ribbon-wrapper">
                                    <div class="ui-ribbon">
                                        +5%
                                    </div>
                                </div>
                                <div class="title">
                                    <h2>Gói 4</h2>
                                    <h1>1.000.000 VNĐ</h1>
                                    <button onclick="makeTransaction(this, 1000)" class="btn btn-warning btn-block" role="button">Nạp ngay</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="pricing ui-ribbon-container">
                                <div class="ui-ribbon-wrapper">
                                    <div class="ui-ribbon">
                                        +10%
                                    </div>
                                </div>
                                <div class="title">
                                    <h2>Gói 5</h2>
                                    <h1>2.000.000 VNĐ</h1>
                                    <button onclick="makeTransaction(this, 2000)" class="btn btn-warning btn-block" role="button">Nạp ngay</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="pricing ui-ribbon-container">
                                <div class="ui-ribbon-wrapper">
                                    <div class="ui-ribbon">
                                        +15%
                                    </div>
                                </div>
                                <div class="title">
                                    <h2>Gói 6</h2>
                                    <h1>3.000.000 VNĐ</h1>
                                    <button onclick="makeTransaction(this, 3000)" class="btn btn-warning btn-block" role="button">Nạp ngay</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="pricing ui-ribbon-container">
                                <div class="ui-ribbon-wrapper">
                                    <div class="ui-ribbon">
                                        +20%
                                    </div>
                                </div>
                                <div class="title">
                                    <h2>Gói 7</h2>
                                    <h1>5.000.000 VNĐ</h1>
                                    <button onclick="makeTransaction(this, 5000)" class="btn btn-warning btn-block" role="button">Nạp ngay</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="pricing ui-ribbon-container">
                                <div class="ui-ribbon-wrapper">
                                    <div class="ui-ribbon">
                                        +25%
                                    </div>
                                </div>
                                <div class="title">
                                    <h2>Gói 8</h2>
                                    <h1>10.000.000 VNĐ</h1>
                                    <button onclick="makeTransaction(this, 10000)" class="btn btn-warning btn-block" role="button">Nạp ngay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('pageStyles')
<style>
    .pricing .title {
        height: 90px;
    }
    .pricing {
        padding-bottom: 100px;
    }
    .ui-ribbon-container .ui-ribbon {
        background-color: #ec4545;
    }
</style>

@endpush

@push('pageScripts')
<script>
    function makeTransaction(element, planId) {
        var btn = $(element);
        $.ajax({
            type: "POST",
            url: '{{ route('website.transaction.apiCreate') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                plan_id: planId
            },
            beforeSend: function() {
                btn.prop('disabled', true);
                btn.prepend('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                btn.prop('disabled', false);
                btn.find('i.fa-spinner').remove();
                if (response.success == 1) {
                    window.location.href = "/giao-dich/" + response.data.code;
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