<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_attachment;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Variant_attachment;

class UserApiController extends Controller
{
    public function userCurrentProduct($id){
        $user = User::with([
            'product'=>function($product){
                $product->where('active', 'On');
                $product->with('attachment');
                $product->with([
                    'variant'=>function($variant){
                        $variant->with('attachment');
                    }
                ]);
            }
        ])
        ->with('attachment')
        ->find($id);
        return $user;
    }
}
