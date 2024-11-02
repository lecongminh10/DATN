<?php

namespace App\Services;
use App\Repositories\OrderItemRepository;

class OrderItemService extends BaseService
{
    protected $orderItemService;

    public function __construct(OrderItemRepository $orderItemService)
    {
        parent::__construct($orderItemService);
        $this->orderItemService = $orderItemService;
    }

}