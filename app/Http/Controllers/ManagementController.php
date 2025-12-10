<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ManagementController extends Controller
{       
    public function index()
    {
        $products = Product::with('thumbnail')->get(); 
        return view('admin.management', compact('products'));
    }
}