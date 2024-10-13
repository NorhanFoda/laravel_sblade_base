<li class="nav-item">
    <a class="nav-link text-white {{ in_array(request()->route()->getName(), $activeList) ? 'active' : '' }}" href="{{ $href ?? '#' }}">
        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            @if ($icon)
                <i class="material-icons opacity-10">{{ $icon }}</i>
            @endif
        </div>
        <span class="nav-link-text ms-1">{{ $label ?? 'sidebar link' }}</span>
    </a>
</li>
