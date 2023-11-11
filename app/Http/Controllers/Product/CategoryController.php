<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(){
        $category = Category::get();

        return Inertia::render('product/category/list',[
            'categoris'=>$category
        ]);
    }
    public function delete($id){
        Product::where('category_id', $id)->update([
            'active'=>'off'
        ]);

        Category::find($id)->delete();
        $category = Category::get();

        return redirect()->route('productCategory')->with('message', "Katagori berhasil dihapus")->with('data', $category);
    }
    public function add(Request $request){
        Category::create([
            'category'=>$request->category
        ]);
        $category = Category::get();

        return redirect()->route('productCategory')->with('message', "Katagori berhasil ditambakan")->with('data', $category);
    }
    public function edit(Request $request, $id){
        // dd("asd");  
        Category::find($id)->update([
            'category'=>$request->category
        ]);
        $category = Category::get();
        return redirect()->route('productCategory')->with('message', "Katagori berhasil diubah")->with('data', $category);
    }
}
