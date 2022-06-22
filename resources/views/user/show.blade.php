<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮） - ユーザー</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- 星読み込み -->
    <link rel="stylesheet" href="{{ asset('css/star.css') }}">
</head>
<body>

    @include('header')

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
        <button value="{{ $page_user_id }}" id="{{ $page_user_id }}" name="follow">フォローする</button>
    @elseif ($follow_flg == "unfollow")
        {{-- フォローしているときは解除ボタンの表示 --}}
        <button value="{{ $page_user_id }}" id="{{ $page_user_id }}" name="unfollow" >解除</button>
    @elseif ($follow_flg == "guest")
        {{-- ログイン状態でないときは何も表示しない --}}
    @endif
    <br>
    <a href="{{ asset('/user/follow/' . $user->id) }}">フォロー</a>
    <span name="follow_count" id="follow_count">{{ $follow_count }}</span>
    <a href="{{ asset('/user/follower/' . $user->id) }}">フォロワー</a>
    <span name="follower_count" id="follower_count">{{ $follower_count }}</span>
    <br>
    <a href="{{ asset('/user/assessment/customer/'. $user->id) }}">購入者評価{{ round($user->customer_assessment->avg("point"), 1) }}</a>
    <div class="Stars" id="star" style="--rating: {{ round($user->customer_assessment->avg("point"), 1) }};"></div>
    <br>
    <a href="{{ asset('/user/assessment/seller/'. $user->id) }}">販売者評価{{ round($user->seller_assessment->avg("point"), 1) }}</a>
    <div class="Stars" id="star" style="--rating: {{ round($user->seller_assessment->avg("point"), 1) }};"></div>
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
        $(function() {
            $("button").click(function() {
                let name = $(this).attr("name");
                let follow_id = $(this).val();
                let follower_count = $("#follower_count").text();
                // フォローするボタンが押されたとき
                if (name == "follow") {
                    $.ajax({
                        type: "get",
                        url: "/user/follow_DB",
                        data: {
                            "follow_id": follow_id
                        },
                        dataType: "json"
                    }).done(function(data) {
                        // ボタンを解除するボタンに変更
                        $("#" + data.follow_id).attr("name", "unfollow");
                        $("#" + data.follow_id).attr("class", "btn btn-outline-secondary");
                        $("#" + data.follow_id).text("解除");
                        // フォロワー数を更新
                        $("#follower_count").text(Number(follower_count) + 1);
                    }).fail(function(XMLHttpRequest, textStatus, error) {
                        console.log(error);
                    })
                // 解除するボタンが押されたとき
                } else if (name="unfollow"){
                    $.ajax({
                        type: "get",
                        url: "/user/unfollow_DB",
                        data: {
                            "follow_id": follow_id
                        },
                        dataType: "json"
                    }).done(function(data) {
                        // ボタンをフォローするボタンに変更
                        $("#" + data.follow_id).attr("name", "follow");
                        $("#" + data.follow_id).attr("class", "btn btn-secondary");
                        $("#" + data.follow_id).text("フォローする");
                        // フォロワー数を更新
                        $("#follower_count").text(Number(follower_count) - 1);
                    }).fail(function(XMLHttpRequest, textStatus, error) {
                        console.log(error);
                    })
                }
            })
        })
    </script>
</body>
</html>