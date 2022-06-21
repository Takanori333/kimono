<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/bootcss/css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <script src="{{ asset('js/bootjs/js/bootstrap.bundle.min.js') }}"  crossorigin="anonymous"></script>
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/socketio.js') }}"></script>
</head>
<body>
    <div class="vh-100 min-vh-100 min-vw-100 vw-100 position-relative overflow-hidden">
        <div class="row">
            <div class="col-12 col-lg-2 col-md-2 col-sm-2 col-xl-2 col-xxl-2" style="height: 1px"></div>
            <div class="col-12 col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xxl-8  vh-100 min-vh-100 " style="padding-top: 40px;padding-bottom:40px">
                <div class="border-secondary border" style="width: 100%;height: 100%">
                    <div class="row border-secondary border-bottom d-flex align-items-end" style="height: 7%;max-height: 100px;width: 100%;margin:0">
                        <a class="d-flex text-decoration-none link-dark text-decoration-none h5" href="{{ asset("/stylist/show/".$stylist_info->id) }}">
                            <img src="{{ asset("$stylist_info->icon") }}" width="25" height="25" style="border-radius: 50%"><p> {{ $stylist_info->name }}</p>
                        </a>
                    </div>
                    <div class="row border-secondary border-bottom" style="height: 61%;margin:0;display:block;overflow-y:auto;overflow-x:hidden" id="message_box">
                        @foreach ($message_list as $message)
                            <div class='@if ($message->from==1)self @else other_side @endif'>
                                <div class="inner_div">
                                    <pre>{{ $message->text }}</pre>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row border-secondary border-bottom" style="height: 7%;max-height: 100px;margin:0">
                        <button class="btn btn-outline-secondary" style="width: 20%;max-width: 80px;height: 80%;max-height: 40px;left: 80%;position: relative;padding: 0;margin: 0;align-self: center;font-size: 15px;" onclick="sendMsg()">送信</button>
                    </div>
                    <div class="row form-floating" style="height: 25%;margin:0">
                        <textarea class="form-control h-100" style="resize: none;padding: 3px" id="message"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="stylist_id" value="9999999">
    <input type="hidden" id="customer_id" value="9999999">
    <input type="hidden" id="csrf" value="{{ csrf_token() }}">
    <input type="hidden" id="url" value="{{ asset('/chat/insert_stylist') }}">    
    <script>
        // let stylist_id = "{{ $stylist_info->id }}";
        // let stylist_name = "{{ $stylist_info->name }}";
        let stylist_icon = '{{ asset("$stylist_info->icon") }}';
    </script>
    <script src="{{ asset('js/socket_stylist_customer.js') }}"></script>
</body>
</html>