<x-layouts.app title="Register">
    <div class="flex items-center justify-center min-h-[70vh]">
        <div class="card w-full max-w-md bg-base-200 shadow-2xl border border-base-300">
            <div class="card-body">
                <h2 class="card-title text-3xl font-bold justify-center mb-2">Create an Account</h2>
                <p class="text-center opacity-70 mb-6">Join us to start saving your ideas.</p>

                <x-form.errors :errors="$errors" />

                <form method="POST" action="/register">
                    @csrf
                    
                    <x-form.input 
                        name="name" 
                        label="Full Name" 
                        type="text" 
                        placeholder="John Doe" 
                        required="true" 
                        autofocus 
                        autocomplete="name"
                    />

                    <x-form.input 
                        name="email" 
                        label="Email Address" 
                        type="email" 
                        placeholder="you@example.com" 
                        required="true" 
                        autocomplete="email"
                    />

                    <x-form.input 
                        name="password" 
                        label="Password" 
                        type="password" 
                        placeholder="••••••••" 
                        required="true" 
                        autocomplete="new-password"
                    />

                    <x-form.input 
                        name="password_confirmation" 
                        label="Confirm Password" 
                        type="password" 
                        placeholder="••••••••" 
                        required="true" 
                        autocomplete="new-password"
                    />

                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary/30">Register</button>
                    </div>

                    <div class="divider mt-8">Already have an account?</div>
                    
                    <div class="text-center">
                        <a href="/login" class="btn btn-outline btn-block">Log in instead</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>