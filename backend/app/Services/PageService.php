<?php

namespace App\Services;

use App\Repositories\PageRepository;


class PageService extends BaseService
{
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        parent::__construct($pageRepository);
        $this->pageRepository = $pageRepository;
    }
    public function getAllPages($search, $perPage)
    {
        return $this->pageRepository->getAll($search, $perPage);
    }
    public function show_soft_delete($search, $perPage)
    {
        return $this->pageRepository->show_soft_delete($search, $perPage);
    }
    public function restore_delete($id)
    {
        return $this->pageRepository->restore_delete($id);
    }
}
