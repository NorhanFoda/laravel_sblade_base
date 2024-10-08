// Delete form
$('[id^=confirmDelete-]').on('click', function() {
    var id = $(this).attr('id').split('-')[1];
    var form = $('#deleteForm-' + id);
    var actionUrl = form.attr('action');

    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: form.serialize(),
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