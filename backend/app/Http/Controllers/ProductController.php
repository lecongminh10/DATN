<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Models\Product;
use App\Services\ProductGalleryService;
use App\Services\ProductService;
use App\Services\ProductVariantService;
use App\Services\TagService;
use App\Services\AttributeService;
use App\Services\AttributeValueService;
use App\Models\Attribute;
use App\Services\CouponService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;


class ProductController extends Controller
{
    protected $productService;
    protected $tagService;
    protected $productVariantService;
    protected $productGalleryService;
    protected $attributeService;
    protected $attributeValueService;
    protected $categoryService;

    protected $couponService;
    // const PATH_UPLOAD = 'public/products'; => sau mở lại

    public function __construct(
        ProductService $productService,
        ProductVariantService $productVariantService,
        TagService $tagService,
        ProductGalleryService $productGalleryService,
        CategoryService $categoryService,
        AttributeService $attributeService,
        AttributeValueService $attributeValueService,
        CouponService $couponService,

    ) {
        $this->productService = $productService;
        $this->productVariantService = $productVariantService;
        $this->tagService = $tagService;
        $this->productGalleryService = $productGalleryService;
        $this->categoryService = $categoryService;
        $this->attributeService = $attributeService;
        $this->attributeValueService = $attributeValueService;
        $this->couponService = $couponService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $products = $this->productService->getSeachProduct($search, $perPage);
        return view('admin.products.list-product')->with([
            'products' => $products
        ]);
    }

