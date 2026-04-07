@props(['statusCounts'])

<div class="card bg-base-200 shadow-md border border-base-300 mb-8 max-w-4xl mx-auto w-full">
    <div class="card-body">
        <h3 class="card-title text-lg mb-4">Filter by Status</h3>
        
        <div class="flex flex-wrap gap-3">
            <!-- All Ideas Button -->
            <a 
                href="{{ route('ideas.index') }}"
                class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}"
            >
                All Ideas
                <span class="badge badge-lg">{{ $statusCounts['all'] }}</span>  
            </a>

            <!-- Pending Button -->
            <a
                href="{{ route('ideas.index', ['status' => App\IdeaStatus::PENDING->value]) }}"
                class="btn btn-sm {{ request('status') === App\IdeaStatus::PENDING->value ? 'btn-warning' : 'btn-outline' }}"
            >
                Pending
                <span class="badge badge-lg badge-warning">{{ $statusCounts['pending'] }}</span>
            </a>

            <!-- In Progress Button -->
            <a
                href="{{ route('ideas.index', ['status' => App\IdeaStatus::IN_PROGRESS->value]) }}"
                class="btn btn-sm {{ request('status') === App\IdeaStatus::IN_PROGRESS->value ? 'btn-info' : 'btn-outline' }}"
            >
                In Progress
                <span class="badge badge-lg badge-info">{{ $statusCounts['in_progress'] }}</span>
            </a>

            <!-- Completed Button -->
            <a
                href="{{ route('ideas.index', ['status' => App\IdeaStatus::COMPLETED->value]) }}"
                class="btn btn-sm {{ request('status') === App\IdeaStatus::COMPLETED->value ? 'btn-success' : 'btn-outline' }}"
            >
                Completed
                <span class="badge badge-lg badge-success">{{ $statusCounts['completed'] }}</span>
            </a>
