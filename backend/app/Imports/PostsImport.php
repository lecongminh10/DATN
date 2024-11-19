<?php

namespace App\Imports;

use App\Jobs\DownloadImage;
use App\Models\Post;
// use Faker\Core\File;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class PostsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $imageUrl = trim($row['thumbnail'], '"'); // Loại bỏ dấu ngoặc kép nếu có
        $imageUrl = urldecode($imageUrl);     // Giải mã URL (nếu cần)

        // Kiểm tra sự tồn tại của ảnh trên hệ thống
        if (isset($imageUrl) && file_exists($imageUrl)) {
            $imageName = basename($imageUrl);  // Lấy tên file từ đường dẫn
            $imagePath = 'public/posts/' . $imageName; // Đường dẫn lưu trong storage

            // Đọc nội dung của ảnh và lưu vào storage
            try {
                Storage::put($imagePath, file_get_contents($imageUrl)); // Lưu ảnh vào storage
                // Log::info('Ảnh đã được lưu tại: ' . $imagePath);
            } catch (\Exception $e) {
                // Log::error('Lỗi khi tải ảnh: ' . $e->getMessage());
            }
        } else {
            Log::warning('Đường dẫn ảnh không hợp lệ hoặc không tồn tại: ' . $imageUrl);
        }

        return new Post([
            'title' => $row['title'],
            'content' => $row['content'],
            'slug' => $row['slug'],
            'meta_title' => $row['meta_title'],
            'meta_description' => $row['meta_description'],
            'thumbnail' => $imagePath,
            'user_id' => $row['user_id'],
            'is_published' => $row['is_published'],
            'published_at' => $row['published_at'],
            'deleted_at' => $row['deleted_at'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }
}
