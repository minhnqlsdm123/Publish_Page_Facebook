<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequestCategory extends FormRequest
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
            'name' => 'required|min:3|max:120|unique:category,c_name,' . $this->id,
            'keyword' => 'required',
            'description' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Dữ liệu không được trống',
            'name.min' => 'Dữ liệu có độ dài từ 3 đến 120 kí tự',
            'name.max' => 'Dữ liệu có độ dài từ 3 đến 120 kí tự',
            'name.unique' => 'Dữ liệu đã tồn tại trong hệ thống',
            'keyword.required' => 'Dữ liệu không được trống',
            'description.required' => 'Dữ liệu không được trống',
        ];
    }
}