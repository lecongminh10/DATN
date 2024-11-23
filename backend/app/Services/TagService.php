<?php

namespace App\Services;

use App\Repositories\TagRepository;

class TagService extends BaseService
{
    protected $tagService;
    protected $tagRepository;

    public function __construct(TagRepository $tagService,TagRepository $tagRepository)
    {
        parent::__construct($tagService);
        $this->tagService = $tagService;
        $this->tagRepository = $tagRepository;

    }

    public function getIdandNameAll()
    {
        return $this->tagService->getIdandNameAll();
    }
    public function getAllTags($search, $perPage)
    {
        return $this->tagRepository->getAll($search, $perPage);
    }
    public function show_soft_delete($search, $perPage)
    {
        return $this->tagRepository->show_soft_delete($search, $perPage);
    }
    public function restore_delete($id)
    {
        return $this->tagRepository->restore_delete($id);
    }
}
