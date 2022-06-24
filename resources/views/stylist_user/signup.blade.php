<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>スタイリスト  新規登録</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <nav id="header" class="p-3">
        <div class="p-3 fixed-top d-flex border-bottom flex-wrap w-100">
            <h5 class="me-auto my-0 mr-mb-auto font-weight-normal p-2"><a href="{{ asset('/') }}" class="link-dark text-decoration-none h4">和服フリマ（仮）</a></h5>
        </div>
    </nav>
    <div class="container">
        <div class="contents p-5 w-75 mx-auto mt-3">

            <h2 class="text-center pb-4">新規登録</h2>

            <div class="">
                <form action="{{ asset('/stylist_user/signup_DB') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('name') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                        <div class="w-100 d-none d-md-block"></div>
                        <label for="" class="col-sm-3 col-form-label">名前</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('email') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">メールアドレス</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('phone') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">電話番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('post') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">郵便番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="post" value="{{ old('post') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('address') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">住所</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <!-- <textarea name="" id="" cols="30" rows="7" class="form-control"></textarea> -->
                            {{-- <input type="text" class="form-control my-2"> --}}
                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px;resize: none" name="address">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('year') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                            @foreach ($errors->get('month') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                            @foreach ($errors->get('day') as $message)
                                <p>{{ $message }}</p>
                            @endforeach                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">生年月日</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4">
                                    {{-- <input type="number" class="form-control" placeholder="年" name="year"> --}}
                                    <select class="form-select" aria-label="Default select example" id="year" name="year"></select>
                                    <input type="hidden"  id="old_year" value="{{ old('year') }}">
                                </div>
                                <div class="col-4">
                                    {{-- <input type="number" class="form-control" placeholder="月" name="month"> --}}
                                    <select class="form-select" aria-label="Default select example" id="month" name="month"></select>
                                    <input type="hidden"  id="old_month" value="{{ old('month') }}">
                                </div>
                                <div class="col-4">
                                    {{-- <input type="number" class="form-control" placeholder="日" name="day"> --}}
                                    <select class="form-select" aria-label="Default select example" id="day" name="day"></select>
                                    <input type="hidden"  id="old_day" value="{{ old('day') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('sex') as $message)
                                <p>{{ $message }}</p>
                            @endforeach                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">性別</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8 py-2">
                            <input type="radio" class="form-check-input" name="sex" id="man" value="1">
                            <label class="form-check-label me-3" for="man">男性</label>
                            <input type="radio" class="form-check-input" name="sex" id="woman" value="0">
                            <label class="form-check-label me-3" for="woman">女性</label>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('password') as $message)
                                <p>{{ $message }}</p>
                            @endforeach                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">パスワード</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                        </div>
                        <label for="" class="col-sm-3 col-form-label">パスワード（確認）</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('icon') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">アイコン画像</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="icon" accept="image/*">
                        </div>
                    </div>
                    <div class="row text-center flex" style="justify-content: center">
                        <button type="submit" class="btn btn-secondary btn-block my-2 py-3" style="width: 150px;">登録</button>
                    </div>
                    <div class="text-center p-2">
                        <p class="d-inline">アカウントをお持ちの方</p>
                        <p class="d-inline"><a href="{{ asset('/stylist_user/signin') }}" class="link-secondary">サインイン</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="{{ asset('/js/birthday.js') }}"></script>
</body>
</html>