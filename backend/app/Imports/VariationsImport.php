<?php
namespace App\Imports;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// use Illuminate\Support\Carbon;

class VariationsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $imageUrl = trim($row['variant_image'], '"'); // Loại bỏ dấu ngoặc kép nếu có
        $imageUrl = urldecode($imageUrl);     // Giải mã URL (nếu cần)

        // Kiểm tra sự tồn tại của ảnh trên hệ thống
        if (isset($imageUrl) && file_exists($imageUrl)) {
            $imageName = basename($imageUrl);  // Lấy tên file từ đường dẫn
            $imagePath = 'products/variant_images/' . $imageName; // Đường dẫn lưu trong storage

            // Đọc nội dung của ảnh và lưu vào storage
            try {
                Storage::put($imagePath, file_get_contents($imageUrl)); // Lưu ảnh vào storage
                Log::info('Ảnh đã được lưu tại: ' . $imagePath);
            } catch (\Exception $e) {
                Log::error('Lỗi khi tải ảnh: ' . $e->getMessage());
            }
        } else {
            Log::warning('Đường dẫn ảnh không hợp lệ hoặc không tồn tại: ' . $imageUrl);
        }

        return new ProductVariant([
            'product_id' => $row['product_id'],
            'price_modifier' => $row['price_modifier'],
            'original_price' => $row['original_price'],
            'stock' => $row['stock'],
            'sku' => $row['sku'],
            'status' => $row['status'],
            'variant_image' => $imagePath,
            'deleted_at' => $row['deleted_at'],
            'deleted_by' => $row['deleted_by'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }
}
