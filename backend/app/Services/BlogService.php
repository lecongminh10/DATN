<?php

namespace App\Services;

use App\Models\Blog;
use App\Repositories\BlogRepository;


class BlogService extends BaseService
{
    protected $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        parent::__construct($blogRepository);
        $this->blogRepository = $blogRepository;

    }



    public function getAllBlogs($search, $perPage)
    {
        return $this->blogRepository->getAll($search, $perPage);
    }

    // public function show_soft_delete($search , $perPage)
    // {
    //     return $this->blogRepository->show_soft_delete($search , $perPage);
    // }

    // public function show_soft_delete($search, $perPage)
    // {
    //     return $this->blogRepository->showSotfDelete($search, $perPage);
    // }

    public function show_soft_delete($search, $perPage)
    {
        // Lọc các bài viết đã bị xóa mềm
        $query = Blog::onlyTrashed();

        // Nếu có từ khóa tìm kiếm, áp dụng điều kiện tìm kiếm
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Lấy dữ liệu đã xóa mềm với phân trang
        return $query->paginate($perPage);
    }

    public function findDeletedBlogById($id)
    {
        // Giả sử bạn có một cột 'deleted_at' để xác định blog đã bị xóa
        return Blog::onlyTrashed()->find($id); // onlyTrashed() lấy các bản ghi bị xóa
    }

    public function restoreDeletedBlog($id)
    {
        return $this->blogRepository->restoreDeleted($id);
    }

    public function restore_delete($id)
    {
        // Tìm kiếm blog bị xóa bằng ID
        $blog = Blog::onlyTrashed()->find($id);

        if (!$blog) {
            throw new \Exception('Blog không tồn tại hoặc đã bị khôi phục.');
        }

        // Thực hiện khôi phục
        $blog->restore();

        // Có thể thêm bất kỳ logic nào khác sau khi khôi phục nếu cần, ví dụ cập nhật trạng thái
    }


}

