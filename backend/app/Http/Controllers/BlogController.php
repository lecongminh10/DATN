<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BlogService;
use Illuminate\Support\Facades\DB;
use App\Events\AdminActivityLogged;
use App\Http\Controllers\Controller;
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
        // Lấy từ khóa tìm kiếm từ request
        $search = $request->input('search');

        // Query danh sách blogs với tìm kiếm
        $blogs = Blog::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'LIKE', "%$search%") // Tìm kiếm theo tiêu đề
                    ->orWhere('content', 'LIKE', "%$search%"); // Tìm kiếm theo nội dung
            })
            ->paginate(10); // Phân trang

        // Trả về view với dữ liệu blogs
        return view('admin.blogs.index', compact('blogs'));
    }

    // Hiển thị form tạo blog mới
    public function create()
    {
        $tags = Tag::all(); // Lấy tất cả các tag
        return view('admin.blogs.create', compact('tags'));
    }


    public function store(BlogRequest $request)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            // Tạo blog mới
            $slug = Str::slug($validatedData['title']);
            $isPublished = $validatedData['is_published'] ?? 1;

            $blog = Blog::create([
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'slug' => $slug,
                'meta_title' => $validatedData['meta_title'],
                'meta_description' => $validatedData['meta_description'],
                'thumbnail' => $request->file('thumbnail') ? $request->file('thumbnail')->store('thumbnails', 'public') : null,
                'user_id' => auth()->id(),
                'is_published' => $isPublished,
                'published_at' => $isPublished == 1 ? now() : null,
            ]);

            // Xử lý tags
            if (!empty($validatedData['tags']) && is_array($validatedData['tags'])) {
                foreach ($validatedData['tags'] as $tagId) {
                    $tag = Tag::find($tagId);
                    if ($tag) {
                        $blog->tags()->attach($tag);
                    }
                }
            }

            // Ghi nhật ký hoạt động
            $logDetails = sprintf('Thêm bài viết: Tiêu Đề - %s', $blog->title);
            event(new AdminActivityLogged(auth()->user()->id, 'Thêm Mới', $logDetails));

            DB::commit();
            return redirect()->route('admin.blogs.index')->with('success', 'Blog đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi tạo bài viết: ' . $e->getMessage()]);
        }
    }




    // Hiển thị chi tiết một blog
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    // Hiển thị form chỉnh sửa blog
    // public function edit($id)
    // {
    //     $blog = Blog::findOrFail($id);
    //     return view('admin.blogs.edit', compact('blog'));
    // }

    public function edit($id)
    {
        $blog = Blog::with('tags')->findOrFail($id);

        // Lấy danh sách ID của các thẻ đã chọn
        $selectedTags = $blog->tags->pluck('id')->toArray();

        // Lấy tất cả các thẻ chưa được chọn
        $allTags = Tag::whereNotIn('id', $selectedTags)->get();

        return view('admin.blogs.edit', compact('blog', 'allTags', 'selectedTags'));
    }


    public function update(BlogRequest $request, $id)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            // Tìm blog theo ID
            $blog = Blog::findOrFail($id);

            // Tạo slug từ tiêu đề
            $slug = Str::slug($validatedData['title']);

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
            $isPublished = $validatedData['is_published'];
            $publishedAt = $isPublished == 1 ? now() : null;

            // Cập nhật thông tin blog
            $blog->update([
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'slug' => $slug,
                'meta_title' => $validatedData['meta_title'],
                'meta_description' => $validatedData['meta_description'],
                'thumbnail' => $thumbnailPath,
                'is_published' => $isPublished,
                'published_at' => $publishedAt,
            ]);

            // Xử lý tags
            if (!empty($validatedData['tags']) && is_array($validatedData['tags'])) {
                // Gắn các tag vào blog, tạo tag mới nếu chưa có
                $blog->tags()->sync([]); // Loại bỏ tất cả các tags hiện tại
                foreach ($validatedData['tags'] as $tagName) {
                    // Kiểm tra xem tag đã tồn tại chưa, nếu chưa thì tạo mới
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $blog->tags()->attach($tag); // Gắn tag vào blog
                }
            }

            // Ghi nhật ký hoạt động
            $logDetails = sprintf('Sửa bài viết: Tiêu Đề - %s', $blog->title);
            event(new AdminActivityLogged(auth()->user()->id, 'Sửa', $logDetails));

            DB::commit();
            return redirect()->route('admin.blogs.index')->with('success', 'Blog đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi cập nhật bài viết: ' . $e->getMessage()]);
        }
    }


    // Xóa mềm blog
    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $data = $this->blogService->show_soft_delete($search, $perPage);
        return view('admin.blogs.deleted', compact('data'));
    }

    public function listTrashDelete(Request $request)
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
            // Tìm blog đã bị xóa mềm dựa trên ID
            $blog = $this->blogService->findDeletedBlogById($id);

            // Kiểm tra xem blog có tồn tại không
            if (!$blog) {
                return redirect()->route('admin.blogs.index')->with('error', 'Blog không tồn tại hoặc đã được khôi phục trước đó.');
            }

            // Khôi phục blog đã bị xóa mềm
            $this->blogService->restore_delete($id);

            // Ghi nhật ký hoạt động
            $logDetails = sprintf('Khôi phục bài viết: Tiêu đề - %s', $blog->title);
            event(new AdminActivityLogged(auth()->user()->id, 'Khôi phục', $logDetails));

            // Trả về thông báo thành công
            return redirect()->route('admin.blogs.index')->with('success', 'Khôi phục blog thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi trong quá trình khôi phục
            return redirect()->route('admin.blogs.index')->with('error', 'Không thể khôi phục blog: ' . $e->getMessage());
        }
    }





    public function destroy($id)
    {
        try {
            // Lấy blog theo ID
            $blog = $this->blogService->getById($id);

            // Kiểm tra xem blog có tồn tại không
            if (!$blog) {
                return response()->json(['message' => 'Blog không tồn tại!'], 404);  // Trả về lỗi nếu không tìm thấy blog
            }

            // Ghi nhật ký chi tiết hành động xóa
            $logDetails = sprintf('Xóa bài viết: Tiêu đề - %s', $blog->title);
            event(new AdminActivityLogged(auth()->user()->id, 'Xóa', $logDetails));

            // Thực hiện xóa blog (xóa mềm hoặc xóa vĩnh viễn tùy yêu cầu)
            $blog->delete();

            // Kiểm tra xem bài viết đã bị xóa thành công (xóa mềm)
            if ($blog->trashed()) {
                return response()->json(['message' => 'Blog đã được xóa thành công']);
            }

            // Nếu không thể xóa, trả về thông báo lỗi
            return response()->json(['message' => 'Không thể xóa blog'], 500);
        } catch (\Exception $e) {
            // Xử lý lỗi trong quá trình xóa
            \Log::error('Error deleting blog: ' . $e->getMessage());
            return response()->json(['message' => 'Đã xảy ra lỗi khi xóa blog: ' . $e->getMessage()], 500);
        }
    }

    
    public function destroyValue(int $id)
    {
        try {
            $data = $this->blogValueService->getById($id);
            if (!$data) {
                return response()->json(['message' => 'Blog Values not found'], 404);
            }
            $logDetails = sprintf(
                'Xóa Value bài viết: Tiêu Đề - %s',
                $data->title
            );

            // Ghi nhật ký hoạt động
            event(new AdminActivityLogged(
                auth()->user()->id,
                'Xóa Mềm',
                $logDetails
            ));
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
        try {
            // Lấy blog kể cả đã bị xóa mềm
            $data = $this->blogService->getIdWithTrashed($id);

            if (!$data) {
                return redirect()->route('admin.blogs.index')->with('error', 'Blog không tồn tại hoặc đã bị xóa trước đó.');
            }

            // Ghi log chi tiết xóa cứng
            $logDetails = sprintf(
                'Xóa bài viết: Tiêu đề - %s',
                $data->title
            );
            event(new AdminActivityLogged(
                auth()->user()->id,
                'Xóa Cứng',
                $logDetails
            ));


            // Thực hiện xóa vĩnh viễn
            $data->forceDelete();

            return redirect()->route('admin.blogs.index')->with('success', 'Blog đã bị xóa vĩnh viễn.');
        } catch (\Exception $e) {
            // Bắt lỗi và hiển thị thông báo nếu xảy ra vấn đề
            return redirect()->route('admin.blogs.index')->with('error', 'Không thể xóa blog: ' . $e->getMessage());
        }
    }




    public function hardDeleteBlogValue(int $id)
    {
        $data = $this->blogValueService->getIdWithTrashed($id);
        if (!$data) {
            return response()->json(['message' => 'Blog không tìm thấy giá trị.'], 404);
        }
        $logDetails = sprintf(
            'Xóa Value bài viết: Tiêu Đề - %s',
            $data->title
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa Cứng',
            $logDetails
        ));
        $data->forceDelete();
        return response()->json(['message' => 'Xóa thành công'], 200);
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
                        return response()->json(['message' => 'Xóa mềm thành công'], 200);

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
