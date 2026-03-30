<x-layouts.app title="View Idea">
    <x-ui.section class="max-w-2xl mx-auto mt-10">

        <x-ideas.show-header :idea="$idea" />
        
        <x-ideas.show-details :description="$idea->description" />

        <x-ideas.links-list :links="$idea->links" />

        <x-ideas.steps-list :steps="$idea->steps" />
        
        <div class="mt-10 flex gap-4">
            <a href="{{ route('ideas.edit', $idea) }}" class="btn btn-primary">Edit Idea</a>
            <a href="{{ route('ideas.index') }}" class="btn btn-ghost">Back to List</a>
        </div>
    </x-ui.section>
</x-layouts.app>
