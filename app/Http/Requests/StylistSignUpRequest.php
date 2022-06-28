<?php

namespace App\Http\Requests;

use App\Rules\email_exist;
use Illuminate\Foundation\Http\FormRequest;

class StylistSignUpRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:50',
                new email_exist()
            ],            
            'phone' => 'required|digits_between:10,11|numeric',
            'sex' => 'required',
            'year' => 'required|integer|digits:4',
            'month' => 'required|numeric|digits_between:1,2',
            'day' => 'required|numeric|digits_between:1,2',
            'post' => 'required|digits:7|numeric',
            'address' => 'required|max:100',
            'password' => 'required|confirmed|max:20|min:8',
            'icon' => 'required',
        ];        
    }
    public function messages()
    {
        return [
            'name.required' => '名前が記入されていません',
            'name.string' => '名前が正しくありません',
            'name.max' => '名前は20文字以下で入力してください',
            
            'email.required' => 'メールアドレスが記入されていません',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'email.unique' => 'そのメールアドレスは既に使用されています',
            'email.confirmed' => 'メールアドレスが一致しません',
            'email.max' => 'メールアドレスは50文字以下で入力してください',
            
            'phone.required' => '電話番号が記入されていません',
            'phone.digits_between' => '電話番号が正しくありません（１０文字か１１文字、間隔、ハイフンなし）',
            'phone.numeric' => '電話番号は数字で入力してください',

            'sex.required' => '性別が選択されていません',

            'year.required' => '誕生年が記入されていません',
            'year.integer' => '誕生年は数字で入力してください',
            'year.digits' => '誕生年が正しくありません',

            'month.required' => '誕生月が記入されていません',
            'month.numeric' => '誕生月は数字で入力してください',
            'month.digits_between' => '誕生月が正しくありません',

            'day.required' => '誕生日が記入されていません',
            'day.numeric' => '誕生日は数字で入力してください',
            'day.digits_between' => '誕生日が正しくありません',

            'post.required' => '郵便番号が記入されていません',
            'post.numeric' => '郵便番号は数字で入力してください',
            'post.digits' => '郵便番号が正しくありません（７文字、間隔、ハイフンなし）',

            'address.required' => '住所が記入されていません',
            'address.max' => '住所は100文字以下で入力してください',

            'password.required' => 'パスワードが記入されていません',
            'password.confirmed' => 'パスワードが一致しません',
            'password.max' => 'パスワードは8文字以上20文字以下で入力してください',
            'password.min' => 'パスワードは8文字以上20文字以下で入力してください',

            'icon.required' => '画像を選択してください',
        ];
    }
}
