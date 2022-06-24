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
    {{-- {{ var_dump($reserve) }} --}}
    @php
        $user = unserialize(session()->get("user"));
    @endphp
    @include('header')
    <div class="container">
    <div class="contents p-5 m-5 w-100 mx-auto text-center">
            <div class="mt-5 p-5 border secondary" style="padding: 30px;margin-top: 50px;margin-bottom: 50px;background: white;">                    
                    <div class="container gap-1 d-grid">
                        <form action="{{ asset('stylist/confirm') }}" method="POST">
                            <div class="text-danger ms-4 text-center">
                                <!-- バリデーションメッセージ -->
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach    
                                @endif
                            </div>
                            @csrf
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                    <label for="exampleInputEmail1" class="form-label">名前：{{ $user->name }}</label>
                                </div>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">予約時間</label>
                                <div class="row text-center">
                                    <p>
                                        {{ $reserve->start_time }}~{{ $reserve->end_time }}
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="row text-center" >
                                    <p>
                                        サービスメニュー：{{ $reserve->services }}
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="row" >
                                    <div class="col-2">
                                        <label for="inputPassword6" class="col-form-label">人数</label>
                                    </div>
                                    <div class="col-10" style="place-content: center;">
                                        <select class="form-select" aria-label="Default select example" name="count">
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
    @include('footer')
</body>
</html>