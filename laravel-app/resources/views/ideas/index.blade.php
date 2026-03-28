<x-layout title="My Ideas">
    
    <div class="flex flex-col items-center justify-center mb-12 text-center">
        <h1 class="text-5xl font-extrabold text-primary mb-4 tracking-tight">Your Great Ideas</h1>
        <p class="text-lg opacity-70">A safe space to jot down everything that comes to your mind.</p>
    </div>

    <div class="card bg-base-200 shadow-md border border-base-300 mb-12 max-w-2xl mx-auto w-full">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-4">What's on your mind?</h2>
            
            <x-form.errors :errors="$errors" />

            <form action="/ideas" method="POST">
                @csrf
                <div class="form-control w-full">
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3" 
                        class="textarea textarea-bordered textarea-lg w-full focus:textarea-primary transition-all" 
                        placeholder="E.g., 'I want to build a revolutionary portal...'"></textarea>
                </div>
                
                <div class="card-actions justify-end mt-6">
                    <button type="submit" class="btn btn-primary btn-wide shadow-lg shadow-primary/30">
                        + Save Idea
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="divider mb-12">Your Saved Ideas</div>

    @if ($ideas->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($ideas as $idea)
                <x-idea-card :idea="$idea" />
            @endforeach
        </div>
    @else
        <div class="alert alert-info shadow-lg flex justify-center mt-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>The board is empty. There is always a first time!</span>
        </div>
    @endif

</x-layout>
