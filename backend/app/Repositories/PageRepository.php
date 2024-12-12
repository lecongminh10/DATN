<?php

namespace App\Repositories;

use App\Models\Page;

class  PageRepository extends BaseRepository
{
    protected $pageRepository;

    public function __construct(Page $pageRepository) {
        parent::__construct($pageRepository);
        $this->pageRepository = $pageRepository;
    }
    public function getAll($search = null, $perPage = null)
    {
        $query = Page::query()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }
        return $query->paginate($perPage);
    }
    public function show_soft_delete($search = null, $perPage = 10) // $perPage mặc định là 10
    {
        $query = Page::onlyTrashed()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }
        $model = $query->paginate($perPage);

        return $model;
    }
    public function restore_delete($id)
    {
        $model = Page::onlyTrashed()->findOrFail($id);
        $model->deleted_by = null;
        $model->restore();
    }
}
