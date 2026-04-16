@props([
    'title',
    'description',
    'actionUrl',
    'submitText',
    'alternateText',
    'alternateUrl',
    'alternateActionText',
])

<div class="flex items-center justify-center min-h-[70vh]">
    <div class="card w-full max-w-md bg-base-200 shadow-2xl border border-base-300">
        <div class="card-body">
            <h2 class="card-title text-3xl font-bold justify-center mb-2">{{ $title }}</h2>
            <p class="text-center opacity-70 mb-6">{{ $description }}</p>

            <x-form.errors :errors="$errors" />

            <form method="POST" action="{{ $actionUrl }}">
                @csrf
                
                {{ $slot }}

                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary/30">{{ $submitText }}</button>
                </div>

                <div class="divider mt-8">{{ $alternateText }}</div>
                
                <div class="text-center">
                    <a href="{{ $alternateUrl }}" class="btn btn-outline btn-block">{{ $alternateActionText }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
