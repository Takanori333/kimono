<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stylist_history extends Model
{
    use HasFactory;

    public function stylist()
    {
        return $this->belongsTo(Stylist::class);
    }

    public function stylist_info()
    {
        return $this->belongsTo(Stylist_info::class, "stylist_id", "id");
    }
}
