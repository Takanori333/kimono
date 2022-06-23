<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品購入確認</title>
</head>
<body>
    {{-- ヘッダー --}}
    {{-- @include(); --}}

    {{-- フリマヘッダー --}}
    <div>
        <div>
            {{-- タイトル --}}
            <h1>商品購入確認</h1>
            <p>検索</p>
            <form action="/fleamarket/search" method="GET">
                <input type="text" name="keyword">
                <input type="submit" value="🔍">
            </form>
        </div>
        {{-- お気に入り商品閲覧ページ --}}
        @if ( session('user') )
            <a href="{{asset("/fleamarket/favorite")}}">お気に入り商品</a>
        @endif
        {{-- 出品ボタン --}}
        <a href="{{asset("/fleamarket/exhibit/new")}}">出品</a>
    </div>

    {{-- 商品購入 --}}
    <div>
        @isset( $msg )
            {{ $msg }}
        @endisset
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        {{-- 商品画像 --}}
        <div>
            @foreach ( $item_info["image"] as $image )
                <img src="{{asset($image["path"])}}">
            @endforeach
        </div>
        {{-- 商品情報, 購入ボタン, お気に入りボタン, チャット --}}
        <div>
            {{-- 商品情報, 購入・お気に入りボタン --}}
            <div>
                {{-- 商品名 --}}
                <p>{{ $item_info["name"] }}</p>
                {{-- 値段 --}}
                <p>￥{{ $item_info["price"] }}</p>




                {{-- お届け先 --}}
                <p>お届け先</p>
                <p id="buyer_name">お名前:{{ $payment_way['buyer_name'] }}</p>
                <p id="buyer_post">郵便番号:{{ $payment_way['buyer_post'] }}</p>
                <p id="buyer_address">住所:{{ $payment_way['buyer_address'] }}</p>



                {{-- お支払い方法 --}}
                <p>お支払い方法:{{ $payment_way['payment_way'] }}</p>





                <form action="/fleamarket/purchase/done/{{$item_info['id']}}" method="POST">
                    @csrf
                    <input type="hidden" name="buyer_name" id="hidden_buyer_name" value="{{ $payment_way['buyer_name'] }}">
                    <input type="hidden" name="buyer_post" id="hidden_buyer_post" value="{{ $payment_way['buyer_post'] }}">
                    <input type="hidden" name="buyer_address" id="hidden_buyer_address" value="{{ $payment_way['buyer_address'] }}">
                    <input type="hidden" name="payment_way" id="hidden_payment_way" value="{{ $payment_way['payment_way'] }}">
                    <button name="back" type="submit" value="true">戻る</button>
                    <button name="buy" type="submit" value="true">購入</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>