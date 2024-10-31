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

        return $query->orderBy('created_at', 'desc')->paginate(7); 
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
        return Category::where('parent_id', $parentId)->limit(20)->get();
    }
    public function getCategoriesWithChildren($search = null, $parentId = null, $perPage = 5)
    {
        $query = Category::query()->whereNull('parent_id');
    
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
    
        if ($parentId) {
            $query->orWhere('id', $parentId);
        }
    
        // Sử dụng paginate thay vì get
        $parentCategories = $query->with(['children' => function($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            }
        }])->paginate($perPage);
    
        return $parentCategories;
    }
    
}