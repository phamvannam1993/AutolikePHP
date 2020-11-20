<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 6:45 AM
 */

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class GiftCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'string|required',
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
            'code.required' => 'Mã gift code không được bỏ trống',
            'g-recaptcha-response.required' => 'Bạn cần xác thực google captcha',
            'validation.captcha' => 'Xác thực captcha không thành công.'
        ];
    }
}