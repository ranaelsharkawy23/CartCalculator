<?php

namespace App\Http\Controllers\Api;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::with('products')->get();
    }
    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function destroy(Category $category){
        $category->delete();
        return [
            'message'=>'deleted'
        ];
    }
    public function update(Category $category,Request $request){
      
        $category->update($request->all());
        return $category;
        
       }



}
