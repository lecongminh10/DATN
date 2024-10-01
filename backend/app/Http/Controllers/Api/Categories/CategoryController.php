<?php

namespace App\Http\Controllers\Api\Categories;

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
        $data = $this->categoryService->getParentOrChild();
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $categories = $this->categoryService->getSeachCategory($search, $perPage);
        return response()->json([
            'message' => 'success',
            'categories' => $categories,
            'data' => $data
        ], 200);
    }

    public function create()
    {
        // $parentCategory = $this->categoryService->getParent();
        // return view(self::PATH_VIEW . __FUNCTION__, compact('parentCategory'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->except('image');
        $data['is_active'] ??= 0;
        if ($request->hasFile('image')) {
            // $relativePath = $request->file('image')->store(self::PATH_UPLOAD);
            // $baseUrl = env('APP_URL') . '/storage';
            // $data['image'] = $baseUrl . '/' . str_replace('public/', '', $relativePath);
        }
        $result = $this->categoryService->saveOrUpdate($data);
        return response()->json([
            'data' => $result,
            'message' => 'Add success',
        ], 201);
    }

    public function show(int $id)
    {
        $data = $this->categoryService->getById($id);
        return response()->json(['data' => $data], 200);
    }

    public function edit(int $id)
    {
        $data = $this->categoryService->getById($id);
        $parentCategory = $this->categoryService->getParent();
        return response()->json(['data' => $data, 'parentCategory' => $parentCategory], 200);
    }

    public function update(CategoryRequest $request, int $id)
    {
        $model = $this->categoryService->getById($id);
        $data = $request->except('image');
        $data['is_active'] ??= 0;
        // $baseUrl = env('APP_URL') . '/storage';
        // if ($request->hasFile('cover')) {
        //     $relativePath = $request->file('cover')->store(self::PATH_UPLOAD);
        //     $data['cover'] = $baseUrl . '/' . str_replace('public/', '', $relativePath);
        // }
        // $currentCover = $model->cover;
        // $filename = basename($currentCover);

        $this->categoryService->saveOrUpdate($data, $id);
        // if ($request->hasFile('cover') && $filename && Storage::exists(self::PATH_UPLOAD . '/' . $filename)) {
        //     Storage::delete(self::PATH_UPLOAD . '/' . $filename);
        // }
        return response()->json([
            'data' => $data,
            'messages' => 'Update success'
        ], 200);
    }

    public function destroy(int $id)
    {
        $data = $this->categoryService->getIdWithTrashed($id);

        if (!$data) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $data->delete();
        if ($data->trashed()) {
            return response()->json(['message' => 'Category soft deleted successfully'], 200);
        }

        return response()->json(['message' => 'Category permanently deleted and cover file removed'], 200);
    }

    public function deleteMuitpalt(Request $request)
    {
        // Xác thực yêu cầu
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer', // Đảm bảo tất cả các ID là kiểu số nguyên
            'action' => 'required|string', // Thêm xác thực cho trường action
        ]);

        // Lấy các ID và action từ yêu cầu
        $ids = $request->input('ids'); // Lấy mảng ID
        $action = $request->input('action'); // Lấy giá trị của trường action

        if (count($ids) > 0) {
            foreach ($ids as $id) {

                switch ($action) {
                    case 'soft_delete':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->categoryService->isCategorySoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroy($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete':
                        foreach ($ids as $id) {
                            $this->hardDelete($id);
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);

                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
                }
            }
            return response()->json(['message' => 'Categories deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }

    public function hardDelete(int $id)
    {
        $data = $this->categoryService->getIdWithTrashed($id);

        if (!$data) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        // Xóa cứng category
        $data->forceDelete();

        // Nếu cần, có thể xóa hình ảnh liên quan
        // $currentImage = $data->image;
        // $filename = basename($currentImage);
        // if ($currentImage && Storage::exists(self::PATH_UPLOAD . '/' . $filename)) {
        //     Storage::delete(self::PATH_UPLOAD . '/' . $filename);
        // }

        return response()->json(['message' => 'Delete with success'], 200);
    }
}
