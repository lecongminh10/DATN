<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:tags,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string'   => 'Trường tên phải là một chuỗi ký tự.',
            'name.max'      => 'Trường tên không được vượt quá 255 ký tự.',
            'name.unique'   => 'Tên này đã tồn tại.',
        ];
    }
}
