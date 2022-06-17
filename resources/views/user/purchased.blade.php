<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>購入履歴</h1>
    @if ($purchased_items->isNotEmpty())
        @foreach ($purchased_items as $purchased_item)
            <div>
                <img src="{{ asset($purchased_item->item->item_photo->first()->path) }}" alt="">
                <br>
                <a href="{{ asset('/fleamarket/item/'. $purchased_item->item_id) }}">{{ $purchased_item->item_info->name }}</a>
                <p>{{ number_format($purchased_item->item_info->price) }}円</p>
                <p>購入日時：{{ str_replace('-', '/', $purchased_item->created_at) }}</p>
                <span>販売者：</span>
                <a href="{{ asset('/user/show/' . $purchased_item->item->user_id) }}">{{ $purchased_item->item->user_info->name }}</a>
            </div>
        @endforeach
    @else
        <p>商品を購入していません</p>
    @endif
</body>
</html>