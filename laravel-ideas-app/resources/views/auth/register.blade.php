<x-layouts.app title="Register">
    <x-auth.card
        title="Create an Account"
        description="Join us to start saving your ideas."
        actionUrl="/register"
        submitText="Register"
        alternateText="Already have an account?"
        alternateUrl="/login"
        alternateActionText="Log in instead"
    >
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
    </x-auth.card>
</x-layouts.app>
