let form = {};
$('#form').on('input change', function(){
    $('#form :input').each(function() {
        let input = $(this);
        let name = input.attr('name');
        if (name) {
            $(`.validation-error[data-name="${name}"]`).html('');
        }
    });
});

$('button[type="submit"]').click(function(e) {
    e.preventDefault();
    collectFormData();
    submit();
});

function collectFormData() {
    $('#form :input').each(function() {
        let input = $(this);
        let name = input.attr('name');
        if (name) {
            if(input.val() !== '') {
                form[name] = input.val();
            }
        }
    });
}

// Store and Edit form
function submit() {
    $.ajax({
        url:  $('#form').attr('action'),
        method: 'POST',
        data: form,
        success: function(response) {
            toastr.success(response.message?.message);
            setTimeout(function() {
                window.location.href = $('#form').data('redirect');
            }, 1500);
        },
        error: function(error) {
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