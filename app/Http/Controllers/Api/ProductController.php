<?php

namespace App\Http\Controllers\Api;
use App\Models\Product;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    public function assign(Request $request)
    {
    
        $cart->products()->syncWithoutDetaching([
            $request['product_id'] 
        ]);
        return $product->load('products');
    }
    public function index_Cart(Product $product){
        return $product->cart;
    }
    public function index(){
        return ProductResource::collection(Product::with(['cart'])->get());
    }
    public function store(ProductRequest $request){
        $validated=$request->validated();
        $product=Product::create($validated);
        return $product;
    }
    public function show(Product $product){
        return new ProductResource($product);
    }
    public function destroy(Product $product){
        $product->delete();
        return [
            'message'=>'deleted'
        ];
    }
    public function update(Product $product,ProductRequest $request){
      
        $requestData = $request->validated();
        $product->update(collect($requestData)->except('carts')->toArray());
        if(isset($requestData['carts']))
        {
            // $tags = Tag::whereIn('name', $requestData['tags'])->pluck('id');
            $carts = [];
            foreach($requestData['carts'] as $cart)
            {
                $createdcart = Cart::firstOrCreate(['name' => $cart]);
                array_push($carts, $createdcart->id);

            }
            $product->carts()->sync($carts);
        }
      
        return new ProductResource($product->load('carts'));
    }
}
