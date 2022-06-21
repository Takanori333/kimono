<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stylist extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function stylist_comment()
    {
        return $this->hasMany(Stylist_comment::class);
    }

    public function stylist_info()
    {
        return $this->hasOne(Stylist_info::class, "id");
    }

    public function stylist_area()
    {
        return $this->hasMany(Stylist_area::class);
    }

    
}
