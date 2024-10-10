<div class="input-group input-group-static mb-4 {{$containerClass ?? ''}}">
    @if ($showLabel ?? true)
        <label class="form-label">
            @isset ($required)
                <span class="text-danger">*</span>
            @endif
            {{$label ?? $name}}
        </label>
    @endif
    <select
        name="{{ $name ?? '' }}"
        class="form-control select2 {{$inputClass ?? ''}}"
        @if(isset($disabled) && $disabled) disabled @endif
        data-isArray="{{ $isArray ?? false }}">
        @foreach ($options as $option)
            <option value="{{ $option->id }}" 
                {{ (isset($selected) && $selected == $option->id) ? 'selected' : '' }}>
                {{ $option->name }}
            </option>
        @endforeach
    </select>
</div>
@if (($showError ?? true) === true)
    <x-form.validation-error :name="!empty($errorName) ? $errorName : $name" :errors="$errors" />
@endif
