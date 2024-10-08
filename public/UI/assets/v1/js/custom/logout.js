$(document).on('click', '#submitLogout', function(e) {
    e.preventDefault();
    logout();
});

function logout() {
    $.ajax({
        url:  $('#logoutForm').attr('action'),
        method: 'POST',
        data: {},
        success: function(response) {
            window.location.href = $('#logoutForm').data('redirect');
        },
        error: function(error) {
            // console.log(error);
        }
    });
}