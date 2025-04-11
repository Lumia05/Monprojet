<header class="fixed top-0 left-0 w-full z-50 bg-opacity-50 shadow">
    <div class="w-full bg-blue-900 flex justify-between items-center py-8 px-8 text-white font-light ">
        <div class="">
            <!-- logo -->
            <a href="/" class="text-3xl font-bold">Managerz</a>
        </div>
        <div class="">
            <div class="hidden lg:flex gap-8">
                @guest()
                <a 
                   href="{{ route('inscrire') }}"
                   class="transition-all px-3 py-2 cursor-pointer hover:bg-white hover:text-blue-900 rounded-lg"
                >
                   Sign up
                </a>
                <a
                    href="{{ route('login') }}" 
                    class="transition-all px-3 py-2 cursor-pointer hover:bg-white hover:text-blue-900 rounded-lg"
                >
                    Sign in
                </a>
                @endguest
                
                @auth()
                    {{-- <a 
                        class="transition-all px-3 py-2 cursor-pointer hover:bg-white hover:text-blue-900 rounded-lg"
                        href="{{ route('filament.admin.pages.dashboard') }}"
                    >
                        Dashboard
                    </a> --}}
                    <form method="POST" action={{ route('deconnecter') }}
                    >
                        
                        <button
                            type="submit"
                            class="transition-all px-3 py-2 cursor-pointer hover:bg-white hover:text-blue-900 rounded-lg"
                        >
                            Log out
                        </button> 
                    </form>
                @endauth
            </div>
        </div>
    </div>
</header>