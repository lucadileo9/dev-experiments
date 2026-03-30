@props(['id', 'title' => ''])

<dialog id="{{ $id }}" class="modal">
    <div class="modal-box w-11/12 max-w-3xl">
        @if($title)
            <h3 class="font-bold text-2xl mb-6">{{ $title }}</h3>
        @endif
        
        {{ $slot }}
        
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
