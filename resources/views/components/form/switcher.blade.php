<div class="form-check form-switch d-flex align-items-center mb-3">
    <input 
        class="form-check-input {{ $inputClass ?? '' }}" 
        type="checkbox" id="{{ $id ?? 'switcher' }}" 
        name="{{ $name }}"
        @if (isset($checked) && $checked) checked @endif>

    <label 
        class="form-check-label mb-0 ms-3" 
        for="{{ $id ?? 'switcher' }}">
        @if (isset($required) && $required)
            <span class="text-danger">*</span>
        @endif
        {{ $label ?? '' }}
    </label>
</div>
@if (($showError ?? true) === true)
    <x-form.validation-error :name="!empty($errorName) ? $errorName : $name" :errors="$errors" />
@endif
