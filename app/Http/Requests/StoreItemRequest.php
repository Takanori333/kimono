<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:20',
            'image' => 'required',
            'category' => 'required|string|max:50',
            'price' => 'required|integer|gte:1|lte:9999999',
            'pref' => 'required|in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県',
            'material' => 'required|string|max:50',
            'color' => 'required|max:50',
            'status' => 'required|max:50',
            'smell' => 'required|max:50',
            'size_height' => 'required|numeric|regex:/((^([1-9][0-9]{0,2})$))/',
            'size_length' => 'required|numeric|regex:/((^([1-9][0-9]{0,2})$))/',
            'size_sleeve' => 'required|numeric|regex:/((^([1-9][0-9]{0,2})$))/',
            'size_sleeves' => 'required|numeric|regex:/((^([1-9][0-9]{0,2})$))/',
            'size_front' => 'required|numeric|regex:/((^([1-9][0-9]{0,2})$))/',
            'size_back' => 'required|numeric|regex:/((^([1-9][0-9]{0,2})$))/',
            'detail' => 'nullable|string|max:200',
        ];
    }

    public function messages(){
        return [
            'name.required' => ':attributeが記入されていません',
            'name.string' => ':attributeが正しくありません',
            'name.max:20' => '20 文字以下で入力してください',

            'image.required' => ':attributeが選択されていません',
            'image.image' => ':attributeが正しくありません',
            
            'category.required' => ':attributeが入力されていません',
            'category.string' => ':attributeが正しくありません',
            'category.max:50' => '50 文字以下で入力してください',
            
            'price.required' => ':attributeが記入されていません',
            'price.integer' => ':attributeは数字で入力してください',
            'price.gte' => '1 円以上で入力してください',
            'price.lte:9999999' => '999 万 9999 円以下で入力してください',
            
            'pref.required' => ':attributeが指定されていません',
            'pref.in' => '都道府県が正しくありません',
            
            'material.required' => ':attributeが記入されていません',
            'material.string' => ':attributeが正しくありません',
            'material.max:50' => '50 文字以下で入力してください',
            
            'color.required' => ':attributeが記入されていません',
            'color.max:50' => '50 文字以下で入力してください',
            
            'status.required' => ':attributeが記入されていません',
            'status.max:50' => '50 文字以下で入力してください',
            
            'smell.required' => ':attributeが記入されていません',
            'smell.max:50' => '50 文字以下で入力してください',
            
            'size_height.required' => ':attributeが記入されていません',
            'size_height.numeric' => ':attributeは数字で入力してください',
            'size_height.regex' => '1cm から 999cm の範囲で入力してください',
            
            'size_length.required' => ':attributeが記入されていません',
            'size_length.numeric' => ':attributeは数字で入力してください',
            'size_length.regex' => '1cm から 999cm の範囲で入力してください',
            
            'size_sleeve.required' => ':attributeが記入されていません',
            'size_sleeve.numeric' => ':attributeは数字で入力してください',
            'size_sleeve.regex' => '1cm から 999cm の範囲で入力してください',
            
            'size_sleeves.required' => ':attributeが記入されていません',
            'size_sleeves.numeric' => ':attributeは数字で入力してください',
            'size_sleeves.regex' => '1cm から 999cm の範囲で入力してください',
            
            'size_front.required' => ':attributeが記入されていません',
            'size_front.numeric' => ':attributeは数字で入力してください',
            'size_front.regex' => '1cm から 999cm の範囲で入力してください',
            
            'size_back.required' => ':attributeが記入されていません',
            'size_back.numeric' => ':attributeは数字で入力してください',
            'size_back.regex' => '1cm から 999cm の範囲で入力してください',
            
            'detail.max:200' => '200 文字以下で入力してください',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '商品名',
            'image' => '商品画像',
            'category' => 'カテゴリ',
            'price' => '値段',
            'pref' => '発送元都道府県',
            'material' => '素材',
            'color' => '色',
            'status' => '商品状態',
            'smell' => 'におい',
            'size_height' => '身丈',
            'size_length' => '裄丈',
            'size_sleeve' => '袖丈',
            'size_sleeves' => '袖幅',
            'size_front' => '前幅',
            'size_back' => '後幅',
            'detail' => '自由記入欄',
        ];
    }
}