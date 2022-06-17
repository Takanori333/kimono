<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_info()
    {
        return $this->hasOne(User_info::class, "id");
    }

    public function customer_assessment()
    {
        return $this->hasMany(Customer_assessment::class, "to_id");
    }

    public function seller_assessment()
    {
        return $this->hasMany(Seller_assessment::class, "to_id");
    }

    public function getAverageSellerPoint()
    {
        // 販売者の合計評価点の初期値
        $all_seller_point = 0;
        $count = 0;

        // 販売者の評価点を取り出し、all_seller_pointに加算
        foreach ($this->seller_assessment as $seller_assessment)
        {
            $all_seller_point += $seller_assessment->point;
            $count++;
        }

        // 評価がされていないとき、countが0なのでエラーがでる
        if ($count) {
            // 販売者の平均評価の計算
            $average_seller_point = round($all_seller_point / $count, 1);
        } else {
            $average_seller_point = 0;
        }

        return $average_seller_point;
    }

    public function getAverageCustomerPoint()
    {
        // 販売者の合計評価点の初期値
        $all_customer_point = 0;
        $count = 0;

        // 販売者の評価点を取り出し、all_customer_pointに加算
        foreach ($this->customer_assessment as $customer_assessment)
        {
            $all_customer_point += $customer_assessment->point;
            $count++;
        }

        // 評価がされていないとき、countが0なのでエラーがでる
        if ($count) {
            // 販売者の平均評価の計算
            $average_customer_point = round($all_customer_point / $count, 1);
        } else {
            $average_customer_point = 0;
        }

        return $average_customer_point;
    }

    

}
