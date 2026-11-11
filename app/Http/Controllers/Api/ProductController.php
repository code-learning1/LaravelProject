<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    return response()->json(
        Product::with('category')->where('isDeleted', 0)->get()
    );
}

public function store(Request $request)
{
    $data = $request->validate([
        'ProductName'  => 'required|max:100',
        'Description'  => 'nullable|max:255',
        'CategoryID'   => 'required|exists:categories,category_id',
        'Barcode'      => 'nullable|unique:products,Barcode',
        'Expiredate'   => 'nullable|date',
        'Qty'          => 'required|integer|min:0',
        'UnitPriceIn'  => 'required|numeric|min:0',
        'UnitPriceOut' => 'required|numeric|min:0',
        'ProductImage' => 'nullable|image',
    ]);
    if ($request->hasFile('ProductImage')) {
        $data['ProductImage'] = $request->file('ProductImage')->store('products', 'public');
    }
    return response()->json(Product::create($data), 201);
}

public function show(Product $product)
{
    return response()->json($product->load('category'));
}

public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'ProductName'  => 'required|max:100',
        'Description'  => 'nullable|max:255',
        'CategoryID'   => 'required|exists:categories,category_id',
        'Barcode'      => 'nullable|unique:products,Barcode,' . $product->ProductID . ',ProductID',
        'Expiredate'   => 'nullable|date',
        'Qty'          => 'required|integer|min:0',
        'UnitPriceIn'  => 'required|numeric|min:0',
        'UnitPriceOut' => 'required|numeric|min:0',
        'ProductImage' => 'nullable|image',
    ]);
    if ($request->hasFile('ProductImage')) {
        $data['ProductImage'] = $request->file('ProductImage')->store('products', 'public');
    }
    $product->update($data);
    return response()->json($product);
}

public function destroy(Product $product)
{
    $product->delete();
    return response()->json(['message' => 'Deleted']);
}
}
