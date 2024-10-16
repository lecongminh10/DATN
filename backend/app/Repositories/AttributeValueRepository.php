<?php

namespace App\Repositories;

use App\Models\AttributeValue;

class AttributeValueRepository extends BaseRepository
{
    protected $model;

    public function __construct(AttributeValue $atributeValue)
    {
        parent::__construct($atributeValue);
        $this->model = $atributeValue;
    }

    public function getByAttributeId($attributeId)
    {
        return $this->model->where('id_attributes', $attributeId)->get();
    }
}
