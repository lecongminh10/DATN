<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'is_active' => 'required|in:1,0',
            'permalink' => 'required|string|max:255|unique:pages,permalink',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ];
    }

    /**
     * Tùy chọn, trả về thông báo lỗi tùy chỉnh nếu cần.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên trang là bắt buộc.',
            'name.string' => 'Tên trang phải là chuỗi văn bản.',
            'name.max' => 'Tên trang không được vượt quá 255 ký tự.',

            'content.required' => 'Nội dung trang là bắt buộc.',
            'content.string' => 'Nội dung phải là chuỗi văn bản.',

            'is_active.required' => 'Trạng thái hoạt động là bắt buộc.',
            'is_active.in' => 'Trạng thái hoạt động phải là 1 (Hoạt động) hoặc 0 (Không hoạt động).',

            'permalink.required' => 'Permalink là bắt buộc.',
            'permalink.string' => 'Permalink phải là chuỗi văn bản.',
            'permalink.max' => 'Permalink không được vượt quá 255 ký tự.',
            'permalink.unique' => 'Permalink phải là duy nhất.',

            'image.image' => 'Hình ảnh phải là một file hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif, hoặc svg.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',

            'seo_title.string' => 'Tiêu đề SEO phải là chuỗi văn bản.',
            'seo_title.max' => 'Tiêu đề SEO không được vượt quá 255 ký tự.',

            'seo_description.string' => 'Mô tả SEO phải là chuỗi văn bản.',
            'seo_description.max' => 'Mô tả SEO không được vượt quá 500 ký tự.',
        ];
    }
}
