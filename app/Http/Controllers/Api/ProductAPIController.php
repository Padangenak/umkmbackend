<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductAPIController extends Controller
{
    public function getProductAll(){
        $popularFood = Product::where('active', 'On')->with([
            'user'=>function($user){
                $user->where('active', 'On');
            }
        ])->with('attachment')->where('type', 'Makanan/Satuan/pcs')->get()->sortByDesc('count');
        $food = collect([...$popularFood]);
        $popularItem = Product::where('active', 'On')->with([
            'user'=>function($user){
                $user->where('active', 'On');
            }
        ])->with('attachment')->where('type', 'Barang/Buah/Item')->get()->sortByDesc('count');
        $item = collect([...$popularItem]);
        $popularAll = Product::where('active', 'On')->with([
            'user'=>function($user){
                $user->where('active', 'On');
            }
        ])->with('attachment')->get()->sortByDesc('count');
        $all = collect([...$popularAll]);
        return [
            'food'=>$food,
            'item'=>$item,
            'all'=>$all,
        ];
    }
    public function productId($id){
        return Product::with([
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
        ->find($id);
    }
    public function productCount($id){
        $product = Product::find($id);
        Product::find($id)->update([
            'count'=>$product->count+1
        ]);
    }
}
