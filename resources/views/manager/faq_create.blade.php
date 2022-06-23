<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮） - フリマ</title>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>
    {{-- <h1>FAQ追加</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
            <br>
        @endforeach
    @endif
    {{ $msg }}
    <form action="{{ asset('/manager/faq/create_DB') }}">
        <p>質問</p>
        <textarea name="question" id="" cols="30" rows="10"></textarea>
        <br>
        <p>回答</p>
        <textarea name="answer" id="" cols="30" rows="10"></textarea>
        <br>
        <input type="submit" value="確定">
    </form>
    <button onclick="location.href='{{ asset('/manager/faq') }}'">一覧に戻る</button> --}}
    @include('header')
    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto text-center">
            <h1>FAQ追加</h1>
            <p class="invalid-feedback" style="display: block">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
                <br>
            @endforeach
            @endif
            </p>
            <p>{{ $msg }}</p>
            <div class="">
                <form action="{{ asset('/manager/faq/create_DB') }}">
                    @csrf
                    <div class="text-center my-4">
                        <div class="w-75 row m-0 mx-auto  my-4">
                            <div class="row text-start">
                                <label for="question" class="form-label p-0">質問</label>
                                <textarea class="form-control" name="question" id="question"></textarea>
                            </div>
                            <div class="row text-start">
                                <label for="answer" class="form-label p-0">回答</label>
                                <textarea class="form-control" name="answer" id="answer"></textarea>
                            </div>
                            <div class="row d-flex justify-content-center mb-3 w-100">
                                <button class="btn btn-outline-primary px-3 mt-4 mx-1 col-3" type="submit">確定</button>
                            </div>
                            <div class="row">
                                <button class="btn btn-outline-secondary px-3 mt-4 mb-4 mx-1 col-3" onclick="location.href='{{ asset('/manager/faq') }}'" type="button">一覧に戻る</button>
                            </div>
                        </div>            
                    </div>
                </form>    
            </div>
        </div>
    </div>
    @include('footer')
</body>
</html>