<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository extends BaseRepository
{
    protected $model;

    public function __construct(Address $addressRepository)
    {
        parent::__construct($addressRepository);
        $this->model = $addressRepository;
    }
}