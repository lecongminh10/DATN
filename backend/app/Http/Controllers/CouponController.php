<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $couponService;

    public function __construct(CouponService $couponService,)
    {
        $this->couponService = $couponService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $status = $request->input('status');
        $appliesTo = $request->input('applies_to');
        $discountType = $request->input('discount_type');
        $coupons = $this->couponService->getAllCoupon($search, $perPage, $status, $appliesTo, $discountType);
        return view('admin.coupons.index', compact('coupons'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $couponRequest)
    {
        $validatedData = $couponRequest->all();
        try {
            $couponData = [
                'applies_to'          => $validatedData['applies_to'],
                'code'                => $validatedData['code'],
                'description'         => $validatedData['description'] ?? null,
                'discount_type'       => $validatedData['discount_type'],
                'discount_value'      => $validatedData['discount_value'],
                'max_discount_amount' => $validatedData['max_discount_amount'] ?? null,
                'min_order_value'     => $validatedData['min_order_value'] ?? null,
                'start_date'          => $validatedData['start_date'] ?? null,
                'end_date'            => $validatedData['end_date'] ?? null,
                'usage_limit'         => $validatedData['usage_limit'] ?? null,
                'is_active'           => $validatedData['is_active'] ? 1 : 0,
                'is_stackable'        => $validatedData['is_stackable'] ? 1 : 0,
                'eligible_users_only' => $validatedData['eligible_users_only'] ? 1 : 0,
                'created_by'          => auth()->id() ?? 1, // Lấy ID của người dùng hiện tại
            ];
            $coupon = $this->couponService->saveOrUpdate($couponData);
            return redirect()->route('admin.coupons.index', compact('coupon'))->with('success', 'Thêm mới coupon thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi thêm coupon: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $coupon = $this->couponService->getById($id);

        if (!$coupon) {
            Log::error('Coupon not found: ' . $id);
            return response()->json(['error' => 'Coupon not found'], 404);
        }

        return response()->json(['coupon' => $coupon], 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = $this->couponService->getById($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $couponRequest, string $id)
    {
        $validatedData = $couponRequest->validated();

        try {
            DB::beginTransaction();

            // Lấy coupon theo ID
            $coupon = $this->couponService->getById($id);

            // Kiểm tra nếu coupon không tồn tại
            if (!$coupon) {
                return redirect()->back()->withErrors(['error' => 'Coupon không tồn tại']);
            }

            // Cập nhật thông tin coupon
            $couponData  = ([
                'applies_to'                    => $validatedData['applies_to'],
                'code'                          => $validatedData['code'],
                'description'                   => $validatedData['description'] ?? null,
                'discount_type'                 => $validatedData['discount_type'],
                'discount_value'                => $validatedData['discount_value'],
                'max_discount_amount'           => $validatedData['max_discount_amount'] ?? null,
                'min_order_value'               => $validatedData['min_order_value'] ?? null,
                'start_date'                    => $validatedData['start_date'] ?? null,
                'end_date'                      => $validatedData['end_date'] ?? null,
                'usage_limit'                   => $validatedData['usage_limit'] ?? null,
                'per_user_limit'                => $validatedData['per_user_limit'] ?? null,
                'is_active'                     => $validatedData['is_active'],  
                'is_stackable'                  => $validatedData['is_stackable'], 
                'eligible_users_only'           => $validatedData['eligible_users_only'],
            ]);
            // dd($couponData);
            $coupon = $this->couponService->saveOrUpdate($couponData, $id);

            DB::commit();

            return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật coupon thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi cập nhật coupon: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $status = $request->input('status');
        $appliesTo = $request->input('applies_to');
        $discountType = $request->input('discount_type');
        $data = $this->couponService->show_soft_delete($search, $perPage, $status, $appliesTo, $discountType);
        return view('admin.coupons.deleted', compact('data'));
    }

    public function showSotfDeleteID(string $id)
    {
        $coupon = $this->couponService->show_soft_delete_id($id);
        if (!$coupon) {
            Log::error('Coupon not found: ' . $id);
            return response()->json(['error' => 'Coupon not found'], 404);
        }

        return response()->json(['coupon' => $coupon], 200);
    }

    public function restore($id)
    {
        try {
            $this->couponService->restore_delete($id);
            return redirect()->route('admin.coupons.deleted')->with('success', 'Khôi phục thuộc tính thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.coupons.deleted')->with('error', 'Không thể khôi phục thuộc tính: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCoupon(int $id)
    {
        $data = $this->couponService->getById($id);

        if (!$data) {
            return abort(404);
        }
        $data->delete();
        if ($data->trashed()) {
            return redirect()->route('admin.coupons.index')->with('success', 'Thuộc tính mềm đã được xóa không thành công');
        }

        return redirect()->route('admin.coupons.index')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }

    public function hardDeleteCoupon(int $id)
    {
        $data = $this->couponService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->route('admin.coupons.index')->with('success', 'Thuộc tính đã được xóa không thành công');
        }
        $data->forceDelete();
        return redirect()->route('admin.coupons.deleted')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }


    public function deleteMuitpalt(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'action' => 'required|string',
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');

        if (count($ids) > 0) {
            foreach ($ids as $id) {

                switch ($action) {
                    case 'soft_delete_coupon':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->couponService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroyCoupon($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_coupon':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->couponService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteCoupon($id);
                            }
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);
                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
                }
            }
            return response()->json(['message' => 'Categories deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }
}
