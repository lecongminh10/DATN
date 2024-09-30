<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function rules() {
        return [
            'permission_name' => 'required|string|max:255',
            'permissions_values' => 'required|array',
            'permissions_values.*.value' => 'required|string|max:255'
        ];
    }
}
