<section class="min-h-screen min-w-full  flex items-center pt-40 pb-16 bg-slate-200">
    <div class="md:w-7xl max-w-[400px] bg-white mx-auto p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">Managerz - Login</h2>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form 
            wire:submit.prevent="signin"
            enctype="multipart/form-data"
        >
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    wire:model.defer="email"
                    id="email" 
                    value="{{ old('email') }}" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    wire:model.defer="password"
                    id="password" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="text-center">
                <button 
                    type="submit" 
                    class="w-full px-6 py-3 bg-blue-900 cursor-pointer  text-white rounded-md font-medium hover:bg-blue-950 transition"
                >
                    {{-- <span wire.loading wire:target='signin' class="">Loging in...</span> --}}
                    <span wire.loading.remove wire:target='signin' class="">Log in</span>
                </button>
            </div>
        </form>
        <p class="text-center mt-4 text-sm text-gray-600">
            Don't have an account? 
            <a href="{{ route('inscrire') }}" class="text-blue-900 hover:underline">Sign up</a>
        </p>
    </div>
</section>