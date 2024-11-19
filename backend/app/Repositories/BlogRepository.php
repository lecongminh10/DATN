<?php

namespace App\Repositories;

use App\Models\Blog;

class BlogRepository extends BaseRepository
{
    protected $model;

    public function __construct(Blog $blogRepository)
    {
        parent::__construct($blogRepository);
        $this->model = $blogRepository;
    }

    public function getAll($search = null, $perPage = null)
    {
        $query = Blog::query()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('content', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
    }

    // public function show_soft_delete($search = null, $perPage = 10) // $perPage mặc định là 10
    // {
    //     $query = Blog::onlyTrashed()->latest('id');

    //     if ($search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('title', 'LIKE', '%' . $search . '%')
    //                 ->orWhere('content', 'LIKE', '%' . $search . '%');
    //         });
    //     }
    //     // Sử dụng paginate để phân trang
    //     $model = $query->paginate($perPage);

    //     return $model;
    // }

    public function showSotfDelete($search, $perPage)
{
    // Kiểm tra nếu đối tượng Blog không phải là null
    if (Blog::exists()) {
        return Blog::onlyTrashed()
                    
                   ->orWhere('title', 'like', "%$search%")
                   ->paginate($perPage);
                   
    } else {
        // Xử lý khi Blog không tồn tại
        return response()->json(['error' => 'Blog not found'], 404);
    }
}


    public function restoreDeleted($id)
    {
        $model = Blog::onlyTrashed()->findOrFail($id);
        $model->restore();
    }

    
}
