<li class="nav-item active">
    <a class="nav-link" href="{{ $href ?? '#' }}">
        @if ($icon)
            <i class="fas fa-fw {{ $icon }}"></i>
        @endif
        <span>{{ $label ?? 'sidebar link' }}</span>
    </a>
</li>