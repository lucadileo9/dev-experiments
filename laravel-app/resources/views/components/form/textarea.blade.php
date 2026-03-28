@props([
    'name', 
    'label', 
    'placeholder' => '',
    'value' => '',
    'rows' => 3,
    'required' => false
])

<div class="form-control w-full mb-4">
    <label class="label" for="{{ $name }}">
        <span class="label-text font-semibold">{{ $label }}</span>
    </label>
    
    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}" 
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'textarea textarea-bordered textarea-lg w-full focus:textarea-primary transition-all text-base']) }} 
    >{{ old($name, $value) }}</textarea>
</div>