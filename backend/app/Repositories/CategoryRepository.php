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

    public function getCategoriesByParentIdAndName($parentId = null, $name = null, $perPage = 7)
    {
        $query = Category::query();

        // Tìm theo tên
        if (!is_null($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // Tìm theo parent_id
        if (!is_null($parentId)) {
            $query->where('parent_id', $parentId);
        } else {
            $query->whereNull('parent_id');
        }

        return $query->with('children')->paginate($perPage);
    }

    // public function show_soft_delete()

    public function show_soft_delete($search = null, $perPage = 10) // $perPage mặc định là 10
    {
        $query = Category::onlyTrashed()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        // if ($status) {
        //     $query->where('is_active', $status);
        // }
        $model = $query->paginate($perPage);

        return $model;
    }

}