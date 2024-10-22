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
    $search = $request->input('search');
    $parentId = $request->input('parent_id'); // Lấy ID danh mục cha từ request
    // Lấy danh mục theo điều kiện lọc
    $data = $this->categoryService->getParentOrChild($search, $parentId)->paginate(5);
    // Lấy danh mục con cho mọi danh mục trong data
    foreach ($data as $item) {
        $item->children = $this->categoryService->getChildCategories($item->id);
    }
    // Lấy danh mục cha để hiển thị trong dropdown (hoặc select)
    $parentCategories = $this->categoryService->getParent();
    return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'search', 'parentCategories', 'parentId'));
}

public function create()
{
$parentCategories = $this->categoryService->getParent(); // Lấy danh mục cha
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
return redirect()->route('categories.index');
}

public function show($id)
{
$id = (int)$id;
$data = $this->categoryService->getById($id);
return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
}

public function edit( $id)
{
$id = (int)$id; // Chuyển đổi ID thành số nguyên
$data = $this->categoryService->getById($id); // Lấy danh mục theo ID
$parentCategories = $this->categoryService->getParent(); // Lấy danh mục cha
return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'parentCategories'));
}

public function update(CategoryRequest $request, $id)
{
$id = (int)$id; // Chuyển đổi ID thành số nguyên
$model = $this->categoryService->getById($id); // Lấy danh mục theo ID
// Lấy dữ liệu từ request, loại bỏ trường 'image'
$data = $request->except('image');
$data['is_active'] ??= 0; // Đặt giá trị mặc định cho 'is_active'
// Kiểm tra nếu có file ảnh mới
if ($request->hasFile('image')) {
// Lưu ảnh mới
$relativePath = $request->file('image')->store(self::PATH_UPLOAD);
$data['image'] = $relativePath;
// Xóa ảnh cũ nếu có
$currentCover = $model->image;
$filename = basename($currentCover);
if ($filename && Storage::exists(self::PATH_UPLOAD . '/' . $filename)) {
Storage::delete(self::PATH_UPLOAD . '/' . $filename);
}
}
// Cập nhật danh mục trong cơ sở dữ liệu
$this->categoryService->saveOrUpdate($data, $id);
// Chuyển hướng về danh sách danh mục với thông báo thành công
return redirect()->route('categories.index')->with('success', 'Update successful');
}

public function destroy($id)
{
    $id = (int)$id;
    $data = $this->categoryService->getById($id);
    // Xóa mềm (soft delete)
    $data->delete();
    // Không xóa ảnh; ảnh vẫn được giữ lại trong Storage
    return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
}

public function deleteMultiple(Request $request)
{
$categoryIds = $request->input('categories', []);
if (empty($categoryIds)) {
return redirect()->route('categories.index')->with('error', 'No categories selected for deletion.');
}
Category::destroy($categoryIds);
return redirect()->route('categories.index')->with('success', 'Selected categories deleted successfully.');
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
return redirect()->route('categories.trashed')->with('success', 'Category restored successfully.');
}

public function hardDelete($id)
{
$category = Category::onlyTrashed()->findOrFail($id);
$category->forceDelete();
return redirect()->route('categories.trashed')->with('success', 'Category permanently deleted.');
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
return redirect()->route('categories.trashed')->with('error', 'No categories selected for restoration.');
}
Category::onlyTrashed()->whereIn('id', $categoryIds)->restore();
return redirect()->route('categories.trashed')->with('success', 'Selected categories restored successfully.');
}

public function hardDeleteMultiple(Request $request)
{
$categoryIds = $request->input('categories', []);
if (empty($categoryIds)) {
return redirect()->route('categories.trashed')->with('error', 'No categories selected for deletion.');
}
// Xóa cứng các danh mục đã chọn
Category::onlyTrashed()->whereIn('id', $categoryIds)->forceDelete();
return redirect()->route('categories.trashed')->with('success', 'Selected categories deleted permanently.');
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