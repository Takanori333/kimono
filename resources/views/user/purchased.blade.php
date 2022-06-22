<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮）- 購入履歴</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>

    @include('header')

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto text-center">
            <h2 class="text-center py-5">購入履歴</h2>

            @if ($purchased_items->isNotEmpty())

            <!-- 商品一覧 -->
            <div class="text-center my-4 py-5">

                @foreach ($purchased_items as $purchased_item)

                <div class="w-75 row m-0 mx-auto my-4" style="box-shadow: rgba(67, 71, 85, 0.27) 0px 0px 0.25em, rgba(90, 125, 188, 0.05) 0px 0.25em 1em;">
                    <img src="{{ asset($purchased_item->item->item_photo->first()->path) }}" alt="" class="col-sm w-25 p-0">
                    <div class="col-sm-8">
                        <div class="mx-3 mt-5 mb-3 text-start">
                            <a href="{{ asset('/fleamarket/item/'. $purchased_item->item_id) }}" class="link-dark text-decoration-none h4">{{ $purchased_item->item_info->name }}</a>
                        </div>
                        <div class="row">
                            <p class="col m-3 text-start">￥{{ number_format($purchased_item->item_info->price) }}</p>
                            <p class="col m-3 text-start">{{ str_replace('-', '/', $purchased_item->created_at) }}</p>
                        </div>
                        <div class="text-end me-3 mb-3">
                            @if ($user->id == $purchased_item->buyer_id)
                            @switch($purchased_item->trade_status->status)
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
                            <label>販売者：</label>
                            <a href="{{ asset('/user/show/' . $purchased_item->item->user_id) }}" class="link-dark text-decoration-none">{{ $purchased_item->item->user_info->name }}</a>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>
            
            @else

            <!-- 商品購入歴が無い場合 -->
            <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                <p class="text-center text-secondary">商品を購入していません。</p>
            </div>

            @endif

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

    {{--
    <h1>購入履歴</h1>
    @if ($purchased_items->isNotEmpty())
    @foreach ($purchased_items as $purchased_item)
    <div>
        <img src="{{ asset($purchased_item->item->item_photo->first()->path) }}" alt="">
        <br>
        <a href="{{ asset('/fleamarket/item/'. $purchased_item->item_id) }}">{{ $purchased_item->item_info->name }}</a>
        <p>{{ number_format($purchased_item->item_info->price) }}円</p>
        <p>購入日時：{{ str_replace('-', '/', $purchased_item->created_at) }}</p>
        <span>販売者：</span>
        <a href="{{ asset('/user/show/' . $purchased_item->item->user_id) }}">{{ $purchased_item->item->user_info->name }}</a>
        @if ($user->id == $purchased_item->buyer_id)
        @switch($purchased_item->trade_status->status)
        @case(0)
        <p>発送待ち</p>
        @break
        @case(1)
        <p>発送済み</p>
        @break
        @default --}}
        {{-- 何も表示しない --}}
        {{--
        @endswitch
        @endif
    </div>
    @endforeach
    @else
    <p>商品を購入していません</p>
    @endif
    --}}

    @include('footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>