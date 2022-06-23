{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>サインイン</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
            <br>
        @endforeach
    @endif
    {{ $msg }}
    <form action="{{ asset('/manager/signin_DB') }}" method="post">
        @csrf
        <input type="text" name="email" value="{{ old('email') }}"><br>
        <input type="text" name="password"><br>
        <input type="submit" name="singin" id="" value="サインイン">
    </form>
</body>
</html>

 --}}

<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮） - ログイン</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>
    @include('header')
    <div class="container">
        <div class="contents pt-5 w-75 mx-auto">
            <h2 class="text-center pt-5">ログイン</h2>
            <div class="">
                <form action="{{ asset('/manager/signin_DB') }}" method="post" novalidate>
                    @csrf
                    <p class="invalid-feedback" style="display: block">
                        <!-- バリデーションメッセージ -->
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                                <br>
                            @endforeach
                        @endif
                        {{ $msg }}                        
                    </p>
                    <div class="mb-3">
                        <label for="form-label">メールアドレス</label>
                        <input type="text" name="email" class="form-control my-2 py-2">
                    </div>
                    <div class="mb-3">
                        <label for="form-label">パスワード</label>
                        <input type="password" name="password" class="form-control my-2 py-2">
                    </div>
                    <div class="d-grid gap-2 my-2">
                        <button type="submit" class="btn btn-secondary btn-block my-2 py-3">ログイン</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('footer')
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