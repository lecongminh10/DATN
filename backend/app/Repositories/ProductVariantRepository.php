<?php

namespace App\Repositories;

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
       $query = $this->productVariantRepository->where('product_id', $productId);

       if ($searchTerm) {
           $query->where(function($q) use ($searchTerm) {
               $q->where('sku', 'like', '%' . $searchTerm . '%')
                 ->orWhere('status', 'like', '%' . $searchTerm . '%');
           });
       }

       return $query->paginate($perPage);
   }

   public function getProductVariant(int $id){
    return DB::table('product_variants')
            ->join('attributes_values', 'product_variants.product_attribute_id', '=', 'attributes_values.id')
            ->join('attributes', 'attributes_values.id_attributes', '=', 'attributes.id')
            ->select(
                'product_variants.id',
                'product_variants.product_id',
                'product_variants.product_attribute_id', 
                'product_variants.original_price',
                'product_variants.price_modifier',
                'product_variants.stock',
                'product_variants.sku',
                'product_variants.status',
                'product_variants.variant_image',
                'attributes.attribute_name as attribute_name',
                'attributes_values.attribute_value as attribute_value',
                'attributes_values.id as product_attribute_id'
            )
            ->where('product_variants.product_id', $id)
            ->get();
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
}
