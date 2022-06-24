<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>スタイリスト ログイン</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>
    {{-- <form action="{{ asset('/stylist_user/signin_DB') }}" method="POST">
        @csrf
        <input type="email" name="email">
        <br>
        <input type="password" name="password" id="">
        <br>
        <button>サインイン</button>
    </form>
    <a href="{{ asset('/stylist_user/signup') }}">サインアップ</a> --}}

    <nav id="header" class="p-3">
        <div class="p-3 fixed-top d-flex border-bottom flex-wrap w-100">
            <h5 class="me-auto my-0 mr-mb-auto font-weight-normal p-2"><a href="{{ asset('/') }}" class="link-dark text-decoration-none h4">和服フリマ（仮）</a></h5>
        </div>
    </nav>
    <div class="container">
        <div class="contents p-5 mt-5 w-75 mx-auto ">
            <h2 class="text-center pt-5">ログイン</h2>
            <div class="">
                <form action="{{ asset('/stylist_user/signin_DB') }}" method="POST">
                    @csrf
                    <div class="text-danger ms-4 text-center">
                        <!-- バリデーションメッセージ -->
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach    
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="form-label">メールアドレス</label>
                        <input type="email" class="form-control my-2 py-2" name="form[email]">
                    </div>
                    <div class="mb-3">
                        <label for="form-label">パスワード</label>
                        <input type="password" class="form-control my-2 py-2" name="form[password]">
                    </div>
                    <div class="row text-center flex" style="justify-content: center">
                        <button type="submit" class="btn btn-secondary btn-block my-2 py-3" style="width: 150px;">サインイン</button>
                    </div>
                </form>
                <div class="text-center p-2">
                    <p class="d-inline">アカウントをお持ちでない方</p>
                    <p class="d-inline"><a href="{{ asset('/stylist_user/signup') }}" class="link-secondary">アカウントを作成する</a></p>
                </div>
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