$(document).ready(function () {
    // Check if DataTable is already initialized
    if ($.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable().destroy();  // Destroy the existing instance
    }

    // Initialize DataTable
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        paging: false,  // Disable pagination
        searching: false,  // Disable search
        ordering: false,  // Disable ordering
        ajax: function(data, callback, settings) {
            // You can make the AJAX request here to fetch data manually
        }
    }); 
});