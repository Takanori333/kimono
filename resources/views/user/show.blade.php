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

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto text-center">

            <div class="row my-4">
                <div class="col-1 p-0 d-flex align-items-center">
                    <!-- アイコン -->
                    <img src="{{ asset($user->user_info->icon) }}" alt="" class="w-100 img-fluid">
                </div>
                {{-- <p>id:{{ $user->id }}</p> --}}
                <!-- ユーザ名 -->
                <div class="col d-flex align-items-center fs-3">{{ $user->user_info->name }}</div>
                <div class="col d-flex align-items-center justify-content-end">
                    {{-- {{ $follow_flg }} --}}
                    {{-- アクセスしたユーザーがフォローしているかを確認 --}}
                    @if ($follow_flg == "myself")
                    {{-- ユーザーがアクセスしたユーザー自身の時は何も表示しない --}}
                    @elseif ($follow_flg == "follow")
                    {{-- フォローしていないときはフォローボタンの表示 --}}
                    <button value="{{ $page_user_id }}" id="{{ $page_user_id }}" name="follow" class="btn btn-secondary">フォローする</button>
                    @elseif ($follow_flg == "unfollow")
                    {{-- フォローしているときは解除ボタンの表示 --}}
                    <button value="{{ $page_user_id }}" id="{{ $page_user_id }}" name="unfollow" class="btn btn-outline-secondary">解除</button>
                    @elseif ($follow_flg == "guest")
                    {{-- ログイン状態でないときは何も表示しない --}}
                    @endif
                </div>
            </div>

            <div class="row my-4">
                <!-- フォロー -->
                <a href="{{ asset('/user/follow/' . $user->id) }}" class="col d-block text-dark text-decoration-none">
                    <p class="d-inline mr-2">フォロー</p>
                    <p class="d-inline m-2" name="follow_count" id="follow_count">{{ $follow_count }}</p>
                </a>
                <!-- フォロワー -->
                <a href="{{ asset('/user/follower/' . $user->id) }}" class="col text-dark text-decoration-none">
                    <p class="d-inline mr-2">フォロワー</p>
                    <p class="d-inline m-2" name="follower_count" id="follower_count">{{ $follower_count }}</p>
                </a>
            </div>

            <!-- 評価 -->
            <div class="my-4">
                <div class="row">
                    <div class="col"><a href="{{ asset('/user/assessment/customer/'. $user->id) }}" class="text-decoration-none link-dark">購入者評価</a></div>
                    @if (round($user->customer_assessment->avg("point"), 1) == 0)
                    <p class="col">評価なし</p>
                    @else
                    <div class="col">
                        <a href="{{ asset('/user/assessment/customer/'. $user->id) }}" class="link-dark">
                            <div class="Stars" style="--rating: {{ round($user->customer_assessment->avg('point'), 1) }};" aria-label="Rating of this product is 3.5 out of 5.">
                                <p class="d-inline">{{ number_format(round($user->customer_assessment->avg('point'), 1), 1) }}</p>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col">
                        <a href="{{ asset('/user/assessment/seller/'. $user->id) }}" class="text-decoration-none link-dark">販売者評価</a>
                    </div>
                    @if (round($user->seller_assessment->avg('point'), 1) == 0)
                    <p class="col">評価なし</p>
                    @else
                    <div class="col">
                        <a href="{{ asset('/user/assessment/seller/'. $user->id) }}" class="link-dark">
                            <div class="col Stars" style="--rating: {{ round($user->seller_assessment->avg('point'), 1) }};" aria-label="Rating of this product is 4.3 out of 5.">
                                <p class="d-inline">{{ number_format(round($user->seller_assessment->avg('point'), 1), 1) }}</p>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 商品一覧 -->
            <div class="">
                <h4>商品一覧</h4>

                <a href="{{ asset('/user/sold/'. $user->id) }}" class="text-end d-flex justify-content-end link-secondary text-decoration-none">過去の商品を見る</a>

                @if ($exhibited_items->isNotEmpty())

                <div class="row">
                    <span class="col-sm-4 w-25"></span>
                    <span class="col-sm-4 w-25"></span>
                    <span class="col-sm-4 w-25"></span>

                    @foreach ($exhibited_items as $exhibited_item)

                    <div class="col-sm-4 my-4">
                        <a href="{{ asset('/fleamarket/item/'. $exhibited_item->id) }}" class="col d-block text-decoration-none">
                            <img src="{{ asset($exhibited_item->item_photo->first()->path) }}" alt="" class="w-100 ob-fit item_img_size">
                            <p class="text-dark text-start mt-3 mb-2">{{ $exhibited_item->item_info->name }}</p>
                            <p class="text-dark text-start">￥{{ number_format($exhibited_item->item_info->price) }}</p>
                        </a>
                    </div>

                    @endforeach

                </div>

                <!-- ページネーション -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link border-0" href="#" aria-label="Previous">
                                <span aria-hidden="true" class="link-secondary">&#8249;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link link-secondary border-0" href="#">1</a></li>
                        <li class="page-item"><a class="page-link link-secondary border-0" href="#">2</a></li>
                        <li class="page-item"><a class="page-link link-secondary border-0" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link border-0" href="#" aria-label="Next">
                                <span aria-hidden="true" class="link-secondary">&#8250;</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                @else

                <!-- 出品中の商品がない場合 -->
                <p class="text-secondary my-5" style="height: 200px;">出品中の商品はありません。</p>

                @endif

            </div>

        </div>
    </div>

    @include('footer')

    <!-- <img src="{{ asset($user->user_info->icon) }}" alt="">
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
    <button value="{{ $page_user_id }}" id="{{ $page_user_id }}" name="unfollow">解除</button>
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
    @endif -->

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
                } else if (name = "unfollow") {
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>