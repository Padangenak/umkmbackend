<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function detail($id)
    {
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

        return new UserResource($user);
    }
}
