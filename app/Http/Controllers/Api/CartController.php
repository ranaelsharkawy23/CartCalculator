<?php

namespace App\Http\Controllers\Api;
 use App\Models\Cart;
 use App\Models\Product;
 use App\Models\Rate;
 use App\Models\Discount;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Requests\ShippingRequest;
use App\Http\Requests\DiscountRequest;
use Illuminate\Http\Request;
 
class CartController extends Controller
{
    public function index()
    {
        return Cart::with('products')->get();
    }
    public function store(CartRequest $request)
    {
        $products = $request->input('products'); // Array of ['product_id' => id, 'quantity' => qty]

        // Create a new Cart
        $cart = Cart::create(); // Assuming Cart model has necessary fields and logic for creation

        foreach ($products as $productData) {
            $product = Product::find($productData['product_id']);
            if ($product) {
                // Attach product to cart
                $cart->products()->attach($product->id, ['quantity' => $productData['quantity']]);
            } else {
                return response()->json(['error' => 'Product not found', 'product_id' => $productData['product_id']], 404);
            }
        }

        return response()->json([
            'message' => 'Products added to cart',
            'items' => $cart->products,
            'calculation' => $this->getCartDetails($cart->id)
        ]);
    }

    public function destroy(Cart $cart){
        $cart->delete();
        return [
            'message'=>'deleted'
        ];
    }
    public function update(Cart $cart,Request $request){
      
        $cart->update($request->all());
        return $cart;
        
    }



    public function getCartDetails($cartId)
    {
        // Retrieve the cart with its products using the cart ID
        $cart = Cart::with('products')->find($cartId); 
        // Calculate values based on the cart's products
        $subtotal = $this->calculateSubtotal($cart->products);
        $totalShipping = $this->calculateShipping($cart->products);
        $vat = $this->calculateVAT($subtotal);
        $discounts = $this->applyDiscount($cart, $totalShipping);
        $total = $subtotal + $totalShipping  + $vat -$discounts['totalDiscount'] ;
        
        // Return the detailed cart information
        return [
            'subtotal' => $subtotal,
            'shipping' => $totalShipping,
            'vat' => $vat,
            'discounts' => $discounts['details'] ,
            'total' => $total,
        ];
    }
    
    
    public function calculateSubtotal($products)
    {
       
        return $products->sum(function ($product) {
            return $product->Itemprice * $product->pivot->quantity;
            
        });
    }
    
    
    
    public function calculateShipping($cartItems)
    {
        $totalShipping = 0;
        foreach ($cartItems as $item) {
            // Access the product directly from the item
            $shippingRate = $this->getShippingRate($item['shippingfrom']);
            $totalShipping += $shippingRate * ($item['weight'] * 10); // Weight in grams
        }
        return $totalShipping;
    }
    



    public function applyDiscount($cart, $shippingCost)
    {
        // Initialize variables
        $total = 0;
        $appliedDiscountValue = 0;
        $appliedDiscount = [];
        $details=[];
        // Fetch all applicable discounts
        $discounts = Discount::all(); // Adjust if you have a way to filter relevant discounts
    
        foreach ($discounts as $discount) {
            // Check if the discount condition is met
            if ($this->checkCondition($discount, $cart)) {
               $total= $cart->products->sum(function ($product) {
                     return $product->Itemprice * $product->pivot->quantity;
                    
                });
          
                $discountValue = 0;
                // Apply discount based on 'applyon' field
                $discountItem = $cart->products->filter(function ( $item) use($discount){
                    return strtolower($item->Itemtype) == strtolower($discount->applyon);
                })->values()->first();

                if($discountItem)
                {
                    if ($discount->type === 'percentage') {
                        $discountValue = ($discount->value / 100) *$discountItem->Itemprice;
                    } elseif ($discount->type === 'fixed') {
                        $discountValue = $discount->value;
                    }
                    $appliedDiscountValue += $discountValue;
                    array_push($details, [
                        'value' => -$discountValue,
                        'description' => $discount->description
                    ]);

                }

                  
                if ($discount->applyon === 'shipping') {

                    if ($discount->type === 'percentage') {
                        return $discountValue = ($discount->value / 100) *$shippingCost;
                    } elseif ($discount->type === 'fixed') {
                        $discountValue = $discount->value;
                    }

                // Assuming you have a shipping cost in the cart
                $appliedDiscountValue += $discountValue;
                   // $cart->totalShipping = max(0, $shippingCost); // Ensure shipping cost doesn't go negative
                     // Adjust the total price
                     array_push($details, [
                        'value' => -$discountValue,
                       'description' => $discount->description
                    ]);
                }
    
                // Track the applied discount value and set as the applied discount
                array_push($appliedDiscount, $discount); // Record the discount that was applied
    
                
            }
        }
    

       
        return [
            'totalDiscount' => $appliedDiscountValue,
            'applied_discount' => $appliedDiscount,
            'details'=>$details
        ];
    }
    






   
    
   private function checkCondition($discount, $cart)
   {
    $matchedCondition = $cart->products->filter(function ( $item) use($discount){
        return strtolower($item->category?->name) == strtolower($discount->condition);
    })->values();

    if($matchedCondition && $matchedCondition->count()*$matchedCondition->sum('pivot.quantity') >= $discount->min_items)
    {
        return true;
    }elseif($discount->condition == 'shipping' && $cart->products->count()*$cart->products->sum('pivot.quantity') > $discount->min_items){
        return true;
    }

    return false;


}
   



    

    public function getShippingRate($shippedfrom)
    {
        $shippingRate = Rate::where('country', $shippedfrom)->first();
        
        return $shippingRate ? $shippingRate->rate : 0;
    }

    private function calculateVAT($subtotal)
    {
        return $subtotal * 0.14;
    }



}