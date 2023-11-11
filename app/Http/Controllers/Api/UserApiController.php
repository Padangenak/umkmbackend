<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserApiController extends Controller
{
    public $service;
    public function __construct(){
        $this->service = new UserService;
    }
    public function userCurrentProduct($id){
        return $this->service->detail($id);
    }
}
