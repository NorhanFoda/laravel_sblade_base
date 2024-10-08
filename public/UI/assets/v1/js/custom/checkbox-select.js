$('.form-check-input.main-checkbox').on('change', function() {
    const isChecked = $(this).is(':checked');
    const model = $(this).val();
    $('input[type="checkbox"].form-check-input.child-checkbox[data-model="' + model + '"]').prop('checked', isChecked);
});

$('input[type="checkbox"].form-check-input.child-checkbox').on('change', function() {
    const model = $(this).data('model');
    const allChecked = $('input[type="checkbox"].form-check-input.child-checkbox[data-model="' + model + '"]').length === 
                       $('input[type="checkbox"].form-check-input.child-checkbox[data-model="' + model + '"]:checked').length;
    $('input[type="checkbox"].form-check-input.main-checkbox[value="' + model + '"]').prop('checked', allChecked);
});