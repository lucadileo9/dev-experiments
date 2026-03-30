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
    x-data="{ newLink: '', links: @json($idea?->links ?? []), 
    newStep: '', steps: @json($idea?->steps ?? []) }"
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
    
    <div class="form-control w-full mb-4">
        <label class="label" for="new-link">
            <span class="label-text font-semibold">References (Optional)</span>
        </label>
        
        <div class="flex gap-2 items-end">
            <input
                id="new-link"
                x-model="newLink"
                type="url"
                placeholder="https://example.com"
                autocomplete="url"
                class="input input-bordered flex-1 focus:input-primary"
                spellcheck="false"
            >
            <button
                type="button"
                @click="if(newLink.trim().length > 0 && !links.includes(newLink.trim())) { links.push(newLink.trim()); newLink = ''; }"
                :disabled="newLink.trim().length === 0"
                class="btn btn-outline"
            >
                + Add
            </button>
        </div>
    </div>


    <!-- TO DO: this two probably should be fused together or moved in an other components -->
    <!-- Hidden inputs for links submission -->
    <template x-for="link in links" :key="link">
        <input type="hidden" name="links[]" :value="link">
    </template>
    <!-- Display links list -->
    <template x-if="links.length > 0">
        <div class="form-control w-full mb-4">
            <label class="label">
                <span class="label-text font-semibold">Added References</span>
            </label>
            <div class="space-y-2">
                <template x-for="(link, index) in links" :key="index">
                    <div class="flex items-center justify-between bg-base-200 p-3 rounded-lg border border-base-300">
                        <a :href="link" target="_blank" class="link link-primary break-all flex-1" x-text="link"></a>
                        <button
                            type="button"
                            @click="links.splice(index, 1)"
                            class="btn btn-sm btn-ghost ml-2"
                            title="Remove this link"
                        >
                            ✕
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <div class="form-control w-full mb-4">
        <label class="label" for="new-step">
            <span class="label-text font-semibold">Steps (Optional)</span>
        </label>
        
        <div class="flex gap-2 items-end">
            <input
                id="new-step"
                x-model="newStep"
                type="url"
                placeholder="to do..."
                autocomplete="url"
                class="input input-bordered flex-1 focus:input-primary"
                spellcheck="false"
            >
            <button
                type="button"
                @click="if(newStep.trim().length > 0 && !steps.includes(newStep.trim())) { steps.push(newStep.trim()); newStep = ''; }"
                :disabled="newStep.trim().length === 0"
                class="btn btn-outline"
            >
                + Add
            </button>
        </div>
    </div>


    <!-- TO DO: this two probably should be fused together or moved in an other components -->
    <!-- Hidden inputs for steps submission -->
    <template x-for="step in steps" :key="step">
        <input type="hidden" name="steps[]" :value="step">
    </template>
    <!-- Display steps list -->
    <template x-if="steps.length > 0">
        <div class="form-control w-full mb-4">
            <label class="label">
                <span class="label-text font-semibold">Added Steps</span>
            </label>
            <div class="space-y-2">
                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex items-center justify-between bg-base-200 p-3 rounded-lg border border-base-300">
                        <a :href="step" target="_blank" class="step step-primary break-all flex-1" x-text="step"></a>
                        <button
                            type="button"
                            @click="steps.splice(index, 1)"
                            class="btn btn-sm btn-ghost ml-2"
                            title="Remove this step"
                        >
                            ✕
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <div class="space-y-2">
        <label for="image" class="label">Featured Image</label>
        <input type="file" name="image" accept="image/*" />
        <x-form.errors :errors="$errors" />
    </div>


    <div class="mt-8 flex items-center {{ $showDeleteButton ? 'justify-between' : 'justify-end' }}">
        <div class="flex gap-4">
            <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
            @if($idea)
                <a href="/ideas/{{ $idea->id }}" class="btn btn-ghost">Cancel</a>
            @else
                <a href="{{ url()->previous() }}" class="btn btn-ghost">Cancel</a>
            @endif
        </div>
        @if($showDeleteButton && $idea)
            <button type="button" class="btn btn-error btn-outline" onclick="document.getElementById('delete-idea-form').submit()">
                Delete Idea
            </button>
        @endif
    </div>
</form>

@if($showDeleteButton && $idea)
    <form action="/ideas/{{ $idea->id }}" method="POST" class="hidden" id="delete-idea-form">
        @csrf
        @method('DELETE')
    </form>
@endif

