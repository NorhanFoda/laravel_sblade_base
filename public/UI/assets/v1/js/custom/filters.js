let filters = {
    page: 1,
    keyword: '',
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
    if ($(this).data('embed') !== '') {
        filters.embed = $(this).data('embed'); 
    }
    e.preventDefault();
    getResources();
});

function getResources(page = 1, tableId = 'dataTable') {
    filters.page = page;
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
    let limit = filters.limit ?? 10; // Set limit based on filters or default to 10
    const paginationWrapper = $('.pagination'); // Select the pagination element

    // Update the "Showing" text
    const showingText = `Showing ${(currentPage - 1) * limit + 1} to ${Math.min(currentPage * limit, totalEntries)} of ${totalEntries} entries`;
    paginationWrapper.closest('.card-footer').find('p.text-sm').text(showingText); // Update the text in the card footer

    // Clear existing pagination links
    paginationWrapper.empty();

    // Create pagination links
    if (totalPages > 1) {
        // Previous button
        if (currentPage > 1) {
            const prevButton = $('<li class="page-item">')
                .append($('<a class="page-link" href="#" aria-label="Previous">&laquo;</a>')
                    .on('click', function(e) {
                        e.preventDefault();
                        getResources(currentPage - 1); // Fetch previous page data
                    }));
            paginationWrapper.append(prevButton);
        }

        // Page number links
        for (let page = 1; page <= totalPages; page++) {
            const pageItem = $('<li class="page-item">')
                .addClass(page === currentPage ? 'active' : '')
                .append($('<a class="page-link" href="#">' + page + '</a>')
                    .on('click', function(e) {
                        e.preventDefault();
                        getResources(page); // Fetch data for the selected page
                    }));
            paginationWrapper.append(pageItem);
        }

        // Next button
        if (currentPage < totalPages) {
            const nextButton = $('<li class="page-item">')
                .append($('<a class="page-link" href="#" aria-label="Next">&raquo;</a>')
                    .on('click', function(e) {
                        e.preventDefault();
                        getResources(currentPage + 1); // Fetch next page data
                    }));
            paginationWrapper.append(nextButton);
        }
    }
}



function updatePage(page) {
    filters.page = page;  // Update the page in filters
    getResources(); // Fetch data for the new page
}

