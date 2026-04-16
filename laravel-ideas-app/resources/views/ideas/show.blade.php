<x-layouts.app title="View Idea">
    <x-ui.section class="max-w-2xl mx-auto mt-10">

        <x-ideas.show-header :idea="$idea" />
        
        <x-ideas.show-details :description="$idea->description" />

        <x-ideas.links-list :links="$idea->links" />

        <x-ideas.steps-list :steps="$idea->steps" />
        
        <div class="mt-10 flex gap-4">
            <button class="btn btn-primary" onclick="edit_idea_modal.showModal()">Edit Idea</button>
            <a href="{{ route('ideas.index') }}" class="btn btn-ghost">Back to List</a>
        </div>

        <x-ui.modal id="edit_idea_modal" title="Edit Idea">
            <x-ideas.form 
                :idea="$idea"
                :action="route('ideas.update', $idea)"
                submitText="Save Changes"
                method="PATCH"
                :showDeleteButton="true"
            />
        </x-ui.modal>

    </x-ui.section>
</x-layouts.app>
