$('#type_button').click(function () {
	var subArray = [];
    $(".types").each(function() {
    	var id = $(this).attr('data-id');
	    if($(this).prop('checked')) {
	    	subArray.push(id);
	    }
    	$('.subscribers').val(JSON.stringify(subArray));
    	$('#type_button').prop('type', 'submit');
		$('#type_button').submit();
	});
})