@if (session('success'))
    <div class="toast toast-top toast-center z-[100] mt-16">
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