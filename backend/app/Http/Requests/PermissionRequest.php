<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function rules() {
        return [
            'permission_name' => 'required|string|max:255',
            'description1' => 'nullable|string',

            'value' => 'required|array', // Giá trị quyền phải là một mảng
            'value.*' => 'nullable|string|max:255', // Mỗi giá trị quyền không được để trống và tối đa 255 ký tự
            'description' => 'nullable|array', // Mô tả phải là một mảng
            'description.*' => 'nullable|string|max:1000', // Mô tả có thể để trống, tối đa 1000 ký tự
        ];
    }
}
