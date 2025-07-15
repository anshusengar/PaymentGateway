@extends('layouts.app')

@section('content')
<div class="w-full mt-20 p-8 space-y-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800">All Users</h2>


    @if(session('success'))
    <div class="flex justify-between items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="text-green-700" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none';">
            <span aria-hidden="true" class="text-xl font-bold">&times;</span>
        </button>
    </div>
@endif


    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">User Name</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Password</th>
                  
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                @foreach($users as $index => $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->password}}</td>
                    

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
