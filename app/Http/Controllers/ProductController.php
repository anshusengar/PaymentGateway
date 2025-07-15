<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class ProductController extends Controller
{
   

    public function index(){
        $products=Product::all();
        return view('products.index',compact('products'));
    }


public function create(){
     $categories = Category::all();
    return view('products.create', compact('categories'));
}



public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'sizes'       => 'nullable|string',
        'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $mainImagePath = null;

    // If images exist, use the first one as main image
    if ($request->hasFile('images') && count($request->file('images')) > 0) {
        $firstImage = $request->file('images')[0];
        $mainImagePath = $firstImage->store('product-images', 'public');
    }

    // Save product with main image
    $product = Product::create([
        'name'        => $request->name,
        'price'       => $request->price,
        'description' => $request->description,
        'category_id' => $request->category_id,
        'sizes'       => $request->sizes,
        'image'       => $mainImagePath,  // main image saved in products table
    ]);

    // Save all uploaded images into product_images table
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $path = $img->store('product-images', 'public');
            $product->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('products')->with('success', 'Product added successfully!');
}

public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all(); // for category dropdown

    return view('products.edit', compact('product', 'categories'));
}



public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'category_id' => 'required|exists:categories,id',
    ]);

    // If new image uploaded, store it and delete the old one (optional)
    if ($request->hasFile('image')) {
        // Optionally delete old image
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        $imagePath = $request->file('image')->store('product_images', 'public');
        $product->image = $imagePath;
    }

    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;
    $product->category_id = $request->category_id;
    $product->sizes = $request->sizes;
    $product->save();

   return redirect()->route('products', ['refresh' => 'true'])
                 ->with('success', 'Product updated successfully!');
}


public function delete($id){

    $products=Product::find($id);
       $products->delete();
       return redirect()->back()->with('success', 'Product Deleted successfully.');
}


 public function categories(){
        $cats=Category::all();
        return view('products.categories',compact('cats'));
    }





public function saveCat(Request $request)
{
    $request->validate([
        'cat_name' => 'required|string|max:255'
    ]);

    $cat = new Category();
    $cat->name = $request->cat_name;
    $cat->save();

    return redirect()->back()->with('success', 'Category Added successfully.');
}

public function destroy($id)
{
    $cat = Category::findOrFail($id);
    $cat->delete();
    return redirect()->back()->with('success', 'Category deleted successfully.');
}

}
