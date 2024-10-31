<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    protected $categoryRepository;

    public function __construct(Category $categoryRepository)
    {
        parent::__construct($categoryRepository);
        $this->categoryRepository = $categoryRepository;
    }
    public function getParentOrChild()
    {
        $data = Category::query()->with(['parent', 'children'])->latest('id')->get();
        return $data;
    }
    public function getParent()
    {
        $data = Category::query()->with('children')->whereNull('parent_id')->paginate(7);
        return $data;
    }

    public function getNameandIdAll()
    {
        $data = Category::query()->with(['parent', 'children'])->pluck('name', 'id')->all();
        return $data;
    }

    public function isSoftDeleted(int $id): bool
    {
        $category = $this->model->withTrashed()->findOrFail($id);
        return $category ? $category->trashed() : false;
    }

    public function getAll($search = null, $perPage = null)
    {
        $query = Category::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }
}