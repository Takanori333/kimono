<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_history extends Model
{
    use HasFactory;

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
}
