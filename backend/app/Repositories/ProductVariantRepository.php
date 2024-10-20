<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductVariantRepository extends BaseRepository
{
   protected $productVariantRepository;

   public function __construct(ProductVariant $productVariantRepository)
   {
      parent::__construct($productVariantRepository);
      $this->productVariantRepository = $productVariantRepository;
   }

     public function getVariantsByProductId($productId, $perPage = 3, $searchTerm = '')
    {
        $query = $this->productVariantRepository
            ->where('product_id', $productId)
            ->with(['attributeValues' => function($query) {
                $query->with('attribute');
            }]);

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('sku', 'like', '%' . $searchTerm . '%')
                ->orWhere('status', 'like', '%' . $searchTerm . '%');
            });
        }
        return $query->paginate($perPage);
    }

    public function getProductVariant(int $id)
    {
        return ProductVariant::with(['attributeValues.attribute'])
            ->where('product_id', $id)
            ->get()
            ->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'original_price' => $variant->original_price,
                    'price_modifier' => $variant->price_modifier,
                    'stock' => $variant->stock,
                    'sku' => $variant->sku,
                    'status' => $variant->status,
                    'variant_image' => $variant->variant_image,
                    'attributes' => $variant->attributeValues->map(function ($attributeValue) {
                        return [
                            'attribute_name' => $attributeValue->attribute->attribute_name,
                            'attribute_value' => $attributeValue->attribute_value,
                            'attribute_value_id' => $attributeValue->id,
                        ];
                    }),
                ];
            });
    }    

    public function getVariantByProduct(int $id){
        return ProductVariant::where('product_id', $id)->select('id','variant_image')->get();
    }

    public function getAttributeByProduct(int $id){
        return  DB::table('product_variants as pv')
                ->join('attributes_values as av', 'pv.product_attribute_id', '=', 'av.id')
                ->join('attributes as a', 'av.id_attributes', '=', 'a.id')
                ->where('pv.product_id', $id)
                ->select('a.id as attribute_id', 'a.attribute_name' , 'av.id as attribute_value_id'  ,'av.attribute_value')
                ->get();
    }
    public function getVariantByAttributes($attributes_values, $product_id)
    {
        $attributes = explode(',', $attributes_values);

        $attributeValueIds = AttributeValue::whereIn('attribute_value', $attributes)->pluck('id')->toArray();

        if (count($attributeValueIds) !== count($attributes)) {
            return null;
        }

        $productVariants = ProductVariant::where('product_id', $product_id)->get();

        // Lặp qua từng biến thể để kiểm tra
        foreach ($productVariants as $variant) {
            // Lấy tất cả attribute_value_id của biến thể này
            $variantAttributeIds = $variant->attributeValues()->pluck('attribute_value_id')->toArray();
    
            // Kiểm tra nếu tất cả attribute_value_id tìm được có trong biến thể
            if (!array_diff($attributeValueIds, $variantAttributeIds)) {
                // Nếu không có khác biệt, tức là tất cả các giá trị đều khớp
                return $variant;
            }
        }

        return null;
    }
    
    
    
}
