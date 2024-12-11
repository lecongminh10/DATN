<?php

namespace App\Repositories;

use App\Models\Attribute;

class AttributeRepository extends BaseRepository
{
    protected $model;

    public function __construct(Attribute $attributeRepository)
    {
        parent::__construct($attributeRepository);
        $this->model = $attributeRepository;
    }

    public function getAll($search = null, $perPage = null)
    {
        $query = Attribute::query()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('attribute_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function show_soft_delete($search = null, $perPage = 10) // $perPage mặc định là 10
    {
        $query = Attribute::onlyTrashed()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('attribute_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }
        $model = $query->paginate($perPage);
        return $model;
    }

    public function restore_delete($id)
    {
        $model = Attribute::onlyTrashed()->findOrFail($id);
        $model->deleted_by = null;
        $model->restore();
    }
}
