<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($reserve_list as $reserve)
    <a href="{{ asset('/stylist_user/reserve_detail/'.$reserve->id) }}">
        <div>{{ $reserve->address }} {{ $reserve->start_time }}から{{ $reserve->end_time }}まで</div>
    </a>
    @endforeach
</body>
</html>