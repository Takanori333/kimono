<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_follower extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    // user_idを入れると、そのユーザーのフォロワー数(そのユーザーの事をフォローしているユーザーの人数)を返す
    public function getFollowerCount($id)
    {
        $follower_count = $this->where("follow_id", $id)->count();
        
        return $follower_count;
    }

    // user_idを入れると、そのユーザーのフォロワー数(そのユーザーの事をフォローしているユーザーの人数)を返す
    public function getFollowCount($id)
    {
        $follow_count = $this->where("follower_id", $id)->count();
        
        return $follow_count;
    }
    
    // public function user()
    // {
    //     return $this->belongsTo(User::class, "follower_id");
    // }

    // public function user_info()
    // {
    //     return $this->belongsTo(User_info::class, "follower_id", "id");
    // }
}
