<x-layouts.app title="View Idea">
    <x-ui.section class="max-w-2xl mx-auto mt-10">
        <div class="flex justify-between items-start mb-6">
            <div>
                <x-ui.title>{{ $idea->title }}</x-ui.title>
                <p class="text-sm text-base-content/60 mt-2">{{ $idea->created_at->format('d F Y - H:i') }}</p>
            </div>
            <x-ideas.status-badge :status="$idea->status" />
        </div>

        <div class="mt-6">
            <div class="bg-base-100 p-6 rounded-box shadow-inner mb-6">
                <p class="text-xl text-base-content leading-relaxed">{{ $idea->description }}</p>
            </div>
        </div>
        
        <div class="mt-10 flex gap-4">
            <a href="/ideas/{{ $idea->id }}/edit" class="btn btn-primary">Edit Idea</a>
            <a href="/ideas" class="btn btn-ghost">Back to List</a>
        </div>
    </x-ui.section>
</x-layouts.app>