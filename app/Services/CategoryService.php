<?php

namespace App\Services;

use App\Models\Category;
// use App\Models\Product;
use App\Http\Resources\CategoryResource;

class CategoryService
{
    public function get()
    {
        $categories = Category::with([
            'product'=>function($product){
                $product->with('user')->with('attachment')->with('category')->orderByDesc('count');
                // $product->with('user');
            }
        ])->get();
        
        return CategoryResource::collection($categories);
    }
}
