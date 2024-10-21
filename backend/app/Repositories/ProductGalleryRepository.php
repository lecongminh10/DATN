<?php

namespace App\Repositories;
use App\Models\ProductGallery;


class  ProductGalleryRepository extends BaseRepository
{
   protected $productGalleryRepository;

   public function __construct(ProductGallery $productGalleryRepository)
   {
      parent::__construct($productGalleryRepository);
      $this->productGalleryRepository = $productGalleryRepository;
   }

   public function getGalaryByProduct(int $id){
      return ProductGallery::where('product_id', $id)->select('id','image_gallery')->get();
   }

}
