<?php

namespace App\Repositories;

use App\Models\Attribute;

class AttributeRepository extends BaseRepository
{
    protected $model;

    public function __construct(Attribute $attributeRepository)
    {
        parent::__construct($attributeRepository);
        $this->model = $attributeRepository; // Đặt model là Attribute
    }

    public function getAll($search = null, $perPage = null)
    {
        $query = Attribute::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('attribute_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function isSoftDeleted(int $id): bool
    {
        $attribute = $this->model->withTrashed()->findOrFail($id);
        return $attribute ? $attribute->trashed() : false;
    }

}

