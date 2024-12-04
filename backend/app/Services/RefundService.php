<?php

namespace App\Services;

use App\Repositories\RefundRepository;
use Illuminate\Http\Request;

class RefundService extends BaseService
{
    protected $refundService;
    protected $refundRepository;

    public function __construct(RefundRepository $refundRepository)
    {
        parent::__construct($refundRepository);
        $this->refundRepository = $refundRepository;
    }

    public function searchRefund(array $filters)
    {
        return $this->refundRepository->getSearchRefund($filters);
    }
}
