<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
// use App\Models\Product;
use App\Services\ProductGalleryService;
use App\Services\ProductService;
use App\Services\ProductVariantService;
use App\Services\TagService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

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

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $products = $this->productService->getSeachProduct($search, $perPage);
        return response()->json([
            'message' => 'success',
            'products' => $products,
        ], 200);
    }

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

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
       // Tìm product bằng id
        $product = $this->productService->getById($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // $baseUrl = env('APP_URL') . '/storage'; => sau mở lại
        $dataProduct = $request->except(['product_variants', 'product_galaries','product_tags']);

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

        // Cập nhật dữ liệu của product
        $product = $this->productService->saveOrUpdate($dataProduct, $product->id);

        // Xử lý cập nhật product variants
        if ($request->has('product_variants')) {
            foreach ($request->product_variants as $item) {
                $dataProductVariant = [
                    'product_id' => $product->id,
                    'product_attribute_id' => $item['product_attribute_id'],
                    'price_modifier' => $item['price_modifier'],
                    'stock' => $item['stock'] ?? 0,
                    'sku' => $item['sku'] ?? null,
                    'status' => $item['status'] ?? 0,
                ];

                // Nếu có `id` thì cập nhật, nếu không có thì tạo mới
                if (isset($item['id'])) {
                    $this->productVariantService->saveOrUpdate($dataProductVariant, $item['id']);
                } else {
                    $this->productVariantService->saveOrUpdate($dataProductVariant);
                }
            }
        }

        // Xử lý cập nhật product galleries
        if ($request->has('product_galaries')) {
            foreach ($request->product_galaries as $image_gallery) {
                // Kiểm tra nếu `image_gallery` là một file tải lên hợp lệ
                if (isset($image_gallery['image_gallery'])) {
                    $dataProductGallery = $image_gallery['image_gallery'];
                    
                    $galleryData = [
                        'product_id' => $product->id,
                        'image_gallery' => $dataProductGallery,
                        'is_main' => $image_gallery['is_main'] ?? 0,  // Thiết lập giá trị is_main
                    ];

                    // Nếu có `id` thì cập nhật, nếu không có thì tạo mới
                    if (isset($image_gallery['id'])) {
                        $this->productGalleryService->saveOrUpdate($galleryData, $image_gallery['id']);
                    } else {
                        $this->productGalleryService->saveOrUpdate($galleryData);
                    }
                }
            }
        }

        // Xử lý cập nhật product tags
        if ($request->has('product_tags')) {
            $product = Product::with('tags')->find($id);
            if ($product != null) {
                $product_tags_currents=[];
                if( $product->tags){
                    $product_tags_currents = $product->tags->pluck('id')->toArray();
                }
                $newTags = $request->input('product_tags'); 
                $tagsToAdd = [];
                $tagsToRemove = [];

                foreach ($newTags as $newTag) {
                    if (!in_array($newTag, $product_tags_currents)) {
                        $tagsToAdd[] = $newTag;
                    }
                }
                foreach ($product_tags_currents as $currentTag) {
                    if (!in_array($currentTag, $newTags)) {
                        $tagsToRemove[] = $currentTag;
                    }
                }

                if (count($tagsToRemove) > 0) {
                    $product->tags()->detach($tagsToRemove);  
                }
                if (count($tagsToAdd) > 0) {
                    $product->tags()->attach($tagsToAdd);  
                }
            }
        }
        return response()->json([
            'message' => 'Update successful',
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
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
                switch ($action) {
                    case 'soft_delete':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->productService->isProductSoftDeleted($id);
                            if(!$isSoftDeleted){
                                Product::destroy($id); 
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);
        
                    case 'hard_delete':
                        foreach ($ids as $id) {
                            $this->hardDelete($id); 
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);
        
                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
                }
            }
            return response()->json(['message' => 'Categories deleted successfully'],200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }

    public function hardDelete(int $id)
    {
         $data = $this->productService->getIdWithTrashed($id);
    
        if (!$data) {
            return response()->json(['message' => 'Category not found.'], 404);
        }
    
        // Xóa cứng category
        $data->forceDelete();
    
        // Nếu cần, có thể xóa hình ảnh liên quan
        // $currentImage = $data->image;
        // $filename = basename($currentImage);
        // if ($currentImage && Storage::exists(self::PATH_UPLOAD . '/' . $filename)) {
        //     Storage::delete(self::PATH_UPLOAD . '/' . $filename);
        // }
    
        return response()->json(['message' => 'Delete with success'], 200);
    }

    public function destroy(string $id)
    {
        
    }
}
