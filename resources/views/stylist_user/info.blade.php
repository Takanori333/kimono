<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>情報編集</title>
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/stylist_update.js') }}"></script>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
</head>
<body>
    @include('stylist_user.header')
    @php
    use Illuminate\Support\Carbon;
    $stylist = unserialize(session()->get("stylist"));
    $state_list = [
        "北海道","青森県","岩手県","宮城県","秋田県","山形県","福島県","茨城県","栃木県","群馬県","埼玉県","千葉県","東京都","神奈川県","新潟県","富山県","石川県","福井県","山梨県","長野県","岐阜県","静岡県","愛知県","三重県","滋賀県","京都府","大阪府","兵庫県","奈良県",
        "和歌山県","鳥取県","島根県","岡山県","広島県","山口県","徳島県","香川県","愛媛県","高知県","福岡県","佐賀県","長崎県","熊本県","大分県","宮崎県","鹿児島県","沖縄県"
    ];
    $service_list = [
        "着付け","メイク","ヘアアレンジ","講師"
    ]
    @endphp
    <form action="{{ asset('/stylist_user/info_DB') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" value="{{ $stylist->getId() }}" name="id">
        <div class="container">
            <div class="text-danger ms-4 text-center">
                <!-- バリデーションメッセージ -->
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach    
                @endif
            </div>
            <div class="row pt-5">
                <div class="col-12 col-xxl-1 col-lg-1 col-md-1  col-xl-1">
                </div>
                <div class="col-12 col-xxl-4 col-lg-4 col-md-4  col-xl-4">
                    <div class="container">
                        <div class="row" style="text-align: -webkit-center">
                            <div class="col">
                                <img src="{{ asset($stylist->getIcon()) }}" class="img-thumbnail" width="250px" height="300px" id="img">
                                <input type="file" class="form-control-sm" width="250px" name="icon" onchange="imgChange(this)">
                            </div>
                        </div>
                        <br>
                        <div class="row" style="place-content: center;">
                            <div class="col-auto">
                                <label for="inputPassword6" class="col-form-label">活動場所</label>
                            </div>
                            <div class="col-auto">
                                <select name="" id="" class="form-select" aria-label="Default select example" style="width: 160px" onchange="insert_area('{{ asset('stylist_user/insert_area') }}','{{ csrf_token() }}',this)">
                                    <option value="0" selected disabled>活動場所追加</option>
                                    @foreach ($state_list as $state)
                                        <option value="{{ $state }}"
                                        @if (array_search($state,$service_area)!==false)
                                            disabled
                                        @endif
                                        >{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="d-flex flex-wrap border secondary">
                                @foreach ($service_area as $area)
                                <div class="border secondary" style="margin: 3px;padding: 5px">{{ $area }}
                                    <a class="link-danger" href="javascript:void(0);" onclick="delete_area('{{ asset('/stylist_user/delete_area') }}','{{ csrf_token() }}','{{ $area }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg></a></div>
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <div class="row" style="place-content: center;">
                            <div class="col-auto">
                                <label for="inputPassword6" class="col-form-label">サービスメニュー</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" aria-label="Default select example" style="width: 160px" onchange="insert_service('{{ asset('stylist_user/insert_service') }}','{{ csrf_token() }}',this)">
                                    <option value="0" selected disabled>メニュー追加</option>
                                    @foreach ($service_list as $s)
                                        <option value="{{ $s }}"
                                        @if (array_search($s,$service)!==false)
                                            disabled
                                        @endif
                                        >{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="d-flex flex-wrap border secondary">
                                @foreach ($service as $s)
                                <div class="border secondary" style="margin: 3px;padding: 5px">{{ $s }}
                                    <a class="link-danger" href="javascript:void(0);" onclick="delete_service('{{ asset('/stylist_user/delete_service') }}','{{ csrf_token() }}','{{ $s }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg></a></div>                            
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-4">料金範囲:</div>
                           <div class="col-4"><input type="number" class="form-control" name="price[min]" value="{{ $stylist->getMin_price() }}" placeholder="最低料金"></div>
                           <div class="col-4"><input type="number" class="form-control" name="price[max]" value="{{ $stylist->getMax_price() }}" placeholder="最高料金"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-2 col-lg-2 col-md-2 col-xl-2">
                </div>
                <div class="col-12 col-xxl-4 col-lg-4 col-md-4 col-xl-4">
                    <div class="container">
                        <div class="container gap-1 d-grid">
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">名前</label>
                                <input type="text" class="form-control" name="name" value="{{ $stylist->getName() }}">
                            </div>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">メールアドレス</label>
                                {{ $stylist->getEmail() }}
                            </div>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">電話番号</label>
                                <input type="text" class="form-control"  name="phone" value="{{ $stylist->getPhone() }}">
                            </div>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">郵便番号</label>
                                <input type="text" class="form-control" name="post" value="{{ $stylist->getPost() }}">
                            </div>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">住所</label>
                                <textarea class="form-control" id="floatingTextarea2" style="height: 100px;resize: none" name="address">{{ $stylist->getAddress() }}</textarea>
                            </div>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">生年月日</label>
                                <div class="row ">
                                    <div class="col-3 ">
                                        <select class="form-select" aria-label="Default select example" id="year" name="year" style="width: 85px"></select>
                                        <input type="hidden" class="form-control" id="old_year" placeholder="年" value="{{Carbon::parse($stylist->getBirthday())->format('Y')}}">                                        
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-3">
                                        <select class="form-select" aria-label="Default select example" id="month" name="month" style="width: 85px"></select>
                                        <input type="hidden" class="form-control" id="old_month"  placeholder="月" value="{{Carbon::parse($stylist->getBirthday())->format('m')}}">
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-3">
                                        <select class="form-select" aria-label="Default select example" id="day" name="day" style="width: 85px"></select>
                                        <input type="hidden" class="form-control" id="old_day"  placeholder="日" value="{{Carbon::parse($stylist->getBirthday())->format('d')}}">
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="alert-danger"></div>
                                <label for="exampleInputEmail1" class="form-label">性別</label>
                                <div class="row">
                                    {{ $stylist->getSex() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center"><button class="btn btn-outline-secondary">更新</button></div>
        </div>
    </form>
    @include('stylist_user.footer')
    <script src="{{ asset('/js/birthday.js') }}"></script>

</body>
</html>
