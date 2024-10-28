<?php

namespace App\Repositories;

use App\Models\OrderLocation;

class OrderLocationRepository extends BaseRepository
{
    protected $orderLocationRepository;

    public function __construct(OrderLocation $orderLocationRepository)
    {
        parent::__construct($orderLocationRepository);
        $this->orderLocationRepository = $orderLocationRepository;
    }

}