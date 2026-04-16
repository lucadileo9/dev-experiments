@props(['statusCounts'])

<div class="card bg-base-200 shadow-md border border-base-300 mb-8 max-w-4xl mx-auto w-full">
    <div class="card-body">
        <h3 class="card-title text-lg mb-4">Filter by Status</h3>
        
        <div class="flex flex-wrap gap-3">
            <!-- All Ideas Button -->
            <a 
                href="/ideas" 
                class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}"
            >
                All Ideas
                <span class="badge badge-lg">{{ $statusCounts['all'] }}</span>
            </a>
            
            <!-- Pending Button -->
            <a 
                href="/ideas?status=pending" 
                class="btn btn-sm {{ request('status') === 'pending' ? 'btn-warning' : 'btn-outline' }}"
            >
                Pending
                <span class="badge badge-lg badge-warning">{{ $statusCounts['pending'] }}</span>
            </a>
            
            <!-- In Progress Button -->
            <a 
                href="/ideas?status=in_progress" 
                class="btn btn-sm {{ request('status') === 'in_progress' ? 'btn-info' : 'btn-outline' }}"
            >
                In Progress
                <span class="badge badge-lg badge-info">{{ $statusCounts['in_progress'] }}</span>
            </a>
            
            <!-- Completed Button -->
            <a 
                href="/ideas?status=completed" 
                class="btn btn-sm {{ request('status') === 'completed' ? 'btn-success' : 'btn-outline' }}"
            >
                Completed
                <span class="badge badge-lg badge-success">{{ $statusCounts['completed'] }}</span>
            </a>
        </div>
    </div>
</div>
