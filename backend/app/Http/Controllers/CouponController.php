<?php

namespace App\Http\Controllers;

use App\Events\CouponEvent;
use App\Http\Requests\CouponRequest;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\UserCoupon;
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
            DB::beginTransaction();

            // Dữ liệu chính của coupon
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
                'created_by'          => auth()->id() ?? 1,
            ];

            // Lưu coupon mới
            $coupon = $this->couponService->saveOrUpdate($couponData);

            $appliesTo = $validatedData['applies_to'];
            $dynamicValueIds = explode(',', $validatedData['dynamic_value']); // Chuyển chuỗi ID thành mảng các ID

            // Xử lý từng trường hợp áp dụng
            if ($appliesTo === 'category') {
                foreach ($dynamicValueIds as $categoryId) {
                    CouponCategory::create([
                        'coupon_id' => $coupon->id,
                        'category_id' => (int) $categoryId,
                    ]);
                }
            } elseif ($appliesTo === 'product') {
                foreach ($dynamicValueIds as $productId) {
                    CouponProduct::create([
                        'coupon_id' => $coupon->id,
                        'product_id' => (int) $productId,
                    ]);
                }
            } elseif ($appliesTo === 'user') {
                foreach ($dynamicValueIds as $userId) {
                    UserCoupon::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => (int) $userId,
                    ]);
                }
            } elseif ($appliesTo === 'all') {
                User::all()->each(function ($user) use ($coupon) {
                    UserCoupon::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => $user->id,
                    ]);
                });
                Product::all()->each(function ($product) use ($coupon) {
                    CouponProduct::create([
                        'coupon_id' => $coupon->id,
                        'product_id' => $product->id,
                    ]);
                });
                Category::all()->each(function ($category) use ($coupon) {
                    CouponCategory::create([
                        'coupon_id' => $coupon->id,
                        'category_id' => $category->id,
                    ]);
                });
            }

            // Phát broadcast coupon
            broadcast(new CouponEvent($coupon));
            DB::commit();
            return redirect()->route('admin.coupons.index', compact('coupon'))->with('success', 'Thêm mới coupon thành công');
        } catch (\Exception $e) {
            Log::error('Đã xảy ra lỗi khi cập nhật coupon: ' . $e->getMessage(), ['trace' => $e->getTrace()]);
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
        $coupon = Coupon::with(['products', 'users', 'categories'])->find($id);

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
        $categories = $coupon->categories()->select('categories.id', 'categories.name')->get();
        $products = $coupon->products()->select('products.id', 'products.name')->get();
        $users = $coupon->users()->select('users.id', 'users.username')->get();
        // dd($categories); 
        return view('admin.coupons.edit', compact('coupon', 'categories', 'products', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $couponRequest, string $id)
    {
        $validatedData = $couponRequest->validated();

        try {
            DB::beginTransaction();
            $coupon = $this->couponService->getById($id);

            if (!$coupon) {
                return redirect()->back()->withErrors(['error' => 'Coupon không tồn tại']);
            }

            // Xóa các bản ghi liên quan trước khi cập nhật
            CouponCategory::where('coupon_id', $coupon->id)->delete();
            CouponProduct::where('coupon_id', $coupon->id)->delete();
            UserCoupon::where('coupon_id', $coupon->id)->delete();
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
                'per_user_limit'      => $validatedData['per_user_limit'] ?? null,
                'is_active'           => $validatedData['is_active'] ? 1 : 0,
                'is_stackable'        => $validatedData['is_stackable'] ? 1 : 0,
                'eligible_users_only' => $validatedData['eligible_users_only'] ? 1 : 0,
            ];

            $this->couponService->saveOrUpdate($couponData, $id);

            // Lấy danh sách các giá trị ID mới từ dynamic_value
            $dynamicValueIds = is_array($validatedData['dynamic_value']) ? $validatedData['dynamic_value'] : explode(',', $validatedData['dynamic_value']);

            $appliesTo = $validatedData['applies_to'];
            switch ($appliesTo) {
                case 'category':

                    $existingCategoryIds = CouponCategory::where('coupon_id', $coupon->id)->pluck('category_id')->toArray();
                    $categoryIdsToDelete = array_diff($existingCategoryIds, $dynamicValueIds);
                    $categoryIdsToAdd = array_diff($dynamicValueIds, $existingCategoryIds);
                    CouponCategory::where('coupon_id', $coupon->id)
                        ->whereIn('category_id', $categoryIdsToDelete)
                        ->delete();
                    foreach ($categoryIdsToAdd as $categoryId) {
                        CouponCategory::create([
                            'coupon_id' => $coupon->id,
                            'category_id' => $categoryId,
                        ]);
                    }
                    break;

                case 'product':
                    $existingProductIds = CouponProduct::where('coupon_id', $coupon->id)->pluck('product_id')->toArray();
                    $productIdsToDelete = array_diff($existingProductIds, $dynamicValueIds);
                    $productIdsToAdd = array_diff($dynamicValueIds, $existingProductIds);

                    CouponProduct::where('coupon_id', $coupon->id)
                        ->whereIn('product_id', $productIdsToDelete)
                        ->delete();

                    foreach ($productIdsToAdd as $productId) {
                        CouponProduct::create([
                            'coupon_id' => $coupon->id,
                            'product_id' => $productId,
                        ]);
                    }
                    break;
                case 'user':
                    $existingUserIds = UserCoupon::where('coupon_id', $coupon->id)->pluck('user_id')->toArray();
                    $userIdsToDelete = array_diff($existingUserIds, $dynamicValueIds);
                    $userIdsToAdd = array_diff($dynamicValueIds, $existingUserIds);
                    UserCoupon::where('coupon_id', $coupon->id)
                        ->whereIn('user_id', $userIdsToDelete)
                        ->delete();
                    foreach ($userIdsToAdd as $userId) {
                        UserCoupon::create([
                            'coupon_id' => $coupon->id,
                            'user_id' => $userId,
                        ]);
                    }
                    break;
                case 'all':
                    User::all()->each(function ($user) use ($coupon) {
                        UserCoupon::create([
                            'coupon_id' => $coupon->id,
                            'user_id' => $user->id,
                        ]);
                    });
                    Product::all()->each(function ($product) use ($coupon) {
                        CouponProduct::create([
                            'coupon_id' => $coupon->id,
                            'product_id' => $product->id,
                        ]);
                    });
                    Category::all()->each(function ($category) use ($coupon) {
                        CouponCategory::create([
                            'coupon_id' => $coupon->id,
                            'category_id' => $category->id,
                        ]);
                    });
                    break;
            }

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
            return redirect()->route('admin.coupons.index')->with('error', 'Thuộc tính đã được xóa không thành công');
        }
        DB::transaction(function () use ($data) {
            $data->users()->detach();
            $data->categories()->detach();
            $data->products()->detach();
            $data->usage()->forceDelete();
            $data->forceDelete();
        });

        return redirect()->route('admin.coupons.deleted')->with('success', 'Thuộc tính và các liên kết trung gian đã bị xóa vĩnh viễn');
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
    public function applyDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
        ]);
        $couponCode = $request->code;

        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json(['message' => 'Mã giảm giá không hợp lệ.'], 400);
        }
        if ($coupon->start_date && $coupon->start_date > now()) {
            return response()->json(['message' => 'Mã giảm giá chưa bắt đầu.'], 400);
        }

        if ($coupon->end_date && $coupon->end_date < now()) {
            return response()->json(['message' => 'Mã giảm giá đã hết hạn.'], 400);
        }

        if ($coupon->usage_limit && $coupon->usage_limit <= 0) {
            return response()->json(['message' => 'Mã giảm giá đã đạt giới hạn sử dụng.'], 400);
        }
        if($coupon->is_active==false){
            return response()->json(['message' => 'Mã giảm giá không hoạt động.'], 400);
        }
        return response()->json([
            'message' => 'Mã giảm giá đã được áp dụng!',
            'data' => $coupon,
        ]);
    }
}
