<?php

namespace App\Repositories;

use App\Models\Seo;

class  SeoRepository extends BaseRepository
{
    protected $seoRepository;

    public function __construct(Seo $seoRepository) {
        parent::__construct($seoRepository);
        $this->seoRepository = $seoRepository;
    }
    public function getAll($search = null, $perPage = null)
    {
        $query = Seo::query()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('meta_title', 'LIKE', '%' . $search . '%');
            });
        }
        return $query->paginate($perPage);
    }
    public function show_soft_delete($search = null, $perPage = 10) // $perPage mặc định là 10
    {
        $query = Seo::onlyTrashed()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('meta_title', 'LIKE', '%' . $search . '%');
            });
        }
        $model = $query->paginate($perPage);

        return $model;
    }
    public function restore_delete($id)
    {
        $model = Seo::onlyTrashed()->findOrFail($id);
        $model->restore();
        foreach ($model->products as $product) {
            $model->products()->updateExistingPivot($product->id, ['deleted_at' => null]);
        }
    }
}
