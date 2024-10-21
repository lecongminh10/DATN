<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;

use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
  const PATH_VIEW = 'client.';
  public $categoryService;
  public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    public function index(Request $request)
  {
    $categories = $this->getCategoriesForMenu();
    return view(self::PATH_VIEW . 'home', compact('categories'));
    
  }


  public function getCategoriesForMenu()
{
    // Lấy tất cả danh mục cha
    $parentCategories = $this->categoryService->getParent()->take(9);

    // Lấy danh mục con cho từng danh mục cha
    foreach ($parentCategories as $parent) {
        // Lấy danh mục con bằng cách sử dụng parent_id của danh mục cha
        $parent->children = $this->categoryService->getChildCategories($parent->id);
    }

    return $parentCategories; // Trả về danh mục cha với danh mục con
}

}
