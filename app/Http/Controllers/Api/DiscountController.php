<?php

namespace App\Http\Controllers\Api;
use App\Models\Cart;
use App\Models\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'value' => 'required|numeric',
            'applyon' => 'required|string',  // e.g., 'product', 'shipping'
            'condition' => 'nullable|string',
            'type' => 'required|string'  // e.g., 'percentage', 'fixed'
        ]);

        $discount = Discount::create($request->all());

        return response()->json($discount, 201);
    }
    public function destroy($id)
    {
        // Find the discount by ID or fail if not found
        $discount = Discount::findOrFail($id);
    
        // Delete the discount
        $discount->delete();
    
        // Return a successful response
        return response()->json(['message' => 'Discount deleted successfully.'], 200);
    }


}
