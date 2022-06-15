<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{ $reserve->customer_id }}
    <br>
    {{ $reserve->address }}
    <br>
    {{ $reserve->start_time }}
    <br>
    {{ $reserve->end_time }}
    <br>
    {{ $reserve->services }}
    <br>
    {{ $reserve->count }}
    <br>
    {{ $reserve->price }}
    <br>
</body>
</html>