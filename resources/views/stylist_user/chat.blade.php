<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チャット</title>
    <link href="{{ asset('css/bootcss/css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
    <script src="{{ asset('js/bootjs/js/bootstrap.bundle.min.js') }}"  crossorigin="anonymous"></script>
    <script src="{{ asset('/js/socketio.js') }}"></script>
    <script src="{{ asset('/js/jquery.js') }}"></script>

</head>
<body>
    @php
        $stylist = unserialize(session()->get("stylist"));
    @endphp
    @if ($customer_list->isEmpty())
        @include('stylist_user.header')
    <div class="p-5 mb-4  rounded-3 " style="height: 500px">
        <div class="container-fluid py-5 text-center">
          <h1 class="display-5 fw-bold" style="color:#7a7a7a;">顧客からのメッセージはありません</h1>
        </div>
    </div>
      @include('stylist_user.footer')

      @else
    <div class="vh-100 min-vh-100 min-vw-100 vw-100 position-relative overflow-hidden">
        <div class="row">
            <div class="position-absolute start-0 top-0 col-12 col-lg-2 col-md-2 col-sm-2 col-xl-2 col-xxl-2" style="padding: 0">
               <div class="dropdown ">
                  <a class="btn btn-outline-secondary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            顧客一覧
                        </a>
                        <ul class="dropdown-menu vh-100 min-vh-100 fixed-top w-100 overflow-auto" aria-labelledby="dropdownMenuLink" id="customer_list_box">
                        </ul>
                </div>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-3 col-xl-3 col-xxl-3" style="height: 1px"></div>
            <div class="col-12 col-lg-8 col-md-8 col-sm-8 col-xl-8 col-xxl-8  vh-100 min-vh-100 " style="padding-top: 40px">
                <div class="border-secondary border" style="width: 100%;height: 100%">
                    <div class="row border-secondary border-bottom d-flex align-items-end " style="height: 7%;max-height: 100px;width: 100%;margin:0;align-content: center;" id="customer_info">
                        {{-- <a class="d-flex">
                            <img src="http://192.168.10.209:8000/image/default.png" width="25" height="25" style="border-radius: 50%"><p>test</p>
                        </a> --}}
                    </div>
                    <div class="row border-secondary border-bottom" style="height: 61%;margin:0;display:block;overflow-y:auto;overflow-x:hidden" id="message_box"></div>
                    <div class="row border-secondary border-bottom" style="height: 7%;max-height: 100px;margin: 0;display: flex;justify-content: flex-end;">
                        <button class="btn btn-outline-secondary" style="max-width: 120px;height: 80%;max-height: 40px;position: relative;padding: 0;margin: 0;align-self: center;font-size: 15px;margin-right:20px" onclick="open_reverse()">予約を作る</button>
                        <button class="btn btn-outline-secondary" style="width: 20%;max-width: 80px;height: 80%;max-height: 40px;position: relative;padding: 0;margin: 0;align-self: center;font-size: 15px;margin-right:20px" onclick="sendMsg()">送信</button>
                    </div>
                    <div class="row form-floating" style="height: 25%;margin:0">
                        <textarea class="form-control h-100" style="resize: none;padding: 3px" id="message" placeholder="ここに入力"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="h-100 w-100" style="z-index: 100;background:#cccfd3ba;position:fixed;top:0;display:none" id="reverse">
        <div class="row">
            <form id="reverse_form">
            <div class="start-50  position-absolute translate-middle-x border secondary col-10 col-xxl-4 col-lg-4 col-md-4 col-sm-4 col-xl-4" style="padding: 30px;margin-top: 50px;margin-bottom: 50px;background: white;box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">
                    <div style="display: flex;justify-content: end">
                        <a class="link-danger" href="javascript:void(0);" onclick="close_reverse()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                              </svg>
                        </a>
                    </div>
                    <div class="container gap-1 d-grid">
                        <div class="mb-3 row">
                            <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label" id="reserve_name"></label>
                        </div>
                        <div class="mb-3 row">
                            <div class="alert-danger"></div>
                            <label for="exampleInputEmail1" class="form-label">予約時間：</label>
                            <div class="row">
                                <input type="datetime-local" class="col-5 form-control-sm" id="start_time">
                                <h6 class="col-2 text-center">~</h6>
                                <input type="datetime-local" class="col-5 form-control-sm" id="end_time">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="row" >
                                <div class="col-auto">
                                    <label for="inputPassword6" class="col-form-label">サービスメニュー：</label>
                                </div>
                                <div class="col-auto" style="place-content: center;">
                                    <select class="form-select" aria-label="Default select example" onchange="insert_service(this)" id="service_select" >
                                        <option value="0" selected disabled>メニュー追加</option>
                                        @foreach ($service as $s)
                                            <option value="{{ $s }}">{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex flex-wrap border secondary" id="service_area" ></div>
                        </div>
                        <br>
                        <div class="mb-3 row">
                            <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="col-form-label col-3" style="word-break: keep-all;">料金：</label>
                            <div class="col-9">
                                <input type="number" class="form-control" id="price">
                            </div>
                        </div>                    
                        <div class="row text-center flex" style="justify-content: center">
                            <button type="button" class="btn btn-outline-primary" style="width: 200px;" onclick="make_reserve('{{ asset('/make_reserve') }}')">予約</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    
    <input type="hidden" id="stylist_id" value="{{ $stylist->getId() }}">
    {{-- <input type="hidden" id="customer_id" value="9999999"> --}}
    <input type="hidden" id="csrf" value="{{ csrf_token() }}">
    <input type="hidden" id="url" value="{{ asset('/chat/insert_stylist') }}">
    <script>
        let customer_list_url = "{{ asset('/stylist_user/get_customer') }}";
        let customer_csrf = "{{  csrf_token()  }}";
    </script>
    <script src="{{ asset('js/socket_stylist_user.js') }}"></script>        
    @endif

</body>
</html>