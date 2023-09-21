<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductAPIController extends Controller
{
    public function getProductAll(){
        $food = collect([]);
        $item = collect([]);
        $popularAll = Product::where('active', 'On')->with([
            'user'=>function($user){
                $user->where('active', 'On');
            }
        ])->with('attachment')->get()->sortByDesc('count');
        $all = collect([]);
        foreach($popularAll as $unit){
            if($unit->user){
                if ($unit->type == "Barang/Buah/item") {
                    $food->push($unit);
                    $all->push($unit);
                }elseif($unit->type == "Makanan/Satuan/pcs"){
                    $item->push($unit);
                    $all->push($unit);
                }
            }
        }
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
    public function getPaginateAll($id){
        $product = Product::find($id);
        Product::find($id)->update([
            'count'=>$product->count+1
        ]);
    }
}
