$('select').select2();

$('body').on('click', '#update', function () {
    var id = $(this).data('id');
    var data = {
        user_id: $('#edit_site' + id + ' #user_id').val(),
        supplier_id: $('#edit_site' + id + ' #supplier_id').val(),
        armor_code: $('#edit_site' + id + ' #armor_code').val(),
        _token: $('[name=csrf-token]').attr('content')
    }
    $.ajax({
        url: '/admin/update-safe-site/' + id,
        method: 'POST',
        data: data,
        success: function(response) {
            if(response.success == true) {
                $('tr[data-entry-id=' + id + '] td').eq(4).html(response.site.user.name);
                $('tr[data-entry-id=' + id + '] td').eq(5).html(response.site.supplier.name);
                $('tr[data-entry-id=' + id + '] td').eq(6).html(response.site.armor_code);
                $('#edit_site' + id).modal('hide');
                $('#message').removeClass('alert-danger').addClass('alert-success').html(response.message).show();
            } else {
                $('#message').removeClass('alert-success').addClass('alert-danger').html(response.message).show();
            }
        }
    });
});
$('body').on('click', '#point', function () {
    $('.main').css('pointer-events', 'none');
    $('.steps-validation').css('opacity', 0.4);
    $('.loadingGif').show();
    var id = $(this).data('id');
    $.ajax({
        url: '/admin/set-host/' + id,
        method: 'GET',
        success: function(response) {
            $('.steps-validation').css('opacity', 0);
            $('.loadingGif').hide();
            $('#edit_site' + id).modal('hide');
            $('#successMessage').addClass('alert-success').show().html(response.message);
            setTimeout(function(){
                location.href = '/admin/safe-sites';
            },1500)
        }
    })
});

$('body').on('click', '.destroyBtn', function () {
	$('.shureInputDiv').hide();
	$('.shureButtonsDiv').show();
	$('.help-block').hide();
	$('.shureInputDiv').removeClass('has-error');
	$('.shureInput').val('');
});

$('body').on('click', '.destroyAppr', function () {
	$('.shureButtonsDiv').hide();
	$('.shureInputDiv').show();
});

$('body').on('click', '.destroy  ', function () {
	var id = $(this).attr('data-id');
	if ($('#shureInput' + id).val() == 'DELETE') {
		$('.shureInputDiv').removeClass('has-error');
		$('.help-block').hide();

		$('#destroy_site' + id).modal('hide');
		$('.main').css('pointer-events', 'none').css('opacity', 0.3);
		$('.loadingGif').show();

		$.ajax({
            url: '/admin/destroy-safe-site/' + id,
            method: 'GET',
            success: function(response) {
            	$('.main').removeAttr('style');
				$('.loadingGif').hide();

                if(response.success == true) {
					$('#site_' + id + ' .buttons').html('<span class="text-center">Not active!</span>');
					$('#message').removeClass('alert-danger').addClass('alert-success').html(response.message).show();
				} else {
					$('#message').removeClass('alert-success').addClass('alert-danger').html(response.message).show();
				}
            }
        });
	} else {
		$('.shureInputDiv').addClass('has-error');
		$('.help-block').show();
	}
})

window.action = null;
function tableContent(action, mediaId, supplierId) {
	window.action = action;
	var mediaIdData = null;
	var supplierIdData = null;
	if(typeof mediaId != 'undefined' && mediaId != '') {
		mediaIdData = mediaId;
	}
	if(typeof supplierId != 'undefined' && supplierId != '') {
		supplierIdData = supplierId;
	}

	$.ajax({
        url: APP_URL+'/admin/safe-sites/' + action + '/' + mediaIdData + '/' + supplierIdData +'/get-sites',
        method: 'GET',
        success: function(response) {
            if(response.success == true) {
				$('.render_content').html(response.html);
			}
        }
    });
}

$('body').on('click', '.contentButton', function () {
	tableContent($(this).attr('data-action'));
});

$('body').on('change', '.mediaBuyerSort', function () {
	var mediaId = $(this).val();
	var supplierId = $('.supplierSort').val();
	tableContent(action, mediaId, supplierId);
})

$('body').on('change', '.supplierSort', function () {
	var supplierId = $(this).val();
	var mediaId = $('.mediaBuyerSort').val();
	tableContent(action, mediaId, supplierId);
})

$('#tabs ul li').on('click', function () {
	$('#tabs ul li').removeClass('active');
	$(this).addClass('active');
});