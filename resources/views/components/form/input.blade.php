<div class="input-group input-group-outline my-30  {{$containerClass ?? ''}}">
    @if ($showLabel ?? true)
        <label class="form-label">
            @if ($required)
                <span class="text-danger">*</span>
            @endif
            {{$label ?? $name}}
        </label>
    @endif
    <input 
        type="{{ $type ?? 'text' }}" 
        name="{{ $name ?? '' }}"
        step={{ $step ?? '' }}
        min={{ $min ?? '' }}
        max={{ $max ?? '' }}
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $value ?? '' }}"
        class="form-control {{$inputClass ?? ''}}">
</div>
<x-form.validation-error :name="!empty($errorName) ? $errorName : $name" :errors="$errors"/>