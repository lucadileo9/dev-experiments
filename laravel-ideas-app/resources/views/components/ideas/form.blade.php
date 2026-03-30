@props([
    'idea' => null,
    'action' => route('ideas.store'),
    'submitText' => 'Save Idea',
    'method' => 'POST',
    'showDeleteButton' => false
])

<x-form.errors :errors="$errors" />

<form 
    action="{{ $action }}" 
    method="POST"
    enctype="multipart/form-data"
>
    @csrf
    @if($method === 'PATCH')
        @method('PATCH')
    @endif
    
    <div class="form-control w-full mb-4">
        <label class="label" for="title">
            <span class="label-text font-semibold">Idea Title</span>
        </label>
        <input 
            id="title" 
            type="text" 
            name="title" 
            value="{{ old('title', $idea?->title ?? '') }}" 
            placeholder="E.g., 'A revolutionary new idea...'" 
            required
            class="input input-bordered w-full focus:input-primary"
        />
    </div>
    
    <div class="form-control w-full mb-4">
        <label class="label" for="description">
            <span class="label-text font-semibold">Idea Description</span>
        </label>
        <textarea 
            id="description" 
            name="description" 
            rows="5"
            placeholder="Describe your idea in detail..." 
            required
            class="textarea textarea-bordered w-full focus:textarea-primary transition-all text-base"
        >{{ old('description', $idea?->description ?? '') }}</textarea>
    </div>

    <div class="form-control w-full mb-4">
        <label class="label" for="status">
            <span class="label-text font-semibold">Status</span>
        </label>
        <select id="status" name="status" class="select select-bordered w-full focus:select-primary transition-all">
            <option value="pending" @selected(old('status', $idea?->status->value ?? 'pending') === 'pending')>
                Pending
            </option>
            <option value="in_progress" @selected(old('status', $idea?->status->value ?? '') === 'in_progress')>
                In Progress
            </option>
            <option value="completed" @selected(old('status', $idea?->status->value ?? '') === 'completed')>
                Completed
            </option>
        </select>
    </div>
    
    <x-form.dynamic-list 
        name="links"
        label="References (Optional)"
        placeholder="https://example.com"
        type="url"
        :items="old('links', $idea ? array_values((array)($idea->links ?? [])) : [])"
    />

    <x-form.dynamic-list 
        name="steps"
        label="Steps (Optional)"
        placeholder="E.g., 'Do some research'"
        type="text"
        :items="old('steps', $idea ? $idea->steps->pluck('title')->values()->toArray() : [])"
    />

    <div class="form-control w-full mb-4">
        <label class="label" for="image">
            <span class="label-text font-semibold">Featured Image (Optional)</span>
        </label>
        <input 
            type="file" 
            id="image" 
            name="image" 
            accept="image/*" 
            class="file-input file-input-bordered w-full focus:file-input-primary transition-all" 
        />
    </div>

    <div class="mt-8 flex items-center {{ $showDeleteButton ? 'justify-between' : 'justify-end' }}">
        @if($showDeleteButton && $idea)
            <button type="button" class="btn btn-error btn-outline" onclick="document.getElementById('delete-idea-form').submit()">
                Delete Idea
            </button>
        @else
            <div></div>
        @endif
        
        <div class="flex gap-4">
            <button type="button" class="btn btn-ghost" onclick="this.closest('dialog').close()">Cancel</button>
            <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
        </div>
    </div>
</form>

@if($showDeleteButton && $idea)
    <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="hidden" id="delete-idea-form">
        @csrf
        @method('DELETE')
    </form>
@endif

