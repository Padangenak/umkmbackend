<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Variant extends Model
{
    use HasFactory, HasUlids;
    protected $fillable = ['variant', 'product_id'];

    public function attachment(){
        return $this->hasMany(Variant_attachment::class, 'variant_id');
    }
}
