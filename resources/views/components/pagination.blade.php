<div class="card-footer d-flex justify-content-between align-items-center">
    <div>
        <p class="text-sm">
            Showing {{ ($models->currentPage() - 1) * $models->perPage() + 1 }} to
            {{ min($models->currentPage() * $models->perPage(), $models->total()) }} of 
            {{ $models->total() }} entries
        </p>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            @if ($models->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="{{__('pagination.prev')}}"
                       onclick="event.preventDefault(); getResources({{ $models->currentPage() - 1 }});">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            @for ($i = 1; $i <= $models->lastPage(); $i++)
                <li class="page-item {{ $i == $models->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); getResources({{ $i }});">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            @if ($models->currentPage() < $models->lastPage())
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="{{__('pagination.next')}}"
                       onclick="event.preventDefault(); getResources({{ $models->currentPage() + 1 }});">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
