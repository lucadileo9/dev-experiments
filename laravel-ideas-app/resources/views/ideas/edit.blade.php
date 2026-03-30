<x-layouts.app title="Edit Idea">
    <x-ui.section class="max-w-2xl mx-auto mt-10">
        <x-ui.title>Modify Idea</x-ui.title>

        <x-ideas.form 
            :idea="$idea"
            action="/ideas/{{ $idea->id }}"
            submitText="Save Changes"
            method="PATCH"
            :showDeleteButton="true"
        />
    </x-ui.section>
</x-layouts.app>