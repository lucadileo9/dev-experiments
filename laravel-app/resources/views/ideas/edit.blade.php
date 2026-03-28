<x-layout title="Edit Idea">
    <x-section class="max-w-2xl mx-auto mt-10">
        <x-title>Modify Idea</x-title>

        <x-form.errors :errors="$errors" />

        <form action="/ideas/{{ $idea->id }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="form-control w-full mt-4">
                <label class="label" for="description">
                    <span class="label-text text-base">Idea description</span>
                </label>
                <textarea id="description" name="description" rows="5" 
                    class="textarea textarea-bordered textarea-lg w-full focus:textarea-primary transition-all">{{ $idea->description }}</textarea>
                <label class="label">
                    <span class="label-text-alt opacity-70">Update the description of your idea.</span>
                </label>
            </div>
            
            <div class="mt-8 flex items-center justify-between">
                <div class="flex gap-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="/ideas/{{ $idea->id }}" class="btn btn-ghost">Cancel</a>
                </div>
                <button type="submit" class="btn btn-error btn-outline" form="delete-idea-form">Delete Idea</button>
            </div>
        </form>

        <form action="/ideas/{{ $idea->id }}" method="POST" class="hidden" id="delete-idea-form">
            @csrf
            @method('DELETE')
        </form>
    </x-section>
</x-layout>
