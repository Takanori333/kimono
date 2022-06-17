<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録</title>
</head>
<body>
    {{-- ヘッダー --}}
    {{-- @include(); --}}

    {{-- フリマヘッダー --}}
    <div>
        <h1>商品登録</h1>
    </div>

    {{-- 商品登録フォーム --}}
    <div>
        <form action="/fleamarket/exhibit/confirm" method="POST" enctype="multipart/form-data">
        @csrf
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
            <label for="name">商品名:</label>
            <input type="text" name="name" value="{{ old("name") }}">
            <br>

            <label for="image">商品画像:</label>
            <input type="file" name="image" value="{{ old("image") }}" multiple>
            <br>

            <label for="category">カテゴリ:</label>
            <input type="text" name="category" value="{{ old("category") }}">
            <br>

            <label for="price">値段:</label>
            <input type="text" name="price" value="{{ old("price") }}">
            <br>

            <label for="pref">発送元都道府県:</label>
            <input type="text" name="pref" value="{{ old("pref") }}">
            <br>

            <label for="material">素材:</label>
            <input type="text" name="material" value="{{ old("material") }}">
            <br>

            <label for="color">色:</label>
            <input type="text" name="color" value="{{ old("color") }}">
            <br>

            <label for="status">商品状態:</label>
            <input type="text" name="status" value="{{ old("status") }}">
            <br>

            <label for="smell">におい:</label>
            <input type="text" name="smell" value="{{ old("smell") }}">
            <br>

            <label for="size_heigh">身丈:</label>
            <input type="text" name="size_heigh" value="{{ old("size_heigh") }}">
            <br>
            <label for="size_length">裄丈:</label>
            <input type="text" name="size_length" value="{{ old("size_length") }}">
            <br>
            <label for="size_sleeve">袖丈:</label>
            <input type="text" name="size_sleeve" value="{{ old("size_sleeve") }}">
            <br>
            <label for="size_sleeves">袖幅:</label>
            <input type="text" name="size_sleeves" value="{{ old("size_sleeves") }}">
            <br>
            <label for="size_front">前幅:</label>
            <input type="text" name="size_front" value="{{ old("size_front") }}">
            <br>
            <label for="size_back">後幅:</label>
            <input type="text" name="size_back" value="{{ old("size_back") }}">
            <br>

            <label for="detail">自由記入欄</label>
            <textarea name="detail" cols="30" rows="10">{{ old("detail") }}</textarea>
            <br>

            <input type="submit" value="内容を確認">
        </form>
    </div>
</body>
</html>