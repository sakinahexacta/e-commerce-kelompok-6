<?php

namespace App\Http\Controllers;

public function show($id)
{
    $product = Product::findOrFail($id);

    return view('product.detail', compact('product'));
}
