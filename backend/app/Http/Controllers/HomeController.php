<?php

namespace App\Http\Controllers;
<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
=======

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
<<<<<<< HEAD
use Illuminate\Support\Facades\Storage;
=======

use Illuminate\Support\Facades\Storage;

>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
class HomeController extends Controller
{
  const PATH_VIEW = 'client.';
  public $categoryService;
  public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

<<<<<<< HEAD
=======

>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
    public function index(Request $request)
  {
    $categories = $this->getCategoriesForMenu();
    return view(self::PATH_VIEW . 'home', compact('categories'));
<<<<<<< HEAD
  }

=======
    
  }


>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
  public function getCategoriesForMenu()
{
    // Lấy tất cả danh mục cha
    $parentCategories = $this->categoryService->getParent()->take(9);
<<<<<<< HEAD
=======

>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
    // Lấy danh mục con cho từng danh mục cha
    foreach ($parentCategories as $parent) {
        // Lấy danh mục con bằng cách sử dụng parent_id của danh mục cha
        $parent->children = $this->categoryService->getChildCategories($parent->id);
    }
<<<<<<< HEAD
    return $parentCategories; // Trả về danh mục cha với danh mục con
}

}
=======

    return $parentCategories; // Trả về danh mục cha với danh mục con
}

}
>>>>>>> 4607b755be06a9326f90309a9787aec11106cddd
