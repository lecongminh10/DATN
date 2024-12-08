<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\ApiHelper;
use App\Mail\OrderCompletedMail;
use App\Mail\OrderPlacedMail;
use App\Models\Address;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Product;
use App\Models\WishList;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\OrderLocation;
use App\Models\ProductVariant;
use App\Services\OrderService;
use App\Models\PaymentGateways;
use App\Models\shippingMethods;
use Illuminate\Support\Facades\DB;
use App\Events\AdminActivityLogged;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Services\OrderLocationService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
class OrderController extends Controller
{

    protected $orderService;
    protected $orderLocationService;

    public function __construct(
        OrderService $orderService,
        OrderLocationService $orderLocationService,

    ) {
        $this->orderService = $orderService;
        $this->orderLocationService = $orderLocationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Artisan::call('generate:orders-json');

        $search = $request->input('search');
        $status = $request->input('status');
        $date = $request->input('date');
        $perPage = $request->input('perPage', 5);

        $orders = Order::with(['user', 'payment.paymentGateway']);

        // Kiểm tra nếu có giá trị tìm kiếm thì áp dụng tìm kiếm
        if (!empty($search)) {
            $orders->where(function ($query) use ($search) {
                $query->where('code', 'LIKE', $search . '%')
                    ->orWhere('total_price', 'LIKE', '%' . $search . '%')
                    ->orWhere('tracking_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('email', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('payment.paymentGateway', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        // Kiểm tra nếu trạng thái không phải 'all' thì lọc theo trạng thái
        if (!empty($status) && $status != 'all') {
            $orders->where('status', $status);
        }

        // Kiểm tra nếu có ngày tháng thì lọc theo ngày
        if (!empty($date)) {
            try {
                $parsedDate = Carbon::createFromFormat('d-m-Y', $date);
                $orders->whereDate('created_at', '=', $parsedDate);
            } catch (\Exception $e) {
                Log::error('Error parsing date: ' . $date . '. Error: ' . $e->getMessage());
            }
        }

        // Phân trang kết quả
        $orders = $orders->paginate($perPage);

        // Kiểm tra xem có yêu cầu AJAX hay không
        if ($request->ajax()) {
            return response()->json($orders); // Trả về dữ liệu JSON cho yêu cầu AJAX
        }

        return view('admin.orders.list-order', compact('orders'));
    }

    public function listTrash(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $date = $request->input('date');
        $perPage = $request->input('perPage', 5);

        // Sử dụng onlyTrashed() để lấy các đơn hàng đã bị soft delete
        $orderTrash = Order::onlyTrashed(); // Lấy các đơn hàng đã bị xóa (soft delete)

        // Áp dụng các bộ lọc tìm kiếm nếu có
        if (!empty($search)) {
            $orderTrash->where(function ($query) use ($search) {
                $query->where('code', 'LIKE', '%' . $search . '%')
                    ->orWhere('total_price', 'LIKE', '%' . $search . '%')
                    ->orWhere('tracking_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('email', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        // Lọc theo trạng thái nếu có
        if (!empty($status) && $status != 'all') {
            $orderTrash->where('status', $status);
        }

        // Lọc theo ngày nếu có
        if (!empty($date)) {
            try {
                $parsedDate = Carbon::createFromFormat('d-m-Y', $date);
                $orderTrash->whereDate('created_at', '=', $parsedDate);
            } catch (\Exception $e) {
                Log::error('Error parsing date: ' . $date . '. Error: ' . $e->getMessage());
            }
        }

        // Phân trang và trả về kết quả
        $orderTrash = $orderTrash->paginate($perPage);

        // Kiểm tra xem có yêu cầu AJAX hay không
        if ($request->ajax()) {
            return view('admin.orders.partials.order-list', compact('orderTrash'))->render(); // Trả về partial view qua AJAX
        }

        return view('admin.orders.list-trash-order', compact('orderTrash')); // Trả về view với dữ liệu phân trang
    }



    public function showOrder(int $id)
    {
        $data = $this->orderService->getById($id);
        $user = $data->user;
        // $admin = User::join('permissions_value_users', 'users.id', '=', 'permissions_value_users.user_id')
        // ->join('permissions_values', 'permissions_value_users.permission_value_id', '=', 'permissions_values.id')
        // ->join('addresses', 'users.id', '=', 'addresses.user_id')
        // ->where('permissions_values.value', 'admin_role')
        // ->select('users.username', 'users.email', 'users.phone_number', 'addresses.address_line', 'addresses.address_line1', 'addresses.address_line2')
        // ->first();
        // dd($admin);

        // $users = User::with('addresses')->first();
        // dd($user);

        $orderLocation = $this->orderLocationService->getAll()->where('order_id', $id)->first();

        $orderItems = $data->items()->with(['product', 'productVariant.attribute', 'productVariant.attributeValue'])->get();
        // $productVar = ProductVariant::with(['attributes', 'attributes.attributeValues'])->find($idVar);
        // // dd($productVar);


        $subTotal = 0;
        $totalDiscount = 0;

        foreach ($orderItems as $value) {
            if ($value->productVariant) {
                $itemPrice = $value->productVariant->price_modifier * $value->quantity;
                $subTotal += $itemPrice;
            } else {
                $itemPrice = ($value->product->price_regular - $value->product->price_sale) * $value->quantity;
                $subTotal += $itemPrice;
            }

            $totalDiscount += $value->discount;
        }

        $shippingCharge = $data->shippingMethod->amount ?? 0;
        $total = $subTotal - $totalDiscount + $shippingCharge;

        $paymentGatewayName = $data->payment->paymentGateway->name ?? 'No Payment Gateway';

        return view('admin.orders.order-detail', compact('data', 'user', 'orderLocation', 'orderItems', 'subTotal', 'totalDiscount', 'shippingCharge', 'total', 'paymentGatewayName'));
    }

    public function showModalEdit($code)
    {
        // Log::info('Searching for order with code: ' . $code);
        $order = Order::with(['user', 'payment.paymentGateway'])->where('code', $code)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order); // Trả về thông tin đơn hàng dưới dạng JSON
    }

    /**
     * Store a newly created resource in storage.
     */

    public function showShoppingCart()
    {
        $userId = auth()->id();
        $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $userId)
            ->get();

        $cartCount = $carts->sum('quantity');
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $wishlistCount = WishList::where('user_id',$userId)->count();
        return view('client.orders.shoppingcart', compact('categories', 'carts', 'cartCount','wishlistCount'));
    }

    public function showCheckOut()
    {
        $userId = auth()->id();
        $cartCheckout = Cart::with(['product', 'productVariant', 'attributeValues.attribute'])
            ->where('user_id', $userId)
            ->get();

        $carts  = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }

        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $cartCheckout =Cart::with(['product', 'product.variants','productVariant.attributeValues.attribute', 'product.galleries','product.productDimension'])
                ->where('user_id', $userId)
                ->get();

                $productDimensions = [];
                $items = [];
                $type = shippingMethods::HANG_NHE;
                $dataShippingMethod =[];
                foreach ($cartCheckout as $key => $cart) {

                    $item = [
                        'name' => $cart->relationLoaded('productVariant') && !empty($cart->productVariant) ? $cart->productVariant->sku : $cart->product->code,
                        'quantity' => $cart->quantity,
                    ];

                    if ($cart->relationLoaded('product') && $cart->product->relationLoaded('productDimension')) {
                        $productDimension = $cart->product->productDimension;
                        $item = array_merge($item, [
                            'height' => $productDimension->height,
                            'weight' => $productDimension->weight,
                            'length' => $productDimension->length,
                            'width' => $productDimension->width,
                        ]);

                        $productDimensions[] = [
                            'weight' => $productDimension->weight,
                        ];
                    }

                    $items[$key] = $item;
                }

                $totalWeight = array_reduce($productDimensions, function ($carry, $item) {
                    return $carry + $item['weight'];
                }, 0);

                if ($totalWeight >= shippingMethods::WEIGHT) {
                    $type = shippingMethods::HANG_NANG;
                    $dataShippingMethod['type']=$type;
                    $dataShippingMethod['value']="ghn";
                    $dataShippingMethod['message']="Vận chuyển hàng nặng";
                }else{
                    $dataShippingMethod['value']="ghn";
                    $dataShippingMethod['type']=$type;
                    $dataShippingMethod['message']="Vận chuyển hàng nhẹ";
                }


        $shipp = ApiHelper::calculateServiceFee($type, $totalWeight, $items);
        if($shipp!==null){
            $dataShippingMethod['shipp']=$shipp;
        }else{
            $dataShippingMethod['shipp']=0;
        }

        return view('client.orders.checkout', compact('cartCheckout' ,'carts', 'cartCount','dataShippingMethod','wishlistCount'));
    }

    public function removeFromCart($id)
    {
        $userId = Auth::check() ? Auth::id() : '';
        $cartItem = Cart::where('user_id',$userId)->findOrFail($id);

        if ($cartItem) {
            $cartItem->delete(); // Xóa sản phẩm khỏi giỏ hàng
            $total = Cart::where('user_id',$userId)->sum('total_price');
            return response()->json(['message' => 'Product removed successfully' ,'total'=> $total]);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }

    public function updateCart(Request $req)
    {
        $userId = auth()->id(); // Lấy ID của người dùng hiện tại
        $cartItems = $req->input('cartItems'); // Nhận dữ liệu từ request

        foreach ($cartItems as $item) {
            $cart = Cart::where('user_id', $userId)
                ->where('id', $item['id'])
                ->first();

            if ($cart) {
                $cart->quantity = $item['quantity']; // Cập nhật số lượng
                // Xác định giá cần sử dụng
                $price = 0;
                if ($cart->productVariant) {
                    // Sử dụng giá của biến thể nếu có
                    $price = $cart->productVariant->price_modifier;
                } else {
                    // Sử dụng giá sale nếu có, nếu không thì lấy giá thường
                    $price = $cart->product->price_sale ?? $cart->product->price_regular;
                }
                // Cập nhật tổng giá dựa trên số lượng và giá đã xác định
                $cart->total_price = $item['quantity'] * $price;
                $cart->save(); // Lưu lại thay đổi
            }
        }

        return response()->json(['message' => 'Cart updated successfully']);
    }

    public function show(string $id)
    {
        //xóa cart ở đâu
    }

    /**
     * Update the specified resource in storage.
     */
 
    public function updateOrder(Request $req, int $id)
    {
        // Log::info($req->all());
        // Xác thực yêu cầu (nếu cần thiết)
        // $req->validate([
        //     'status' => 'required|string|in:Chờ xác nhận,Đã xác nhận,Đang giao,Hoàn thành,Hàng thất lạc,Đã hủy',
        // ]);
        // Tìm order bằng id

        // Ghi log thông tin yêu cầu

        // Lấy trạng thái từ request
        $status = $req->input('status');

        // Gọi service để kiểm tra trạng thái
        $response = $this->orderService->checkStatus($status, $id);
        if ($response && $status === 'Hoàn thành') {
            // Lấy thông tin đơn hàng
            $order = $this->orderService->getOrderById($id); // Đảm bảo phương thức này trả về đối tượng đơn hàng đầy đủ

            if ($order && $order->user && $order->user->email) {
                try {
                    // Gửi email cho khách hàng
                    Mail::to($order->user->email)->send(new OrderCompletedMail($order));

                    // Log::info("Email đã được gửi tới: " . $order->user->email);
                } catch (\Exception $e) {
                    // Log::error("Không thể gửi email: " . $e->getMessage());
                }
            }
        }
        return response()->json(['status' => $response]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(int $id)
    {
        $order = $this->orderService->getById($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $logDetails = sprintf(
            'Xóa Order: Tên - %s',
             $order->code
        );

        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa',
            $logDetails
        ));

        // Xóa mềm đơn hàng
        $order->delete();

        return response()->json(['message' => 'Order soft deleted successfully'], 200);
    }

    public function restore(int $id)
    {
        $order = $this->orderService->getIdWithTrashed($id);

        // if (!$order || !$order->trashed()) { // Kiểm tra đơn hàng đã bị xóa mềm hay chưa
        //     return response()->json(['message' => 'Đơn hàng không tồn tại hoặc chưa bị xóa mềm'], 404);
        // }

        $order->restore(); // Khôi phục đơn hàng

        return response()->json(['message' => 'Đơn hàng đã được khôi phục thành công'], 200);
    }

    public function muitpathRestore(Request $request)
    {
        $ids = $request->input('ids');
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                if ($id > 0) {
                    $this->restore($id); // Giả sử phương thức restore sẽ thực hiện khôi phục
                }
            }
            return response()->json(['message' => 'Đơn hàng đã được khôi phục thành công'], 200); // Trả về thông báo thành công
        }

        return response()->json(['error' => 'Không có đơn hàng nào được chọn để khôi phục'], 400); // Trả về thông báo lỗi nếu không có ID nào
    }


    public function deleteMuitpalt(Request $request)
    {
        // Xác thực yêu cầu
        // $request->validate([
        //     'ids' => 'required|array', // Kiểm tra có tồn tại mảng ID
        //     'ids.*' => 'integer', // Đảm bảo tất cả các ID là kiểu số nguyên
        //     'action' => 'required|string', // Thêm xác thực cho trường action
        // ]);

        $ids = $request->input('ids');
        $action = $request->input('action');

        if (count($ids) > 0) {
            switch ($action) {
                case 'soft_delete':
                    foreach ($ids as $id) {
                        if ($id > 0) {
                            $order = $this->orderService->getById($id); // Lấy đơn hàng
                            if ($order && !$order->trashed()) {
                                $order->delete(); // Xóa mềm đơn hàng
                            }
                        }
                    }
                    return response()->json(['message' => 'Xóa mềm thành công'], 200);

                case 'hard_delete':
                    foreach ($ids as $id) {
                        $order = $this->orderService->getIdWithTrashed($id); // Lấy đơn hàng
                        if ($order && $order->trashed()) {
                            $order->forceDelete(); // Xóa cứng đơn hàng
                        }
                    }
                    return response()->json(['message' => 'Xóa cứng thành công'], 200);
                default:
                    return response()->json(['message' => 'Hành động không hợp lệ'], 400);
            }
        } else {
            return response()->json(['message' => 'Không có ID nào được cung cấp'], 400);
        }
    }

    public function hardDelete(int $id)
    {
        $data = $this->orderService->getIdWithTrashed($id);

        if (!$data) {
            return response()->json(['message' => 'Product not found.'], 404);
        }
        // Xóa cứng category
        $data->forceDelete();

        return response()->json(['message' => 'Delete with success'], 200);
    }

    public function addToCart(Request $request)
    {
        // Validate các trường cần thiết
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'product_variants_id' => 'nullable|exists:product_variants,id',
        //     'quantity' => 'required|integer|min:1'
        // ]);

        if (!Auth::check()) {
            // Nếu chưa đăng nhập, trả về thông báo lỗi
            return response()->json(['message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.'], 401);
        }

        // Lấy thông tin từ request
        $productId = $request->input('product_id');
        $productVariantId = $request->input('product_variants_id');
        $quantity = $request->input('quantity');
        $userId = Auth::id();

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng hay chưa
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('product_variants_id', $productVariantId)
            ->first();

        $price = $productVariantId
            ? ProductVariant::find($productVariantId)->price_modifier
            : Product::find($productId)->price_sale ?? Product::find($productId)->price_regular;

        if ($cartItem) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng và tổng giá
            $cartItem->quantity += $quantity;
            $cartItem->total_price += $quantity * $price;
            $cartItem->save();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ hàng
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'product_variants_id' => $productVariantId,
                'quantity' => $quantity,
                'total_price' => $quantity * $price,
            ]);
        }
        $totalQuantity = Cart::where('user_id', $userId)->sum('quantity');
        $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
        ->where('user_id', $userId)
        ->get();
        // Trả về phản hồi JSON
        return response()->json(['message' => 'Sản phẩm đã được thêm vào giỏ hàng', 'totalQuantity' => $totalQuantity , 'carts'=>$carts]);
    }

    public function wishList()
    {
        $userId = auth()->id();

        $wishLists = WishList::with(['product', 'productVariant'])
            ->where('user_id', $userId)
            ->get();

        $carts  = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $categories = Category::with('children')->whereNull('parent_id')->get();

        $cartCount = $carts->sum('quantity');

        // $wishLists = WishList::with(['product', 'productVariant', 'attributeValues.attribute'])
        //     ->where('user_id', $userId)
        //     ->get();
        // dd($wishLists);


        return view('client.products.wishlist', compact('wishLists', 'categories', 'carts', 'cartCount'));
    }

    public function addWishList(Request $request)
    {
        Log::info('test',$request->all());
        // Kiểm tra xác thực người dùng
        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate dữ liệu đầu vào
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'product_variants_id' => 'nullable|exists:product_variants,id',
        // ]);

        // Kiểm tra xem sản phẩm đã có trong wishlist chưa
        $wishlist = WishList::where('user_id', $userId)
            ->where('product_id', $request->input('product_id'))
            ->where('product_variants_id', $request->input('product_variants_id'))
            ->first();

        if ($wishlist) {
            // Nếu sản phẩm đã tồn tại trong wishlist, thực hiện xóa
            $wishlist->delete();
            $count=WishList::count();
            return response()->json(['status' => false,'count'=>$count]);
        } else {
            // Nếu sản phẩm chưa tồn tại trong wishlist, thực hiện thêm mới
            WishList::create([
                'user_id' => $userId,
                'product_id' => $request->input('product_id'),
                'product_variants_id' => $request->input('product_variants_id'),
            ]);
            $count=WishList::count();
            return response()->json(['status' => true ,'count'=>$count]);
        }
    }

    public function destroyWishlist($id)
    {
        $wishlistItem = Wishlist::find($id);

        if (!$wishlistItem) {
            return response()->json(['message' => 'Wishlist item not found'], 404);
        }

        $wishlistItem->delete();

        return response()->json(['message' => 'Wishlist item deleted successfully'], 200);
    }
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code'); // Mã giảm giá người dùng nhập
        $userId = auth()->id(); // Lấy ID người dùng hiện tại

        // Lấy giỏ hàng từ cơ sở dữ liệu
        $cartItems = Cart::where('user_id', $userId)->get();

        // Kiểm tra giỏ hàng có sản phẩm không
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng không có sản phẩm.',
            ]);
        }

        // Tính tổng phụ và số lượng sản phẩm
        $subTotal = 0;
        $quantity = 0;

        foreach ($cartItems as $item) {
            $subTotal += $item->total_price;
            $quantity += $item->quantity;
        }

        // Kiểm tra mã giảm giá trong cơ sở dữ liệu
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.',
            ]);
        }
        // Kiểm tra phạm vi áp dụng của mã giảm giá
        if ($coupon->applies_to == 'product') {
            // Kiểm tra xem mã giảm giá có áp dụng cho sản phẩm trong giỏ hàng không
            $productIds = $cartItems->pluck('product_id');
            $validProducts = DB::table('coupons_products')
                ->where('coupon_id', $coupon->id)
                ->whereIn('product_id', $productIds)
                ->count();

            if ($validProducts == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không áp dụng cho sản phẩm trong giỏ hàng.',
                ]);
            }
        } elseif ($coupon->applies_to == 'category') {
            // Kiểm tra xem mã giảm giá có áp dụng cho danh mục của sản phẩm trong giỏ hàng không
            $validCategories = DB::table('coupons_categories')
                ->where('coupon_id', $coupon->id)
                ->join('products', 'coupons_categories.category_id', '=', 'products.category_id')
                ->whereIn('products.id', $cartItems->pluck('product_id'))
                ->count();

            if ($validCategories == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không áp dụng cho danh mục sản phẩm trong giỏ hàng.',
                ]);
            }
        } elseif ($coupon->applies_to == 'user') {
            // Kiểm tra xem người dùng có sử dụng mã giảm giá này không
            $userCoupon = DB::table('user_coupons')
                ->where('coupon_id', $coupon->id)
                ->where('user_id', $userId)
                ->first();

            if (!$userCoupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá này không áp dụng cho người dùng hiện tại.',
                ]);
            }
        }

        // Kiểm tra xem tổng đơn hàng có đủ điều kiện áp dụng mã giảm giá không
        if ($subTotal < $coupon->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Tổng đơn hàng chưa đủ điều kiện áp dụng mã giảm giá. Bạn cần mua thêm sản phẩm có giá trị tối thiểu là ' . number_format($coupon->min_order_value, 0, ',', '.') . ' đ.',
            ]);
        }

        // Tính toán giảm giá từ coupon
        $discountAmount = $coupon->discount_type === 'fixed_amount'
            ? $coupon->discount_value
            : ($coupon->discount_value / 100) * $subTotal;

        // Đảm bảo giảm giá không vượt quá mức tối đa
        $discountAmount = min($discountAmount, $coupon->max_discount_amount);

        // Tính tổng sau khi áp dụng giảm giá
        $totalAfterDiscount = $subTotal - $discountAmount;

        // Lấy phí vận chuyển từ yêu cầu
        $shippingCost = $request->input('shipping_cost', 30000); // Mặc định là 30,000 đ

        // Tính tổng tiền sau khi thêm phí vận chuyển
        $total = $totalAfterDiscount + $shippingCost;
        $coupons = session('coupons', []);
        $couponData=[
            'code' => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
            'discount_amount' => $discountAmount,
            'total' => $total,
        ];
        $coupons[]=$couponData;
        session(['coupons'=>$coupons]);
        return response()->json([
            'success' => true,
            'coupon' =>$couponData,
            'cartSummary' => [
                'subTotal' => $subTotal,
                'quantity' => $quantity,
                'shippingCost' => $shippingCost,
                'totalAfterDiscount' => $totalAfterDiscount,
                'total' => $total,
            ],
            'message' => 'Thêm mã giảm giá thành công ',
        ]);
    }
}
