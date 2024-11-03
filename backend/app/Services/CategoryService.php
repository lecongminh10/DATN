<?php

namespace App\Services;

use App\Models\Category;
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
        // Thêm điều kiện sắp xếp theo thời gian tạo giảm dần
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
  
    public function saveOrUpdate(array $data, $id = null)
    {
        if ($id) {
            $category = Category::findOrFail($id);
            $category->update($data);
        } else {
            Category::create($data); // Tạo mới danh mục
        }
    }
  
    public function findById($id)
    {
        return Category::findOrFail($id);
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
    
    public function getActiveCategoriesWithProducts()
    {
        return Category::with(['children' => function ($query) {
                                    $query->where('is_active', true)
                                        ->has('products'); // Only child categories with products
                                }])
                    ->whereNull('parent_id')          // Only top-level categories
                    ->where('is_active', true)        // Parent category is active
                    ->where(function ($query) {
                        $query->has('products')       // Parent category has products
                                ->orWhereHas('children', function ($query) {
                                    $query->where('is_active', true)
                                        ->has('products'); // Or at least one child has products
                                });
                    })
                    ->withCount('products')           // Count products for parent categories
                    ->get();
    }

    

}