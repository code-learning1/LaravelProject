<?php
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::get('files/{path}', function ($path) {
    abort_unless(Storage::disk('public')->exists($path), 404);
    return response()->file(Storage::disk('public')->path($path));})->where('path', '.*');
