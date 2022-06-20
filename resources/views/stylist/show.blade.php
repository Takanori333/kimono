<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>スタイリスト一覧</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/my-sheet.css">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"></head>

    <title>Document</title>
</head>
<body>
    {{ var_dump($areas) }}
    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto text-center">

            <div class="row my-4">
                <div class="col-12 col-xl-4 col-xxl-4">
                    <img src="{{ asset($stylist->icon) }}" alt="" height="300px" width="250px">
                </div>
                <div class="col-12 col-xl-8 col-xxl-8">
                    <div class="container">
                        <div class="row">名前:{{ $stylist->name }}</div>
                        <div class="row">地域:</div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</body>
</html>