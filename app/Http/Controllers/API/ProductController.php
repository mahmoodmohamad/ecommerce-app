<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    //
    public function index()
    {
        return Product::with(['category'])->paginate(12);
    }

    // ✅ Get single product details
    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);
        return response()->json($product);
    }

    // ✅ Search products
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return $query->with('category')->paginate(12);
    }

    // ✅ Get featured products
    public function featured()
    {
        return Product::where('is_featured', true)
            ->latest()
            ->take(8)
            ->with('category')
            ->get();
    }

    // ✅ Get products by category ID
    public function byCategory($categoryId)
    {
        return Product::where('category_id', $categoryId)
            ->with('category')
            ->paginate(12);
    }
}
