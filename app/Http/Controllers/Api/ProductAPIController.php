<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;

class ProductAPIController extends Controller
{
    public $service;
    public function __construct(){
        $this->service = new ProductService;
    }
    public function getProductAll(){
        return $this->service->get();
    }
    public function productId($id){
        return $this->service->getDetail($id);
    }
    public function productCount($id){
        return $this->service->productCount($id);
    }
}
