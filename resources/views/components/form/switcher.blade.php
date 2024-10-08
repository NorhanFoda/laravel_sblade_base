<div class="form-check form-switch d-flex align-items-center mb-3">
    <input class="form-check-input {{ $inputClass ?? '' }}" type="checkbox" id="{{ $id ?? 'switcher' }}" name="{{ $name }}"
        @if (isset($checked) && $checked) checked @endif>
    <label class="form-check-label mb-0 ms-3" for="{{ $id ?? 'switcher' }}">{{ $label ?? '' }}</label>
</div>
