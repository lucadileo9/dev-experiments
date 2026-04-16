@props([
    'name', 
    'label', 
    'type' => 'text', 
    'placeholder' => '',
    'required' => false
])

<div class="form-control w-full mb-4">
    <label class="label" for="{{ $name }}">
        <span class="label-text font-semibold">{{ $label }}</span>
    </label>
    
    <input 
        id="{{ $name }}" 
        type="{{ $type }}" 
        name="{{ $name }}" 
        value="{{ $type === 'password' ? '' : old($name) }}" 
        placeholder="{{ $placeholder }}" 
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'input input-bordered w-full focus:input-primary']) }} 
    />
</div>