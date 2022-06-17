<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        @charset "UTF-8";
        :root {
        --star-size: 30px;
        --star-color: #fff;
        --star-background: #fc0;
        }

        .Stars {
        --percent: calc(var(--rating) / 5 * 100%);
        display: inline-block;
        font-size: var(--star-size);
        font-family: Times;
        line-height: 1;
        }
        .Stars::before {
        content: "★★★★★";
        letter-spacing: 3px;
        background: linear-gradient(90deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        }

        /* body {
        background: #eee;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        } */

        * {
        position: relative;
        box-sizing: border-box;
        }
    </style>

    <img src="{{ asset($user->user_info->icon) }}" alt="">
    <br>
    {{-- <p>id:{{ $user->id }}</p> --}}
    <a href="{{ asset('/user/show/' . $user->id) }}">{{ $user->user_info->name }}</a>
    <br>
    <a href="{{ asset('/user/follow/' . $user->id) }}">フォロー</a>{{ $follow_count }}
    <a href="{{ asset('/user/follower/' . $user->id) }}">フォロワー</a>{{ $follower_count }}
    <br>
    <span>購入者評価{{ $average_seller_point }}</span>
    <div class="Stars" id="star" style="--rating: {{ $average_seller_point }};"></div>
    <br>
    <span>販売者評価{{ $average_customer_point }}</span>
    <div class="Stars" id="star" style="--rating: {{ $average_customer_point }};"></div>
    <div>
        <p>メールアドレス{{ $user->email }}</p>
        <p>電話番号{{ $user->user_info->phone }}</p>
        <p>郵便番号{{ $user->user_info->post }}</p>
        <p>住所{{ $user->user_info->address }}</p>
        <p>性別
            @if ($user->user_info->sex== 1)
                男
            @else
                女
            @endif
        </p>
        <p>生年月日{{  str_replace('-', '/', $user->user_info->birthday) }}</p>
        <p>身長
            @if ($user->user_info->height)
                {{ $user->user_info->height }}
            @else
                未入力
            @endif
        </p>
    </div>
    <a href="{{ asset('/user/exhibited/'. $user->id) }}">出品中商品</a>
    <br>
    <a href="{{ asset('/user/purchased/'. $user->id) }}">商品購入履歴</a>
    <br>
    <a href="{{ asset('/user/sold/'. $user->id) }}">商品販売履歴</a>
    <br>
    <a href="{{ asset('/user/ordered/'. $user->id) }}">着付け依頼履歴</a>
    <br>
    <a href="{{ asset('/user/edit/'. $user->id) }}">登録情報変更</a>
</body>
</html>