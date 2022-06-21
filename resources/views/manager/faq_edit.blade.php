<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>FAQ編集</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
            <br>
        @endforeach
    @endif
    {{ $msg }}
    <p>ID:{{ $faq->id }}</p>
    <form action="{{ asset('/manager/faq/edit_DB') }}">
        <p>質問</p>
        <textarea name="question" id="" cols="30" rows="10">{{ $faq->question }}</textarea>
        <br>
        <p>回答</p>
        <textarea name="answer" id="" cols="30" rows="10">{{ $faq->answer }}</textarea>
        <input type="hidden" value={{ $faq->id }} name="faq_id">
        <br>
        <input type="submit" value="確定">
    </form>
    <button onclick="location.href='{{ asset('/manager/faq') }}'">一覧に戻る</button>
</body>
</html>