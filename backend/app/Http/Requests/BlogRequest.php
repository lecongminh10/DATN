<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',  // Đảm bảo bài viết có nội dung
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $this->route('id'), // Kiểm tra duy nhất slug
            'meta_title' => 'required|string|max:255',  // Meta title không bắt buộc
            'meta_description' => 'nullable|string|max:255',  // Meta description không bắt buộc
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Hình ảnh thumbnail
            'is_published' => 'required|in:0,1',  // Trạng thái xuất bản
            'tags' => 'required|array',  // Mảng tags không bắt buộc
            
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề bài viết không được để trống.',
            'title.max' => 'Tiêu đề bài viết không được vượt quá 255 ký tự.',
            'content.required' => 'Nội dung bài viết không được để trống.',
            'slug.required' => 'Slug bài viết không được để trống.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
            'meta_title.max' => 'Meta title không được vượt quá 255 ký tự.',
            'meta_description.max' => 'Meta description không được vượt quá 255 ký tự.',
            'thumbnail.image' => 'Ảnh đại diện phải là một hình ảnh.',
            'thumbnail.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc gif.',
            'thumbnail.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'is_published.required' => 'Trạng thái xuất bản là bắt buộc.',
            'is_published.in' => 'Trạng thái xuất bản chỉ được là "0" (Chưa xuất bản) hoặc "1" (Đã xuất bản).',
            'tags.required' => 'Phải chọn ít nhất 1 thẻ.',
            
        ];
    }
}

