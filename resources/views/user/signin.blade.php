<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>サインイン</h1>
    {{ $msg }}
    <form action="{{ asset('/user/signin_DB') }}" method="post">
        @csrf
        <input type="text" name="email"><br>
        <input type="text" name="password"><br>
        <input type="submit" name="singin" id="" value="サインイン">
    </form>
    <span>アカウントをお持ちでない場合</span>
    <a href="{{ asset('/user/signup') }}">アカウントを作成する</a>
</body>
</html>