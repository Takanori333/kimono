<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap"
        rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>晴 re 着 - 商品購入確認</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
</head>
<body>
    {{-- ヘッダー --}}
    @include('header');

    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto">

            <div class="row mt-5">

                {{-- 商品画像 --}}
                <div class="col-sm-6">
                    @foreach ( $item_info["image"] as $image )
                    <img src="{{asset($image['path'])}}" class="d-block w-100 ob-fit-cont item-img-size-500 mb-2" alt="">
                    @endforeach
                </div>

                <!-- 詳細 -->
                <div class="col-sm-6 p-5">
                    @isset( $msg )
                    {{ $msg }}
                    @endisset
                    @foreach ($errors->all() as $error)
                    <p class="text-danger">{{$error}}</p>
                    @endforeach

                    {{-- 商品名 --}}
                    <p class="fs-4">{{ $item_info["name"] }}</p>
                    {{-- 値段 --}}
                    <p class="fs-5 d-inline">￥{{ $item_info["price"] }}</p>
                    <!-- <p class="d-inline">（送料：￥400）</p> -->
                    <!-- <p>税込</p> -->
                    <div class="my-3 row">
                        <p class="me-2 col-sm-2 m-1">お届け先</p>
                        <div class="col-sm">
                            <p class="mb-0" id="buyer_name">{{ $payment_way['buyer_name'] }}</p>
                            <p class="mb-0" id="buyer_post">〒{{ $payment_way['buyer_post'] }}</p>
                            <p class="mb-0" id="buyer_address">{{ $payment_way['buyer_address'] }}</p>
                        </div>
                    </div>
                    
                    <div class="my-3 row">
                        <p class="me-2 col-sm-2 m-1 pe-0">お支払方法</p>
                        <div class="col-sm mt-1">
                            <p class="mb-0">{{ $payment_way['payment_way'] }}</p>
                        </div>
                    </div>
                    
                    <form action="/fleamarket/purchase/done/{{$item_info['id']}}" method="POST">
                        @csrf
                        <input type="hidden" name="buyer_name" id="hidden_buyer_name" value="{{ $payment_way['buyer_name'] }}">
                        <input type="hidden" name="buyer_post" id="hidden_buyer_post" value="{{ $payment_way['buyer_post'] }}">
                        <input type="hidden" name="buyer_address" id="hidden_buyer_address" value="{{ $payment_way['buyer_address'] }}">
                        <input type="hidden" name="payment_way" id="hidden_payment_way" value="{{ $payment_way['payment_way'] }}">
                        <div class="d-grid gap-2">
                            <button name="back" type="submit" value="true" class="btn btn-secondary rounded-0">戻る</button>
                            <button name="buy" type="submit" value="true" class="btn btn-secondary rounded-0">購入</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

    @include('footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>