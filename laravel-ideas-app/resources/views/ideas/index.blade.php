<x-layouts.app title="My Ideas">
    
    <div class="flex flex-col items-center justify-center mb-12 text-center">
        <h1 class="text-5xl font-extrabold text-primary mb-4 tracking-tight">Your Great Ideas</h1>
        <p class="text-lg opacity-70">A safe space to jot down everything that comes to your mind.</p>
    </div>

    <div class="flex justify-center mt-8">
        <button class="btn btn-primary btn-lg shadow-lg" onclick="create_idea_modal.showModal()">
            Propose a New Idea
        </button>
    </div>

    <x-ui.modal id="create_idea_modal" title="Propose a New Idea">
        <x-ideas.form 
            :action="route('ideas.store')"
            submitText="Save Idea"
            method="POST"
        />
    </x-ui.modal>


    <div class="divider my-12">Your Saved Ideas</div>

    <x-ideas.status-filter :statusCounts="$statusCounts" />

    @if ($ideas->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($ideas as $idea)
                <x-ideas.card :idea="$idea" />
            @endforeach
        </div>
    @else
        <div class="alert alert-info shadow-lg flex justify-center mt-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>The board is empty. There is always a first time!</span>
        </div>
    @endif

</x-layouts.app>
