<?php

namespace App\Services;

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

    public function show_soft_delete($search , $perPage)
    {
        return $this->blogRepository->show_soft_delete($search , $perPage);
    }

    public function restoreDeletedBlog($id)
    {
        return $this->blogRepository->restoreDeleted($id);
    }
}

