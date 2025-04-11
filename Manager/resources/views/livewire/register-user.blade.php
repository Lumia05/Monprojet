<section class="min-h-screen flex items-center justify-center pt-40 pb-16 bg-slate-200">
    <div class="md:w-[700px] max-w-[400px] mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">Managerz - Sign up</h2>
        
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif
        
        <form 
            wire:submit.prevent="register"
            {{-- method="POST"  --}}
            {{-- action="{{ route('register') }}"  --}}
            enctype="multipart/form-data"
        >
            <div class="mb-4">
                <label for="profil" class="cursor-pointer relative md:left-[25%] left-[10%] rounded-full border-2 w-48 h-48 border-gray-100 block">
                    <img
                        id="profil-preview"
                        src="{{ asset('images/default-avatar.png') }}" 
                        class="w-full h-full object-cover border-0 rounded-full"
                        alt="Photo de profil"
                    />
                </label>
                <input 
                    type="file" 
                    wire:model.defer="profil"
                    name="profil" 
                    id="profil" 
                    accept="image/*" 
                    class="mt-1 hidden"
                    onchange="previewImage(event)" 
                >
                @error('profil')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 my-6">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input 
                        type="text" 
                        name="name"
                        wire:model.defer="name"
                        id="name" 
                        value="{{ old('name') }}" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        wire:model.defer="email"
                        id="email" 
                        value="{{ old('email') }}" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                        required
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        wire:model.defer="password"
                        id="password" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                        required
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date_de_naissance" class="block text-sm font-medium text-gray-700">Date de Naissance</label>
                    <input 
                        type="date" 
                        wire:model.defer="date_de_naissance"
                        name="date_de_naissance" 
                        id="date_de_naissance" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                    >
                    @error('date_de_naissance')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                <div class="mb-4">
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input 
                        type="text" 
                        name="telephone" 
                        wire:model.defer="telephone"
                        id="telephone" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                    >
                    @error('telephone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="sexe" class="block text-sm font-medium text-gray-700">sexe</label>
                    <select 
                        name="sexe" 
                        id="sexe" 
                        wire:model.defer="sexe"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                        required
                    >
                        <option value="" class="text-sm" selected>Selectionez votre sexe</option>
                        <option value="F" class="">Feminin</option>
                        <option value="M" class="">Masculin</option>
                    </select>
                    @error('sexe')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                <div class="mb-4">
                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <input 
                        type="text" 
                        name="adresse" 
                        wire:model.defer="adresse"
                        id="adresse" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                        required
                    >
                    @error('adresse')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="poste" class="block text-sm font-medium text-gray-700">Poste</label>
                    <select 
                        name="poste" 
                        wire:model.defer="poste"
                        id="poste" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-900 focus:border-blue-900" 
                        required
                    >
                        <option value="" class="text-sm" selected>Selectionez votre poste</option>
                        <option value="consultant" class="">Consultant</option>
                        <option value="directeur_Adjoint" class="">directeur Adjoint</option>
                    </select>
                    @error('poste')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button 
                    type="submit" 
                    class="w-full px-6 py-3 bg-blue-900 cursor-pointer  text-white rounded-md font-medium hover:bg-blue-950 transition"
                >
                    {{-- <span wire.loading wire:target='register' class="">Signing up...</span> --}}
                    <span wire.loading.remove wire:target='register' class="">Sign Up</span>
                </button>
            </div>

            
        </form>
        <p class="text-center mt-4 text-sm text-gray-600">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-blue-900 hover:underline">Log in</a>
        </p>

        <script>
            function previewImage(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('profil-preview');
        
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result; // Met à jour l'image avec l'aperçu
                    };
                    reader.readAsDataURL(file); // Convertit le fichier en URL pour l'affichage
                }
            }
        </script>
    </div>
</section>
