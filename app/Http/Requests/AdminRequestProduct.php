<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequestProduct extends FormRequest
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
            'name' => 'required|min:3|max:120|unique:products,pro_name,' . $this->id,
            'price' => 'required',
            'description' => 'required|min:3|max:255',
//            'content' => 'required',
            // 'keyword' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Dữ liệu không được trống',
            'name.unique' => 'Dữ liệu đã tồn tại trong hệ thống',
            'name.min' => 'Dữ liệu có độ dài từ 3 đến 120 kí tự',
            'name.max' => 'Dữ liệu có độ dài từ 3 đến 120 kí tự',
            'price.required' => 'Dữ liệu không được trống',
            'description.required' => 'Dữ liệu không được trống',
            'description.min' => 'Dữ liệu có độ dài từ 3 đến 255 kí tự',
            'description.max' => 'Dữ liệu có độ dài từ 3 đến 255 kí tự',
//            'content.required' => 'Dữ liệu không được trống',
            // 'keyword.required' => 'Dữ liệu không được trống',
        ];
    }
}