    public function showProduct(int $id)
    {
        Artisan::call('generate:attributes-json');
        Artisan::call('generate:tags-json');
        $product = $this->productService->getById($id)->load(['category', 'tags', 'galleries']);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found');
        }
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $selectedTags = $product->tags->pluck('id')->toArray();
        $variants = $this->productVariantService->getProductVariant($id);
        return view('admin.products.show-product' ,compact('product','categories','selectedTags','variants'));
        
    }


    public function showAdd()
    {
        Artisan::call('generate:attributes-json');
        Artisan::call('generate:tags-json');
        Artisan::call('generate:coupons-json');
        session()->forget('product_attributes');
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $tags = $this->tagService->getAll();
        $attribute = $this->attributeService->getAll();
        $attributeValue = $this->attributeValueService->getAll();

        return view('admin.products.add-product')->with([
            'categories' => $categories,
            'tags' => $tags,
            'attribute' => $attribute,
            'attributeValue' => $attributeValue
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $dataProduct = $request->validated();
        unset($dataProduct['product_variants'], $dataProduct['product_galaries'] , $dataProduct['coupon'] , $dataProduct['addcoupon']);

        $dataProduct['is_active'] ??= 0;
        $dataProduct['is_hot_deal'] ??= 0;
        $dataProduct['is_show_home'] ??= 0;
        $dataProduct['is_new'] ??= 0;
        $dataProduct['is_good_deal'] ??= 0;

        if (!empty($dataProduct['name']) && !empty($dataProduct['code'])) {
            $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['code'];
        }
        $product = $this->productService->saveOrUpdate($dataProduct);

        if ($request->has('product_variants')) {
            foreach ($request->product_variants as $item) {
                $dataProductVariants = [
                    'product_id' => $product->id,
                    'price_modifier' => $item['price_modifier'],
                    'original_price' =>$item['original_price'],
                    'stock' => $item['stock'] ?? 0,
                    'status' => $item['status'] ?? '',
                    'sku' => substr(bin2hex(random_bytes(5)), 0, 10)
                ];
                if (isset($item['variant_image']) && $item['variant_image'] instanceof UploadedFile) {
                    $extension = $item['variant_image']->getClientOriginalExtension();
                    $imageName = time() . '_' . uniqid() . '.' . $extension;
                    $imagePath = $item['variant_image']->storeAs('public/products/variant_images', $imageName);
                    $dataProductVariants['variant_image'] = str_replace('public/', '', $imagePath);
                }
                $productVariant=$this->productVariantService->saveOrUpdate($dataProductVariants);
                $attributes = explode(',', $item['attributes_values']);
                $attributeValueIds = [];
                if(count($attributes)>0){
                    foreach($attributes as $value){
                      $id = $this->attributeValueService->getIdbyAttribute($value)->id;
                        if ($id) { 
                            $attributeValueIds[] = $id; 
                        }
                    }
                }
                if (!empty($attributeValueIds)) {
                    $productVariant->attributeValues()->attach($attributeValueIds);
                }

            }
        }

        if ($request->has('product_galaries')) {
            foreach ($request->product_galaries as $image_gallery) {
                $dataProductGallery = [
                    'product_id' => $product->id,
                    'is_main' => $image_gallery['is_main'] ?? 0, 
                ];
                if (isset($image_gallery['image_gallery']) && $image_gallery['image_gallery'] instanceof UploadedFile) {  
                    $extension = $image_gallery['image_gallery']->getClientOriginalExtension();
                    $imageName = time() . '_' . uniqid() . '.' . $extension;
                    $relativePath = $image_gallery['image_gallery']->storeAs('public/products/gallery', $imageName);
                    $dataProductGallery['image_gallery'] = str_replace('public/', '', $relativePath);
                    $this->productGalleryService->saveOrUpdate($dataProductGallery);
                }
            }
        }
        if ($request->has('product_tags')) {
            foreach ($request->product_tags as $tag_id) {
                $product->tags()->attach($tag_id);
            }
        }
        if($request->has('coupon')){
            $coupons = $request->coupon;
            foreach($coupons as $coupon){
                if($coupon>0){
                    foreach($coupon  as $value){
                        $setCoupon= $this->couponService->findByCode($value);
                        if($setCoupon){
                            $product->coupons()->attach($setCoupon->id);
                        }
                    }
                }
            }
        }
        if($request->has('addcoupon')){
            $coupon = $request->addcoupon;
            $couponData = [
                'applies_to'          => $coupon['applies_to'],
                'code'                => $coupon['code'],
                'description'         => $coupon['description'] ?? null,
                'discount_type'       => $coupon['discount_type'],
                'discount_value'      => $coupon['discount_value'],
                'max_discount_amount' => $coupon['max_discount_amount'] ?? null,
                'min_order_value'     => $coupon['min_order_value'] ?? null,
                'start_date'          => $coupon['start_date'] ?? null,
                'end_date'            => $coupon['end_date'] ?? null,
                'usage_limit'         => $coupon['usage_limit'] ?? null,
                'is_active'           => $coupon['is_active'] ? 1 : 0,
                'is_stackable'        => $coupon['is_stackable'] ? 1 : 0,
                'eligible_users_only' => $coupon['eligible_users_only'] ? 1 : 0,
                'created_by'          => auth()->id() ?? 1, // Lấy ID của người dùng hiện tại
            ];
            $setCoupon = $this->couponService->saveOrUpdate($couponData);
            if($setCoupon){
                $product->coupons()->attach($setCoupon->id);
            }
        }
        return redirect()->route('admin.products.listProduct')->with(['message'=>'Thêm sản phẩm thành công ']);
    }

    public function showUpdate(int $id)
    {
        Artisan::call('generate:attributes-json');
        Artisan::call('generate:tags-json');
        $product = $this->productService->getById($id)->load(['category', 'tags', 'galleries']);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found');
        }
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $selectedTags = $product->tags->pluck('id')->toArray();
        $variants = $this->productVariantService->getProductVariant($id);
        session()->forget('product_attributes');
        return view('admin.products.update-product', compact('product','categories','selectedTags','variants'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = $this->productService->getById($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $dataProduct = $request->except(['product_variants', 'product_galaries']);

        $dataProduct['is_active'] ??= 0;
        $dataProduct['is_hot_deal'] ??= 0;
        $dataProduct['is_show_home'] ??= 0;
        $dataProduct['is_new'] ??= 0;
        $dataProduct['is_good_deal'] ??= 0;

        if (!empty($dataProduct['name']) && !empty($dataProduct['code'])) {
            $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['code'];
        }

        $product = $this->productService->saveOrUpdate($dataProduct, $product->id);
        if ($request->has('product_variants')) {
            $currentVariants = $this->productVariantService->getVariantByProduct($id); 
            $submittedVariantIds = [];
            foreach ($request->product_variants as $item) {
                $dataProductVariants = [
                    'product_id' => $id,
                    'price_modifier' => $item['price_modifier'],
                    'original_price' => $item['original_price'],
                    'stock' => $item['stock'] ?? 0,
                    'status' => $item['status'] ?? '',
                    'sku' => $item['sku'] ?? substr(bin2hex(random_bytes(5)), 0, 10),
                ];
                if (isset($item['variant_image']) && $item['variant_image'] instanceof UploadedFile) {
                    $extension = $item['variant_image']->getClientOriginalExtension();
                    $imageName = time() . '_' . uniqid() . '.' . $extension;
                    $imagePath = $item['variant_image']->storeAs('public/products/variant_images', $imageName);
                    $dataProductVariants['variant_image'] = str_replace('public/', '', $imagePath);
                }
        
                if (isset($item['id'])) {
                    $submittedVariantIds[] = $item['id'];
                    $productVariant = $this->productVariantService->saveOrUpdate($dataProductVariants, $item['id']);
                } 
                else {
                    $existingVariant = $this->productVariantService->getVariantByAttributes($item['attributes_values'], $product->id);
                    $existingVariantData=[];
                    if ($existingVariant) {
                        $existingVariantData['stock'] = $existingVariant->stock + $item['stock'] ?? 0;
                        $productVariant = $this->productVariantService->saveOrUpdate($existingVariantData, $existingVariant->id);
                    } else {
                        $productVariant = $this->productVariantService->saveOrUpdate($dataProductVariants);
                    }
                }

                $attributes = explode(',', $item['attributes_values']);
                $attributeValueIds = [];
                if (!empty($attributes)) {
                    foreach ($attributes as $value) {
                        $value = trim($value);
                        $attributeValue = $this->attributeValueService->getIdByAttribute($value);
                        if ($attributeValue) {
                            $attributeValueIds[] = $attributeValue->id;
                        }
                    }
                }   
                if (!empty($attributeValueIds)) {
                    $productVariant->attributeValues()->sync($attributeValueIds);
                }
            }

            foreach ($currentVariants as $variant) {
                if (!in_array($variant->id, $submittedVariantIds)) {
                    $variantImagePath = public_path('storage/' . $variant->variant_image);
                    if (file_exists($variantImagePath) && ($variant->variant_image)) {
                        unlink($variantImagePath);
                    }
                    $variant->forceDelete();
                }
            }
        }
        if(empty($request->has('product_variants'))){
            $currentVariants = $this->productVariantService->getVariantByProduct($id); 
            if($currentVariants){
                foreach($currentVariants as $variant){
                    $variantImagePath = public_path('storage/' . $variant->variant_image);
                    if (file_exists($variantImagePath) && ($variant->variant_image)) {
                        unlink($variantImagePath);
                    }
                    $variant->forceDelete();
                }
            }
        }
        if ($request->has('product_galaries')) {
            $currentGalary = $this->productGalleryService->getGalaryByProduct($id);
            $submittedGalleryIds = [];
        
            foreach ($request->product_galaries as $image_gallery) {
                $dataProductGallery = [
                    'product_id' => $product->id,
                    'is_main' => $image_gallery['is_main'] ?? 0,
                ];
                if (isset($image_gallery['image_gallery']) && $image_gallery['image_gallery'] instanceof UploadedFile) {
                    $extension = $image_gallery['image_gallery']->getClientOriginalExtension();
                    $imageName = time() . '_' . uniqid() . '.' . $extension;
                    $relativePath = $image_gallery['image_gallery']->storeAs('public/products/gallery', $imageName);
                    $dataProductGallery['image_gallery'] = str_replace('public/', '', $relativePath);
                    $this->productGalleryService->saveOrUpdate($dataProductGallery);
                }
                if (isset($image_gallery['id'])) {
                    $submittedGalleryIds[] = $image_gallery['id']; // Keep track of submitted IDs
                    $this->productGalleryService->saveOrUpdate($dataProductGallery, $image_gallery['id']);
                }
            }
        
            foreach ($currentGalary as $item) {
                if (!in_array($item->id, $submittedGalleryIds)) {
                    $imagePath = public_path('storage/' . $item->image_gallery);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $item->forceDelete();
                }
            }
        }
        
        

        if ($request->has('product_tags')) {
            $product->tags()->sync($request->product_tags);
        }

        return back();
    }

    public function destroy(int $id)
    {
        $data = $this->productService->getById($id);

        if (!$data) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $data->delete();
        if ($data->trashed()) {
            return back()->with(['message'=>'Xóa thành công']);
        }

        return response()->json(['message' => 'Product permanently deleted and cover file removed'], 200);
    }

    public function restore(int $id)
    {
        $product = Product::withTrashed()->find($id);
        
        if ($product) {
            $product->restore();
            
            return back()->with(['message'=>'Khôi phục sản phẩm thành công']);
        }
           
        return back()->with(['message'=>'Khôi phục sản phẩm thất bại']);
        
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
                switch ($action) {
                    case 'soft_delete':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->productService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroy($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->productService->isSoftDeleted($id);
                            if($isSoftDeleted){
                                $this->hardDelete($id);
                            }
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);

                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
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
            return back()->with(['message'=>'Lỗi khi xóa sản phẩm']);
        }
        $data->forceDelete();
        return back()->with(['message'=>'Xóa sản phẩm thành công']);
    }

    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $data = $this->productService->show_soft_delete($search , $perPage);
        return view('admin.products.deleted', compact('data'));
    }
    public function getVariants(Request $request ,int $id)
    {
        $perPage = $request->get('per_page', 10); // Số mục mỗi trang
        $searchTerm = $request->get('search', ''); // Từ khóa tìm kiếm

        $variants = $this->productVariantService->getVariantsByProductId($id, $perPage, $searchTerm);

        return response()->json($variants);
    }
}
