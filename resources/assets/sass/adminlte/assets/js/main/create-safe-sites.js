setTimeout(function () {
	$('.select').select2({
        // minimumResultsForSearch: Infinity
    });
});

$('body').on('click', '#buyTab', function () {
    $('#domainId').val('').trigger('change');
})

$('body').on('click', '#selectTab', function () {
    $('#domain').val('');
})

var isBuy = false;
var isBuilt = false;
var form = $(".steps-validation").show();
$('body').on('change', '#domainId', function () {
    window.domainId = $(this).val();
})

// Initialize wizard
var steps = $(".steps-validation").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="number">#index#</span> #title#',
    autoFocus: true,
    enableFinishButton: false,
    onStepChanging: function (event, currentIndex, newIndex) {

        // Allways allow previous action even if the current form is not valid!

        if (currentIndex > newIndex) {
            return true;
        }

        if (!isBuy && !$.isNumeric(domainId)) {
            return false;
        }

        if (currentIndex == 1) {
            
        }


        if (!isBuilt && currentIndex == 1) {
            return false;
        }


        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3) {
            return false;
        }

        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex) {

            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }

        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();    
    },

    onStepChanged: function (event, currentIndex, priorIndex) {

        if (currentIndex === 1) {
            if(!$('#domain').val()) {
                var data = {
                    domain: $('#domainId').val(),
                    step: 1,
                    _token: $('[name=csrf-token]').attr('content')
                };
                $.ajax({
                    url: '/admin/add-safe-site',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success == true) {
                            $('#title').val(response.title);
                            window.siteId = response.id;
                        } else {
                            return false;
                        }
                    }
                })
            }
        }

        // Used to skip the "Warning" step if the user is old enough.
        if (currentIndex === 2) {

        }

        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3) {
            form.steps("previous");
        }
    },

    onFinishing: function (event, currentIndex) {
        form.validate().settings.ignore = ":disabled";

        return form.valid();
    },

    onFinished: function (event, currentIndex) {
        $('#errors').empty().css('display', 'none');
    }
});


// Initialize validation
$(".steps-validation").validate({
    ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },

    // Different components require proper error label placement
    errorPlacement: function(error, element) {

        // Styled checkboxes, radios, bootstrap switch
        if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
            if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent().parent().parent() );
            }
             else {
                error.appendTo( element.parent().parent().parent().parent().parent() );
            }
        }

        // Unstyled checkboxes, radios
        else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
            error.appendTo( element.parent().parent().parent() );
        }

        // Input with icons and Select2
        else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
            error.appendTo( element.parent() );
        }

        // Inline checkboxes, radios
        else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
            error.appendTo( element.parent().parent() );
        }

        // Input group, styled file input
        else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
            error.appendTo( element.parent().parent() );
        }

        else {
            error.insertAfter(element);
        }
    },
    rules: {
        email: {
            email: true
        }
    }
});

// $("#domain").keyup(function(){
//     //console.log(1);
//     //$("input").css("background-color", "pink");
// });

$('#search').click(function () {
    var domain = $('#domain').val();
    if(domain) {
        $('#search, #buy').prop('disabled', true).css('opacity', 0.7);
        $('#searchImg').show();
        $.ajax({
            url: '/admin/check',
            method: 'POST',
            data: {domain: domain, _token: $('[name=csrf-token]').attr('content')},
            success: function(response) {
                $('#search, #buy').prop('disabled', false).css('opacity', 1);
                $('#searchImg').css('display', 'none');
                if (response.success == 1) {
                    $('#message').html(response.message);
                    $('#message').attr('class', 'text-success');
                } else {
                    $('#message').html(response.message.Error);
                    $('#message').attr('class', 'text-danger');
                }

                // $.ajax({
                //     url: '/admin/add-safe-site',
                //     method: 'POST',
                //     data: {domain: $('#domain').val(), step: 1, _token: $('[name=csrf-token]').attr('content')},
                //     success: function(response) {
                //         if (response.success == true) {
                //             window.siteId = response.id;
                //         } else {
                //             return false;
                //         }
                //     }
                // })
            }
        })
    } else {
        $('#message').html('This field is required!');
        $('#message').attr('class', 'text-danger');
    }
});

$('#buy').click(function () {
    $('#selectLi').html('<a href="#">Select domain</a>');
    var domain = $('#domain').val();
    if (domain) {
        $('#search, #buy').prop('disabled', true).css('opacity', 0.7);
        $('#buyImg').show();
        $.ajax({
            url: '/admin/buy',
            method: 'POST',
            data: {domain: domain, _token: $('[name=csrf-token]').attr('content')},
            success: function(response) {
                $('#search, #buy').prop('disabled', false).css('opacity', 1);
                $('#buyImg').css('display', 'none');
                if (response.success == 1) {
                    $('#message').html(response.message);
                    $('#message').attr('class', 'text-success');
                    isBuy = true;
                    $.ajax({
                        url: '/admin/add-safe-site',
                        method: 'POST',
                        data: {domain: $('#domain').val(), step: 1, _token: $('[name=csrf-token]').attr('content')},
                        success: function(response) {
                            if (response.success == true) {
                                window.siteId = response.id;
                                $('#title').val(response.title);
                            } else {
                                return false;
                            }
                        }
                    })
                } else {
                    $('#selectLi').html('<a data-toggle="tab" href="#selectDomain">Select domain</a>');
                    $('#message').html(response.message.Error);
                    $('#message').attr('class', 'text-danger');
                }
            }
        })
    } else {
        $('#message').html('This field is required!');
        $('#message').attr('class', 'text-danger');
    }
});

$('#build').click(function () {
    $('.main').css('pointer-events', 'none');
    $('#errorMessage, #successMessage').hide();
    $('.steps-validation').css('opacity', 0.4);
    $('.loadingGif').show();

    var data = {
        step: 2,
        user_id: $('#user_id').val(),
        supplier_id: $('#supplier_id').val(),
        title: $('#title').val(),
        tagline: $('#tagline').val(),
        keywords: $('#keywords').val(),
        armor_code: $('#armor_code').val(),
        campaign_id: $('#campaign_id').val(),
        siteId: siteId,
        _token: $('[name=csrf-token]').attr('content')
    };

    $.ajax({
        url: '/admin/create-droplet',
        method: 'POST',
        data: data,
        success: function(response) {
            $('.main, .steps-validation').removeAttr('style');
            $('.loadingGif').hide();
            if(response.success == 1) {
                isBuilt = true;
                $('#successMessage').show().html(response.message);
                steps.steps('next');

            } else {
                $('#errorMessage').show().html(response.message);
            }
        },
        error: function(errorResponse) {
            $('.main, .steps-validation').removeAttr('style');
            $('.loadingGif').hide();
        }
    })
})

$('#point').click(function () {
    $('.main').css('pointer-events', 'none');
    $('.steps-validation').css('opacity', 0.4);
    $('.loadingGif').show();
    $.ajax({
        url: '/admin/set-host/' + siteId,
        method: 'GET',
        success: function(response) {
            if(response.success == 1) {
                $('#successMessage').show().html(response.message);
                setTimeout(function(){
                    location.href = '/admin/safe-sites';
                },1000)
            }
        }
    })
})