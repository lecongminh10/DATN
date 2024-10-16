<?php

namespace App\Services;

use App\Repositories\TagRepository;

class TagService extends BaseService
{
    protected $tagService;

    public function __construct(TagRepository $tagService)
    {
        parent::__construct($tagService);
        $this->tagService = $tagService;
    }

    public function getIdandNameAll()
    {
        return $this->tagService->getIdandNameAll();
    }
}