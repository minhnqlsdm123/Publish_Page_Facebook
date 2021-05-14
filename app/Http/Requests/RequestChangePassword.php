<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestChangePassword extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'min:6|max:20',
            'confirm_password' => 'same:password',
        ];
    }
    public function messages()
    {
        return [
            'password.min' => 'Password có độ dài từ 6 đến 20 kí tự',
            'password.max' => 'Password có độ dài từ 6 đến 20 kí tự',
            'confirm_password.same' => 'Confirm password chưa khớp'
        ];
    }
}