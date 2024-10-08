@if (isset($shape) && $shape === 'href')
    <a href="#" id="{{ $id ?? 'submit' }}" class="nav-link text-body font-weight-bold px-0">
        {{ $icon ?? '' }}
        <span class="d-sm-inline d-none">{{ $label ?? 'save' }}</span>
    </a>
@else
    <button id="{{ $id ?? 'submit' }}" type="submit" class="btn btn-primary">{{ $label ?? 'save' }}</button>
@endif