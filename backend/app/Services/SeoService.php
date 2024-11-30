<?php

namespace App\Services;

use App\Repositories\SeoRepository;

class SeoService extends BaseService
{
    protected $seoRepository;

    public function __construct(SeoRepository $seoRepository)
    {
        parent::__construct($seoRepository);
        $this->seoRepository = $seoRepository;
    }
    public function getAllSeos($search, $perPage)
    {
        return $this->seoRepository->getAll($search, $perPage);
    }
    public function show_soft_delete($search, $perPage)
    {
        return $this->seoRepository->show_soft_delete($search, $perPage);
    }
    public function restore_delete($id)
    {
        return $this->seoRepository->restore_delete($id);
    }
}
