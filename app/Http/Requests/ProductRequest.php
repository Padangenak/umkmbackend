<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ImageTrait;
use App\Models\Product;
use App\Models\Product_attachment;

class ProductRequest extends FormRequest
{
    use ImageTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product'=>'required',
            'type'=>'required',
            'price'=>'required|numeric',
            'discon'=>'required|numeric|min:0|max:100',
            'description'=>'required|string',
            'attachment'=>'required'
        ];
    }
    public function add($user){
        // dd($this->validated());
        $image = $this->resize($this->validated()['attachment']);
        $explode = explode('.', $image->basename);

        $product = Product::create([
            'product'=>$this->validated()['product'],
            'price'=>$this->validated()['price'],
            'discon'=>$this->validated()['discon'],
            'description'=>$this->validated()['description'],
            'type'=>$this->validated()['type']['name'],
            'active'=>'On',
            'user_id'=>$user,
        ]);

        $attachment = Product_attachment::create([
            'path'=>'/images/',
            'type'=>$explode[1],
            'filename'=>$image->basename,
            'product_id'=>$product->id,
        ]);
        return $product;

    }
}
