<?php

namespace App\Services;

use App\Repositories\AttributeRepository;


class AttributeService extends BaseService
{
    protected $attributeService;


    public function __construct(AttributeRepository $attributeService)
    {
        parent::__construct($attributeService);
        $this->attributeService = $attributeService;
    }

    public function getAllAttribute($search, $perPage)
    {
        return $this->attributeService->getAll($search, $perPage);
    }

    public function findById($id)
    {
        return $this->attributeService->find($id);
    }


    public function isAttributeSoftDeleted(int $id): bool
    {
        $attribute = $this->attributeService->find($id);
        return $attribute && $attribute->trashed();
    }
}
