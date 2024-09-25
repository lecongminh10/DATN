<?php

namespace App\Repositories;

use App\Models\ProductVariant;


class ProductVariantRepository extends BaseRepository
{
   protected $productVariantRepository;

   public function __construct(ProductVariant $productVariantRepository)
   {
      parent::__construct($productVariantRepository);
      $this->productVariantRepository = $productVariantRepository;
   }


}
