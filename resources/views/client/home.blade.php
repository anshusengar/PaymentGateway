@extends('layouts.homeapp')

@section('content')


<body>

    <!-- Hero Section -->
   <section class="bg-gray-100">
    <div class="relative h-[500px] bg-cover bg-center" style="background-image: url('{{ asset('assets/images/slide.jpg') }}'); background-position: bottom;">

        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="flex justify-center items-center absolute inset-0 text-center text-white">
            <div>
                <h1 class="text-4xl font-bold mb-4">Shop the Best of Fashion</h1>
                <a href="{{ route('products') }}" class="bg-blue-500 px-6 py-3 text-xl rounded-lg hover:bg-blue-400 transition">Shop Now</a>
            </div>
        </div>
    </div>
</section>


    <!-- Categories Section -->
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-8">Shop by Category</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <div class="category-item">
                    <a href="{{ route('products', ['category' => 'men']) }}">
                        <img src="assets/images/men-category.jpg" alt="Men's Fashion" class="w-full h-64 object-cover rounded-lg shadow-md">
                        <p class="text-center text-xl mt-4">Men</p>
                    </a>
                </div>
                <div class="category-item">
                    <a href="{{ route('products', ['category' => 'women']) }}">
                        <img src="assets/images/women-category.jpg" alt="Women's Fashion" class="w-full h-64 object-cover rounded-lg shadow-md">
                        <p class="text-center text-xl mt-4">Women</p>
                    </a>
                </div>
                <div class="category-item">
                    <a href="{{ route('products', ['category' => 'kids']) }}">
                        <img src="assets/images/kids-category.jpg" alt="Kids' Fashion" class="w-full h-64 object-cover rounded-lg shadow-md">
                        <p class="text-center text-xl mt-4">Kids</p>
                    </a>
                </div>
               
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-8">Featured Products</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach ($featuredProducts  as $product)
                <div class="product-item">
                    <a href="#">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                        <p class="text-center text-lg font-semibold mt-2">{{ $product->name }}</p>
                        <p class="text-center text-gray-500 mt-1">${{ $product->price }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Promotional Banner Section -->
    <section class="py-12 bg-blue-600 text-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-4">Seasonal Sale - Up to 50% Off!</h2>
            <p class="mb-4">Don't miss out on exclusive discounts across all categories. Shop now and save big.</p>
            <a href="{{ route('products') }}" class="bg-white text-blue-600 px-6 py-3 text-xl rounded-lg">Shop the Sale</a>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div>
                    <h4 class="font-semibold text-lg">Company</h4>
                    <ul>
                        <li><a href="{{ route('about') }}" class="hover:text-gray-400">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-gray-400">Contact</a></li>
                        <li><a href="#" class="hover:text-gray-400">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-gray-400"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-gray-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-gray-400"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>


@endsection
