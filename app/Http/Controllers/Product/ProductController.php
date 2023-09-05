<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Variant_attachment;
use App\Models\Product_attachment;
use App\Models\Variant;
use App\Models\Product;
use App\Traits\ImageTrait;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class ProductController extends Controller
{
    use ImageTrait;
    public function current(){
        $product = Product::with([
            'variant'=>function($variant){
                $variant->with('attachment');
            }
        ])
        ->orderBy('id', 'DESC')
        ->where('user_id', Auth::user()->id)->get();
        // dd($product);
        return Inertia::render('product/current',[
            'product'=>$product
        ]);
    }
    public function currentActive($id){
        $product = Product::find($id);
        Product::find($id)->update([
            'active'=>$product->active == 'On' ? 'Off' : 'On'
        ]);

        return Product::orderBy('id', 'DESC')->get();
    }
    public function add(){
        return Inertia::render('product/add');
    }
    public function addLoading(ProductRequest $request){
        $user = Auth::user()->id;
        // dd($user);
        $add = $request->add($user, $request);
        if($add != false){
            return redirect()->route('editProduct', ['id'=>$add->id]);
        }else{
            return back();
        }   
    }
    public function attachmentproduct($id, $variantId){
        $attachment = Variant::with('attachment')->find($variantId);
        return Inertia::render('product/attachment',[
            'attachment'=>$attachment
        ]);
    }
    public function attachmentUpload(Request $request, $id, $variantId){
        $variant = Variant::find($variantId)->update([
            'variant'=>$request['variant'],
        ]);
        if (isset($request['image'])) {
            foreach($request['image'] as $image){
                $filename = $this->resize($image);
                $explode = explode('.', $filename->basename);
                Variant_attachment::create([
                    'filename'=>$filename->basename,
                    'path'=>'/images/',
                    'type'=>$explode[1],
                    'variant_id'=>$variantId,
                ]);
            }
        }
        
        return Variant::with('attachment')->find($variantId);
    }
    public function editProduct($id){
        // dd($id);
        return Inertia::render('product/edit/index', [
            'product'=>Product::with('attachment')->with([
                'variant'=>function($variant){
                    $variant->with('attachment');
                }
            ])->findOrFail($id)
        ]);
    }
    public function imageDelete(Request $request, $id, $variantId){
        // dd(Storage::delete('/images/'.$request->params['filename']));
        Storage::disk('public')->delete('images\\'.$request->params['filename']);
        $attachment = Variant_attachment::find($request->params['id'])->delete();

        return Variant::with('attachment')->find($variantId);
    }
    public function variantAdd($id){
        $newVariant = Variant::create([
            'variant'=>null,
            'product_id'=>$id
        ]);

        return to_route('attachmentproduct', [$id, $newVariant->id]);
    }
    public function variantDelete($id, $variantId){
        $variant = Variant::with('attachment')->find($variantId);
        foreach($variant->attachment as $attachmentVariantUnit){
            $attachment = Variant_attachment::find($attachmentVariantUnit->id);
            Storage::disk('public')->delete('images\\'.$attachment->filename);
            $attachment->delete();
        }
        $variant->delete();
        return Product::with([
            'variant'=>function($variant){
                $variant->with('attachment');
            }
        ])->find($id);
    }
    public function newVariant(Request $request, $id){
        variant::create([
            "variant"=>$request->params['value'],
            "product_id"=>$id
        ]);

        return Product::with([
            'variant'=>function($variant){
                $variant->with('attachment');
            }
        ])->find($id);
    }
    public function editProductId(Request $request, $id){
        $product = Product::find($id);
        Product::find($id)->update([
            'product'=>$request->product != null ? $request->product : $product->product,
            'type'=>$request->type != null ? $request->type : $product->type,
            'price'=>$request->price != null ? $request->price : $product->price,
            'discon'=>$request->discon != null ? $request->discon : $product->discon,
            'description'=>$request->description != null ? $request->description : $product->description,
            'active'=>$request->active != null ? $request->active : $product->active,
        ]);

        if($request->attachment != null){
            $image = $this->resize($request->attachment);
            $explode = explode('.', $image->basename);

            Product_attachment::where('product_id', $id)->update([
                'path'=>'/images/',
                'type'=>$explode[1],
                'filename'=>$image->basename,
                'product_id'=>$product->id,
            ]);
        }

        return back()->with('message', "Data Berhasil Diedit");
    }
    public function productDelete($id){
        $product = Product::with('attachment')->with([
            'variant'=>function($variant){
                $variant->with('attachment');
            }
        ])->find($id);
        foreach($product->variant as $variant){
            foreach($variant->attachment as $attachment){
                if (Storage::disk('public')->exists('images\\'.$attachment->filename)) {
                    Storage::disk('public')->delete('images\\'.$attachment->filename);
                }
            }
        }
        Storage::disk('public')->delete('images\\'.$product->attachment->filename);
        Variant::where('product_id', $id)->delete();
        Product::find($id)->delete();

        return Product::with([
            'variant'=>function($variant){
                $variant->with('attachment');
            }
        ])
        ->orderBy('id', 'DESC')
        ->where('user_id', Auth::user()->id)->get();
    }
}
