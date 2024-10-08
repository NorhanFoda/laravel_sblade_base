<div class="form-check">
    <input class="form-check-input {{ $inputClass ?? '' }}" type="checkbox" id="{{ $id ?? 'fcustomCheck1' }}"
        name="{{ $name ?? '' }}" @if (isset($checked) && $checked) checked @endif value="{{ $value ?? '' }}" data-model="{{ $dataModel ?? '' }}">
    <label class="custom-control-label {{ $labelClass ?? '' }}"
        for="{{ $id ?? 'customCheck1' }}">{{ $label ?? 'Check this custom checkbox' }}</label>
</div>
