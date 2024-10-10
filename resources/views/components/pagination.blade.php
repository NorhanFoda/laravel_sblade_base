<div class="card-footer d-flex justify-content-between align-items-center">
    <div>
        <p class="text-sm">Showing {{ ($currentPage - 1) * $models->perPage() + 1 }} to
            {{ min($currentPage * $models->perPage(), $totalEntries) }} of {{ $totalEntries }} entries</p>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            @if ($currentPage > 1)
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="{{__('pagination.prev')}}" 
                       onclick="event.preventDefault(); getResources({{ $currentPage - 1 }});">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif
            @for ($i = 1; $i <= $totalPages; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); getResources({{ $i }});">
                        {{ $i }}
                    </a>
                </li>
            @endfor
            @if ($currentPage < $totalPages)
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="{{__('pagination.next')}}" 
                       onclick="event.preventDefault(); getResources({{ $currentPage + 1 }});">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
