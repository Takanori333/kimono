<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/bootcss/css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
    <script src="{{ asset('js/bootjs/js/bootstrap.bundle.min.js') }}"  crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    {{ var_dump($reserve) }}
    <div class="h-100 w-100">
        <div class="row">
            <div class="start-50  position-absolute translate-middle-x border secondary col-10 col-xxl-4 col-lg-4 col-md-4 col-sm-4 col-xl-4" style="padding: 30px;margin-top: 50px;margin-bottom: 50px;background: white;box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;">                    
                    <div class="container gap-1 d-grid">
                        <form action="{{ asset('stylist/confirm') }}" method="POST">
                            @csrf
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                    <label for="exampleInputEmail1" class="form-label">名前：TEST</label>
                            </div>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">予約時間：</label>
                                <div class="row">
                                    {{ $reserve->start_time }}~{{ $reserve->end_time }}
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="row" >
                                    <div class="col-auto">
                                        <label for="inputPassword6" class="col-form-label">サービスメニュー：{{ $reserve->services }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="row" >
                                    <div class="col-2">
                                        <label for="inputPassword6" class="col-form-label">人数</label>
                                    </div>
                                    <div class="col-10" style="place-content: center;">
                                        <select class="form-select" aria-label="Default select example" name="count">
                                            <option selected>人数を選択してください</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="col-form-label col-2">場所</label>
                                <div class="col-10 ">
                                    <textarea class="form-control" id="floatingTextarea2" style="height: 100px;resize: none" name="address"></textarea>
                                </div>
                            </div>               
                            <div class="row text-center flex" style="justify-content: center">
                                <input type="hidden" name="reserve_id" value="{{ $reserve->reserve_id }}">
                                <button type="submit" class="btn btn-outline-primary" style="width: 200px;">Primary</button>
                            </div>    
                        </form>
                    </div>
            </div>
        </div>
    </div>
    
</body>
</html>