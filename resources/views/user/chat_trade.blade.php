<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item_name }}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
    <link href="{{ asset('css/bootcss/css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <script src="{{ asset('js/bootjs/js/bootstrap.bundle.min.js') }}"  crossorigin="anonymous"></script>
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/socketio.js') }}"></script>
</head>
<body>
    @php
        $user = unserialize(session()->get("user"));
        $user_id = $user->id;
        $self_info = $user_id==$buyer_info->id?$buyer_info:$seller_info;
        $other_info = $user_id!=$buyer_info->id?$buyer_info:$seller_info;
    @endphp
    <div class="vh-100 min-vh-100 min-vw-100 vw-100 position-relative overflow-hidden">
        <div class="row">
            <div class="col-12 col-lg-2 col-md-2 col-sm-2 col-xl-2 col-xxl-2" style="height: 1px"></div>
            <div class="col-12 col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xxl-8  vh-100 min-vh-100 " style="padding-top: 40px;padding-bottom:40px">
                <div class="border-secondary border" style="width: 100%;height: 100%">
                    <div class="row border-secondary border-bottom d-flex align-items-end" style="height: 7%;max-height: 100px;width: 100%;margin:0;justify-content: space-between;align-content: center;">
                        <a class="d-flex text-decoration-none link-secondary  h5" href="{{ asset("/user/show/".$other_info->id) }}" style="width:auto;margin:0px" target="_blank">
                            <img src="{{ asset("$other_info->icon") }}" width="25" height="25" style="border-radius: 50%"><p style="margin-left:5px;margin-bottom:0px">{{ $other_info->name }}</p>
                        </a>
                        <a class="link-secondary  h5" href="{{ asset("/fleamarket/item/".$item_id) }}"  style="width:auto;margin:0px" target="_blank">{{ $item_name }}</a>
                    </div>
                    <div class="row border-secondary border-bottom" style="height: 61%;margin:0;display:block;overflow-y:auto;overflow-x:hidden" id="message_box">
                        @foreach ($message_list as $message)
                            @if ($message->from==$user_id)
                                <div class="self">
                                    <div class="inner_div">
                                        <pre>{{ $message->text }}</pre>
                                    </div>    
                                </div>
                            @else
                                <div class="other_side">
                                    <img src="{{ asset("$other_info->icon") }}" width="0" height="0" style="border-radius: 50%; height: 30px; width: 30px;">
                                    <div class="inner_div">
                                        <pre>{{ $message->text }}</pre>
                                    </div>  
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row border-secondary border-bottom" style="height: 7%;max-height: 100px;margin: 0;display: flex;justify-content: flex-end;">
                        @if ($self_info==$seller_info&&$status=='0')
                            <button class="btn btn-outline-secondary" style="max-width: 120px;height: 80%;max-height: 40px;position: relative;padding: 0;margin: 0;align-self: center;font-size: 15px;margin-right:20px" onclick='changeTradeStatus("{{ asset("/change_trade_status/".$item_id) }}","{{ csrf_token() }}",this)'>発送済み</button> 
                        @endif
                        @if ($self_info==$buyer_info&&$status=='1')
                            <button class="btn btn-outline-secondary" style="max-width: 120px;height: 80%;max-height: 40px;position: relative;padding: 0;margin: 0;align-self: center;font-size: 15px;margin-right:20px" onclick='changeTradeStatus("{{ asset("/change_trade_status/".$item_id) }}","{{ csrf_token() }}",this)'>受け取り済み</button>
                        @endif
                        <button class="btn btn-outline-secondary" style="width: 20%;max-width: 80px;height: 80%;max-height: 40px;position: relative;padding: 0;margin: 0;align-self: center;font-size: 15px;margin-right:20px" onclick="sendMsg()">送信</button>
                    </div>
                    <div class="row" style="height: 25%;margin:0">
                        <textarea class="form-control h-100" style="resize: none;padding: 3px" id="message" placeholder="ここに入力してください"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="self_id" value="{{ $self_info->id}}">
    <input type="hidden" id="other_side_id" value="{{ $other_info->id}}">
    <input type="hidden" id="item_id" value="{{ $item_id}}">
    <input type="hidden" id="csrf" value="{{ csrf_token() }}">
    <input type="hidden" id="url" value="{{ asset('/chat/insert_trade') }}">
    <script>         
        let other_side_icon = '{{ asset("$other_info->icon") }}';
    </script>
    <script src="{{ asset('js/socket_trade.js') }}"></script>
</body>
</html>