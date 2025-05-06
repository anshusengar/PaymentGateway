@extends('layouts.app')

@section('content')


  <div class="w-full  mt-20  p-8  bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold  text-gray-800 text-start">Add a New Product</h2>


    @if(session('success'))
    <div class="flex justify-between items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="text-green-700" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none';">
            <span aria-hidden="true" class="text-xl font-bold">&times;</span>
        </button>
    </div>
@endif





    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf

      <div>
        <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Product Name</label>
        <input type="text" id="name" name="name" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label for="price" class="block mb-1 text-sm font-medium text-gray-700">Price</label>
        <input type="number" id="price" name="price" step="0.01" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label for="description" class="block mb-1 text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="4" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
      </div>

      <div>
        <label for="image" class="block mb-1 text-sm font-medium text-gray-700">Product Image</label>
        <input type="file" id="image" name="image"
          class="w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
      </div>

      <button type="submit"
        class=" bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
        Add Product
      </button>
 
    </form>
  </div>
@endsection 

