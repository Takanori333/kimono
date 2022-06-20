<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    {{-- {{ $follow_flg }} --}}
    {{-- アクセスしたユーザーがフォローしているかを確認 --}}
    @if ($follow_flg == "myself")
        {{-- ユーザーがアクセスしたユーザー自身の時は何も表示しない --}}
    @elseif ($follow_flg == "follow")
        {{-- フォローしていないときはフォローボタンの表示 --}}
        <button value="{{ $page_user_id }}" id="{{ $page_user_id }}" class="follow">フォローする</button>
    @elseif ($follow_flg == "unfollow")
        {{-- フォローしているときは解除ボタンの表示 --}}
        <button value="{{ $page_user_id }}" id="{{ $page_user_id }}" class="unfollow" >解除</button>
    @elseif ($follow_flg == "guest")
        {{-- ログイン状態でないときは何も表示しない --}}
    @endif
    <br>
    <a href="{{ asset('/user/follow/' . $user->id) }}">フォロー</a>
    <span name="follow_count" id="follow_count">{{ $follow_count }}</span>
    <a href="{{ asset('/user/follower/' . $user->id) }}">フォロワー</a>
    <span name="follower_count" id="follower_count">{{ $follower_count }}</span>
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
    <script>
        $(function(){
            $("button").click(function(){
                let class_name = $(this).attr("class");
                let follow_id = $(this).val();
                let follower_count = $("#follower_count").text();
                // フォローするボタンが押されたとき
                if (class_name == "follow") {
                    $.ajax({
                        type: "get",
                        url: "/user/follow_DB",
                        data: {"follow_id": follow_id},
                        dataType: "json"
                    }).done(function(data){
                        // ボタンを解除するボタンをに変更
                        $("#" + data.follow_id).removeClass('follow');
                        $("#" + data.follow_id).addClass('unfollow');
                        $("#" + data.follow_id).text("解除");
                        // フォロワー数を更新
                        $("#follower_count").text(Number(follower_count) + 1);
                    }).fail(function(XMLHttpRequest, textStatus, error){
                        console.log(error);
                    })
                // 解除するボタンが押されたとき
                } else {
                    $.ajax({
                        type: "get",
                        url: "/user/unfollow_DB",
                        data: {"follow_id": follow_id},
                        dataType: "json"
                    }).done(function(data){
                        // ボタンをフォローするボタンをに変更
                        $("#" + data.follow_id).removeClass('unfollow');
                        $("#" + data.follow_id).addClass('follow');
                        $("#" + data.follow_id).text("フォローする");
                        // フォロワー数を更新
                        $("#follower_count").text(Number(follower_count) - 1);
                    }).fail(function(XMLHttpRequest, textStatus, error){
                        console.log(error);
                    })
                }
            })
        })
    </script>
</body>
</html>