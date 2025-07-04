<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    // Fetch featured products from the database (adjust the query as per your needs)
    $featuredProducts = Product::where('is_featured', 1)->get(); // Assuming 'is_featured' is a column that marks featured products

    // Pass the variable to the view
    return view('client.home', compact('featuredProducts'));
}
public function home()
{
    // Fetch the latest 10 featured products based on the creation date
    $featuredProducts = Product::where('is_featured', 1)
                               ->orderBy('created_at', 'desc') // Order by creation date
                               ->take(10) // Limit to 10 products
                               ->get();

    // Pass the variable to the view
    return view('client.home', compact('featuredProducts'));
}

public function about()
{
    
    return view('client.home');
}
public function contact()
{
    
    return view('client.home');
}
public function products()
{
    
    return view('client.home');
}

}
