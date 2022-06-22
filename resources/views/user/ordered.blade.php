<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>着付け依頼履歴</h1>
    {{-- <p>{{ now() }}</p> --}}
    @if ($order_histories->isNotEmpty())
        @foreach ($order_histories as $order_history)
            <div>
                <a href="{{ asset('/stylist/show/' . $order_history->stylist_id) }}">{{ $order_history->stylist_info->name }}</a>
                <p>{{ $order_history->services }}</p>
                <p>{{ str_replace('-', '/', $order_history->created_at) }}</p>
                <p>{{ number_format($order_history->price) }}円</p>
                @if (now() >= $order_history->end_time)
                    <form action="">
                        評価
                        <select name="point" id="">
                            @for ($i=1;$i<=5;$i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <br>
                        <input type="comment">
                        <input type="submit" value="評価する">
                    </form>
                @endif
            </div>
        @endforeach
    @else
        <p>着付けを依頼していません</p>
    @endif
</body>
</html>