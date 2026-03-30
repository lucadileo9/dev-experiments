<x-layouts.app title="View Idea">
    <x-ui.section class="max-w-2xl mx-auto mt-10">

    @if ($idea->image_path)

        <div class="mb-6">
            <img src="{{ asset('storage/' . $idea->image_path) }}" alt="Featured Image" class="w-full h-auto rounded-lg shadow-md">
        </div>
    @endif
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

        @if($idea->links)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4">Related Links</h3>
                <ul class="list-disc list-inside space-y-2">
                    @foreach($idea->links as $link)
                        <li>
                            <a href="{{ $link }}" target="_blank" class="text-primary hover:underline break-all">{{ $link }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

{{-- Qui sarebbe il caso di gestire il checkbox con relativo cambio di stato dello step --}}
        @if($idea->steps)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4">Steps</h3>
                <ul class="list-disc list-inside space-y-2">
                    @foreach($idea->steps as $step)
                        <li>
                            {{ $step->title }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


        
        <div class="mt-10 flex gap-4">
            <a href="/ideas/{{ $idea->id }}/edit" class="btn btn-primary">Edit Idea</a>
            <a href="/ideas" class="btn btn-ghost">Back to List</a>
        </div>
    </x-ui.section>
</x-layouts.app>