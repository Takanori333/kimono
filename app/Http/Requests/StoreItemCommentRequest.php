<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemCommentRequest extends FormRequest
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
            'user_id' => 'required|regex:/^[1-9][0-9]*$/',
            'comment' => 'required|string|max:200',
        ];
    }

    public function messages(){
        return [
            'user_id.required' => 'ログインしてください',
            'user_id.regex' => '値が不正です',

            'comment.required' => 'テキストを入力してから送信してください',
            'comment.string' => ':attributeが正しくありません',
            'comment.max' => '200文字以内で入力してください',
        ];
    }

    public function attributes()
    {
        return [
            'comment' => 'コメント',
        ];
    }
}
