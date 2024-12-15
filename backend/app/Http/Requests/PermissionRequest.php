<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'permission_name' => 'required|string|max:255|unique:permissions,permission_name',
            'description1' => 'nullable|string',
    
            'value' => ['required', 'array'], // Giá trị quyền phải là một mảng
            'value.*' => ['nullable', 'string', 'max:255'], // Mỗi giá trị phải là chuỗi và có độ dài tối đa
    
            'description' => 'nullable|array', // Mô tả phải là một mảng
            'description.*' => 'nullable|string|max:1000', // Mỗi mô tả không được vượt quá 1000 ký tự
        ];
    
        // Nếu đang thực hiện cập nhật (PUT/PATCH), bỏ qua bản ghi hiện tại
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['permission_name'] = 'required|string|max:255|unique:permissions,permission_name,' . $this->route('permission');
        }
    
        // Custom validation for unique values within the array
        $rules['value'] = [
            'required',
            'array',
            function ($attribute, $values, $fail) {
                if (count($values) !== count(array_unique($values))) {
                    $fail('Các giá trị trong ' . $attribute . ' phải là duy nhất.');
                }
            },
        ];
    
        return $rules;
    }

    public function messages()
    {
        return [
            'permission_name.required' => 'Tên quyền là bắt buộc.',
            'permission_name.unique' => 'Tên quyền đã tồn tại. Vui lòng chọn tên khác.',
            'value.required' => 'Giá trị không được bỏ trống.',
            'value.unique' => 'Các giá trị trong danh sách phải là duy nhất.',
        ];
    }
}
