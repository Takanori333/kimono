<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>出品中の商品</h1>
    <a href="{{ asset('/fleamarket/exhibit/new') }}">出品する</a>
    <p>{{ $msg }}</p>
    @if ($exhibited_items->isNotEmpty())
        @foreach ($exhibited_items as $exhibited_item)
            <div>
                <img src="{{ asset($exhibited_item->item_photo->first()->path) }}" alt="">
                <br>
                <a href="{{ asset('/fleamarket/item/'. $exhibited_item->id) }}">{{ $exhibited_item->item_info->name }}</a>
                <p>{{ number_format($exhibited_item->item_info->price) }}円</p>
                <a href="{{ asset('/fleamarket/item/edit/'. $exhibited_item->id) }}">編集する</a>
                <a href="{{ asset('/user/exhibited/delete/'. $exhibited_item->id) }}">削除する</a>
            </div>
        @endforeach
    @else
        <p>出品している商品はありません</p>
    @endif
</body>
</html>