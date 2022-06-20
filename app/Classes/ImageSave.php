<?php
namespace App\Classes;

use Illuminate\Support\Facades\Storage;

class ImageSave{
    /**
     * @param $base64File
     * @return string
     */
    public static function uploadBase64($base64File)
    {
        // "data:{拡張子}"と"base64,"で区切る
        list($fileInfo, $fileData) = explode(';', $base64File);
        // 拡張子を取得
        $extension = explode('/', $fileInfo)[1];
        // $fileDataにある"base64,"を削除する
        list(, $fileData) = explode(',', $fileData);
        // base64をデコード
        $fileData = base64_decode($fileData);
        // ランダムなファイル名生成
        $fileName = md5(uniqid(rand(), true)). ".$extension";
        // サーバー に保存する
        Storage::disk('local')->put($fileName, $fileData);
        // データベースに保存するためのパスを返す
        // return Storage::disk('local')->url($fileName);
        return "image/" . $fileName;
    }
}