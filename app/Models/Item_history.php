<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_history extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at','updated_at']; // 書き込み禁止

    public function item_info()
    {
        return $this->belongsTo(Item_info::class, "item_id", "id");
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user_info()
    {
        return $this->belongsTo(User_info::class, "buyer_id");
    }

    public function trade_status()
    {
        return $this->hasOne(Trade_status::class, "item_id", "item_id");
    }

}
