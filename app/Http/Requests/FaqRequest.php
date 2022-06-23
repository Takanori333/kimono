<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
            "question" => "required|string|max:200",
            "answer" => "required|string|max:200",
        ];
    }

    // エラーメッセージの定義
    public function messages()
    {
        return [
            "question.required" => "質問が記入されていません",
            "question.string" => "質問が正しくありません",
            "question.max" => "質問は200文字以下で入力してください",
            
            "answer.required" => "回答が記入されていません",
            "answer.string" => "回答が正しくありません",
            "answer.max" => "回答は200文字以下で入力してください",
        ];
    }
}
