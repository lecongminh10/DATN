<?php

namespace App\Services;

use App\Repositories\CarrierRepository;


class CarrierService extends BaseService
{
    protected $carrierRepository;


    public function __construct(CarrierRepository $carrierRepository)
    {
        parent::__construct($carrierRepository);
        $this->carrierRepository = $carrierRepository;
    }

    public function getAllCarrier($search, $perPage, $status)
    {
        return $this->carrierRepository->getAll($search, $perPage, $status);
    }

    public function show_soft_delete($search, $perPage, $status)
    {
        return $this->carrierRepository->show_soft_delete($search, $perPage, $status);
    }
    public function restore_delete($id)
    {
        return $this->carrierRepository->restore_delete($id);
    }

    public function update_status($id, $validatedData)
    {
        return $this->carrierRepository->update_status($id, $validatedData);
    }

    public function getByCode($code)
    {
        return $this->carrierRepository->getByCode($code);
    }
}
