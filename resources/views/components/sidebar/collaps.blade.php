<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{$collapsId ?? 'collapseTwo'}}"
        aria-expanded="true" aria-controls="{{$collapsId ?? 'collapseTwo'}}">
        <i class="fas fa-fw fa-cog"></i>
        <span>{{$collapsLabel ?? 'Components'}}</span>
    </a>
    <div id="{{$collapsId ?? 'collapseTwo'}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">{{ $collapsHeader ?? '' }}</h6>
            {{ $collapsItems ?? '' }}
        </div>
    </div>
</li>