<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img src="{{ asset($user->user_info->icon) }}" alt="">
    <p>{{ $user->user_info->name }}</p>
    <a href="">フォロー</a>
    <a href="">フォロワー</a>
    <p>購入者評価{{ $average_seller_point }}</p>
    <p>販売者評価{{ $average_customer_point }}</p>
    <p>メールアドレス{{ $user->user_info->email }}</p>
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
    <p>生年月日{{ $user->user_info->birthday }}</p>
    <p>身長
        @if ($user->user_info->height)
            {{ $user->user_info->height }}
        @else
            未入力
        @endif
    </p>
    <a href="">出品中商品</a>
    <br>
    <a href="">商品購入履歴</a>
    <br>
    <a href="">商品販売履歴</a>
    <br>
    <a href="">着付け依頼履歴</a>
    <br>
    <a href="">登録情報変更</a>
</body>
</html>