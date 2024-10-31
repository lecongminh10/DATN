<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLocation;
use App\Models\Payment;
use App\Models\PaymentGateways;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\WishList;
use App\Services\OrderLocationService;
use App\Services\OrderService;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        
        return view('client.orders.shoppingcart', compact('carts', 'cartCount'));
    }

    public function showCheckOut()
    {
        $userId = auth()->id();
        $cartCheckout = Cart::with(['product', 'productVariant', 'attributeValues.attribute'])
            ->where('user_id', $userId)
            ->get();

        $carts  = collect();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }

        $carts  = collect();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
    
        $cartCount = $carts->sum('quantity');

        $cartCheckout =Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
                ->where('user_id', $userId)
                ->get();
        return view('client.orders.checkout', compact('cartCheckout' ,'carts', 'cartCount'));
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->delete(); // Xóa sản phẩm khỏi giỏ hàng
            return response()->json(['message' => 'Product removed successfully']);
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
        Log::info($req->all());
        // Xác thực yêu cầu (nếu cần thiết)
        // $req->validate([
        //     'status' => 'required|string|in:Chờ xác nhận,Đã xác nhận,Đang giao,Hoàn thành,Hàng thất lạc,Đã hủy',
        // ]);
        // Tìm order bằng id

        $status = $req->input('status');
        $response = $this->orderService->checkStatus($status, $id);

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

        // Trả về phản hồi JSON
        return response()->json(['message' => 'Sản phẩm đã được thêm vào giỏ hàng']);
    }

    public function wishList() {
        $userId = auth()->id();

        $wishLists = WishList::with(['product', 'productVariant'])
        ->where('user_id', $userId)
        ->get();

        $carts  = collect();
        if($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }

        $cartCount = $carts->sum('quantity');

        // $wishLists = WishList::with(['product', 'productVariant', 'attributeValues.attribute'])
        //     ->where('user_id', $userId)
        //     ->get();
        // dd($wishLists);


        return view('client.products.wishlist', compact('wishLists','carts', 'cartCount'));
    }

    public function addWishList(Request $request)
    {
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
            // return response()->json(['success' => 'Product removed from wishlist']);
        } else {
            // Nếu sản phẩm chưa tồn tại trong wishlist, thực hiện thêm mới
            WishList::create([
                'user_id' => $userId,
                'product_id' => $request->input('product_id'),
                'product_variants_id' => $request->input('product_variants_id'),
            ]);

            return response()->json(['in_wishlist' => true]);
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

}