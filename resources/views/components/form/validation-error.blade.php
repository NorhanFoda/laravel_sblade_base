<div class="validation-error" data-name="{{ $name }}">
    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <span class="text-danger">
                <li>{{ $error }}</li>
            </span>
        @endforeach
    @endif
</div>
