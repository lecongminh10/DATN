<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_active' => 'boolean',
        ];
        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục.',
        'description.required' => 'Mô tả không được để trống.',
        'image.image' => 'Tệp phải là hình ảnh.',
        'image.mimes' => 'Chỉ chấp nhận các định dạng: jpeg, png, jpg, gif.',
        ];
    }


}