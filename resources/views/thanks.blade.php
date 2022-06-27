<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>晴 re 着 - 受け取り終了</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">
    <link href="{{ asset('css/bootcss/css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
    <script src="{{ asset('js/bootjs/js/bootstrap.bundle.min.js') }}"  crossorigin="anonymous"></script>
    <script src="{{ asset('/js/socketio.js') }}"></script>
    <script src="{{ asset('/js/jquery.js') }}"></script>

</head>
<body>
    @include('header')
    <div class="py-5"></div>
    <div class="p-5 mb-4  rounded-3 " style="height: 500px">
        <div class="container-fluid py-5 text-center mt-5">
          <h1 class="display-5 fw-bold" style="color:#7a7a7a;">ありがとうございました！</h1>
        </div>
    </div>
    @include('footer')
</body>
</html>