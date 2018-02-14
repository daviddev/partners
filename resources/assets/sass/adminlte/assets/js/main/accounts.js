$('body').on('click', '.delete_account_appr', function () {
    var id = $(this).data('id');
    $.ajax({
        url: '/admin/delete-account/' + id,
        method: 'GET',
        success: function(response) {
            if (response.success == true) {
                $('#delete_account_' + id).hide();
                $('.modal-backdrop').remove();
                $('[data-entry-id="' + id + '"]').remove();
                $('#message').removeClass('alert-danger').addClass('alert-success').show().html(response.message);
            }
        }
    });
});

$('body').on('click', '.edit_account_btn', function () {
    window.accountId = $(this).data('id');
    $.ajax({
        url: '/admin/account/' + accountId,
        method: 'GET',
        success: function(response) {
            if (response.success == true) {
                $('#account_nickname_edit').val(response.account.nickname);
                $('#account_card_id').val(response.account.card_id);
                $('#edit_account').modal('show');
            }
        }
    });
});

$('body').on('click', '#edit_account_details', function () {
    var nickName = $('#account_nickname_edit').val();
    var cardId = $('#account_card_id').val();
    $.ajax({
        url: '/admin/account/' + accountId,
        method: 'PUT',
        data: {'nickname': nickName, 'card_id': cardId},
        success: function(response) {
            if (response.success == true) {
                $('#edit_account').modal('hide');
                $('.modal-backdrop').remove();
                $('tr[data-entry-id=' + accountId + '] td').eq(2).html(nickName);
                $('tr[data-entry-id=' + accountId + '] td').eq(3).html(cardId);
                $('#message').removeClass('alert-danger').addClass('alert-success').show().html(response.message);
            }
        },
        error: function(errorResponse) {
            var errors = JSON.parse(errorResponse.responseText);
            $("#message_modal").addClass("alert").addClass("alert-danger");
            $('#message_modal').html('');
            jQuery.each( errors, function( i, val ) {
                var html = $("#message_modal").html();
                if(val.length > 1) {
                    jQuery.each( val, function( j, errVal ) {
                        html += "<div>" + errVal + "</div>";
                        $("#message_modal").html(html);
                    });
                } else {
                    html += "<div>" + val + "</div>";
                    $("#message_modal").html(html); 
                }
            });
        }
    });
});