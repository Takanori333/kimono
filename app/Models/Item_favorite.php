<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_favorite extends Model
{
    use HasFactory; 
    protected $guarded = ['created_at','updated_at']; // 書き込み禁止
}
