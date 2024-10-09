<div class="form-check">
    <input 
        class="form-check-input {{ $inputClass ?? '' }}" 
        type="checkbox" 
        id="{{ $id ?? 'fcustomCheck1' }}"
        name="{{ $name ?? '' }}" 
        @if (isset($checked) && $checked) checked @endif 
        value="{{ $value ?? '' }}"
        data-model="{{ $dataModel ?? '' }}" 
        data-isArray="{{ $isArray ?? false }}">

    <label 
        class="custom-control-label {{ $labelClass ?? '' }}" 
        for="{{ $id ?? 'customCheck1' }}">
        @if (isset($required) && $required)
            <span class="text-danger">*</span>
        @endif
        {{ $label ?? 'Check this custom checkbox' }}
    </label>
</div>
@if (($showError ?? true) === true)
    <x-form.validation-error :name="!empty($errorName) ? $errorName : $name" :errors="$errors" />
@endif