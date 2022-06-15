<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>新規登録</h1>
    <form action="{{ asset('/user/signup_DB') }}" method="post">
        @csrf
        名前
        <input type="text" name="name">
        <br>
        メールアドレス
        <input type="text" name="email">
        <br>
        メールアドレス確認
        <input type="text" name="emai_confirmation">
        <br>
        電話番号
        <input type="text" name="phone">
        <br>
        性別
        <input type="radio" name="sex" value="1" checked>男
        <input type="radio" name="sex" value="0">女
        <br>
        生年月日
        <select name="year" id="">
            @for ($year = 1900; $year <= date("Y"); $year++)
                <option value="{{ $year }}">{{ $year }}</option>
            @endfor
        </select>年
        <select name="month" id="">
            @for ($month = 1; $month <= 12; $month++)
                <option value="{{ $month }}">{{ $month }}</option>
            @endfor
        </select>月
        <select name="day" id="">
            @for ($day = 1; $day <= 31; $day++)
                <option value="{{ $day }}">{{ $day }}</option>
            @endfor
        </select>日
        <br>
        郵便番号
        <input type="text" name="post">
        <br>
        住所
        <textarea name="address" id="" cols="30" rows="10"></textarea>
        <br>
        身長
        <input type="text" name="height">
        <br>
        パスワード
        <input type="text" name="password">
        <br>
        パスワード確認
        <input type="text" name="password_confirmation">
        <br>
        <input type="submit" name="signup" value="登録">
    </form>
</body>
</html>