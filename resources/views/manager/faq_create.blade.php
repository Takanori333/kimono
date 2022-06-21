<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>FAQ追加</h1>
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
    <button onclick="location.href='{{ asset('/manager/faq') }}'">一覧に戻る</button>
</body>
</html>