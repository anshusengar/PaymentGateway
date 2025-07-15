    
    <!-- Login Section inside guest layout -->
    <x-guest-layout>
        <!-- Login Card -->
        <div >
            
            <h2 class="text-2xl font-bold text-center text-gray-700">Login to your Account</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-1 text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                </div>

                <div>
                    <label class="block mb-1 text-gray-600">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm text-gray-600">Remember Me</span>
                    </label>

                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-500 hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-600">
                    Login
                </button>
            </form>

            <!-- WhatsApp Button -->
        

            <p class="text-sm text-center text-gray-600 mt-4">Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-500 hover:underline">Register</a>
            </p>
           
        </div>
    </x-guest-layout>

  

