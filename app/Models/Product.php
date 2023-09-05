<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Product extends Model
{
    use HasFactory, HasUlids;
    protected $fillable = ['product', 'type', 'price', 'user_id','discon', 'description', 'active', 'count'];
    public function variant(){
        return $this->hasMany(Variant::class, 'product_id');
    }
    public function attachment(){
        return $this->hasOne(Product_attachment::class, 'product_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
