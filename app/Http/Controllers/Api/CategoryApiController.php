<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\services\CategoryService;

class CategoryApiController extends Controller
{
    public $service;
    public function __construct(){
        $this->service = new CategoryService;
    }
    public function getCategoryAll(){
        return $this->service->get();
    }
}
