<x-layouts.app title="Login">
    <x-auth.card
        title="Welcome Back!"
        description="Enter your details to access your account."
        actionUrl="/login"
        submitText="Login"
        alternateText="Don't have an account?"
        alternateUrl="/register"
        alternateActionText="Create an account"
    >
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
    </x-auth.card>
</x-layouts.app>
