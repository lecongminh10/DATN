<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|string|max:255|unique:categories,name', // Kiểm tra tính duy nhất của tên danh mục
            'image' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048', // Kiểm tra định dạng ảnh
        ];

        // Nếu đang thực hiện cập nhật (PUT/PATCH), bỏ qua bản ghi hiện tại
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = 'required|string|max:255|unique:categories,name,' . $this->route('category');
        }

        return $rules;
    }

    
    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.unique' => 'Tên danh mục đã tồn tại. Vui lòng chọn tên khác.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg.',
            'image.max' => 'Kích thước ảnh quá lớn.',
        ];
    }
}