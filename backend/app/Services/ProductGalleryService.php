<?php

namespace App\Services;
use App\Repositories\ProductGalleryRepository;

class ProductGalleryService extends BaseService
{
    protected $productGalleryService;

    public function __construct(ProductGalleryRepository $productGalleryService)
    {
        parent::__construct($productGalleryService);
        $this->productGalleryService = $productGalleryService;
    }

    public function getGalaryByProduct($id){
        return $this->productGalleryService->getGalaryByProduct($id);
    }

}
