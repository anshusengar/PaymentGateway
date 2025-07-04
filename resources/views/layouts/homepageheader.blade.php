<header class="bg-white shadow-md">
    <div class="max-w-6xl mx-auto px-4 py-2 flex items-center justify-between">
        
        <!-- Logo -->
     <a href="#" class="mr-20">
    <img src="assets/images/Kaprakriti.png" alt="logo" class="w-24 h-auto object-cover rounded-full">
</a>



        <!-- Search Bar -->
        <div class="flex-1 mx-8">
            <input type="text" placeholder="Search for products, brands and more" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Navigation Links -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="{{ route('products') }}" class="text-gray-800 hover:text-blue-500">Men</a>
            <a href="{{ route('products') }}" class="text-gray-800 hover:text-blue-500">Women</a>
            <a href="{{ route('products') }}" class="text-gray-800 hover:text-blue-500">Kids</a>
            <a href="{{ route('about') }}" class="text-gray-800 hover:text-blue-500">About</a>
            <a href="{{ route('contact') }}" class="text-gray-800 hover:text-blue-500">Contact</a>
        </nav>

        <!-- Account & Cart Icons -->
        <div class="flex items-center space-x-6">
            @guest
                <a href="{{ route('login') }}" class="text-gray-800 hover:text-blue-500">Login</a>
                <a href="{{ route('register') }}" class="text-gray-800 hover:text-blue-500">Register</a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" class="text-gray-800 hover:text-blue-500">Dashboard</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-800 hover:text-blue-500">Logout</a>
            @endauth

            <a href="#" class="text-gray-800 hover:text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l3 9h12l3-9h2M6 14h12a2 2 0 110 4H6a2 2 0 110-4z"></path>
                </svg>
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="md:hidden">
            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-gray-100 py-4">
        <a href="{{ route('products') }}" class="block px-4 py-2 text-gray-800">Men</a>
        <a href="{{ route('products') }}" class="block px-4 py-2 text-gray-800">Women</a>
        <a href="{{ route('products') }}" class="block px-4 py-2 text-gray-800">Kids</a>
        <a href="{{ route('about') }}" class="block px-4 py-2 text-gray-800">About</a>
        <a href="{{ route('contact') }}" class="block px-4 py-2 text-gray-800">Contact</a>
    </div>
</header>
