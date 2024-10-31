<?php

namespace App\Services;
use App\Repositories\OrderLocationRepository;

class OrderLocationService extends BaseService
{
    protected $orderLocationService;

    public function __construct(OrderLocationRepository $orderLocationService)
    {
        parent::__construct($orderLocationService);
        $this->orderLocationService = $orderLocationService;
    }

}