<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\BlogService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class BlogController extends Controller
{

    protected $data;
    protected $blogService;
    protected $blogValueService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    // Hiển thị danh sách các blog
    public function index(Request $request)
    {
        $blogs = Blog::paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    // Hiển thị form tạo blog mới
    public function create()
    {
        return view('admin.blogs.create');
    }

    // Lưu blog mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $slug = Str::slug($request->title);
        $isPublished = $request->input('is_published', 1);

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'thumbnail' => $request->file('thumbnail') ? $request->file('thumbnail')->store('thumbnails', 'public') : null,
            'user_id' => auth()->id(),
            'is_published' => $isPublished,
            'published_at' => $isPublished == 1 ? now() : null,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }




    // Hiển thị chi tiết một blog
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    // Hiển thị form chỉnh sửa blog
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    // Cập nhật blog

    public function update(Request $request, $id)
    {
        // Tìm blog theo ID
        $blog = Blog::findOrFail($id);

        // Kiểm tra tính hợp lệ của dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'is_published' => 'required|in:0,1,2',
        ]);

        // Tạo slug từ tiêu đề
        $slug = Str::slug($request->title);

        // Xử lý hình ảnh thumbnail
        if ($request->hasFile('thumbnail')) {
            // Xóa hình ảnh cũ nếu có
            if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            // Lưu hình ảnh mới vào disk 'public'
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            // Giữ nguyên hình ảnh cũ nếu không có hình ảnh mới
            $thumbnailPath = $blog->thumbnail;
        }

        // Xác định trạng thái xuất bản
        $isPublished = $request->input('is_published');
        $publishedAt = $isPublished == 1 ? now() : null;

        // Cập nhật thông tin blog
        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'thumbnail' => $thumbnailPath,
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }


    // Xóa mềm blog
    // public function showSotfDelete(Request $request)
    // {
    //     $search = $request->input('search');
    //     $perPage = $request->input('perPage', 10);
    //     $data = $this->blogService->show_soft_delete($search, $perPage);
    //     return view('admin.blogs.deleted', compact('data'));
    // }
    
    public function showSotfDelete(Request $request)
{
    // Lấy giá trị tìm kiếm và số lượng trên mỗi trang
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10);

    // Truy vấn các bài viết đã xóa mềm
    $data = $this->blogService->show_soft_delete($search, $perPage);

    // Trả về view với dữ liệu bài viết đã xóa mềm
    return view('admin.blogs.deleted', compact('data'));
}


    public function restore($id)
{
    try {
        // Kiểm tra xem blog có tồn tại hay không
        $blog = $this->blogService->findDeletedBlogById($id);
        
        if (!$blog) {
            return redirect()->route('admin.blogs.deleted')->with('error', 'Blog không tồn tại hoặc đã bị khôi phục trước đó.');
        }

        // Khôi phục blog
        $this->blogService->restore_delete($id);

        return redirect()->route('admin.blogs.blogshortdeleted')->with('success', 'Khôi phục blog thành công!');
    } catch (\Exception $e) {
        // Trả về thông báo lỗi nếu có lỗi xảy ra trong quá trình khôi phục
        return redirect()->route('admin.blogs.blogshortdeleted')->with('error', 'Không thể khôi phục blog: ' . $e->getMessage());
    }
}

    

    public function destroy($id)
    {
        // Lấy blog theo ID
        $blog = $this->blogService->getById($id);

        // Kiểm tra xem blog có tồn tại không
        if (!$blog) {
            return redirect()->route('admin.blogs.index')->with('error', 'Blog không tồn tại!');
        }

        // Xóa mềm blog
        $blog->delete();

        // Kiểm tra nếu blog đã bị xóa mềm
        if ($blog->trashed()) {
            return redirect()->route('admin.blogs.index')->with('success', 'Blog đã được xóa mềm thành công');
        }

        // Nếu không thể xóa, trả về thông báo lỗi
        return redirect()->route('admin.blogs.index')->with('error', 'Không thể xóa blog');
    }

    public function destroyValue(int $id)
    {
        try {
            $data = $this->blogValueService->getById($id);
            if (!$data) {
                return response()->json(['message' => 'Blog Values not found'], 404);
            }
            $data->delete();
            if ($data->trashed()) {
                return response()->json(['message' => 'Giá trị blog đã được xóa thành công'], 200);
            }
            return response()->json([
                'message' => 'Xóa thành công giá trị blog'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi xóa giá trị blog',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function hardDeleteBlog(int $id)
    {
        $data = $this->blogService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->route('admin.blogs.index')->with('success', 'Blog đã được xóa không thành công');
        }
        $data->forceDelete();
        return redirect()->route('admin.blogs.blogshortdeleted')->with('success', 'Blog đã bị xóa vĩnh viễn');
    }

    public function hardDeleteBlogValue(int $id)
    {
        $data = $this->blogValueService->getIdWithTrashed($id);
        if (!$data) {
            return response()->json(['message' => 'Blog Value not found.'], 404);
        }
        $data->forceDelete();
        return response()->json(['message' => 'Delete with success'], 200);
    }

    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'action' => 'required|string',
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');

        if (count($ids) > 0) {
            foreach ($ids as $id) {
                switch ($action) {
                    case 'soft_delete_blog':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->blogService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroy($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_blog':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->blogService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteBlog($id);
                            }
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);

                    case 'soft_delete_blog_values':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->blogValueService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroyValue($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_blog_value':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->blogValueService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteBlogValue($id);
                            }
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);

                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
                }
            }
            return response()->json(['message' => 'Blogs deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }

    public function saveBlogs(Request $request)
    {
        session()->forget('product_blogs');
        $selectedValues = $request->input('blogs', []);

        if (empty($selectedValues)) {
            return response()->json(['message' => 'Không có dữ liệu blog để lưu.'], 400);
        }

        session(['product_blogs' => $selectedValues]);

        return response()->json([
            'message' => 'Các blog đã được lưu thành công!',
            'data' => $selectedValues
        ]);
    }

}
