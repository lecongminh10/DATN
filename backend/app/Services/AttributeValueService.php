<?php

namespace App\Services;

use App\Repositories\AttributeValueRepository;

class AttributeValueService extends BaseService
{
    protected $attributeValueRepository;

    public function __construct(AttributeValueRepository $attributeValueRepository)
    {
        parent::__construct($attributeValueRepository);
        $this->attributeValueRepository = $attributeValueRepository;
    }

}
