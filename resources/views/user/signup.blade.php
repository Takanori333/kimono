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
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
            <br>
        @endforeach
    @endif
    <form action="{{ asset('/user/signup_DB') }}" method="post" enctype="multipart/form-data">
        @csrf
        名前
        <input type="text" name="name" value="{{ old('name') }}">
        <br>
        メールアドレス
        <input type="text" name="email" value="{{ old('email') }}">
        <br>
        メールアドレス確認
        <input type="text" name="email_confirmation" value="{{ old('email_confirmation') }}">
        <br>
        電話番号
        <input type="text" name="phone" value="{{ old('phone') }}">
        <br>
        性別
        <input type="radio" name="sex" value="1" checked>男
        <input type="radio" name="sex" value="0">女
        <br>
        生年月日
        <input type="text" name="year" value="{{ old('year') }}" placeholder="年">
        <input type="text" name="month" value="{{ old('month') }}" placeholder="月">
        <input type="text" name="day" value="{{ old('day') }}" placeholder="日">
        {{-- <select name="year" id="">
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
        </select>日 --}}
        <br>
        郵便番号
        <input type="text" name="post" value="{{ old('post') }}">
        <br>
        住所
        <textarea name="address" id="" cols="30" rows="10">{{ old('address') }}</textarea>
        <br>
        身長
        <input type="text" name="height" value="{{ old('height') }}">
        <br>
        パスワード
        <input type="text" name="password">
        <br>
        パスワード確認
        <input type="text" name="password_confirmation">
        <br>
        アイコン
        <input type="file" name="icon">
        <br>
        <input type="submit" name="signup" value="登録">
    </form>
</body>
</html>