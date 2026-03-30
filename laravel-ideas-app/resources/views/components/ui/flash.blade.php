@if (session('success'))
    <div
        class="toast toast-top toast-center z-[100] mt-16"
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
    >
        <div class="alert alert-success shadow-lg">
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="toast toast-top toast-center z-[100] mt-16">
        <div class="alert alert-error shadow-lg">
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif