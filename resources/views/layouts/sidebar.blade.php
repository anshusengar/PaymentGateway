<aside class="w-64 min-h-screen bg-gray-100 border-r border-gray-200 shadow-sm">
  <!-- Sidebar header -->
  <div class="px-6 py-4 bg-purple-50 border-b border-purple-100">
    <h2 class="text-xl font-semibold text-purple-700 tracking-wide">Admin Panel</h2>
  </div>

  <!-- Sidebar menu -->
  <ul class="px-4 py-6 space-y-4 text-sm font-medium text-gray-700">
    
    <!-- Dashboard -->
    <li>
      <a href="{{ route('dashboard') }}"
         class="flex items-center px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        📊 <span class="ml-2">Dashboard</span>
      </a>
    </li>

    <!-- Products -->
    <li x-data="{ open: false }">
      <button @click="open = !open"
              class="flex items-center justify-between w-full px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        <span>🛍️ Products</span>
        <svg class="w-4 h-4 text-purple-600 transform transition-transform" :class="{ 'rotate-180': open }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open" x-transition class="mt-2 ml-4 space-y-1 text-gray-600" x-cloak>
        <a href="{{ route('products') }}" class="block px-3 py-1 rounded hover:bg-purple-50">All Products</a>
        <a href="{{ route('create.product') }}" class="block px-3 py-1 rounded hover:bg-purple-50">Add Product</a>
        <a href="#" class="block px-3 py-1 rounded hover:bg-purple-50">Inventory</a>
      </div>
    </li>

    <!-- Categories -->
    <li>
      <a href="{{ route('categories') }}"
         class="flex items-center px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        🗂️ <span class="ml-2">Categories</span>
      </a>
    </li>

    <!-- Orders -->
    <li x-data="{ open: false }">
      <button @click="open = !open"
              class="flex items-center justify-between w-full px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        <span>📦 Orders</span>
        <svg class="w-4 h-4 text-purple-600 transform transition-transform" :class="{ 'rotate-180': open }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open" x-transition class="mt-2 ml-4 space-y-1 text-gray-600" x-cloak>
        <a href="{{ route('orders') }}" class="block px-3 py-1 rounded hover:bg-purple-50">All Orders</a>
        <a href="{{route('orders.pending')}}" class="block px-3 py-1 rounded hover:bg-purple-50">Pending Orders</a>
        <a href="{{route('orders.delivered')}}" class="block px-3 py-1 rounded hover:bg-purple-50">Delivered</a>
      </div>
    </li>

    <!-- Customers -->
    <li>
      <a href="{{route('users')}}"
         class="flex items-center px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        👥 <span class="ml-2">Customers</span>
      </a>
    </li>

    <!-- Payments -->
    <li>
      <a href="#"
         class="flex items-center px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        💰 <span class="ml-2">Payments</span>
      </a>
    </li>

    <!-- Coupons -->
    <li>
      <a href="{{route('coupons.index')}}"
         class="flex items-center px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        🎟️ <span class="ml-2">Coupons</span>
      </a>
    </li>

   

    <!-- Banners -->
    <li>
      <a href="#"
         class="flex items-center px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        🖼️ <span class="ml-2">Banners</span>
      </a>
    </li>

    <!-- Settings -->
    <li>
      <a href="#"
         class="flex items-center px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        ⚙️ <span class="ml-2">Settings</span>
      </a>
    </li>

    <!-- Admin Users -->
    <li>
      <a href="#"
         class="flex items-center px-3 py-2 rounded-lg hover:bg-purple-100 hover:text-purple-800 transition">
        🔐 <span class="ml-2">Admin Users</span>
      </a>
    </li>
  </ul>
</aside>
