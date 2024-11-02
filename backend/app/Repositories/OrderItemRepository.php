<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository extends BaseRepository
{
    protected $orderItemRepository;

    public function __construct(OrderItem $orderItemRepository)
    {
        parent::__construct($orderItemRepository);
        $this->orderItemRepository = $orderItemRepository;
    }
    
}