<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮） - 新規登録</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/my-sheet.css') }}">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="{{ asset('js/header.js') }}"></script>
</head>

<body>

    @include('header')

    <div class="container">
        <div class="contents pt-5 w-75 mx-auto">

            <h2 class="text-center py-5">新規登録</h2>

            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
            <br>
            @endforeach
            @endif

            <div class="">
                <form action="{{ asset('/user/signup_DB') }}" method="post" enctype="multipart/form-data" class="">
                    @csrf
                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <div class="w-100 d-none d-md-block"></div>
                        <label for="" class="col-sm-3 col-form-label">名前</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded-0" id="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">メールアドレス</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">メールアドレス（確認）</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="email_confirmation" value="{{ old('email_confirmation') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">電話番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">性別</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8 py-2">
                            <input type="radio" name="sex" value="1" checked class="form-check-input" id="man">
                            <label class="form-check-label me-3" for="man">男性</label>
                            <input type="radio" name="sex" value="0" class="form-check-input" id="woman">
                            <label class="form-check-label me-3" for="woman">女性</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">生年月日</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <!-- <input type="date" class="form-control rounded-0"> -->
                            <div class="row">
                                <div class="col-4"><input type="text" name="year" value="{{ old('year') }}" placeholder="年" class="form-control rounded-0"></div>
                                <div class="col-4"><input type="text" name="month" value="{{ old('month') }}" placeholder="月" class="form-control rounded-0"></div>
                                <div class="col-4"><input type="text" name="day" value="{{ old('day') }}" placeholder="日" class="form-control rounded-0"></div>
                            </div>
                            {{-- <select name="year" id="">
                                @for ($year = 1900; $year <= date("Y"); $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                            </select>年
                            <select name="month" id="">
                                @for ($month = 1; $month <= 12; $month++) <option value="{{ $month }}">{{ $month }}</option>
                                    @endfor
                            </select>月
                            <select name="day" id="">
                                @for ($day = 1; $day <= 31; $day++) <option value="{{ $day }}">{{ $day }}</option>
                                    @endfor
                            </select>日 --}}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">郵便番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="post" value="{{ old('post') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">住所</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <textarea name="address" id="" cols="30" rows="10" class="form-control my-2 rounded-0">{{ old('address') }}</textarea>
                            <!-- <textarea name="" id="" cols="30" rows="7" class="form-control"></textarea> -->
                            <!-- <input type="text" class="form-control my-2 rounded-0"> -->
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">パスワード</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" name="password" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">パスワード（確認）</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" name="password_confirmation" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">身長</label>
                        <p class="col-sm text-secondary py-2 m-0">任意</p>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="height" value="{{ old('height') }}" class="form-control w-100 rounded-0">
                                </div>
                                <div class="col">
                                    <p class="d-flex align-items-end">cm</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 my-2">
                        <button type="submit" name="signup" class="btn btn-secondary btn-block my-2 py-3 rounded-0">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- <h1>新規登録</h1>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <span>{{ $error }}</span>
    <br>
    @endforeach
    @endif
    <form action="{{ asset('/user/signup_DB') }}" method="post" enctype="multipart/form-data">
        @csrf
        名前
        <input type="text" name="name" value="{{ old('name') }}">
        <br>
        メールアドレス
        <input type="text" name="email" value="{{ old('email') }}">
        <br>
        メールアドレス確認
        <input type="text" name="email_confirmation" value="{{ old('email_confirmation') }}">
        <br>
        電話番号
        <input type="text" name="phone" value="{{ old('phone') }}">
        <br>
        性別
        <input type="radio" name="sex" value="1" checked>男
        <input type="radio" name="sex" value="0">女
        <br>
        生年月日
        <input type="text" name="year" value="{{ old('year') }}" placeholder="年">
        <input type="text" name="month" value="{{ old('month') }}" placeholder="月">
        <input type="text" name="day" value="{{ old('day') }}" placeholder="日">
        {{-- <select name="year" id="">
            @for ($year = 1900; $year <= date("Y"); $year++)
                <option value="{{ $year }}">{{ $year }}</option>
        @endfor
        </select>年
        <select name="month" id="">
            @for ($month = 1; $month <= 12; $month++) <option value="{{ $month }}">{{ $month }}</option>
                @endfor
        </select>月
        <select name="day" id="">
            @for ($day = 1; $day <= 31; $day++) <option value="{{ $day }}">{{ $day }}</option>
                @endfor
        </select>日 --}}
        <br>
        郵便番号
        <input type="text" name="post" value="{{ old('post') }}">
        <br>
        住所
        <textarea name="address" id="" cols="30" rows="10">{{ old('address') }}</textarea>
        <br>
        身長
        <input type="text" name="height" value="{{ old('height') }}">
        <br>
        パスワード
        <input type="text" name="password">
        <br>
        パスワード確認
        <input type="text" name="password_confirmation">
        <br>
        アイコン
        <input type="file" name="icon">
        <br>
        <input type="submit" name="signup" value="登録">
    </form> -->
</body>

</html>