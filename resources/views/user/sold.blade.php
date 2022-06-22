<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>販売履歴</h1>
    @if ($sold_items->isNotEmpty())
        @foreach ($sold_items as $sold_item)
            <div>
                <img src="{{ asset($sold_item->item_photo->first()->path) }}" alt="">
                <br>
                <a href="{{ asset('/fleamarket/item/'. $sold_item->id) }}">{{ $sold_item->item_info->name }}</a>
                <p>{{ number_format($sold_item->item_info->price) }}円</p>
                <p>販売日時：{{ str_replace('-', '/', $sold_item->item_history->created_at) }}</p>
                <span>購入者：</span>
                <a href="{{ asset('/user/show/' . $sold_item->user_id) }}">{{ $sold_item->item_history->user_info->name }}</a>
                @if ($access_user)
                    @if ($access_user->id == $sold_item->user_id || $access_user->id == $sold_item->item_history->buyer_id)
                        @switch($sold_item->trade_status->status)
                            @case(0)
                                <p>発送待ち</p>
                                @break
                            @case(1)
                                <p>発送済み</p>
                                @break                            
                            @default
                                {{-- 何も表示しない --}}
                        @endswitch
                    @endif
                @endif
            </div>
        @endforeach
    @else
        <p>商品を販売していません</p>
    @endif
</body>
</html>