<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮） - マイページ</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/my-sheet.css') }}">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="{{ asset('js/header.js') }}"></script>
</head>
<body>

    @include('header')

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto text-center">

            {{-- <p>id:{{ $user->id }}</p> --}}
            <div class="d-flex justify-content-center">
                <!-- アイコン -->
                <img class="w-25" src="{{ asset($user->user_info->icon) }}" alt="">
                <!-- ユーザーの名前 -->
                <a href="{{ asset('/user/show/' . $user->id) }}" class="px-3 text-dark text-decoration-none fs-5 text-break d-flex align-items-center">{{ $user->user_info->name }}</a>
            </div>

            <div class="row my-4">
                <!-- フォロー -->
                <a href="{{ asset('/user/follow/' . $user->id) }}" class="col d-block text-dark text-decoration-none footer-link">
                    <p class="d-inline mr-2">フォロー</p>
                    <p class="d-inline m-2">{{ $follow_count }}</p>
                </a>
                <!-- フォロワー -->
                <a href="{{ asset('/user/follower/' . $user->id) }}" class="col text-dark text-decoration-none footer-link">
                    <p class="d-inline mr-2">フォロワー</p>
                    <p class="d-inline m-2">{{ $follower_count }}</p>
                </a>
            </div>

            <!-- 評価 -->
            <div class="my-4">
                <div class="row">
                    <div class="col"><a href="{{ asset('/user/assessment/customer/'. $user->id) }}" class="text-decoration-none link-dark">購入者評価</a></div>
                    @if (round($user->seller_assessment->avg('point'), 1) == 0)
                        <p class="col">評価なし</p>
                    @else
                        <div class="col"><a href="{{ asset('/user/assessment/customer/'. $user->id) }}" class="link-dark">
                            <div class="Stars" style="--rating: {{ round($user->seller_assessment->avg('point'), 1) }};" aria-label="Rating of this product is 3.5 out of 5.">
                                <p class="d-inline">{{ round($user->seller_assessment->avg('point'), 1) }}</p>
                            </div>
                        </a></div>
                    @endif
                </div>
                <div class="row">
                <div class="col"><a href="{{ asset('/user/assessment/seller/'. $user->id) }}" class="text-decoration-none link-dark">販売者評価</a></div>
                    @if (round($user->customer_assessment->avg('point'), 1) == 0)
                        <p class="col">評価なし</p>
                    @else
                    <div class="col"><a href="{{ asset('/user/assessment/seller/'. $user->id) }}" class="link-dark">
                        <div class="col Stars" style="--rating: {{ round($user->customer_assessment->avg('point'), 1) }};" aria-label="Rating of this product is 4.3 out of 5.">
                            <p class="d-inline">{{ round($user->customer_assessment->avg('point'), 1) }}</p>
                        </div>
                    </a></div>
                    @endif
                </div>
            </div>

            <!-- 個人情報 -->
            <div class="my-4">
                <div class="row">
                    <div class="col row">
                        <p class="col text-end w-25">メールアドレス</p>
                        <p class="col text-start w-25 text-break">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col row">
                        <p class="col text-end w-25">電話番号</p>
                        <p class="col text-start w-25">{{ $user->user_info->phone }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col row">
                        <p class="col text-end w-25">郵便番号</p>
                        <p class="col text-start w-25">{{ $user->user_info->post }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col row">
                        <p class="col text-end w-25">住所</p>
                        <p class="col text-start w-25 text-break">{{ $user->user_info->address }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col row">
                        <p class="col text-end w-25">性別</p>
                        <p class="col text-start w-25">
                            @if ($user->user_info->sex== 1)
                                男
                            @else
                                女
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col row">
                        <p class="col text-end w-25">生年月日</p>
                        <p class="col text-start w-25">{{ str_replace('-', '/', $user->user_info->birthday) }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col row">
                        <p class="col text-end w-25">身長</p>
                        <p class="col text-start w-25">
                            @if ($user->user_info->height)
                                {{ $user->user_info->height }} cm
                            @else
                                未入力
                            @endif
                        </p>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col row">
                        <p class="col text-end w-25">パスワード</p>
                        <p class="col text-start w-25 text-break">●●●●●●●●</p>
                    </div>
                </div> -->
            </div>

            <!-- リンク一覧 -->
            <div class="my-4 text-center">
                <div class="bg-lightgray w-75 my-3 mx-auto py-3 lightgray-link">
                    <a href="{{ asset('/user/exhibited/'. $user->id) }}" class="link-dark text-decoration-none d-block">出品中の商品</a>
                </div>
                <div class="bg-lightgray w-75 my-3 mx-auto py-3">
                    <a href="{{ asset('/user/purchased/'. $user->id) }}" class="link-dark text-decoration-none d-block">購入履歴</a>
                </div>
                <div class="bg-lightgray w-75 my-3 mx-auto py-3">
                    <a href="{{ asset('/user/sold/'. $user->id) }}" class="link-dark text-decoration-none d-block">販売履歴</a>
                </div>
                <div class="bg-lightgray w-75 my-3 mx-auto py-3">
                    <a href="{{ asset('/user/ordered/'. $user->id) }}" class="link-dark text-decoration-none d-block">着付け依頼履歴</a>
                </div>
                <div class="bg-lightgray w-75 my-3 mx-auto py-3">
                    <a href="{{ asset('/user/edit/'. $user->id) }}" class="link-dark text-decoration-none d-block">登録情報変更</a>
                </div>
            </div>
        </div>
    </div>

    @include('footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    {{-- <style>
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
    <br> --}}
    {{-- <p>id:{{ $user->id }}</p> --}}
    {{-- <a href="{{ asset('/user/show/' . $user->id) }}">{{ $user->user_info->name }}</a>
    <br>
    <a href="{{ asset('/user/follow/' . $user->id) }}">フォロー</a>{{ $follow_count }}
    <a href="{{ asset('/user/follower/' . $user->id) }}">フォロワー</a>{{ $follower_count }}
    <br>
    <span>購入者評価{{ round($user->seller_assessment->avg("point"), 1) }}</span>
    <div class="Stars" id="star" style="--rating: {{ round($user->seller_assessment->avg("point"), 1) }};"></div>
    <br>
    <span>販売者評価{{ round($user->customer_assessment->avg("point"), 1) }}</span>
    <div class="Stars" id="star" style="--rating: {{ round($user->customer_assessment->avg("point"), 1) }};"></div>
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
        <p>生年月日{{ str_replace('-', '/', $user->user_info->birthday) }}</p>
        <p>身長
            @if ($user->user_info->height)
                {{ $user->user_info->height }}
            @else
                未入力
            @endif
        </p>
    </div>
    <button onclick="location.href='{{ asset('/user/exhibited/'. $user->id) }}'">出品中商品</button>
    <br>
    <button onclick="location.href='{{ asset('/user/purchased/'. $user->id) }}'">商品購入履歴</button>
    <br>
    <button onclick="location.href='{{ asset('/user/sold/'. $user->id) }}'">商品販売履歴</button>
    <br>
    <button onclick="location.href='{{ asset('/user/ordered/'. $user->id) }}'">着付け依頼履歴</button>
    <br>
    <button onclick="location.href='{{ asset('/user/edit/'. $user->id) }}'">登録情報変更</button> --}}
</body>
</html>