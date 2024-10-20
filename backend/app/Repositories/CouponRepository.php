<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository extends BaseRepository
{
    protected $model;

    public function __construct(Coupon $couponRepository)
    {
        parent::__construct($couponRepository);
        $this->model = $couponRepository;
    }

    public function getAllCoupon($search, $perPage = 10, $status = null, $appliesTo = null, $discountType = null)
    {
        $query = Coupon::query()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status !== null) {
            $query->where('is_active', $status);
        }

        if ($appliesTo) {
            $query->where('applies_to', $appliesTo);
        }

        if ($discountType) {
            $query->where('discount_type', $discountType);
        }

        return $query->paginate($perPage);
    }

    public function show_soft_delete($search, $perPage = 10, $status = null, $appliesTo = null, $discountType = null)
    {
        $query = Coupon::onlyTrashed()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status !== null) {
            $query->where('is_active', $status);
        }

        if ($appliesTo) {
            $query->where('applies_to', $appliesTo);
        }

        if ($discountType) {
            $query->where('discount_type', $discountType);
        }

        $model = $query->paginate($perPage);

        return $model;
    }

    public function restore_delete($id)
    {
        $model = Coupon::onlyTrashed()->findOrFail($id);
        $model->restore();
    }

    public function update_status($id, $validatedData)
    {
        if ($validatedData['is_active'] === 'active') {
            Coupon::where('id', '!=', $id)
                ->whereNull('deleted_at')
                ->update(['is_active' => 'inactive']);
        }
    }

    public function findByCode(string $code)
    {
        return Coupon::where('code', $code)->first();
    }

    public function show_soft_delete_id($id)
    {
        $query = Coupon::onlyTrashed()->find($id);
        return $query;
    }
}
