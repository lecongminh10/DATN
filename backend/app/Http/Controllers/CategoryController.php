<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    const PATH_VIEW = 'admin.categories.';
    const PATH_UPLOAD = 'public/categories';

    public $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {

//  Số lượng bản ghi trên mỗi trang
    $perPage = 5;

    // Lấy danh mục cha (có parent_id = null) với phân trang
    $parentCategories = Category::whereNull('parent_id')->paginate($perPage);

    return view(self::PATH_VIEW . __FUNCTION__,  compact('parentCategories'));

    //     $search = $request->input('search');
    // $parentId = $request->input('parent_id'); // Lấy ID danh mục cha từ request

    // // Lấy danh mục theo điều kiện lọc và phân trang
    // $data = $this->categoryService->getParentOrChild($search, $parentId)->paginate(5);

    // // Lấy danh mục con cho từng danh mục cha và sắp xếp từ mới đến cũ
    // foreach ($data as $item) {
    //     $item->children = $this->categoryService->getChildCategories($item->id)->sortByDesc('created_at');
    // }

    // // Lấy danh mục cha để hiển thị trong dropdown (hoặc select)
    // $parentCategories = $this->categoryService->getParent();

    // return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'search', 'parentCategories', 'parentId'));
    }

    public function create()
    {
        $parentCategories = $this->categoryService->getParent();
        return view(self::PATH_VIEW . __FUNCTION__, compact('parentCategories'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->except('image');
        $data['is_active'] ??= 0;
        if ($request->hasFile('image')) {
            $relativePath = $request->file('image')->store(self::PATH_UPLOAD);
            $data['image'] = $relativePath;
        }
        // $result = $this->categoryService->saveOrUpdate($data);
        $this->categoryService->saveOrUpdate($data);
        return redirect()->route('admin.categories.index');
    }

    public function show($id)
    {
        $id = (int)$id;
        $data = $this->categoryService->getById($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function edit($id)
    {
        $id = (int)$id;
        $data = $this->categoryService->getById($id);
        $parentCategories = $this->categoryService->getParent();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'parentCategories'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $id = (int)$id;
        $model = $this->categoryService->getById($id);
        $data = $request->except('image');
        $data['is_active'] ??= 0;
        if ($request->hasFile('image')) {
            $relativePath = $request->file('image')->store(self::PATH_UPLOAD);
            $data['image'] = $relativePath;
        }
        $currentCover = $model->image;
        $filename = basename($currentCover);

        $this->categoryService->saveOrUpdate($data, $id);
        if ($request->hasFile('image') && $filename && Storage::exists(self::PATH_UPLOAD . '/' . $filename)) {
            Storage::delete(self::PATH_UPLOAD . '/' . $filename);
        }
        return redirect()->route('admin.categories.index')->with('success', 'Update successful');
    }

    public function destroy($id)
    {
        $id = (int)$id;
        $data = $this->categoryService->getById($id);
        $data->delete();
        return redirect()->route('admin.categories.index');
    }
    public function deleteMultiple(Request $request)
    {
        $categoryIds = $request->input('category_ids', []);
    if (empty($categoryIds)) {
        return redirect()->route('admin.categories.index')->with('error', 'No categories selected for deletion.');
    }

    Category::whereIn('id', $categoryIds)->delete();
    return redirect()->route('admin.categories.index')->with('success', 'Selected categories deleted successfully.');
    }
    public function trashed()
    {
        // Sắp xếp theo thời gian xóa mới nhất
        $trashedCategories = Category::onlyTrashed()
            ->orderBy('deleted_at', 'desc') // Sắp xếp theo trường deleted_at giảm dần
            ->paginate(5);
        return view('admin.categories.trashed', compact('trashedCategories'));
    }
    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.trashed')->with('success', 'Category restored successfully.');
    }

    public function hardDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('admin.categories.trashed')->with('success', 'Category permanently deleted.');
    }

    public function searchTrashed(Request $request)
    {
        $search = $request->input('search'); // Lấy từ khóa tìm kiếm
        $trashedCategories = Category::onlyTrashed()
            ->where('name', 'like', "%{$search}%") // Tìm kiếm theo tên
            ->paginate(30); // Phân trang kết quả
        return view('admin.categories.trashed', compact('trashedCategories', 'search'));
    }

    public function restoreMultiple(Request $request)
    {
        $categoryIds = $request->input('categories', []);
        if (empty($categoryIds)) {
            return redirect()->route('admin.categories.trashed')->with('error', 'No categories selected for restoration.');
        }

        Category::onlyTrashed()->whereIn('id', $categoryIds)->restore();
        return redirect()->route('admin.categories.trashed')->with('success', 'Selected categories restored successfully.');
    }

    public function hardDeleteMultiple(Request $request)
    {
        $categoryIds = $request->input('categories', []);
        if (empty($categoryIds)) {
            return redirect()->route('admin.categories.trashed')->with('error', 'No categories selected for deletion.');
        }
        // Xóa cứng các danh mục đã chọn
        Category::onlyTrashed()->whereIn('id', $categoryIds)->forceDelete();
        return redirect()->route('admin.categories.trashed')->with('success', 'Selected categories deleted permanently.');
    }
    public function updateParent(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:categories,id',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::find($request->id);
        $category->parent_id = $request->parent_id;
        $category->save();

        return response()->json(['success' => true]);
    }
    public function getCategoriesForMenu()
    {
        // Lấy tất cả danh mục cha
        $parentCategories = $this->categoryService->getParent();
        // Lấy danh mục con cho từng danh mục cha
        foreach ($parentCategories as $parent) {
            $parent->children = $this->categoryService->getChildCategories($parent->id);
        }
        return $parentCategories; // Trả về danh mục cha với danh mục con
    }
}
