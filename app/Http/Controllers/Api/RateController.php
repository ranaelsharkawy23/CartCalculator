<?php

namespace App\Http\Controllers\Api;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Rate;
use App\Http\Requests\ShippingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index()
    {
        $shippingRates = Rate::all();
        return $shippingRates;
    }
    
    public function store(ShippingRequest $request)
    {
        $validatedData = $request->validated();
        $shippingRate = new Rate($validatedData);
        $shippingRate->save();
        return response()->json(['message' => 'Shipping rate created successfully', 'data' => $shippingRate]);
    }
    
    public function update(ShippingRequest $request, $id)
    {
        $shippingRate = Rate::findOrFail($id);
        $shippingRate->update($request->validated());
        return response()->json(['message' => 'Shipping rate updated successfully', 'data' => $shippingRate]);
    }
}
