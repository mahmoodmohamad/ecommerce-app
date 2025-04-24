<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    //
    public function index()
    {
        $items = Cart::with('product', 'variant')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $variant = null;

        if ($validated['variant_id']) {
            $variant = Variant::where('product_id', $product->id)
                              ->findOrFail($validated['variant_id']);
            if ($variant->stock < $validated['quantity']) {
                return response()->json(['message' => 'Not enough stock for selected variant'], 422);
            }
        } else {
            if ($product->stock < $validated['quantity']) {
                return response()->json(['message' => 'Not enough product stock'], 422);
            }
        }

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'variant_id' => $validated['variant_id'] ?? null,
            ],
            [
                'quantity' => $validated['quantity']
            ]
        );

        return response()->json($cartItem, 201);
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $stock = $cartItem->variant
            ? $cartItem->variant->stock
            : $cartItem->product->stock;

        if ($validated['quantity'] > $stock) {
            return response()->json(['message' => 'Not enough stock available'], 422);
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json($cartItem);
    }

    public function destroy($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed']);
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Cart cleared']);
    }
}
