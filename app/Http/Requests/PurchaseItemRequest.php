<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'buyer_name' => 'required|string|max:20',
            'buyer_post' => 'required|digits:7|numeric',
            'buyer_address' => 'required|max:200',
            'payment_way' => 'required|string|in:代引き,クレジットカード,コンビニ払い'
        ];
    }

    public function messages(){
        return [
            'buyer_name.required' => ':attributeが記入されていません',
            'buyer_name.string' => ':attributeが正しくありません',
            'buyer_name.max' => ':attributeは20文字以下で入力してください',

            'buyer_post.required' => ':attributeが記入されていません',
            'buyer_post.digits' => ':attributeが正しくありません',
            'buyer_post.numeric' => ':attributeは数字で入力してください',

            'buyer_address.required' => ':attributeが記入されていません',
            'buyer_address.max' => ':attributeは200文字以下で入力してください',

            'payment_way.required' => ':attributeが記入されていません',
            'payment_way.in' => ':attributeが正しくありません',
        ];
    }

    public function attributes()
    {
        return [
            'buyer_name' => 'お名前',
            'buyer_post' => '郵便番号',
            'buyer_address' => '住所',
            'payment_way' => 'お支払い方法',
        ];
    }
}
