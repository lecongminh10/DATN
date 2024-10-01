<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'attribute_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255', 
            'attribute_value' => 'array|max:255',
        ];
    }


    public function messages()
    {
        return [
            'attribute_name.required' => 'Tên thuộc tính là bắt buộc.',
            'attribute_name.string' => 'Tên thuộc tính phải là một chuỗi.',
            'attribute_name.max' => 'Tên thuộc tính không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả phải là một chuỗi.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        ];
    }
}
