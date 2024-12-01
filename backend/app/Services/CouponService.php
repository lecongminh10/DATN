<?php

namespace App\Services;

use App\Repositories\CouponRepository;


class CouponService extends BaseService
{
    protected $couponRepository;


    public function __construct(CouponRepository $couponRepository)
    {
        parent::__construct($couponRepository);
        $this->couponRepository = $couponRepository;
    }

    public function getAllCoupon($search, $perPage, $status, $appliesTo, $discountType)
    {
        return $this->couponRepository->getAllCoupon($search, $perPage, $status, $appliesTo, $discountType);
    }


    public function show_soft_delete($search, $perPage, $status, $appliesTo, $discountType)
    {
        return $this->couponRepository->show_soft_delete($search, $perPage, $status, $appliesTo, $discountType);
    }
    public function restore_delete($id)
    {
        return $this->couponRepository->restore_delete($id);
    }

    public function update_status($id, $validatedData)
    {
        return $this->couponRepository->update_status($id, $validatedData);
    }

    public function findByCode($code)
    {
        return $this->couponRepository->findByCode($code);
    }
    public function show_soft_delete_id($id)
    {
        return $this->couponRepository->show_soft_delete_id($id);
    }
    public function getByCouponUsage($id)
    {
        return $this->couponRepository->getByCouponUsage($id);
    }
    public function updateByOrderCoupon($id)
    {
         $this->couponRepository->updateByOrderCoupon($id);
    }
}
