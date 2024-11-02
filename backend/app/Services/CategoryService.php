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

    public function getParentOrChild($search = null)
{
    $query = Category::query(); // Tạo một truy vấn mới

    if ($search) {
        $query->where('name', 'like', '%' . $search . '%'); // Tìm kiếm theo tên
    }

    return $query->orderBy('created_at', 'desc'); // Trả về truy vấn mà không thực hiện truy vấn
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
}
