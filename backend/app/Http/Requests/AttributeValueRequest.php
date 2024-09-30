<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
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
            'id_attributes' => 'required|exists:attributes,id', 
            'attribute_value' => 'required|string|max:255', 
        ];
    }

    public function messages()
    {
        return [
            'id_attributes.required' => 'ID thuộc tính là bắt buộc.',
            'id_attributes.exists' => 'ID thuộc tính không tồn tại.',
            'attribute_value.required' => 'Giá trị thuộc tính là bắt buộc.',
            'attribute_value.string' => 'Giá trị thuộc tính phải là một chuỗi.',
            'attribute_value.max' => 'Giá trị thuộc tính không được vượt quá 255 ký tự.',
        ];
    }
}
