<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Product_attachment extends Model
{
    use HasFactory, HasUlids;
    protected $fillable = ['filename', 'path', 'type', 'product_id'];

}
