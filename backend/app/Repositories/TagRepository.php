<?php

namespace App\Repositories;

use App\Models\Tag;

class  TagRepository extends BaseRepository
{
    protected $tagRepository;

    public function __construct(Tag $tagRepository) {
        parent::__construct($tagRepository);
        $this->tagRepository = $tagRepository;
    }
    public function getAll($search = null, $perPage = null)
    {
        $query = Tag::query()->oldest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }
        return $query->paginate($perPage);
    }
    public function getIdandNameAll() {
        $data = Tag::query()->pluck('name', 'id')->all();
        return $data;
    }
    public function show_soft_delete($search = null, $perPage = 10) // $perPage mặc định là 10
    {
        $query = Tag::onlyTrashed()->latest('id');

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
        $model = Tag::onlyTrashed()->findOrFail($id);
        $model->restore();
    }
}
