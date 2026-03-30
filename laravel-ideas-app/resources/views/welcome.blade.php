<x-layouts.app title="Home - DevIdeas">
    
    <div class="hero bg-base-200 py-16 rounded-xl shadow-lg mb-12">
        <div class="hero-content text-center">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-extrabold text-primary mb-6"> Share your <span class="text-secondary">Best Ideas</span></h1>
                <p class="py-6 text-xl text-base-content/80">
                    The ideal platform to propose, vote, and discuss the most innovative ideas in the developer community.
                </p>
                <div class="flex justify-center gap-4 mt-6">
                    <a href="/ideas/create" class="btn btn-primary btn-lg">Add an idea</a>
                    <a href="#explore" class="btn btn-outline btn-secondary btn-lg">Explore</a>
                </div>
            </div>
        </div>
    </div>

    <div id="explore"></div>
    <x-ui.title class="text-center md:text-left mb-8">Recent Ideas</x-ui.title>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($ideas ?? [] as $idea)
            <x-ideas.card :idea="$idea" />
        @empty
            <div class="col-span-full">
                <x-ui.section class="text-center text-base-content/60 py-12">
                     No ideas found. Be the first to write one!
                </x-ui.section>
            </div>
        @endforelse
    </div>

</x-layouts.app>
