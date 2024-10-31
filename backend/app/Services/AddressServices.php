<?php

namespace App\Services;

use App\Repositories\AttributeRepository;


class AddressServices extends BaseService
{
    protected $addresssRepository;


    public function __construct(AttributeRepository $addresssRepository)
    {
        parent::__construct($addresssRepository);
        $this->addresssRepository = $addresssRepository;
    }
}