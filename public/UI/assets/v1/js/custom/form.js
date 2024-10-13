let form = {};
$(document).on('click', '#submit', function(e) {
    e.preventDefault();
    submit();
});

// Store and Edit form
function submit() {
    let formData = new FormData($('#form')[0]);
    let redirect = $('#form').data('redirect') ?? '';
    let reload = parseInt($('#form').data('reload')) ?? 0;
    let url = $('#form').attr('action');
    $.ajax({
        url:  $('#form').attr('action'),
        method: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function(response) {
            if (response.message) {
                toastr.success(response.message);
            }
            if (redirect) {
                setTimeout(function() {
                    window.location.replace(redirect);
                }, 1000);
            }
            if (reload) {
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        },
        error: function(error) {
            toastr.error(error.responseJSON?.message);
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