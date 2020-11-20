<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h1>NẠP TIỀN</h1>
                <div class="clearfix"></div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-md-12">
						@foreach($packageList as $package)
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="pricing ui-ribbon-container">
									@if($package['bonus'] > 0)
										<div class="ui-ribbon-wrapper">
											<div class="ui-ribbon">
												+{{ $package['bonus'] }}%
											</div>
										</div>
									@endif
									<div class="title">
										<h2>GÓI NẠP TIỀN</h2>
										<h1>{{ number_format($package['money'])}} VNĐ</h1>
										<button onclick="makeTransaction(this, '{{ $package['_id']  }}')" class="btn btn-warning btn-block" role="button">NẠP NGAY</button>
									</div>
								</div>
							</div>
						@endforeach
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

    .pricing h1 {
        font-size: 24px !important;
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