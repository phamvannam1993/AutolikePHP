<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 6:45 AM
 */

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|required',
            'bank_name' => 'string|nullable',
            'bank_account_name' => 'string|nullable',
            'bank_account_number' => 'string|nullable',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ và tên không được bỏ trống.',
        ];
    }
}