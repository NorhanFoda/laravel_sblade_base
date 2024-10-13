// Delete form
$('[id^=confirmDelete-]').on('click', function() {
    let id = $(this).attr('id').split('-')[1];
    let deleteForm = $('#deleteForm-' + id);
    let actionUrl = deleteForm.attr('action');
    let redirectUrl = deleteForm.data('redirect');

    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: deleteForm.serialize(),
        success: function(response) {
            $('#modal-notification-' + id).hide(); 
            toastr.success(response.message);
            setTimeout(function() {
                window.location.href = redirectUrl;
            }, 1000);
        },
        error: function(errors) {
            toastr.error('An error occurred while deleting the item.');
            if (errors.status === 500) {
                toastr.error(errors.responseJSON?.message);
                // toastr.error(errors.responseJSON.errors.message[0]);
            }
        }
    });
});