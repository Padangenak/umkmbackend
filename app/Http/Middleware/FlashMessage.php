<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Middleware;

class FlashMessage extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function share(Request $request)
    {
         return array_merge(parent::share($request), [
            'flash' => [
                'err' => session('err'),
                'message' => session('message'),
                'data' => session('data')
            ],
        ]);
    }
}
