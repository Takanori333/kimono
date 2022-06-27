<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>晴 re 着 - 商品登録</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap"
        rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    {{-- ヘッダー --}}
    @include('header');

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto">

            <h2 class="text-center py-5 mt-5">商品登録</h2>

            <!-- <div class="text-center">
                <div class="d-inline text-start">
                    @foreach ($errors->all() as $error)
                    <p class="text-danger my-0">{{$error}}</p>
                    @endforeach
                </div>
            </div> -->

            {{-- 商品登録フォーム --}}
            <div>
                <form action="/fleamarket/exhibit/confirm" method="POST" enctype="multipart/form-data" id="item_create_form">
                    @csrf

                    <div class="row my-3">
                        <div class="invalid-feedba ck col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('name') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">商品名</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded-0">
                        </div>

                    </div>

                    @php
                    $images = old("image");
                    @endphp
                    <div class="row my-3">
                        <div class="invalid-feedba ck col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('image') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">商品画像</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <div id="show_img_area">
                                <input type="file" id="input_img" class="form-control rounded-0" multiple accept="image/*">
                                @isset( $images )
                                @foreach ($images as $key => $image )
                                <img src="{{ $image }}" class="w-25 mb-1" id="show_image_{{$key}}">
                                <button type="button" class="btn btn-danger" id="btn_image_{{$key}}" onclick="del_img({{$key}})">×</button>
                                @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                    
                    <div class="row my-3">
                        <div class="invalid-fe edback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('category') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">カテゴリ</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="category" value="{{ old('category') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="invalid-fee dback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('price') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">値段(円)</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <input type="number" name="price" value="{{ old('price') }}" class="form-control rounded-0" step="1" min="1" max="9999999">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="invalid-f eedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('pref') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">発送元都道府県</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            {{-- <input type="text" name="pref" value="{{ old('pref') }}" class="form-control rounded-0"> --}}
                            <select name="pref" class="form-control rounded-0">
                                <option value="" selected disabled>選択してください</option>
                                @foreach ( config('pref') as $pref )
                                    <Option value="{{$pref}}"
                                        @if ( old('pref') == $pref )
                                            selected
                                        @endif
                                    >{{$pref}}</Option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="invalid-fe  edback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('material') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">素材</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="material" value="{{ old('material') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="invalid-fee dback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('color') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">色</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="color" value="{{ old('color') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="invalid-fee dback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('status') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">商品状態</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="status" value="{{ old('status') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="invalid-fe edback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('smell') as $message)
                            <p class="text-danger mb-1">{{ $message }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">におい</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <input type="text" name="smell" value="{{ old('smell') }}" class="form-control rounded-0">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="invalid-f eedback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('size_height') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                            @foreach ($errors->get('size_length') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                            @foreach ($errors->get('size_sleeve') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                            @foreach ($errors->get('size_sleeves') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                            @foreach ($errors->get('size_front') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                            @foreach ($errors->get('size_back') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">サイズ</div>
                        <p class="col-sm text-danger py-2 m-0 text-end">必須</p>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">身丈(cm)</label>
                                    <div class=""><input type="number" name="size_height" value="{{ old('size_height') }}" class="form-control rounded-0" step="1" min="0" max="999"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">裄(cm)</label>
                                    <div class=""><input type="number" name="size_length" value="{{ old('size_length') }}" class="form-control rounded-0" step="1" min="0" max="999"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">袖丈(cm)</label>
                                    <div class=""><input type="number" name="size_sleeve" value="{{ old('size_sleeve') }}" class="form-control rounded-0" step="1" min="0" max="999"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">袖幅(cm)</label>
                                    <div class=""><input type="number" name="size_sleeves" value="{{ old('size_sleeves') }}" class="form-control rounded-0" step="1" min="0" max="999"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">前幅(cm)</label>
                                    <div class=""><input type="number" name="size_front" value="{{ old('size_front') }}" class="form-control rounded-0" step="1" min="0" max="999"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">後ろ幅(cm)</label>
                                    <div class=""><input type="number" name="size_back" value="{{ old('size_back') }}" class="form-control rounded-0" step="1" min="0" max="999"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="invalid-fe edback col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('detail') as $msg)
                            <p class="text-danger mb-1">{{ $msg }}</p>
                            @endforeach
                        </div>
                        <div class="col-sm-2 col-form-label">自由記入欄</div>
                        <p class="col-sm py-2 m-0 text-end">任意</p>
                        <div class="col-sm-8">
                            <textarea name="detail" id="" class="form-control rounded-0" cols="30" rows="10">{{ old("detail") }}</textarea>
                        </div>
                    </div>

                    <div id="hidden_input">
                        @isset( $images )
                        @foreach ($images as $key => $image )
                        <input type="hidden" id="hidden_image_{{$key}}" name="image[{{$key}}]" value="{{ $image }}">
                        @endforeach
                        @endisset
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" value="内容を確認" onclick="submit()" class="btn btn-secondary rounded-0">内容を確認</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('footer')

    <script>
        let image_count = 0;

        $(document).ready(function(){
            // hiddenの中の要素数を数える
            image_count = document.getElementById('hidden_input').childElementCount;
        });

        // 画像の追加
        // <input type="file" id="input_img" multiple>にchangeイベントを設定
        document.getElementById( "input_img" ).addEventListener( "change", function() {
            // フォームで選択された全ファイルを取得
            let fileList = this.files;

            // 個数分の画像を表示する
            for( let i=0,l=fileList.length; l>i; i++ ) {
                // FileReaderオブジェクトを作成
                let fileReader = new FileReader();

                // 読み込み後の処理を決めておく
                fileReader.onload = function() {
                    // Data URIを取得
                    let dataUri = this.result;

                    // 次の画像idを取得
                    let img_id = image_count;

                    // サンプルを表示する領域を取得
                    let show_img = document.getElementById("show_img_area");
                    // HTMLに書き出し (src属性にData URIを指定)
                    show_img.innerHTML += '<img src="' + dataUri + '" class="w-25 mb-' + (i+1) +'" id="show_image_' + img_id + '" >';
                    show_img.innerHTML += '<button type="button" class="btn btn-danger" id="btn_image_' + img_id + '" onclick="del_img(' + img_id + ')">×</button>';
                    
                    // inputタグをhiddenで表示するdivタグを取得する
                    let hidden_area = document.getElementById("hidden_input");
                    hidden_area.innerHTML += '<input type="hidden" name="image[]" id="hidden_image_' + img_id + '" value="' + dataUri +'">';
                    image_count++;
                }
                // ファイルをData URIとして読み込む
                fileReader.readAsDataURL( fileList[i] ) ;
            }
        } ) ;

        // 画像の削除
        function del_img(img_id){
            let show_image = document.getElementById( 'show_image_' + img_id );
            let btn_image = document.getElementById( 'btn_image_' + img_id );
            let hidden_image = document.getElementById( 'hidden_image_' + img_id );
            show_image.remove()
            btn_image.remove();
            hidden_image.remove();
        }


    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>