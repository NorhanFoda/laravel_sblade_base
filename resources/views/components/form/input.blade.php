<div {{$attributes}}>
    <div class="input-group input-group-outline my-3">
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
            class="form-control">
    </div>
    <x-form.validation-error :name="!empty($errorName) ? $errorName : $name" :errors="$errors"/>
</div>