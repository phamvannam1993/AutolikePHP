<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 6:06 AM
 */

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|required',
            'phone' => 'string|required',
            'password' => 'string|required|min:6',
            'referrer_code' => 'string|nullable',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'password.min' => 'Mật khẩu phải có tối thiểu 6 kí tự.',
            'g-recaptcha-response.required' => 'Bạn cần xác thực google captcha',
        ];
    }
}