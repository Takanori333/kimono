<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        <form action="/fleamarket/exhibit/confirm" method="POST" enctype="multipart/form-data" id="item_create_form">
        @csrf
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
            <label for="name">商品名:</label>
            <input type="text" name="name" value="{{ old("name") }}">
            <br>

            @php
                $images = old("image");
            @endphp
            <label for="image">商品画像:</label>
            <input type="file" id="input_img" multiple>

            <div id="show_img_area">
                @isset( $images )
                    @foreach ($images as $image )
                        <img src="{{ $image }}">
                    @endforeach
                @endisset
            </div>
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

            <div id="hidden_input">
                @isset( $images )
                    @foreach ($images as $key => $image )
                        <input type="hidden" name="image[{{$key}}]" value="{{ $image }}">
                    @endforeach
                @endisset
            </div>

            <input type="button" value="内容を確認" onclick="submit()">
        </form>
    </div>
    <script>
        // <input type="file" id="input_img" multiple>にchangeイベントを設定
        document.getElementById( "input_img" ).addEventListener( "change", function() {
            // フォームで選択された全ファイルを取得
            let fileList = this.files ;

            // 個数分の画像を表示する
            for( let i=0,l=fileList.length; l>i; i++ ) {
                // FileReaderオブジェクトを作成
                let fileReader = new FileReader() ;

                // 読み込み後の処理を決めておく
                fileReader.onload = function() {
                    // Data URIを取得
                    let dataUri = this.result ;
                    // サンプルを表示する領域を取得
                    let show_img = document.getElementById("show_img_area");
                    // HTMLに書き出し (src属性にData URIを指定)
                    show_img.innerHTML += '<img src="' + dataUri + '">'
                    
                    // inputタグをhiddenで表示するdivタグを取得する
                    let hidden_area = document.getElementById("hidden_input");
                    hidden_area.innerHTML += '<input type="hidden" name="image[]" value="' + dataUri +'">'
                    console.log( '<input type="hidden" name="image[]" value="' + dataUri +'">');
                }
                // ファイルをData URIとして読み込む
                fileReader.readAsDataURL( fileList[i] ) ;
            }
        } ) ;


    </script>
</body>
</html>