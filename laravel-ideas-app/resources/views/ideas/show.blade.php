<x-layouts.app title="View Idea">
    <x-ui.section class="max-w-2xl mx-auto mt-10">
        <x-ui.title>Idea Details</x-ui.title>

        <div class="mt-6">
            <div class="bg-base-100 p-6 rounded-box shadow-inner mb-6">
                <p class="text-xl text-base-content leading-relaxed">{{ $idea->description }}</p>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="font-semibold text-base-content/70">Status:</span>
                <span class="badge {{ $idea->status === 'completed' ? 'badge-success' : 'badge-neutral' }} badge-lg">
                    {{ ucfirst($idea->status) }}
                </span>
            </div>
        </div>
        
        <div class="mt-10 flex gap-4">
            <a href="/ideas/{{ $idea->id }}/edit" class="btn btn-primary">Edit Idea</a>
            <a href="/ideas" class="btn btn-ghost">Back to List</a>
        </div>
    </x-ui.section>
</x-layouts.app>