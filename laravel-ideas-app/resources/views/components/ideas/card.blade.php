@props(['idea'])

<div class="card bg-base-200 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all border border-base-300">
    <div class="card-body">
        <h2 class="card-title text-lg break-words">{{ $idea->title }}</h2>
        <p class="text-xs text-base-content/60">{{ $idea->created_at->diffForHumans() }}</p>
        <p class="text-base-content/70 italic break-words mt-2 mb-4">"{{ $idea->description }}"</p>
        
        <div class="card-actions justify-between items-center mt-auto">
            <x-ideas.status-badge :status="$idea->status" />
            <a href="/ideas/{{ $idea->id }}" class="btn btn-primary btn-sm">View Details &rarr;</a>
        </div>
    </div>
</div>