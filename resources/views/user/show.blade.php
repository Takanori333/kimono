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
    <br>
    <h2>商品一覧</h2>
    <a href="{{ asset('/user/sold/'. $user->id) }}">過去の商品を見る</a>
    @if ($exhibited_items->isNotEmpty())
        @foreach ($exhibited_items as $exhibited_item)
            <div>
                <img src="{{ asset($exhibited_item->item_photo->first()->path) }}" alt="">
                <br>
                <a href="{{ asset('/fleamarket/item/'. $exhibited_item->id) }}">{{ $exhibited_item->item_info->name }}</a>
                <p>{{ number_format($exhibited_item->item_info->price) }}円</p>
            </div>
        @endforeach
    @else
        <p>出品している商品はありません</p>
    @endif
</body>
</html>