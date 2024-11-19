<?php

namespace App\Repositories;

use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

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
    
    public function getByCouponUsage(int $oder_id)
    {
        return  DB::table('coupons_usage')
        ->where('order_id',$oder_id)
        ->join('coupons', 'coupons_usage.coupon_id', '=', 'coupons.id') // JOIN với bảng coupons
        ->select(
            'coupons_usage.discount_value as usage_discount_value',
            'coupons.code as coupon_code',
            'coupons.discount_value as coupon_discount_value',
        )
        ->get();
    }

    public function updateByOrderCoupon(int $id)
    {
        $couponUsages = DB::table('coupons_usage')
            ->where('order_id', $id)
            ->get();

        foreach ($couponUsages as $couponUsage) {
            DB::table('coupons')
                ->where('id', $couponUsage->coupon_id)
                ->decrement('usage_limit', 1);
        }
    }
}
