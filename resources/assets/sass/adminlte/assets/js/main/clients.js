$('body').on('click', '#add_credit_card', function () {
    $('#credit_card_div').show();
});

$('body').on('click', '#add_client_btn', function () {
    $('#message_modal').html('');
    $('#message_modal').removeClass('alert');
    $(".client_attach_credit_card_last4").val('');
    $("#client_name").val('');
    $("#add_spend_fee").val('');
    $(".added_cards").hide();
    $('.client_delete_new_card').hide();
});

$('body').on('click', '#add_client', function () {
    var cards = [];

    $(".client_attach_credit_card_last4").each(function() {
        if($(this).val() != '') {
            cards.push($(this).val());
        }
    });

    if(cards[0] == "") {
        cards = [];
    }

    var data = {
        name: $('#client_name').val(),
        cards: cards,
        spend_fee: $('#add_spend_fee').val(),
    };
    $.ajax({
        url: '/admin/add-client/',
        method: 'POST',
        data: data,
        success: function(response) {
            if(response.success == true) {
                $('#crudTable tbody').append('<tr data-entry-id='+ response.client.id +' role="row"><td>'+ response.client.id +'</td><td>'+ response.client.name +'</td><td><button data-toggle="modal" class="attach_btn" data-id='+ response.client.id +' data-target="#attach_credit_card">Attach</button><button data-toggle="modal" class="attached_cards" data-id='+ response.client.id +' data-target="#attached_cards_modal">Cards</button><button data-id="' +  response.client.id + '"class="edit_client_btn">Edit</button><button data-toggle="modal" data-target="#delete_client_' + response.client.id +'">Delete</button></td></tr>');
                $('#add_client_modal').modal('hide');
                $('#message').removeClass('alert-danger').addClass('alert-success').show().html(response.message);
                $('.render_content').append('<div id="delete_client_' + response.client.id + '"class="modal fade in"><div class="modal-dialog modal-xs"><div class="modal-content"><div class="modal-header"><h4 class="modal-title col-md-11 no-padding">Are you sure? (All attached cards will be deleted)</h4><button type="button" class="close col-md-1" data-dismiss="modal">×</button></div><div class="modal-body"><div class="shureButtonsDiv text-center"><button class="btn btn-primary delete_client_appr" data-id=' + response.client.id +'>Yes</button><button class="btn btn-default" data-dismiss="modal">No</button></div></div></div></div></div>');
            } else {
                $("#message_modal").addClass("alert").addClass("alert-danger");
                $("#message_modal").html("<div>" + response.message + "</div>");
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

$('body').on('click', '.attach_btn', function () {
    $('.attach_credit_card_last4').val('');
    $('#attach_message_modal').modal('hide');
    $('.childs').remove();
    window.id = $(this).data('id');
    var clientName = $('tr[data-entry-id=' + id + '] td').eq(1).html();
    $('#attach_credit_card_name').val(clientName);
});

$('body').on('click', '.add_new_card', function () {
    $('#credit_cards').append('<div class="col-md-9 input-group childs" style="float:none"><input type="text" class="form-control attach_credit_card_last4" placeholder="Card Number"><span class="input-group-btn delete_new_card"><button class="btn btn-default" type="button"><i class="fa fa-minus"></i></button></span></div>');
});

$('body').on('click', '.client_add_new_card', function () {
    $('#client_credit_cards').append('<div class="col-md-9 input-group childs" style="float:none"><input type="text" class="form-control client_attach_credit_card_last4 added_cards" placeholder="Card Number"><span class="input-group-btn client_delete_new_card"><button class="btn btn-default" type="button"><i class="fa fa-minus"></i></button></span></div>');
});

$('body').on('click', '.delete_new_card', function () {
    $(this).parent().remove();
});

$('body').on('click', '.client_delete_new_card', function () {
    $(this).parent().remove();
});

$('body').on('click', '#attach_credit_card_add', function () {

    var cards = [];

    $(".attach_credit_card_last4").each(function() {
        if($(this).val() != '') {
            cards.push($(this).val());
        }
    });

    if(cards[0] == "") {
        cards = [];
    }

    var data = {
        cards: cards,
        client_id: id
    };

    $.ajax({
        url: '/admin/attach-cards/',
        method: 'POST',
        data: data,
        success: function(response) {
            if (response.success == true) {  
                $('.modal').modal('hide');
                $('#message').removeClass('alert-danger').addClass('alert-success').show().html(response.message);
            } else {
                $('#attach_message_modal').removeClass('alert-success').addClass('alert-danger').html(response.message).show();
            }
        }
    });
});

$('body').on('click', '.attached_cards', function () {
    $('#attached_card_inputs_div').html('');
    $(".update_attached_card_inputs").remove();
    var id  = $(this).data('id');
    $.ajax({
        url: '/admin/client-cards/' + id,
        method: 'GET',
        success: function(response) {
            if (response.success == true) {
                var ap = '&#39';
                $('#attached_cards_modal_title').html(response.client_cards.name + ap + 's credit cards');
                for (i = 0; i < response.client_cards.accounts.length; i++) {
                    $('#attached_card_inputs_div').append('<div class="col-md-9 input-group" data-id="' + response.client_cards.accounts[i].id + '"style="float:none"><input type="text" class="form-control update_attached_card_inputs" data-id="' + response.client_cards.accounts[i].id + '" value="' + response.client_cards.accounts[i].last4 + '"placeholder="Card number"><span class="input-group-btn delete_card"><button class="btn btn-default" type="button"><i class="fa fa-trash-o"></i></button></span></div>');
                }
            }
        }
    });
});

$('body').on('click', '#update_attached_cards', function () {
    var id  = $('.attached_cards').data('id');
    var cards = {};
    var accountId;
    $(".update_attached_card_inputs").each(function() {
        if($(this).val() != '') {
            accountId = $(this).data('id');
            cards[accountId] = $(this).val();
        }
    });

    if(cards[0] == "") {
        cards = [];
    }

    var data = {
        'client_id': id,
        'cards': cards,
        'param': 'update'
    }
    $.ajax({
        url: '/admin/attach-cards/',
        method: 'POST',
        data: data,
        success: function(response) {
            if (response.success == true) {
                $('#attached_cards_modal').modal('hide');
                $('#message').removeClass('alert-danger').addClass('alert-success').show().html(response.message);
            } else {
                $('#cards_message_modal').addClass('alert-danger').html(response.message).show();
            }
        }
    });
});

$('body').on('click', '.delete_card', function () {
    var id = $(this).parent().data('id');
    $.ajax({
        url: '/admin/delete-card/' + id,
        method: 'GET',
        success: function(response) {
            if (response.success == true) {
                $('[data-id="' + id + '"]').remove();
            }
        }
    });
});

$('body').on('click', '.delete_client_appr', function () {
    var id = $(this).data('id');
    $.ajax({
        url: '/admin/delete-client/' + id,
        method: 'GET',
        success: function(response) {
            if (response.success == true) {
                $('#delete_client_' + id).modal('hide');
                $('.modal-backdrop').remove();
                $('[data-entry-id="' + id + '"]').remove();
                $('#message').removeClass('alert-danger').addClass('alert-success').show().html(response.message);
            }
        }
    });
});

$('body').on('click', '.edit_client_btn', function () {
    window.clientId = $(this).data('id');
    $.ajax({
        url: '/admin/client/' + clientId,
        method: 'GET',
        success: function(response) {
            if (response.success == true) {
                $('#client_name_edit').val(response.client.name);
                $('#spend_fee_edit').val(response.client.spend_fee);
                $('#spend_fee_edit').val(response.client.spend_fee);
                $('#edit_client').modal('show');
                $('#edit_client').attr('data-id', clientId);
            }
        }
    });
});

$('body').on('click', '#edit_client_details', function () {
    var name = $('#client_name_edit').val();
    var spendFee = $('#spend_fee_edit').val();
    $.ajax({
        url: '/admin/client/' + clientId,
        method: 'PUT',
        data: {'name': name, 'spend_fee': spendFee},
        success: function(response) {
            if (response.success == true) {
                $('#edit_client').modal('hide');
                $('.modal-backdrop').remove();
                $('tr[data-entry-id=' + clientId + '] td').eq(1).html(name);
                $('#message').removeClass('alert-danger').addClass('alert-success').show().html(response.message);
            }
        }
    });
});