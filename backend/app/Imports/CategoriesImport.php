<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CategoriesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        // Kiểm tra nếu trường 'name' có dữ liệu không
        if (empty($row['name'])) {
            // Log::error('Dữ liệu thiếu tên cho mục: ' . json_encode($row));  // Log lỗi
            return null;  // Bỏ qua dòng này nếu thiếu tên
        }

        $imageUrl = trim($row['image'], '"'); // Loại bỏ dấu ngoặc kép nếu có
        $imageUrl = urldecode($imageUrl);     // Giải mã URL (nếu cần)

        // Kiểm tra sự tồn tại của ảnh trên hệ thống
        if (isset($imageUrl) && file_exists($imageUrl)) {
            $imageName = basename($imageUrl);  // Lấy tên file từ đường dẫn
            $imagePath = 'public/categories/' . $imageName; // Đường dẫn lưu trong storage

            // Đọc nội dung của ảnh và lưu vào storage
            try {
                Storage::put($imagePath, file_get_contents($imageUrl)); // Lưu ảnh vào storage
                // Log::info('Ảnh đã được lưu tại: ' . $imagePath);
            } catch (\Exception $e) {
                // Log::error('Lỗi khi tải ảnh: ' . $e->getMessage());
            }
        } else {
            // Log::warning('Đường dẫn ảnh không hợp lệ hoặc không tồn tại: ' . $imageUrl);
        }


        // Trả về đối tượng Category mới với đường dẫn ảnh
        return new Category([
            'name' => $row['name'],
            'description' => $row['description'],
            'image' => $imagePath,  // Lưu đường dẫn ảnh vào database
            'parent_id' => $row['parent_id'],
            'is_active' => $row['is_active'],
            'deleted_at' => $row['deleted_at'],
            'deleted_by' => $row['deleted_by'],
            'created_at' => $row['created_at'], 
            'updated_at' => $row['updated_at'],
        ]);
    }

}
