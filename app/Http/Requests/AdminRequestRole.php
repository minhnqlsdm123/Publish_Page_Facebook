<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequestRole extends FormRequest
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
            'name' => 'required|min:3|max:20',
            'display_name' => 'required|min:3|max:20',
            'permission' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name không được trống',
            'name.min' => 'Name có độ dài từ 3 đến 20 kí tự',
            'name.max' => 'Name có độ dài từ 3 đến 20 kí tự',
            'display_name.required' => 'Display name không được trống',
            'display_name.min' => 'Display name có độ dài từ 3 đến 20 kí tự',
            'display_name.max' => 'Display name có độ dài từ 3 đến 20 kí tự',
            'permission.required' => 'Bạn chưa chọn quyền'
        ];
    }
}