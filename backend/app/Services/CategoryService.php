<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CatalogueRepository;
use App\Repositories\CategoryRepository;

class CategoryService extends BaseService
{
    protected $categoryService;

    public function __construct(CategoryRepository $categoryService)
    {
        parent::__construct($categoryService);
        $this->categoryService = $categoryService;
    }

    public function getParentOrChild($search = null, $parentId = null)
{
    $query = Category::query();

    if ($search) {
        $query->where('name', 'like', "%{$search}%");
    }

    if ($parentId) {
        $query->where('parent_id', $parentId); // Giả sử bạn có trường parent_id
    }
    $query->orderBy('created_at', 'desc');

    return $query;
}
    public function getParent()
    {
        return $this->categoryService->getParent();
    }

    public function getNameandIdAll()
    {
        return $this->categoryService->getNameandIdAll();
    }

    public function getSeachCategory($search, $perPage)
    {
        return $this->categoryService->getAll($search, $perPage);
    }
    public function getChildCategories($parentId)
{
    return Category::where('parent_id', $parentId)->get();
}
}