@extends('layouts.app')

@section('content')
<div class="w-full mt-20 p-8 space-y-6 ">
    <h2 class="text-2xl font-bold text-gray-800">Manage Categories</h2>

    @if(session('success'))
    <div class="flex justify-between items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="text-green-700" aria-label="Close" onclick="this.parentElement.style.display='none';">
            <span aria-hidden="true" class="text-xl font-bold">&times;</span>
        </button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6">
        {{-- Add Category Form --}}
        <div class="w-full md:w-1/2 bg-gray-50 p-4 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Add New Category</h3>
            <form action="{{ route('save.category') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="cat_name" required class="w-full px-3 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
                </div>
                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 rounded">Add Category</button>
                </div>
            </form>
        </div>

        {{-- Categories List --}}
        <div class="w-full md:w-1/2 overflow-x-auto bg-gray-50 p-4 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">All Categories</h3>
            <table class="min-w-full border border-gray-200 rounded-lg  text-sm">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="px-6 py-3 text-left">#</th>
            <th class="px-6 py-3 text-left">Category Name</th>
            <th class="px-6 py-3 text-left">Action</th>
        </tr>
    </thead>
    <tbody class="text-gray-700 divide-y divide-gray-200">
        @foreach($cats as $index => $cat)
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">{{ $index + 1 }}</td>
            <td class="px-6 py-4">{{ $cat->name }}</td>
            <td class="px-6 py-4">
               <form
    action="{{ route('category.destroy', $cat->id) }}"
    method="POST"
    onsubmit="return confirm('Are you sure you want to delete this category?');"
    style="display:inline"
>
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:text-red-800">
        <i class="fas fa-trash text-xl" ></i>
    </button>
</form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

        </div>
    </div>
</div>
@endsection
