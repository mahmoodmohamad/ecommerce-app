<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
class CouponController extends Controller
{
    //
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found'], 404);
        }

        if ($coupon->expires_at && now()->greaterThan($coupon->expires_at)) {
            return response()->json(['message' => 'Coupon expired'], 400);
        }

        if ($coupon->usage_limit && $coupon->used >= $coupon->usage_limit) {
            return response()->json(['message' => 'Coupon usage limit reached'], 400);
        }

        return response()->json([
            'discount_amount' => $coupon->discount_amount,
            'discount_percent' => $coupon->discount_percent
        ]);
    }
}
