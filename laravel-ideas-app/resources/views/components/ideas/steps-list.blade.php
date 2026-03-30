@props(['steps'])

@if($steps && $steps->count() > 0)
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Steps</h3>
        <div class="space-y-3">
            @foreach($steps as $step)
                <x-ideas.step-item :step="$step" />
            @endforeach
        </div>
    </div>
@endif
