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

   public function getAttributeNameValue($idVariant) {
      return DB::table('product_variants')
      ->join('attributes', 'product_variants.product_attribute_id', '=', 'attributes.id')
      ->join('attributes_values', 'attributes.id', '=', 'attributes_values.id_attributes')
      ->where('product_variants.id', $idVariant)
      ->select('attributes.attribute_name', 'attributes_values.attribute_value')
      ->get();
   }

}
