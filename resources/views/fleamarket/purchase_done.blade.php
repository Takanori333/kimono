<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>- 商品購入完了</title>
</head>
<body>
    {{-- ヘッダー --}}
    {{-- @include('header'); --}}

    {{-- フリマヘッダー --}}
    <div>
        <div>
            {{-- タイトル --}}
            <h1>商品購入完了</h1>
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

    {{-- 購入完了メッセージ --}}
    <div>
        <p>購入が完了しました。</p>
        <br>
        <p>発送・受取プロセスについては<br>販売者とのチャットをご覧ください</p>

        {{-- チャットへのボタン --}}
        <button onclick="location.href='{{asset('/user/trade_chat/' . $id)}}'">チャットへ</button>
    </div>

</body>
</html>