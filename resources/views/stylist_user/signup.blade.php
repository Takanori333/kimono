<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ asset('/stylist_user/signup_DB') }}" method="post" enctype="multipart/form-data">
        @csrf
        email<input type="email" name="email">
        <br>
        name<input type="text" name="name">
        <br>
        birthday<input type="number" name="year">y<input type="number" name="month">m<input type="number" name="day">d
        <br>
        sex<input type="radio" name="sex" value="1">男性 <input type="radio" name="sex" value="0">女性
        <br>
        phone<input type="text" name="phone">
        <br>
        post<input type="text" name="post">
        <br>
        address<textarea name="address" id="" cols="30" rows="10"></textarea>
        <br>
        icon<input type="file" name="icon">
        <br>
        password<input type="password" name="password">
        <br>
        password_c<input type="password">
        <br>
        <button>サインアップ</button>
    </form>
</body>
</html>