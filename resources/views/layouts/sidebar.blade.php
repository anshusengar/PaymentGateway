<aside class="w-64  border-r border-gray-200 min-h-screen bg-gray-100 ">
    <div class="px-6 py-4">
        <h2 class="text-xl font-bold text-purple-800">Menu</h2>
    </div>

    <ul class="space-y-2 px-6">
        <li>
            <a href="{{ route('dashboard') }}" class="block py-2 px-3 text-purple-700 font-medium hover:bg-purple-100 rounded">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}" class="block py-2 px-3 text-purple-700 font-medium hover:bg-purple-100 rounded">
                Profile
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left py-2 px-3 text-purple-700 font-medium hover:bg-purple-100 rounded">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</aside>
