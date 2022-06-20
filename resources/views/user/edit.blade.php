<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>登録情報変更</h1>
    {{ $msg }}
    <div>
        <form action="{{ asset('/user/edit_DB') }}" method="post">
            @csrf
            名前
            <input type="text" value="{{ $user->user_info->name }}" name="name">
            <br>
            メールアドレス
            <input type="text" value="{{ $user->email }}" name="email">
            <br>
            電話番号
            <input type="text" value="{{ $user->user_info->phone }}" name="phone">
            <br>
            性別
            @if ($user->user_info->sex)
                <input type="radio" name="sex" value="1" checked>男
                <input type="radio" name="sex" value="0">女
            @else
                <input type="radio" name="sex" value="1">男
                <input type="radio" name="sex" value="0" checked>女
            @endif
            <br>
            生年月日
            <input type="text" value="{{ explode("-", $user->user_info->birthday)[0] }}" name="year">
            /
            <input type="text" value="{{ intval(explode("-", $user->user_info->birthday)[1]) }}" name="month">
            /
            <input type="text" value="{{ intval(explode("-", $user->user_info->birthday)[2]) }}" name="day">
            <br>
            郵便番号
            <input type="text" value="{{ $user->user_info->post }}" name="post">
            <br>
            住所
            <textarea name="address" id="" cols="30" rows="10">{{ $user->user_info->address }}</textarea>
            <br>
            身長
            <input type="text" value="{{ $user->user_info->height }}" name="height">
            <br>
            パスワード
            <input type="text" value="{{ $user->password }}" name="password">
            <br>
            <a href="{{ asset('/user/info/' . $user->id) }}">戻る</a>
            <input type="submit" name="signup" value="確定">
        </form>
    </div>
</body>
</html>