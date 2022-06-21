<!DOCTYPE html>
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