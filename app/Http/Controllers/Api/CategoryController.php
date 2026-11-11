<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()  { return response()->json(Category::all()); }

    public function store(Request $request)
{
    $data = $request->validate([
        'category_name' => 'required|max:50',
        'description'   => 'nullable|max:255',
        'image'         => 'required|image',
    ]);
    $data['image'] = $request->file('image')->store('categories', 'public');
    return response()->json(Category::create($data), 201);
}

public function show(Category $category) { return response()->json($category); }

public function update(Request $request, Category $category)
{
    $data = $request->validate([
        'category_name' => 'required|max:50',
        'description'   => 'nullable|max:255',
        'image'         => 'nullable|image',
    ]);
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('categories', 'public');
    }
    $category->update($data);
    return response()->json($category);
}

public function destroy(Category $category)
{
    $category->delete();
    return response()->json(['message' => 'Deleted']);
}
}
