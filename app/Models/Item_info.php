<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_info extends Model
{
    use HasFactory;

    // public function item()
    // {
    //     return $this->belongsTo(Item::class, "id");
    // }
    protected $guarded = ['created_at','updated_at']; // 書き込み禁止
}
