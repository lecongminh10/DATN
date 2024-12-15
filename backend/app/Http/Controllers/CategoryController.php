<?php

namespace App\Http\Controllers;

use App\Events\AdminActivityLogged;
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
        $parent_id = $request->parent_id;
        $search = $request->search;
        $perPage = 10;

        $data = $this->categoryService->getCategoriesByParentIdAndName($parent_id, $search, $perPage);

        $parentCategories = Category::whereNull('parent_id')->with('children')->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'parentCategories'));
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
        $this->categoryService->saveOrUpdate($data);

        $logDetails = sprintf(
            'Thêm mới danh mục: Tên - %s',
            $data['name']
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id, 
            'Thêm mới',         
            $logDetails         
        ));


        return redirect()->route('admin.categories.index')->with('success','Thêm mới danh mục thành công');
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

        $logDetails = sprintf(
            'Sửa danh mục: Tên - %s',
            $data['name']
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id, 
            'Sửa',         
            $logDetails         
        ));

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy($id)
    {
        $id = (int) $id;
        $data = $this->categoryService->getById($id);

        $user = auth()->user();
        $data->deleted_by = $user->id;
        $data->save();

        $data->delete();

        $logDetails = sprintf(
            'Xóa danh mục: Tên danh mục - %s, ID người xóa - %d, Tên người xóa - %s, Ngày xóa - %s',
            $data->username,
            $user->id,
            $user->username,
            now()->format('d-m-Y H:i:s')
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            $user->id, 
            'Xóa',         
            $logDetails     
        ));

        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục thành công.');
    }
    public function deleteMultiple(Request $request)
    {
        $categoryIds = $request->input('category_ids', []);
        if (empty($categoryIds)) {
            return redirect()->route('admin.categories.index')->with('error', 'Không có danh mục nào được chọn để xóa.');
        }

        $user = auth()->user();

        $categories = Category::whereIn('id', $categoryIds)->get();

        foreach ($categories as $category) {
            $logDetails = sprintf(
                'Xóa danh mục: Tên danh mục - %s, ID danh mục - %d, ID người xóa - %d, Tên người xóa - %s, Ngày xóa - %s',
                $category->name,
                $category->id,
                $user->id, 
                $user->username,
                now()->format('d-m-Y H:i:s')
            );

            event(new AdminActivityLogged(
                $user->id,
                'Xóa',
                $logDetails 
            ));
        }

        Category::whereIn('id', $categoryIds)
        ->update(['deleted_by' => $user->id,
                                'deleted_at' => now(),
                                ]);
        Category::whereIn('id', $categoryIds)->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa thành công danh mục đã chọn.');
    }
    public function trashed(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perpage', 5);

        $trashedCategories = $this->categoryService->show_soft_delete($search, $perPage);

        return view('admin.categories.trashed', compact('trashedCategories', 'search', 'perPage'));
    }
    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.trashed')->with('success', 'Đã khôi phục danh mục thành công.');
    }

    public function hardDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('admin.categories.trashed')->with('success', 'Danh mục bị xóa vĩnh viễn.');
    }

    public function restoreMultiple(Request $request)
    {
        $categoryIds = $request->input('categories', []);

        if (empty($categoryIds)) {
            return redirect()->route('admin.categories.trashed')->with('error', 'Không có danh mục nào được chọn để khôi phục.');
        }

        if (is_string($categoryIds)) {
            $categoryIds = explode(',', $categoryIds);
        }

        $categoryIds = array_map('intval', $categoryIds);

        Category::onlyTrashed()->whereIn('id', $categoryIds)->restore();

        return redirect()->route('admin.categories.trashed')->with('success', 'Khôi phục thành công các danh mục đã chọn.');
    }

    public function hardDeleteMultiple(Request $request)
    {
        $categoryIds = $request->input('categories', []);
        if (empty($categoryIds)) {
            return redirect()->route('admin.categories.trashed')->with('error', 'Không có danh mục nào được chọn để xóa.');
        }
        // Xóa cứng các danh mục đã chọn
        Category::onlyTrashed()->whereIn('id', $categoryIds)->forceDelete();
        return redirect()->route('admin.categories.trashed')->with('success', 'Các danh mục đã chọn đã bị xóa vĩnh viễn.');
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
