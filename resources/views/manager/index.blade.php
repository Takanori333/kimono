<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>管理ページ</h1>
    <button onclick="location.href='{{ asset('/manager/user') }}'">ユーザー管理</button>
    <br>
    <button onclick="location.href='{{ asset('/manager/item') }}'">商品管理</button>
    <br>
    <button onclick="location.href='{{ asset('/manager/stylist') }}'">スタイリスト管理</button>
    <br>
    <button onclick="location.href='{{ asset('/manager/faq') }}'">FAQ管理</button>
</body>
</html>