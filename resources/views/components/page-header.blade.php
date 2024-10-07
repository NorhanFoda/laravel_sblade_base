<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ $previousPageLink ?? 'javascript:;' }}">{{ $previousPage ?? '' }}</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
            {{ $currentPage ?? '' }}
        </li>
    </ol>
    <div class="d-flex justify-content-between align-items-center">
        <h6 class="font-weight-bolder mb-0">{{ $currentPage ?? '' }}</h6>
        <div>
            {{ $slot }}
        </div>
    </div>
</nav>
