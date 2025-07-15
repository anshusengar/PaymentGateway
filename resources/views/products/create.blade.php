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
    <label for="category_id" class="block mb-1 text-sm font-medium text-gray-700">Category</label>
    <select
        id="category_id"
        name="category_id"
        required
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
    >
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div>
<label for="sizes">Sizes (comma separated)</label>
<input type="text" name="sizes" id="sizes" class="form-input" placeholder="e.g., S,M,L,XL" required>
</div>


      <div>
        <label for="description" class="block mb-1 text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="4" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
      </div>

     <div class="row align-items-center" id="fileInputContainer" style="margin-top: 10px;">
    <div class="col-sm-10">
        <div id="additionalFilesContainer">
            <input type="file" name="images[]" class="form-control mb-2" style="border: 1px solid #6c757d;" />
        </div>
    </div>
    <div class="col-sm-2">
        <button id="addMoreButton" type="button" class="btn btn-secondary w-100 mb-2">
            Add More
        </button>
    </div>
</div>






      <button type="submit"
        class=" bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
        Add Product
      </button>
 
    </form>
  </div>
  <script>
document.getElementById("addMoreButton").addEventListener("click", function () {
    const container = document.getElementById("additionalFilesContainer");

    const input = document.createElement("input");
    input.type = "file";
    input.name = "images[]";
    input.className = "form-control mb-2";
    input.style.border = "1px solid #6c757d";

    container.appendChild(input);
});
</script>


@endsection 

