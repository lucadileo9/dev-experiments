<x-layouts.app title="Nuova Idea - DevIdeas">

    <x-ui.section class="max-w-2xl mx-auto mt-8">
        <x-ui.title>Proponi una Nuova Idea</x-ui.title>

        <x-ideas.form 
            :action="route('ideas.store')"
            submitText="Save Idea"
            method="POST"
        />
    </x-ui.section>

</x-layouts.app>