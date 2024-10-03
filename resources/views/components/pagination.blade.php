<div class="pagination-wrapper">
    <span>Showing {{ ($currentPage - 1) * $models->perPage() + 1 }} to 
    {{ min($currentPage * $models->perPage(), $totalEntries) }} of {{ $totalEntries }} entries</span>
    <nav>
        <ul class="pagination">
            @if($currentPage > 1)
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous" 
                       onclick="event.preventDefault(); filters.page = {{ $currentPage - 1 }}; fetchData();">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif
            @for($i = 1; $i <= $totalPages; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); filters.page = {{ $i }}; fetchData();">
                        {{ $i }}
                    </a>
                </li>
            @endfor
            @if($currentPage < $totalPages)
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next" 
                       onclick="event.preventDefault(); filters.page = {{ $currentPage + 1 }}; fetchData();">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
