let form = {};
$(document).on('click', '#submit', function(e) {
    e.preventDefault();
    collectFormData();
    submit();
});

function collectFormData() {
    $('#form :input, #form select').each(function() {
        let input = $(this);
        let name = input.attr('name');
        if (name) {
            if (input.is(':checkbox')) {
                collectCheckboxValues(input, name);
            } else if (input.is('select')) {
                collectSelectValues(input, name);
            } else if (input.val() !== '') {
                form[name] = input.val();
            }
        }
    }); 
}

function collectCheckboxValues(input, name) {
    let isArray = input.data('isarray');
    if (isArray) {
        if (!form[name]) {
            form[name] = [];
        }
        if (input.is(':checked')) {
            form[name].push(input.val());
        }
    } else {
        form[name] = input.is(':checked') ? '1' : '0';
    }
}

function collectSelectValues(input, name) {
    let isArray = input.data('isarray');
    if (isArray) {
        if (!form[name]) {
            form[name] = [];
        }
        form[name].push(input.val());
    } else {
        form[name] = input.val();
    }
}

// Store and Edit form
function submit() {
    $.ajax({
        url:  $('#form').attr('action'),
        method: 'POST',
        data: form,
        success: function(response) {
            if (response.message?.message) {
                toastr.success(response.message?.message);
            }
            setTimeout(function() {
                window.location.href = $('#form').data('redirect');
            }, 1000);
        },
        error: function(error) {
            // console.log(error);
            toastr.error(JSON.parse(error.responseText)?.message);
            if (error.status === 422) {
                let errors = error.responseJSON.errors;
                $('.validation-error').html('');
                for (let name in errors) {
                    let errorMessages = errors[name];
                    $(`.validation-error[data-name="${name}"]`).html(errorMessages.map(function(error) {
                        return `<span class="text-danger"><li>${error}</li></span>`;
                    }).join(''));
                }
            }
        }
    });
}

// Clear validation errors
$(document).on('input change', '#form', function(){
    $('#form :input').each(function() {
        let input = $(this);
        let name = input.attr('name');
        if (name) {
            $(`.validation-error[data-name="${name}"]`).html('');
        }
    });
});