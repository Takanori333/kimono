<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮）- 販売履歴</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap"
        rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>

    @include('header')

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto text-center">
            <h2 class="text-center py-5">販売履歴</h2>

            <!-- 商品一覧 -->
            <div class="text-center my-4 py-5">

                <div class="w-75 row m-0 mx-auto my-4" style="box-shadow: rgba(67, 71, 85, 0.27) 0px 0px 0.25em, rgba(90, 125, 188, 0.05) 0px 0.25em 1em;">
                    <img src="./images/jeans-1161035_960_720.jpg" alt="" class="col-sm w-25 p-0">
                    <div class="col-sm-8">
                        <div class="mx-3 my-5 text-start">
                            <a href="" class="link-dark text-decoration-none h4">商品名商品名商品名商品名商品名商品名商品</a>
                        </div>
                        <div class="row">
                            <p class="col m-3 text-start">￥9,999,999</p>
                            <p class="col m-3 text-start">2022/01/01</p>
                        </div>
                        <div class="text-end me-3">
                            <label>購入者：</label>
                            <a href="" class="link-dark text-decoration-none">購入者名購入者名購入者名購入者名購入者名</a>
                        </div>
                    </div>
                </div>

                <div class="w-75 row m-0 mx-auto my-4" style="box-shadow: rgba(67, 71, 85, 0.27) 0px 0px 0.25em, rgba(90, 125, 188, 0.05) 0px 0.25em 1em;">
                    <img src="./images/animal_kuma.png" alt="" class="col-sm w-25 p-0">
                    <div class="col-sm-8">
                        <div class="mx-3 my-5 text-start">
                            <a href="" class="link-dark text-decoration-none h4">商品名</a>
                        </div>
                        <div class="row">
                            <p class="col m-3 text-start">1,000 円</p>
                            <p class="col m-3 text-start">2022/01/01</p>
                        </div>
                        <div class="text-end me-3">
                            <label>購入者：</label>
                            <a href="" class="link-dark text-decoration-none">購入者名</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 商品販売歴が無い場合 -->
            <!-- <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                <p class="text-center text-secondary">商品を販売していません。</p>
            </div> -->

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

        </div>
    </div>

    @include('footer')
    <h1>販売履歴</h1>
    @if ($sold_items->isNotEmpty())
        @foreach ($sold_items as $sold_item)
            <div>
                <img src="{{ asset($sold_item->item_photo->first()->path) }}" alt="">
                <br>
                <a href="{{ asset('/fleamarket/item/'. $sold_item->id) }}">{{ $sold_item->item_info->name }}</a>
                <p>{{ number_format($sold_item->item_info->price) }}円</p>
                <p>販売日時：{{ str_replace('-', '/', $sold_item->item_history->created_at) }}</p>
                <span>購入者：</span>
                <a href="{{ asset('/user/show/' . $sold_item->user_id) }}">{{ $sold_item->item_history->user_info->name }}</a>
                {{-- ログイン状態であるか確認 --}}
                @if ($access_user)
                    {{-- 出品者か購入者であるか確認 --}}
                    @if ($access_user->id == $sold_item->user_id || $access_user->id == $sold_item->item_history->buyer_id)
                        {{-- 商品のやり取りの状態で表示を変える --}}
                        @switch($sold_item->trade_status->status)
                            @case(0)
                                <p>発送待ち</p>
                                @break
                            @case(1)
                                <p>発送済み</p>
                                @break                            
                            @default
                                {{-- 何も表示しない --}}
                        @endswitch
                    @endif
                @endif
            </div>
        @endforeach
    @else
        <p>商品を販売していません</p>
    @endif
</body>
</html>