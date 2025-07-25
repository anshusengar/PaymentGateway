<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function index() {
    return Category::all();
}

public function store(Request $request) {
    $request->validate([
        'name' => 'required'
    ]);
    return Category::create($request->only('name'));
}
}
