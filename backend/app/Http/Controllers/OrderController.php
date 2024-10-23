<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLocation;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
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

//đoạn hiện trang này ở đâu áTrang nào nhỉ
    /**
     * Store a newly created resource in storage.
     */

    public function showShoppingCart()
    {
        $userId = auth()->id();
        $carts = Cart::with(['product', 'productVariant', 'attributeValues.attribute'])
            ->where('user_id', $userId)
            ->get();

        return view('client.orders.shoppingcart', compact('carts'));
    }

    public function showCheckOut()
    {
        $userId = auth()->id();
        $cartCheckout = Cart::with(['product', 'productVariant', 'attributeValues.attribute'])
            ->where('user_id', $userId)
            ->get();

        $address = Address::select('address_line', 'address_line1', 'address_line2')
            ->where('user_id', $userId)
            ->first();

        return view('client.orders.checkout', compact('cartCheckout', 'address'));
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
                $cart->total_price = $item['quantity'] * ($cart->productVariant ? $cart->productVariant->price_modifier : $cart->product->price_regular);
                $cart->save(); // Lưu lại thay đổi
            }
        }

        return response()->json(['message' => 'Cart updated successfully']);
    }
    public function updateOrInsertAddress(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'username' => 'required|string|max:255',
            'phone' => 'required|string|max:15', // Hoặc một quy tắc khác phù hợp với số điện thoại
            'newAddress' => 'required|string|max:255',
            // Thêm các quy tắc xác thực khác nếu cần
        ]);

        // Lưu thông tin người dùng
        $user = User::updateOrCreate(
            ['id' => auth()->id()], // Tìm kiếm người dùng theo ID
            ['username' => $request->username, 'phone_number' => $request->phone]
        );

        // Lưu địa chỉ
        $address = new Address();
        $address->address_line = $request->newAddress;
        $address->user_id = $user->id; // Liên kết địa chỉ với người dùng
        $address->save();

        return response()->json(['success' => true, 'message' => 'Thêm địa chỉ thành công!']);
    }

    public function addOrder(Request $request)
    {
        // Validate request data
        // $request->validate([
        //     'address' => 'required|string|max:255',
        //     'ward' => 'required|string|max:255',
        //     'district' => 'required|string|max:255',
        //     'city' => 'required|string|max:255',
        //     'phone_number' => 'required|string|max:15',
        //     'email' => 'required|email|max:255',
        //     'note' => 'nullable|string|max:500',
        //     'radio-ship' => 'required', // Shipping method
        // ]);

        // Tính toán tổng giá trị đơn hàng từ giỏ hàng
        $subTotal = 0;
        if ($request->has('order_item')) {
            foreach ($request->order_item as $item) {
                $subTotal += $item['price'] * $item['quantity'];
            }
        }

        if($request->has('radio_pay')){
            $radio_pay = $request->radio_pay;
            if($radio_pay=='cash'){
                $dataOrder['payment_id']=6;
            }
        }

        // Lấy giá trị phí vận chuyển
        $shippingCost = floatval($request->input('radio-ship')); // Đảm bảo giá trị là số

        // Tính tổng giá trị đơn hàng
        $totalPrice = $subTotal + $shippingCost;

        // Tạo đơn hàng
        $dataOrder = [
            'user_id' => Auth::id(),
            'code' => 'ORDER-' . strtoupper(uniqid()),
            'total_price' => $totalPrice, // Đặt giá trị tổng đã tính toán ở đây
            'note' => $request->note,
            'status' => Order::CHO_XAC_NHAN,
        ];

        
        // Lưu đơn hàng
        $order = $this->orderService->saveOrUpdate($dataOrder);

        // Tiếp tục với địa chỉ và các sản phẩm...
        $dataOrderLocation = [
            'order_id' => $order->id,
            'address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'ward' => $request->ward,
            'latitude' => null,
            'longitude' => null,
        ];

        if ($request->has('order_item')) {
            foreach ($request->order_item as $value) {
                $dataItem = [
                    'order_id' => $order->id,
                    'product_id' => $value['product_id'],
                    'variant_id' => $value['product_variant_id'],
                    'quantity' => $value['quantity'],
                    'price' => $value['price'],
                    'discount' => $value['discount'] ?? null,
                ];
                OrderItem::create($dataItem);
                $idCard = $value['id_cart'];
                $this->removeFromCart($idCard);
            }
        }

        $this->orderLocationService->saveOrUpdate($dataOrderLocation);
        return redirect()->route('client')->with('message', 'Đơn hàng đã được đặt thành công!');
    }


    /**
     * Display the specified resource.
     */
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


}