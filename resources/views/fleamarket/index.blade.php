<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマトップ</title>
</head>
<body>
    {{-- ヘッダー --}}
    {{-- @include(); --}}

    {{-- フリマヘッダー --}}
    <div>
        {{-- 検索窓 --}}
        <div>
            <p>検索</p>
            <form action="/fleamarket/search" method="GET">
                <input type="text" name="keyword">
                <input type="submit" value="🔍">
            </form>
        </div>
        {{-- 出品ボタン --}}
        <a href="{{asset("/fleamarket/exhibit/new")}}">出品</a>
    </div>

    {{-- 商品一覧 --}}
    {{-- 絞り込み機能 --}}
    <div>
        <p>販売商品のみを表示</p>
        <p>カテゴリ</p>
        <p>ソート</p>
    </div>
    {{-- 表示件数 --}}
    <div>
        <p>○件中○件表示</p>
    </div>
    {{-- 商品カード --}}
    <div>
        @isset( $msg )
            {{ $msg }}
        @endisset
        @foreach ( $item_infos as $item_info )
            <a href="{{asset('fleamarket/item/' . $item_info['id'] )}}">
                <div>
                    <img src="{{asset($item_info["image"][0]["path"])}}">
                    <p> 商品名: {{ $item_info["name"] }}</p>
                    <p> 値段: {{ $item_info["price"] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</body>
</html>