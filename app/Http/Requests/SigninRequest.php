<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
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
            "email" => "required|email|max:50",
            "password" => "required|max:20",
        ];
    }

    // エラーメッセージの定義
    public function messages()
    {
        return [
            "email.required" => "メールアドレスが記入されていません",
            "email.email" => "メールアドレスの形式が正しくありません",
            "email.max" => "メールアドレスは50文字以下で入力してください",
            "password.required" => "パスワードが記入されていません",
            "password.max:20" => "パスワードは20文字以下で入力してください",
        ];
    }
}
