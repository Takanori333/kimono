<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮）- 登録情報変更</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>

    @include('header')

    @php
    use Illuminate\Support\Carbon;
    @endphp

    <div class="container">
        <div class="contents pt-5 w-75 mx-auto">

            <h2 class="text-center py-5">登録情報変更</h2>

            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
            <br>
            @endforeach
            @endif

            <!-- 成功メッセージ -->
            <p class="text-center text-secondary">{{ $msg }}</p>

            <div class="">
                <form action="{{ asset('/user/edit_DB') }}" method="post" enctype="multipart/form-data" class="">
                    @csrf
                    <div class="text-center my-3">
                        <img src="{{ asset($user->user_info->icon) }}" alt="" class="w-25">
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <div class="w-100 d-none d-md-block"></div>
                        <label for="" class="col-sm-3 col-form-label">名前</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" id="" value="{{ $user->user_info->name }}" name="name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">メールアドレス</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="email" class="form-control rounded-0" value="{{ $user->email }}" name="email">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">電話番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" value="{{ $user->user_info->phone }}" name="phone">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">性別</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8 py-2">
                            @if ($user->user_info->sex)
                            <input type="radio" name="sex" value="1" class="form-check-input" id="man" checked>
                            <label class="form-check-label me-3" for="man">男性</label>
                            <input type="radio" name="sex" value="0" class="form-check-input" id="woman">
                            <label class="form-check-label me-3" for="woman">女性</label>
                            @else
                            <input type="radio" name="sex" value="1" class="form-check-input" id="man">
                            <label class="form-check-label me-3" for="man">男性</label>
                            <input type="radio" name="sex" value="0" class="form-check-input" id="woman" checked>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">生年月日</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-3 ">
                                    <select class="form-select" aria-label="Default select example" id="year" name="year" style="width: 85px"></select>
                                    <input type="hidden" class="form-control" id="old_year" placeholder="年" value="{{Carbon::parse($user->user_info->birthday)->format('Y')}}">                                        
                                </div>
                                <div class="col-1"></div>
                                <div class="col-3">
                                    <select class="form-select" aria-label="Default select example" id="month" name="month" style="width: 85px"></select>
                                    <input type="hidden" class="form-control" id="old_month"  placeholder="月" value="{{Carbon::parse($user->user_info->birthday)->format('m')}}">
                                </div>
                                <div class="col-1"></div>
                                <div class="col-3">
                                    <select class="form-select" aria-label="Default select example" id="day" name="day" style="width: 85px"></select>
                                    <input type="hidden" class="form-control" id="old_day"  placeholder="日" value="{{Carbon::parse($user->user_info->birthday)->format('d')}}">
                                </div>
                                <div class="col-1"></div>
                                {{-- <div class="col-4"><input type="text" value="{{ explode('-', $user->user_info->birthday)[0] }}" name="year" placeholder="年" class="form-control rounded-0"></div>
                                <div class="col-4"><input type="text" value="{{ intval(explode('-', $user->user_info->birthday)[1]) }}" name="month" placeholder="月" class="form-control rounded-0"></div>
                                <div class="col-4"><input type="text" value="{{ intval(explode('-', $user->user_info->birthday)[2]) }}" name="day" placeholder="日" class="form-control rounded-0"></div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">郵便番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" value="{{ $user->user_info->post }}" name="post">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">住所</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <textarea name="address" id="" cols="20" rows="7" class="form-control rounded-0">{{ $user->user_info->address }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">パスワード</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" class="form-control rounded-0" value="{{ $user->password }}" name="password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">身長</label>
                        <p class="col-sm text-secondary py-2 m-0">任意</p>
                        <div class="col-sm-8 row p-0">
                            <input type="text" class="form-control w-50 col rounded-0" value="{{ $user->user_info->height }}" name="height">
                            <p class="col align-bottom d-flex align-items-end">cm</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->

                        </div>
                        <label for="" class="col-sm-3 col-form-label">アイコン画像</label>
                        <p class="col-sm text-danger py-2 m-0"></p>
                        <div class="col-sm-8">
                            <input type="file" onchange="previewImage(this);" class="form-control rounded-0" name="icon">
                        </div>
                    </div>

                    {{-- この中に画像のプレビューを追加 --}}
                    <div id="show_img_area"></div>

                    <div class="row my-2">
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="col text-center">
                            <button type="button" onclick="location.href='{{ asset('/user/info/' . $user->id) }}'" class="btn btn-secondary my-2 py-2 rounded-0">戻る</button>
                        </div>
                        <div class="col text-center">
                            <button type="submit" name="signup" class="btn btn-secondary my-2 py-2 rounded-0">変更</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('footer')

    <script>
        function previewImage(obj)
        {
            let fileReader = new FileReader();
            fileReader.onload = (function() {
                let show_img = document.getElementById("show_img_area");
                // class_nameで追加したいクラスを定義
                let class_name = "";
                show_img.innerHTML = `<img src="${fileReader.result}" class="${class_name}">`
            });
            fileReader.readAsDataURL(obj.files[0]);
        }
    </script>

    <!-- <h1>登録情報変更</h1>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <span>{{ $error }}</span>
    <br>
    @endforeach
    @endif
    <p>{{ $msg }}</p>
    <div>
        <form action="{{ asset('/user/edit_DB') }}" method="post" enctype="multipart/form-data">
            @csrf
            <img src="{{ asset($user->user_info->icon) }}" alt="">
            <br>
            名前
            <input type="text" value="{{ $user->user_info->name }}" name="name">
            <br>
            メールアドレス
            <input type="text" value="{{ $user->email }}" name="email">
            <br>
            電話番号
            <input type="text" value="{{ $user->user_info->phone }}" name="phone">
            <br>
            性別
            @if ($user->user_info->sex)
            <input type="radio" name="sex" value="1" checked>男
            <input type="radio" name="sex" value="0">女
            @else
            <input type="radio" name="sex" value="1">男
            <input type="radio" name="sex" value="0" checked>女
            @endif
            <br>
            生年月日
            <input type="text" value="{{ explode("-", $user->user_info->birthday)[0] }}" name="year">
            /
            <input type="text" value="{{ intval(explode("-", $user->user_info->birthday)[1]) }}" name="month">
            /
            <input type="text" value="{{ intval(explode("-", $user->user_info->birthday)[2]) }}" name="day">
            <br>
            郵便番号
            <input type="text" value="{{ $user->user_info->post }}" name="post">
            <br>
            住所
            <textarea name="address" id="" cols="30" rows="10">{{ $user->user_info->address }}</textarea>
            <br>
            身長
            <input type="text" value="{{ $user->user_info->height }}" name="height">
            <br>
            パスワード
            <input type="text" value="{{ $user->password }}" name="password">
            <br>
            <input type="file" name="icon">
            <br>
            <button type="button" onclick="location.href='{{ asset('/user/info/' . $user->id) }}'">戻る</button>
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="submit" name="signup" value="確定">
        </form>
    </div> -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('/js/birthday.js') }}"></script>
</body>

</html>