<div class="navbar bg-base-300 shadow-xl mb-8 sticky top-0 z-50">
    <div class="flex-1">
        <a href="/" class="btn btn-ghost text-2xl font-bold">🚀 DevIdeas</a>
    </div>
    <div class="flex-none gap-2">
        <ul class="menu menu-horizontal px-1 items-center gap-2">
            @auth
                <li><a href="/ideas" class="font-semibold">My Ideas</a></li>
            @endauth
            
            <!-- Switch Theme (All DaisyUI Themes Dropdown) -->
            <li>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm m-1">
                        Theme
                        <svg width="12px" height="12px" class="h-2 w-2 fill-current opacity-60 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2048 2458"><path d="M2048 819l-960 1152-960-1152h1920z"/></svg>
                    </div>
                    <ul tabindex="0" class="dropdown-content bg-base-300 rounded-box z-50 w-52 p-2 shadow-2xl h-80 overflow-y-auto block">
                        @foreach(['light', 'dark', 'cupcake', 'bumblebee', 'emerald', 'corporate', 'synthwave', 'retro', 'cyberpunk', 'valentine', 'halloween', 'garden', 'forest', 'aqua', 'lofi', 'pastel', 'fantasy', 'wireframe', 'black', 'luxury', 'dracula', 'cmyk', 'autumn', 'business', 'acid', 'lemonade', 'night', 'coffee', 'winter', 'dim', 'nord', 'sunset'] as $theme)
                            <li>
                                <input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="{{ ucfirst($theme) }}" value="{{ $theme }}" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            @auth
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-error btn-sm ml-2">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="/login" class="btn btn-primary btn-sm ml-2">Login</a></li>
                <li><a href="/register" class="btn btn-secondary btn-sm">Register</a></li>
            @endauth
        </ul>
    </div>
</div>