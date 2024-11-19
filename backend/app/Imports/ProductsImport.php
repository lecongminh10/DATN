<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Xử lý nhiều URL ảnh (giả sử các URL ngăn cách bởi dấu phẩy)
        $imageUrls = explode(',', $row['image_urls']); // Tách các URL

        $imagePaths = [];
        foreach ($imageUrls as $imageUrl) {
            $imageUrl = trim($imageUrl, '"'); // Loại bỏ dấu ngoặc kép nếu có
            $imageUrl = urldecode($imageUrl); // Giải mã URL

            // Kiểm tra URL có hợp lệ không (URL bắt đầu bằng http hoặc file)
            if (preg_match('/^(http|https|file):\/\/.*/', $imageUrl)) {
                $imageName = basename($imageUrl);

                // Thêm đuôi .jpg nếu chưa có
                if (!preg_match('/\.(jpg|jpeg|png|webp)$/i', $imageName)) {
                    $imageName .= '.jpg';
                }

                $imagePath = 'public/products/gallery/' . $imageName;
                try {
                    Storage::put($imagePath, file_get_contents($imageUrl));
                    // Log::info('Ảnh đã được lưu tại: ' . $imagePath);
                    $imagePaths[] = $imagePath;  // Thêm vào danh sách ảnh để lưu trong product_galleries
                } catch (\Exception $e) {
                    // Log::error('Lỗi khi tải ảnh: ' . $e->getMessage());
                }
            } else {
                // Log::warning('Đường dẫn ảnh không hợp lệ hoặc không tồn tại: ' . $imageUrl);
            }
        }

        // Xử lý các logic

        // Lấy tên sản phẩm và mã sản phẩm, sử dụng giá trị mặc định nếu không có
        $name = $row['name'] ?? 'default-name';
        $code = $row['code'] ?? 'default-code';  // Lấy mã sản phẩm, nếu không có thì sử dụng giá trị mặc định

        // Kết hợp tên và mã sản phẩm để tạo slug
        $slugSource = $name . '-' . $code;  // Kết hợp name và code để tạo slug
        $slug = Str::slug($slugSource);  // Tạo slug từ chuỗi kết hợp

        $originalSlug = $slug;  // Lưu slug gốc để có thể thêm hậu tố nếu trùng lặp

        // Kiểm tra trùng lặp slug và thêm hậu tố
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;  // Thêm hậu tố vào slug
            $count++;
        }

        // Tạo mã sản phẩm ngẫu nhiên
        $code = strtoupper(Str::random(8));  // Mã ngẫu nhiên

        // Kiểm tra trùng lặp mã sản phẩm
        while (Product::where('code', $code)->exists()) {
            $code = strtoupper(Str::random(8)); // Tạo lại code nếu trùng lặp
        }

        // Tạo giá trị cho price (loại bỏ dấu phân cách)
        $priceRegular = str_replace(['.', ' VNĐ'], '', $row['price_regular']); // Xử lý giá bán
        $priceSale = isset($row['price_sale']) && !empty($row['price_sale']) ? str_replace(['.', ' VNĐ'], '', $row['price_sale']) : null; // Xử lý giá giảm, nếu không có thì gán null

        $isActive = isset($row['is_active']) ? $row['is_active'] : 1;  // Gán giá trị mặc định là 0 nếu không có giá trị
        $isHotDeal = isset($row['is_hot_deal']) ? $row['is_hot_deal'] : 0;  // Gán giá trị mặc định là 0 nếu không có giá trị
        $isShowHome = isset($row['is_show_home']) ? $row['is_show_home'] : 0;  // Gán giá trị mặc định là 0 nếu không có giá trị
        $isNew = isset($row['is_new']) ? $row['is_new'] : 0;  // Gán giá trị mặc định là 0 nếu không có giá trị
        $isGoodDeal = isset($row['is_good_deal']) ? $row['is_good_deal'] : 0;  // Gán giá trị mặc định là 0 nếu không có giá trị

        

        // Tạo sản phẩm mới
        $product = new Product([
            'category_id' => $row['category_id'],
            'code' => $code,    
            'name' => $row['name'],
            'short_description' => $row['short_description'],
            'content' => $row['content'],
            'price_regular' => $priceRegular,
            'price_sale' => $priceSale,
            'stock' => $row['stock'],
            'rating' => $row['rating'],
            'warranty_period' => $row['warranty_period'],
            'view' => $row['view'],
            'buycount' => $row['buycount'],
            'wishlistscount' => $row['wishlistscount'],
            'is_active' => $isActive,
            'is_hot_deal' => $isHotDeal,
            'is_show_home' => $isShowHome,
            'is_new' => $isNew,
            'is_good_deal' => $isGoodDeal,
            'slug' => $slug,
            'meta_title' => $row['meta_title'],
            'meta_description' => $row['meta_description'],
            'deleted_at' => $row['deleted_at'],
            'deleted_by' => $row['deleted_by'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);

        // Lưu sản phẩm
        $product->save();

        // Lưu từng ảnh vào bảng product_galleries
        foreach ($imagePaths as $index => $path) {
            ProductGallery::create([
                'product_id' => $product->id,
                'image_gallery' => $path,
                'is_main' => $index === 0,  // Đánh dấu ảnh đầu tiên là ảnh chính
            ]);
        }

        return $product;
    }
}
