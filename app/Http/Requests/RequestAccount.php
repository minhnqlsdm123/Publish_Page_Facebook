<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestAccount extends FormRequest
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
            'name' => 'min:6|max:20',
            'email' => 'email|unique:account,email' . $this->id,
            'password' => 'min:6|max:20',
            'confirm_password' => 'same:password',
        ];
    }
    public function messages()
    {
        return [
            'name.min' => 'Fullname có độ dài từ 6 đến 20 kí tự',
            'name.max' => 'Fullname có độ dài từ 6 đến 20 kí tự',
            'email.email' => 'Email chưa đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'password.min' => 'Password có độ dài từ 6 đến 20 kí tự',
            'password.max' => 'Password có độ dài từ 6 đến 20 kí tự',
            'confirm_password.same' => 'Confirm password chưa khớp'
        ];
    }
}