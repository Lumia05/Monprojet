<section class="w-full relative min-h-screen flex items-center bg-cover bg-center" style="background-image: url('https://images.pexels.com/photos/3184360/pexels-photo-3184360.jpeg?auto=compress&cs=tinysrgb&w=600')">
    <!-- Gradient Overlay for Blur Effect at the Top -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/25 to-black/55"></div>
    
    <!-- Content -->
    <div class="lg:max-w-4xl max-w-[335px] mx-auto text-center px-4 relative z-10 pt-20">
        <h1 class="text-3xl lg:text-5xl font-semibold mb-4 text-white">
            Bienvenue sur Managerz
        </h1>
        <p class="text-lg mb-8 text-white">
            Streamline your company’s workforce Managerz – the ultimate system for managing employees, tracking performance, and boosting productivity.
        </p>
        <div class="flex justify-center gap-4">
            <a 
                href="{{ route('filament.admin.auth.login') }}" 
                class="px-6 py-3 bg-white text-blue-500 rounded-sm font-medium hover:bg-gray-100 transition"
            >
                Log in
            </a>
            <a 
                href="{{ route('inscrire') }}" 
                class="px-6 py-3 border-2 border-white text-white hover:bg-white hover:text-blue-500 rounded-sm font-medium transition"
            >
                Sign Up
            </a>
        </div>
    </div>
</section>