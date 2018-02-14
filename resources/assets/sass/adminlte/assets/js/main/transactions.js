$('body').on('click', '.total', function () {
	var id = $(this).data('id');
	$('.bottom_' + id).toggle();
    if($('.cards').is(":visible")) {
        $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
    } else {
        $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
    }
});

$('body').on('click', '.filter_transactions', function () {
	var param = $(this).data('param');
	$('#tabs ul li').removeClass('active');
	$(this).addClass('active');
	$(this).parent().addClass('active');
	$("#transaction_filters:nth-child(2)").removeClass('active');
	$(this).parent().addClass('active');
	$('.main').css('pointer-events', 'none');
    $('#transactions_list').css('opacity', 0.4);
    $('.loadingGif').show();
	$.ajax({
        url: '/admin/transactions/' + param,
        method: 'GET',
        success: function(response) {
            if (response.success == true) {
            	$('#transactions_list').css({'opacity' : '' });
            	$('#transactions_list').html(response.html)
            	$('.loadingGif').hide();
            	$('.main').css('pointer-events','');
            } else {
                
            }
        }
    });
});

