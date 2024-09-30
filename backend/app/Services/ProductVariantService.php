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
}
