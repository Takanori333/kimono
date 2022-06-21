<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1>FAQ</h1>
    @foreach ($faqs as $faq)
        <div>
            <p>Q.{{ $faq->question }}</p>
            <p>A.{{ $faq->answer }}</p>
        </div>
    @endforeach
</body>
</html>