<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮） - 新規登録</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    {{-- <form action="{{ asset('/stylist_user/signup_DB') }}" method="post" enctype="multipart/form-data">
        @csrf
        email<input type="email" name="email">
        <br>
        name<input type="text" name="name">
        <br>
        birthday<input type="number" name="year">y<input type="number" name="month">m<input type="number" name="day">d
        <br>
        sex<input type="radio" name="sex" value="1">男性 <input type="radio" name="sex" value="0">女性
        <br>
        phone<input type="text" name="phone">
        <br>
        post<input type="text" name="post">
        <br>
        address<textarea name="address" id="" cols="30" rows="10"></textarea>
        <br>
        icon<input type="file" name="icon">
        <br>
        password<input type="password" name="password">
        <br>
        password_c<input type="password">
        <br>
        <button>サインアップ</button>
    </form> --}}
    <div class="container">
        <div class="contents pt-5 w-75 mx-auto">

            <h2 class="text-center py-5">新規登録</h2>

            <div class="">
                <form action="{{ asset('/stylist_user/signup_DB') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
                        </div>
                        <div class="w-100 d-none d-md-block"></div>
                        <label for="" class="col-sm-3 col-form-label">名前</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">メールアドレス</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">電話番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="phone">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">郵便番号</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="post">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">住所</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <!-- <textarea name="" id="" cols="30" rows="7" class="form-control"></textarea> -->
                            {{-- <input type="text" class="form-control my-2"> --}}
                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px;resize: none" name="address"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">生年月日</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4"><input type="text" class="form-control" placeholder="年" name="year"></div>
                                <div class="col-4"><input type="text" class="form-control" placeholder="月" name="month"></div>
                                <div class="col-4"><input type="text" class="form-control" placeholder="日" name="day"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
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
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">パスワード</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">パスワード（確認）</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password_c">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="invalid-feedbac k col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            
                        </div>
                        <label for="" class="col-sm-3 col-form-label">アイコン画像</label>
                        <p class="col-sm text-danger py-2 m-0">必須</p>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="icon">
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
</body>
</html>