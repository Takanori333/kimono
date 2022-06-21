<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'year' => 'required|integer|digits:4',
            'month' => 'required|integer|digits_between:1,2',
            'day' => 'required|integer|digits_between:1,2',
            'email' => 'required|email|max:50',
            'phone' => 'required|digits_between:10,11|numeric',
            'post' => 'required|digits:7|numeric',
            'address' => 'required|max:200',
            'password' => 'required|max:20',
            'height' => 'numeric|nullable|digits_between:1,3',
        ];
    }

    // エラーメッセージの定義
    public function messages()
    {
        return [
            'name.required' => "名前が記入されていません",
            'name.string' => "名前が正しくありません",
            'name.max' => "名前は20文字以下で入力してください",

            'year.required' => '誕生年が記入されていません',
            'year.integer' => '誕生年は数字で入力してください',
            'year.digits' => '誕生年が正しくありません',

            'month.required' => '誕生月が記入されていません',
            'month.integer' => '誕生月は数字で入力してください',
            'month.digits_between' => '誕生月が正しくありません',

            'day.required' => '誕生日が記入されていません',
            'day.integer' => '誕生日は数字で入力してください',
            'day.digits_between' => '誕生日が正しくありません',

            'email.required' => "メールアドレスが記入されていません",
            'email.email' => "メールアドレスの形式が正しくありません",
            'email.max' => "メールアドレスは50文字以下で入力してください",

            'phone.required' => "電話番号が記入されていません",
            'phone.digits_between' => "電話番号が正しくありません",
            'phone.numeric' => "電話番号は数字で入力してください",

            'post.required' => "郵便番号が記入されていません",
            'post.numeric' => "郵便番号は数字で入力してください",
            'post.digits' => "郵便番号が正しくありません",

            'address.required' => "住所が記入されていません",
            'address.max' => "住所は200文字以下で入力してください",

            'password.required' => "パスワードが記入されていません",
            'password.max' => "パスワードは20文字以下で入力してください",

            'height.numeric' => "身長は数字で入力してください",
            'height.digits_between' => "身長が正しくありません",
        ];
    }
}
