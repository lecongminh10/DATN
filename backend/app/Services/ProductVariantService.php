<?php

namespace App\Services;

use App\Repositories\ProductVariantRepository;


class ProductVariantService extends BaseService
{
    protected $productVariantService;

    public function __construct(ProductVariantRepository $productVariantService)
    {
        parent::__construct($productVariantService);
        $this->productVariantService = $productVariantService;
    }

    public function getVariantsByProductId($productId, $perPage, $searchTerm){
        return $this->productVariantService->getVariantsByProductId($productId, $perPage, $searchTerm );
    }

    public function getProductVariant($id){
        return $this->productVariantService->getProductVariant($id);
    }

    public function getVariantByProduct($id){
        return $this->productVariantService->getVariantByProduct($id);
    }

    public function getAttributeByProduct($id){
        return $this->productVariantService->getAttributeByProduct($id);
    }
}
