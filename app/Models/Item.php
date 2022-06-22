<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function item_info()
    {
        return $this->hasOne(Item_info::class, "id");
    }

    public function item_photo()
    {
        return $this->hasMany(Item_photo::class);
    }

    public function user_info()
    {
        return $this->belongsTo(User_info::class, "user_id", "id");
    }

    public function item_history()
    {
        return $this->hasOne(Item_history::class);
    }

    public function trade_status()
    {
        return $this->hasOne(Trade_status::class);
    }

}
