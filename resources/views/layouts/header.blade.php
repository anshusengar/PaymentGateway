<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row bg-white  h-20">
    <div class="w-full flex items-center justify-between px-4 h-full bg-gray-100">

        <!-- Left Side: Logo + Clients Dropdown + Orders Dropdown -->
        <div class="flex items-center space-x-4 md:space-x-10 flex-wrap">

            <!-- Logo -->
            <a href="#" class="m-10">
    <img src="assets/images/asp.png" alt="logo" class="h-20  w-auto " style="font-size:20px;">
</a>



          
        </div>

        <!-- Middle: Search -->
<div class="w-full md:w-1/3 lg:w-1/4 px-4">
    <form action="{{ route('admin.search') }}" method="GET">
        <div class="relative">
            <input
                type="text"
                name="query"
                placeholder="Search..."
                class="w-full py-2 px-4 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400"
            />
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-purple-600">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
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
