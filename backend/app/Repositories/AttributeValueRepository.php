<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeValueRepository extends BaseRepository
{
    protected $model;

    public function __construct(AttributeValue $atributeValue)
    {
        parent::__construct($atributeValue);
        $this->model = $atributeValue;
    }
    public function deleteValues(array $ids)
    {
        return $this->model->destroy($ids);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
    public function isSoftDeleted(int $id): bool
    {
        $attributeValue = $this->model->withTrashed()->findOrFail($id);
        return $attributeValue ? $attributeValue->trashed() : false;
    }
}
