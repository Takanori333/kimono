<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/socket.io/2.0.3/socket.io.js"></script>
    <script src="{{ asset('/js/jquery.js') }}"></script>
</head>
<body>
    <div class="vh-100 min-vh-100 min-vw-100 vw-100 position-relative overflow-hidden">
        <div class="row">
            <div class="position-absolute start-0 top-0 col-12 col-lg-2 col-md-2 col-sm-2 col-xl-2 col-xxl-2" style="padding: 0">
               <div class="dropdown ">
                  <a class="btn btn-secondary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown link
                        </a>
                        <ul class="dropdown-menu vh-100 min-vh-100 fixed-top w-100 overflow-auto" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                        </ul>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-3 col-xl-3 col-xxl-3" style="height: 1px"></div>
            <div class="col-12 col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xxl-8  vh-100 min-vh-100 " style="padding-top: 40px">
                <div class="" style="width: 100%;height: 100%">
                    <div class="row border-warning border-bottom" style="height: 5%;max-height: 100px;width: 100%;margin:0"></div>
                    <div class="row border-warning border-bottom" style="height: 65%;margin:0;display:block" id="message_box"></div>
                    <div class="row border-warning border-bottom" style="height: 5%;max-height: 100px;margin:0">
                        <button  style="width: 20%;max-width: 80px;height: 80%;max-height: 40px;left: 80%;position: relative;padding: 0;margin: 0;align-self: center;font-size: 15px;" onclick="sendMsg()">send</button>
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
    <script src="{{ asset('js/socket_stylist_customer.js') }}"></script>
</body>
</html>