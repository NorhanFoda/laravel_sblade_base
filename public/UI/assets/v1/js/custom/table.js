// Delete form
$('[id^=confirmDelete-]').on('click', function() {
    let id = $(this).attr('id').split('-')[1];
    let deleteForm = $('#deleteForm-' + id);
    let actionUrl = deleteForm.attr('action');

    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: deleteForm.serialize(),
        success: function(response) {
            $('#modal-notification-' + id).modal('hide'); 
            toastr.success(response.message);
            setTimeout(function() {
                location.reload();
            }, 1500);
        },
        error: function(xhr, status, error) {
            toastr.error('An error occurred while deleting the item.');
        }
    });
});