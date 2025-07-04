<footer class="bg-gray-800 text-white py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Logo or Brand Name -->
            <div class="text-lg font-semibold mb-4 md:mb-0">
                KapraKriti
            </div>

            <!-- Navigation Links -->
            <div class="flex space-x-4 text-sm">
                <a href="{{ route('home') }}" class="hover:text-purple-400">Home</a>
                <a href="{{ route('about') }}" class="hover:text-purple-400">About</a>
                <a href="{{ route('products') }}" class="hover:text-purple-400">Products</a>
                <a href="{{ route('contact') }}" class="hover:text-purple-400">Contact</a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-4 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} KapraKriti. All rights reserved.
        </div>
    </div>
</footer>
