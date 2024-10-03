let filters = {
    page: 1,
    keyword: '',
    embed: 'roles:id,roles.permissions:id',
    includeEmptyRelations: false,
    columns: 'id,name'
};
$('#filter').on('input change', function() {
    $('#filter :input').each(function() {
        let input = $(this);
        let name = input.attr('name');
        if (name) {
            filters[name] = input.val();
        }
    });
});
$('#filter').submit(function(e) {
    e.preventDefault();
    getResources(filters);
});

function getResources(filters, tableId = 'dataTable') {
    $.ajax({
        url: window.location.href,
        method: 'GET',
        data: filters,
        success: function(response) {
            $(`#${tableId} tbody`).html(response.html); // Update table rows with the data
            updatePagination(response.totalEntries, response.currentPage, response.totalPages);
        }
    });
}

function updatePagination(totalEntries, currentPage, totalPages) {
    let limit = filters.limit ?? 10;
    const paginationWrapper = $('.pagination-wrapper');
    paginationWrapper.find('.pagination').empty(); // Clear existing pagination links

    // Update the "Showing" text
    paginationWrapper.find('span').text(`Showing ${(currentPage - 1) * limit + 1} to ${Math.min(currentPage * limit, totalEntries)} of ${totalEntries} entries`);

    // Create pagination links
    if (totalPages > 1) {
        // Previous button
        const prevButton = $('<li class="page-item">')
            .append($('<a class="page-link" href="#" aria-label="Previous">&laquo;</a>')
                .on('click', function(e) {
                    e.preventDefault();
                    if (currentPage > 1) {
                        filters.page = currentPage - 1; // Decrement the page
                        getResources(filters); // Fetch new data
                    }
                }));
        paginationWrapper.find('.pagination').append(prevButton);

        // Page number links
        for (let page = 1; page <= totalPages; page++) {
            const pageItem = $('<li class="page-item">')
                .addClass(page === currentPage ? 'active' : '')
                .append($('<a class="page-link" href="#">' + page + '</a>')
                    .on('click', function(e) {
                        e.preventDefault();
                        filters.page = page; // Set the current page
                        getResources(filters); // Fetch new data
                    }));
            paginationWrapper.find('.pagination').append(pageItem);
        }

        // Next button
        const nextButton = $('<li class="page-item">')
            .append($('<a class="page-link" href="#" aria-label="Next">&raquo;</a>')
                .on('click', function(e) {
                    e.preventDefault();
                    if (currentPage < totalPages) {
                        filters.page = currentPage + 1; // Increment the page
                        getResources(filters); // Fetch new data
                    }
                }));
        paginationWrapper.find('.pagination').append(nextButton);
    }
}


function updatePage(page) {
    filters.page = page;  // Update the page in filters
    getResources(filters); // Fetch data for the new page
}

