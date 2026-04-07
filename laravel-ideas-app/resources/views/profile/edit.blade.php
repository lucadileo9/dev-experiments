<x-layouts.app title="Profile - DevIdeas">
    <div class="flex flex-col items-center justify-center mb-12 text-center">
        <h1 class="text-5xl font-extrabold text-primary mb-4 tracking-tight">Your Profile</h1>
        <p class="text-lg opacity-70">Update your account's profile information and email address.</p>
    </div>

    <x-ui.section class="max-w-2xl mx-auto mt-8">
        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            <div>
                <label for="name" class="label">
                    <span class="label-text">Name</span>
                </label>
                <input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="input input-bordered w-full @error('name') input-error @enderror" 
                    value="{{ old('name', $user->name) }}" 
                    required 
                    autofocus 
                    autocomplete="name" 
                />
                @error('name')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="label">
                    <span class="label-text">Email</span>
                </label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="input input-bordered w-full @error('email') input-error @enderror" 
                    value="{{ old('email', $user->email) }}" 
                    required 
                    autocomplete="username" 
                />
                @error('email')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center gap-4 mt-6">
                <button type="submit" class="btn btn-primary">Save Profile</button>
            </div>
        </form>
    </x-ui.section>
</x-layouts.app>
