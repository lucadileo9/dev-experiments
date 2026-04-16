@props(['step'])

<div class="flex items-center gap-3 p-3 bg-base-100 rounded-lg shadow-sm border border-base-200">
    <form method="POST" action="{{ route('steps.toggle', $step) }}" class="flex items-center">
        @csrf
        @method('PATCH')
        <input 
            type="checkbox" 
            class="checkbox checkbox-primary" 
            {{ $step->is_completed ? 'checked' : '' }} 
            onChange="this.form.submit()"
        />
    </form>
    
    <span class="text-base {{ $step->is_completed ? 'line-through opacity-50' : '' }}">
        {{ $step->title }}
    </span>
</div>
