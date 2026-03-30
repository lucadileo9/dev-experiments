@props(['idea'])

<div class="card bg-base-200 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all border border-base-300">
    <div class="card-body">
        <h2 class="card-title text-xl break-words">Idea #{{ $idea->id }}</h2>
        <p class="text-base-content/70 italic break-words mt-2 mb-4">"{{ $idea->description }}"</p>
        
        <div class="card-actions justify-between items-center mt-auto">
            {{-- <div class="badge {{ $idea->status === 'pending' ? 'badge-warning' : 'badge-success' }} badge-outline font-semibold">
                {{ ucfirst($idea->status ?? 'pending') }}
            </div> --}}
            <a href="/ideas/{{ $idea->id }}" class="btn btn-primary btn-sm">View Details &rarr;</a>
        </div>
    </div>
</div>