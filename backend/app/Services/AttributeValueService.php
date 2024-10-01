<?php

namespace App\Services;

use App\Repositories\AttributeValueRepository;

class AttributeValueService extends BaseService
{
    protected $attributeValueService;

    public function __construct(AttributeValueRepository $attributeValueService)
    {
        parent::__construct($attributeValueService);
        $this->attributeValueService = $attributeValueService;
    }

    public function findById($id)
    {
        return $this->attributeValueService->find($id);
    }

    public function deleteValues(array $ids)
    {
        return $this->attributeValueService->deleteValues($ids);
    }

    public function isAttributeValueSoftDeleted(int $id): bool
    {
        $attribute = $this->attributeValueService->find($id);
        return $attribute && $attribute->trashed();
    }
}
