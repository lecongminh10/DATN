<?php

namespace App\Services;

use App\Models\Category;
<<<<<<< HEAD
=======
use App\Repositories\CatalogueRepository;
>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
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
<<<<<<< HEAD
{
    $query = Category::query();
    if ($search) {
        $query->where('name', 'like', "%{$search}%");
=======
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
>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
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
<<<<<<< HEAD
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
=======
    {
        return Category::where('parent_id', $parentId)->get();
    }
>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
}