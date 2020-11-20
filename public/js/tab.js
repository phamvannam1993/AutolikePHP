$('.tab').click(function () {
    var tab = $(this).attr('data-id');
    var uid = $('#uid').val();
    viewData(1, tab , uid);
})

$('body').on('click', '.page-link', function() {
    var page = $(this).text();
    var tab = $(this).closest('.tab-pane').attr('data-id');
    var uid = $('#uid').val();
    viewData(page, tab , uid);
});

function viewData(page, tab , uid) {
     $.ajax({
        type: "GET",
        url: $('#getAtionUrl').val(),
        data: {
            tab: tab,
            uid: uid,
            page:page
        },
        success: function (response) {
            $('.tabAction'+tab).html(response);
            $('.tabAction'+tab).find('a').attr('href', 'javascript:void(0)');
        },
        error: function (response) {

        }
    });
}

$('.btnSubmit').click(function () {
    var id = $(this).attr('id');
    submitForm(id);
})

function submitForm(id) {
    form = $('#CloneForm');
    var data = form.serialize();
    if(id == 'delete') {
        var url = $('#deleteClone').val();
    } else {
        var url = $('#updateClone').val();
    }
    if(id == 'update-all') {
        data = {
            'update' : '1',
            '_token' : $('#_token').val()
        };
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (response) {
            location.reload();
        },
        error: function (response) {

        }
    });
}

$('#search').click(function () {
    var action = $('#action').val();
    var uid = $('#Clone').val();
    var url = $('#urlSearch').val()+'?action='+action+'&uid='+uid;
    window.location.href = url;
})

$('.checkAll').click(function () {
    if ($('.checkAll').is(':checked')) {
        $('body .checkBox').attr('checked', true);
    } else {
        $('body .checkBox').attr('checked', false);
    }
})

var action = $('#action').val() ? $('#action').val() : '';
if(action) {
    $('.boxClone').find('.page-link').each(function () {
        var href = $(this).attr('href')
        if(href) {
            var link = href+'&action='+action
            $(this).attr('href', link)
        }
    })
}

function updateStatus(element, code, status) {
    var url = $('#UrlUpdateTransaction').val()
    var StatusCompleted1 = $('#StatusCompleted1').val()
    var StatusCompleted2 = $('#StatusCompleted2').val()
    var StatusCompleted3 = $('#StatusCompleted3').val()
    var btn = $(element);
    $.ajax({
        type: "POST",
        url: url,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
        code: code,
            status: status
    },
    beforeSend: function() {
        btn.prop('disabled', true);
        btn.prepend('<i class="fa fa-spinner fa-spin"></i>');
    },
    success: function(response) {
        btn.prop('disabled', false);
        btn.find('i.fa-spinner').remove();
        if (response.success == 1) {
            if (response.data.status == StatusCompleted1) {
                $('.view-status-pending-' + code).addClass('hidden');
                $('.view-status-expired-' + code).addClass('hidden');
                $('.view-status-completed-' + code).removeClass('hidden');
            } else if (response.data.status == StatusCompleted2) {
                $('.view-status-completed-' + code).addClass('hidden');
                $('.view-status-expired-' + code).addClass('hidden');
                $('.view-status-pending-' + code).removeClass('hidden');
            } else if (response.data.status == StatusCompleted3) {
                $('.view-status-completed-' + code).addClass('hidden');
                $('.view-status-pending-' + code).addClass('hidden');
                $('.view-status-expired-' + code).removeClass('hidden');
            }
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
