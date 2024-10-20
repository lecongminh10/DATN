<?php

namespace App\Services;

use App\Repositories\AttributeRepository;


class AttributeService extends BaseService
{
    protected $attributeRepository;


    public function __construct(AttributeRepository $attributeRepository)
    {
        parent::__construct($attributeRepository);
        $this->attributeRepository = $attributeRepository;
    }

    public function getAllAttribute($search, $perPage)
    {
        return $this->attributeRepository->getAll($search, $perPage);
    }

    public function show_soft_delete($search , $perPage)
    {
        return $this->attributeRepository->show_soft_delete($search , $perPage);
    }
    public function restore_delete($id)
    {
        return $this->attributeRepository->restore_delete($id);
    }
    
}
