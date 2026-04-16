@props(['idea'])

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
