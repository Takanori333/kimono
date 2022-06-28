<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeItemFavoriteRequest extends FormRequest
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
            'item_id' => 'required|regex:/^[1-9][0-9]*$/',
        ];
    }

    public function messages(){
        return [
            'user_id.required' => 'ログインしてください',
            'user_id.integer' => '値が不正です',

            'item_id.required' => '値が不正です',
            'item_id.integer' => '値が不正です',
        ];
    }
}
