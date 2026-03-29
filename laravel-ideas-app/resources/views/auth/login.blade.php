<x-layouts.app title="Login">
    <div class="flex items-center justify-center min-h-[70vh]">
        <div class="card w-full max-w-md bg-base-200 shadow-2xl border border-base-300">
            <div class="card-body">
                <h2 class="card-title text-3xl font-bold justify-center mb-2">Welcome Back!</h2>
                <p class="text-center opacity-70 mb-6">Enter your details to access your account.</p>

                <x-form.errors :errors="$errors" />

                <form method="POST" action="/login">
                    @csrf
                    
                    <x-form.input 
                        name="email" 
                        label="Email Address" 
                        type="email" 
                        placeholder="you@example.com" 
                        required="true" 
                        autofocus 
                        autocomplete="email"
                    />

                    <x-form.input 
                        name="password" 
                        label="Password" 
                        type="password" 
                        placeholder="••••••••" 
                        required="true" 
                        autocomplete="current-password"
                    />

                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary/30">Login</button>
                    </div>

                    <div class="divider mt-8">Don't have an account?</div>
                    
                    <div class="text-center">
                        <a href="/register" class="btn btn-outline btn-block">Create an account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>