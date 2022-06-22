<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade_status extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at','updated_at']; // 書き込み禁止
}
