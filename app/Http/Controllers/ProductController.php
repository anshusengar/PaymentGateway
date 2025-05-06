<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
   

    public function index(){
        $products=Product::all();
        return view('products.index',compact('products'));
    }


public function create(){
    return view('products.create');
}



public function store(Request $request)
{
    // Validate the form data
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate image file type and size
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        // Store the image in the 'public/product_images' directory
        $imagePath = $request->file('image')->store('product_images', 'public');
    }

    // Create the product
    Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'description' => $request->description,
        'image' => $imagePath,  // Save the image path in the database
    ]);

    // Redirect with success message
    return redirect()->route('products')->with('success', 'Product added successfully!');
}



public function delete($id){

    $products=Product::find($id);
       $products->delete();
       return redirect()->back()->with('success', 'Product Deleted successfully.');
}




}
