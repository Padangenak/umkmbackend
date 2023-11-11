<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductService
{
    public function get()
    {
        $categories = Category::get();
        $datas = collect([]);

        $popularAll = Product::where('active', 'On')->with([
            'user'=>function($user){
                $user->where('active', 'On');
            }
        ])
        ->with('attachment')
        ->with('category')
        ->get()
        ->sortByDesc('count');

        return ProductResource::collection($popularAll);
    }
    public function getDetail($id){
        $product = Product::with([
            'variant'=>function($variant){
                $variant->with('attachment');
            }
        ])
        ->with([
            'user'=>function($user){
                $user->with('attachment');
            }
        ])
        ->with('attachment')
        ->with('category')
        ->find($id);

        return new ProductResource($product);
    }
    public function productCount($id){
        $product = Product::find($id);
        Product::find($id)->update([
            'count'=>$product->count+1
        ]);

        return response()->json('Berhasil', 200);
    }
}
