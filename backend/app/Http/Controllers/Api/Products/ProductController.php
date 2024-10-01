<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
// use App\Models\Product;
use App\Services\ProductGalleryService;
use App\Services\ProductService;
use App\Services\ProductVariantService;
use App\Services\TagService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;
    protected $tagService;
    protected $productVariantService;
    protected $productGalleryService;

    // const PATH_UPLOAD = 'public/products'; => sau mở lại

    public function __construct(
        ProductService $productService,
        ProductVariantService $productVariantService,
        TagService $tagService,
        ProductGalleryService $productGalleryService,

    ) {
        $this->productService = $productService;
        $this->productVariantService = $productVariantService;
        $this->tagService = $tagService;
        $this->productGalleryService = $productGalleryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $baseUrl = env('APP_URL') . '/storage'; => sau mở lại
        $dataProduct = $request->except(['product_variants', 'product_galaries']);

        // Gán giá trị mặc định cho các trường boolean nếu không có
        $dataProduct['is_active'] ??= 0;
        $dataProduct['is_hot_deal'] ??= 0;
        $dataProduct['is_show_home'] ??= 0;
        $dataProduct['is_new'] ??= 0;
        $dataProduct['is_good_deal'] ??= 0;

        // Xử lý slug(tạo slug)
        if (!empty($dataProduct['name']) && !empty($dataProduct['code'])) {
            $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['code'];
        }

        // Xử lý images
        // if (isset($dataProduct['images']) && $dataProduct['images'] instanceof UploadedFile) {
        //     $relativePathProduct = $dataProduct['images']->store(self::PATH_UPLOAD);
        //     $dataProduct['images'] = $baseUrl . '/' . str_replace('public/', '', $relativePathProduct);
        // }

        $product = $this->productService->saveOrUpdate($dataProduct);

        if ($request->has('product_variants')) {
            $dataProductVariants = [];
            foreach ($request->product_variants as $item) {

                $dataProductVariants = [
                    'product_id' => $product->id,
                    'product_attribute_id' => $item['product_attribute_id'],
                    'price_modifier' => $item['price_modifier'],
                    'stock' => $item['stock'] ?? 0,
                    'sku' => $item['sku'] ?? null,
                    "status" => $item["status"] ?? 0,
                ];
                $this->productVariantService->saveOrUpdate($dataProductVariants);
            }

        }

        if ($request->has('product_galaries')) {
            foreach ($request->product_galaries as $image_gallery) {
                // Kiểm tra nếu image_gallery là một file tải lên hợp lệ
                if (isset($image_gallery['image_gallery'])) {

                    // if (isset($image_gallery['image_gallery']) && $image_gallery['image_gallery'] instanceof UploadedFile) => thay vào if
                    // $relativePath = $image_gallery['image_gallery']->store(self::PATH_UPLOAD);
                    // $dataProductGallery = $baseUrl . '/' . str_replace('public/', '', $relativePath); => khi muốn lưu và folder

                    $dataProductGallery = $image_gallery['image_gallery'];
                    $this->productGalleryService->saveOrUpdate([
                        'product_id' => $product->id,
                        'image_gallery' => $dataProductGallery,
                        'is_main' => $image_gallery['is_main'] ?? 0,  // Thiết lập giá trị is_main
                    ]);
                }
            }
        }

        if ($request->has('product_tags')) {
            foreach ($request->product_tags as $tag_id) {
                $product->tags()->attach($tag_id);
            }
        }

        return response()->json([
            'message' => 'Success',
            'product' => $product
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     // Lấy thông tin sản phẩm
    //     $product = $this->productService->getById($id);

    //     if ($product) {
    //         // Xóa mềm các biến thể của sản phẩm (nếu có)
    //         $product->variants()->delete();

    //         // Xóa mềm các ảnh liên quan đến sản phẩm
    //         $product->galleries()->delete();

    //         // Xóa mềm chính sản phẩm
    //         $product->delete();

    //         return redirect()->back()->with('success', 'Sản phẩm và các ảnh liên quan đã được xóa mềm.');
    //     }

    //     return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
    // }

    public function destroy(int $id)
    {
        $data = $this->productService->getIdWithTrashed($id);

        if (!$data) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $data->delete();
        if ($data->trashed()) {
            return response()->json(['message' => 'Product soft deleted successfully'], 200);
        }

        return response()->json(['message' => 'Product permanently deleted and cover file removed'], 200);
    }

    public function deleteMuitpalt(Request $request)
    {
        // Xác thực yêu cầu
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer', // Đảm bảo tất cả các ID là kiểu số nguyên
            'action' => 'required|string', // Thêm xác thực cho trường action
        ]);
    
        // Lấy các ID và action từ yêu cầu
        $ids = $request->input('ids'); // Lấy mảng ID
        $action = $request->input('action'); // Lấy giá trị của trường action
    
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                // Đảm bảo $id là số nguyên trước khi gọi hàm
                if (is_int($id)) {
                    switch ($action) {
                        case 'soft_delete':
                            $isSoftDeleted = $this->productService->isProductSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroy($id);  // Gọi destroy nếu chưa bị soft delete
                            }
                            break;
    
                        case 'hard_delete':
                            $this->hardDelete($id); // Gọi hardDelete
                            break;
    
                        default:
                            return response()->json(['message' => 'Invalid action'], 400);
                    }
                } else {
                    // Nếu có $id không hợp lệ, trả về lỗi
                    return response()->json(['message' => 'Invalid ID format'], 400);
                }
            }
            return response()->json(['message' => 'Products deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }
    

    public function hardDelete(int $id)
    {
        $data = $this->productService->getIdWithTrashed($id);

        if (!$data) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        // Xóa cứng sản phẩm
        $data->forceDelete();

        // Nếu cần, có thể xóa hình ảnh liên quan
        // $currentImage = $data->image;
        // $filename = basename($currentImage);
        // if ($currentImage && Storage::exists(self::PATH_UPLOAD . '/' . $filename)) {
        //     Storage::delete(self::PATH_UPLOAD . '/' . $filename);
        // }

        return response()->json(['message' => 'Delete with success'], 200);
    }


}
