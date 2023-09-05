<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class User_attachment extends Model
{
    use HasFactory, HasUlids;
    protected $fillable = ['filename', 'path', 'type', 'user_id'];

}
