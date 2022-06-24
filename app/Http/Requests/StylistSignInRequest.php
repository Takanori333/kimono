<?php

namespace App\Http\Requests;

use App\Rules\stylist_signin;
use Illuminate\Foundation\Http\FormRequest;

class StylistSignInRequest extends FormRequest
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
            "form.email" => "required|email|max:50",
            "form.password" => "required|max:20",
            "form" => [new stylist_signin()]
        ];
    }

    // エラーメッセージの定義
    public function messages()
    {
        return [
            "form.email.required" => "メールアドレスが記入されていません",
            "form.email.email" => "メールアドレスの形式が正しくありません",
            "form.email.max" => "メールアドレスは50文字以下で入力してください",
            "form.password.required" => "パスワードが記入されていません",
            "form.password.max" => "パスワードは20文字以下で入力してください",
        ];
    }
}
