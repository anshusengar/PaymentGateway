<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row bg-white  h-20">
    <div class="w-full flex items-center justify-between px-4 h-full bg-gray-100">

        <!-- Left Side: Logo + Clients Dropdown + Orders Dropdown -->
        <div class="flex items-center space-x-4 md:space-x-10 flex-wrap">

            <!-- Logo -->
            <a href="#" class="m-10">
    <img src="assets/images/asp.png" alt="logo" class="h-20  w-auto " style="font-size:20px;">
</a>



            <div class="hidden md:flex items-center space-x-10">

                <!-- Clients Dropdown -->
                <div class="ml-20 relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-1 focus:outline-none">
                        <span class="text-md text-[#6c757d] font-sans">Clients</span>
                        <svg class="w-4 h-4 text-[#b66dff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute mt-2 w-40 bg-white shadow-lg rounded-md z-50">
                        <a href="#" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">View/Search Clients</a>
                        <a href="#" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">Manage Users</a>
                        <a href="#" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">Add New Client</a>
                        <a href="#" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">Product/Services</a>
                        <a href="#" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">Service Addons</a>
                        <a href="#" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">Domain Registration</a>
                    </div>
                </div>

                <!-- Products Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-1 focus:outline-none">
                        <span class="text-md text-[#6c757d] font-sans">Products</span>
                        <svg class="w-4 h-4 text-[#b66dff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute mt-2 w-52 bg-white shadow-lg rounded-md z-50">
                        <a href="{{route('products')}}" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">All Products</a>
                        <a href="{{route('create.product')}}" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">Create A Product</a>
                    </div>
                </div>

                <!-- Orders Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-1 focus:outline-none">
                        <span class="text-md text-[#6c757d] font-sans">Orders</span>
                        <svg class="w-4 h-4 text-[#b66dff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute mt-2 w-40 bg-white shadow-lg rounded-md z-50">
                        <a href="{{route('orders')}}" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">View Orders</a>
                        <a href="{{route('create.order')}}" class="block px-4 py-1 font-sans text-gray-700 hover:bg-[#b66dff] hover:text-[#fff]">Create order</a>
                    </div>
                </div>

                <!-- Additional Dropdowns (Billing, Support, Reports) -->
                <!-- Repeat the same structure for Billing, Support, and Reports if needed -->
            </div>
        </div>

        <!-- Right Side: User Icon (Clickable) -->
        <div class="mr-8 flex items-center relative">
            <button id="userIcon" class="flex items-center text-gray-700" aria-haspopup="true">
                <i class="fas fa-user-circle text-gray-700 mr-2 text-2xl"></i>
                <span>{{ Auth::user()->name }}</span>
            </button>

            <!-- Dropdown Menu -->
            <div id="userDropdown" class="absolute right-0 hidden mt-2 bg-white shadow-lg rounded-md w-48 py-2 z-50">
    <a href="#" class="block px-4 py-1 text-gray-700 hover:bg-gray-200">Profile</a>
    <a href="#" class="block px-4 py-1 text-gray-700 hover:bg-gray-200">Settings</a>

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="javascript:void(0)" onclick="this.closest('form').submit()" class="block px-4 py-1 text-gray-700 hover:bg-gray-200">
            Logout
        </a>
    </form>
</div>

        </div>

    </div>
</nav>
