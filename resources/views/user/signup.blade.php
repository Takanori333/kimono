<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>晴 re 着  - 新規登録</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
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

            <h2 class="text-center py-5 mt-5">新規登録</h2>

            <!-- @if ($errors->any())
            @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
            <br>
            @endforeach
            @endif -->

            <div class="">
                <form action="{{ asset('/user/signup_DB') }}" method="post" enctype="multipart/form-data" class="">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('name') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                        </div>
                        <div class="w-100 d-none d-md-block"></div>
                        <label for="" class="col-sm-3 col-form-label">名前</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('email') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                        </div>
                        <label for="" class="col-sm-3 col-form-label">メールアドレス</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="" class="col-sm-3 col-form-label">メールアドレス（確認）</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="email_confirmation" value="{{ old('email_confirmation') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('phone') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                        </div>
                        <label for="" class="col-sm-3 col-form-label">電話番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
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
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('year') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                            @foreach ($errors->get('month') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                            @foreach ($errors->get('day') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                        </div>
                        <label for="" class="col-sm-3 col-form-label">生年月日</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4">
                                    <select class="form-select rounded-0" aria-label="Default select example" id="year" name="year"></select>
                                    <input type="hidden"  id="old_year" value="{{ old('year') }}">
                                </div>
                                <div class="col-4">
                                    <select class="form-select rounded-0" aria-label="Default select example" id="month" name="month"></select>
                                    <input type="hidden"  id="old_month" value="{{ old('month') }}">
                                </div>
                                <div class="col-4">
                                    <select class="form-select rounded-0" aria-label="Default select example" id="day" name="day"></select>
                                    <input type="hidden"  id="old_day" value="{{ old('day') }}">
                                </div>
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
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('post') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                        </div>
                        <label for="" class="col-sm-3 col-form-label">郵便番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="post" value="{{ old('post') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('address') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                        </div>
                        <label for="" class="col-sm-3 col-form-label">住所</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <textarea name="address" cols="30" rows="7" class="form-control my-2 rounded-0">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('password') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                        </div>
                        <label for="" class="col-sm-3 col-form-label">パスワード</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" name="password" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="" class="col-sm-3 col-form-label">パスワード（確認）</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" name="password_confirmation" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('height') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
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

                    <div class="row mb-3">
                        <div class="invalid-fee dback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('icon') as $error_msg)
                            <small class="text-danger d-block mb-1">{{ $error_msg }}</small>
                            @endforeach
                        </div>
                        <label for="" class="col-sm-3 col-form-label">アイコン画像</label>
                        <p class="col-sm text-secondary py-2 m-0">任意</p>
                        <div class="col-sm-8">
                            <input type="file" onchange="previewImage(this);" name="icon" class="form-control rounded-0">
                        </div>
                        {{-- この中に画像のプレビューを追加 --}}
                        <div id="show_img_area" class="img_view col-sm-8 offset-md-4 mt-2"></div>
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
    <script src="{{ asset('/js/birthday.js') }}"></script>

    <script>
        function previewImage(obj)
        {
            let fileReader = new FileReader();
            fileReader.onload = (function() {
                let show_img = document.getElementById("show_img_area");
                // class_nameで追加したいクラスを定義
                let class_name = "img_view";
                show_img.innerHTML = `<img src="${fileReader.result}" class="${class_name} w-25">`
            });
            fileReader.readAsDataURL(obj.files[0]);
        }
    </script>

</body>

</html>