<div class="filter-container d-flex flex-column align-items-end">
    <button class="btn btn-outline-light btn-icon-text d-flex align-items-center me-2"
        type="button" data-bs-toggle="collapse" data-bs-target="#filterSection"
        aria-expanded="false" aria-controls="filterSection">
        <i class="fas fa-filter me-2"></i> Filter
    </button>
    <div class="collapse" id="filterSection">
        <div class="card-body pt-4 pb-0 px-3">
            <form id="filter" class="row g-3" {{ $attributes }} data-embed="{{ $embed ?? '' }}">
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control form-control-lg bg-light text-dark" name="keyword"
                        placeholder="Keyword">
                </div>
                {{ $slot }} <!-- This allows additional form fields to be passed -->
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-light btn-lg">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>