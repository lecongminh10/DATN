<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use App\Models\WishList;
use App\Models\Permission;
use App\Models\UserReview;
use Illuminate\Http\Request;
use App\Models\OrderLocation;
use App\Services\UserService;
use App\Models\ProductVariant;
use App\Services\AddressServices;
use App\Events\AdminActivityLogged;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    protected $userService;
    protected $userRepository;
    protected $productService;

    public function __construct(UserService $userService, AddressServices $addressServices)
    {
        $this->userService = $userService;
    }


    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Số lượng mặc định là 10
        $user = $this->userService->getAll($perPage);

        return view('admin.users.index', compact('user'));
    }

    public function add()
    {
        $permissionsValues = Permission::with('permissionValues')
            ->where('permission_name', 'user_management')
            ->first()
            ->permissionValues;
        return view('admin.users.store', compact('permissionsValues'));
    }


    public function store(UserStoreRequest $request)
    {
        try {
            $data = $request->validated();

            // Hash mật khẩu
            $data['password'] = bcrypt($data['password']);

            // Xử lý ảnh đại diện nếu có
            if ($request->hasFile('profile_picture')) {
                $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $data['profile_picture'] = $imagePath;
            }

            // Tạo người dùng
            $user = $this->userService->createUser($data);

            // Ghi nhật ký
            $logDetails = sprintf(
                'Thêm người dùng: Tên - %s',
                $user->username
            );
            event(new AdminActivityLogged(
                auth()->user()->id,
                'Thêm mới',
                $logDetails
            ));

            // Xử lý quyền
            if ($user && $request->has('permissions')) {
                $user->permissionsValues()->attach($request->input('permissions'));
            }

            return redirect()->route('admin.users.index')->with([
                'success' => 'Thêm mới thành công'
            ]);
        } catch (\Exception $e) {
            Log::error("Error creating user: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo người dùng.');
        }
    }


    public function show($id)
    {
        $user = $this->userService->getById($id);

        $permissions = $user->permissionsValues;

        $userId = auth()->id();
        $carts  = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }

        $cartCount = $carts->sum('quantity');

        return view('admin.users.show', compact('user', 'permissions', 'carts', 'cartCount'));
    }

    public function edit($id)
    {
        $user = User::with('permissionsValues')->findOrFail($id);

        $permissionsValues = Permission::with('permissionValues')
            ->where('permission_name', 'user_management')
            ->first()
            ->permissionValues;

        return view('admin.users.update', compact('user', 'permissionsValues'));
    }


    public function update(UserUpdateRequest $request, $id)
    {

        $data = $request->validated();

        $user = $this->userService->updateUser($id, $data);

        //nhật ký
        $logDetails = sprintf(
            'Sửa người dùng: Tên - %s',
            $user->username,
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Sửa',
            $logDetails
        ));

        if ($request->hasFile('profile_picture')) {
            // Xóa ảnh cũ nếu có
            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }

            // Lưu ảnh mới
            $filename = time() . '.' . $request->file('profile_picture')->extension();
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');

            $user->profile_picture = $path;
            $user->save(); // Lưu lại thông tin người dùng cùng ảnh mới
        }

        if ($request->has('id_permissions')) {
            $user->permissionsValues()->sync($request->id_permissions);
        }
        return redirect()->route('admin.users.index')->with([
            'success' => 'Cập nhật thành công !'
        ]);
    }

    public function destroy($id, Request $request)
    {
        // Tìm người dùng cần xóa
        $user = User::findOrFail($id);

        // Kiểm tra xem có yêu cầu xóa cứng (force delete) không
        if ($request->forceDelete === 'true') {
            $user->forceDelete();
        } else {
            $user->deleted_by = Auth::id(); 
            $user->save(); 
            $user->delete(); 
        }

        // Nhật ký hành động
        $logDetails = sprintf(
            'Xóa người dùng: Tên - %s',
            $user->username
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa',
            $logDetails
        ));

        //nhật ký
        $logDetails = sprintf(
            'Xóa người dùng: Tên - %s',
            $user->username,
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa',
            $logDetails
        ));

        return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản thành công');
    }

    public function deleteMultiple(Request $request)
    {
        $ids = json_decode($request->ids);
        $forceDelete = $request->forceDelete === 'true';

        // Xóa người dùng
        foreach ($ids as $id) {
            $user = User::withTrashed()->find($id);
            if ($forceDelete) {
                $user->forceDelete();
            } else {
                $user->deleted_by = Auth::id();
                $user->save();
                $user->delete();
            }
        }
        return redirect()->route('users.index')->with([
            'success' => 'Xóa nhiều thành công'
        ]);
    }


    public function indexClient()
    {
        $userId = auth()->id();
        $carts  = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $cartCount = $carts->sum('quantity');
        return view('client.users.index', compact('carts', 'cartCount','wishlistCount'));
    }

    public function showClient($id)
    {
        $user = $this->userService->getById($id);
        $address = Address::where('user_id', $id)->first();

        $userId = auth()->id();
        $carts  = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }
        $wishlistCount = WishList::where('user_id',$userId)->count();
        $cartCount = $carts->sum('quantity');
        return view('client.users.show', compact('user', 'address', 'carts', 'cartCount','wishlistCount'));
    }

    public function updateClient(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(10)->format('Y-m-d'),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Custom messages for username
            'username.required' => 'Tên không được bỏ trống.',
            'username.string' => 'Tên phải là một chuỗi ký tự hợp lệ.',
            'username.max' => 'Tên không được vượt quá 255 ký tự.',
    
            // Custom messages for phone_number
            'phone_number.required' => 'Số điện thoại không được bỏ trống.',
            'phone_number.string' => 'Số điện thoại phải là một chuỗi ký tự hợp lệ.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'phone_number.regex' => 'Số điện thoại không đúng định dạng. Ví dụ: +84123456789 hoặc 0123456789.',
    
            // Custom messages for email
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
    
            // Custom messages for date_of_birth
            'date_of_birth.required' => 'Ngày sinh không được bỏ trống.',
            'date_of_birth.date' => 'Ngày sinh phải là một ngày hợp lệ.',
            'date_of_birth.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'date_of_birth.before_or_equal' => 'Ngày sinh phải trước ngày ' . now()->subYears(10)->format('d/m/Y') . ' (ít nhất 10 tuổi).',
    
            'profile_picture.image' => 'Tệp tải lên phải là một hình ảnh.',
            'profile_picture.mimes' => 'Chỉ chấp nhận các định dạng JPEG, PNG, JPG và GIF.',
            'profile_picture.max' => 'Kích thước hình ảnh không được vượt quá 2 MB.',
        ]);
    
        $user = $this->userService->getById($id);
    
        $user->username = $request->input('username');
        $user->phone_number = $request->input('phone_number');
        $user->email = $request->input('email');
        $user->date_of_birth = $request->input('date_of_birth');
    
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }
            $filename = time() . '.' . $request->file('profile_picture')->extension();
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');
            $user->profile_picture = $path;
        }
        $user->save();
    
        return redirect()->route('users.showClient', $user->id);

    }
    

    public function showOrder(Request $request)
    {
        $userId = Auth::user()->id;
        $status = $request->input('status', 'all');

        // Query cơ bản để lấy tất cả đơn hàng của người dùng
        $baseQuery = Order::where('user_id', $userId);

        // Lọc theo trạng thái nếu có
        if ($status !== 'all') {
            $baseQuery->where('status', $status);
        }

        // Tổng số đơn hàng không thay đổi theo phân trang
        $totalOrders = $baseQuery->count();

        // Lấy dữ liệu với phân trang
        $orders = $baseQuery->with([
            'items.product',
            'items.productVariant.attributeValues.attribute',
            'payment.paymentGateway',
            'shippingMethod'
        ])->simplePaginate(5);

        // Giỏ hàng và số lượng giỏ hàng
        $carts = Cart::where('user_id', $userId)
            ->with('product')
            ->get();

        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$userId)->count();

        return view('client.users.show_order', compact('orders', 'totalOrders', 'status', 'carts', 'cartCount', 'wishlistCount'));
    }


    public function showDetailOrder($id)
    {
        $statusMapping = [
            'pending' => 'Đang chờ xử lí',
            'approved' => 'Đã duyệt',
            'rejected' => 'Bị từ chối',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];

        $orders = Order::with([
            'items.product',
            'items.productVariant.attributeValues.attribute',
            'payment.paymentGateway',
            'shippingMethod'
        ])->findOrFail($id);

        $refund = Refund::where('order_id', $id)->first(); // Lấy thông tin hoàn trả nếu có
        $refundStatus = $refund->status ?? null; // Lấy trạng thái hoàn trả
        $timeRefunds = $refund->created_at ??null;
        // Nếu có trạng thái hoàn trả, ưu tiên hiển thị trạng thái này
        $orderStatus = $statusMapping[$refundStatus] ?? $orders->status;
        $dateTimeOrders= $timeRefunds ?? $orders->created_at;
        $messageStatus='';
        if( $refundStatus=='rejected' &&  $refund->rejection_reason!==null) $messageStatus=$refund->rejection_reason;
        // if($statusMapping[$refundStatus]=='rejected' &&  $refund->rejection_reason!==null) $messageStatus=$refund->rejection_reason;
        // Quy định điều kiện ẩn/hiện nút
        $showButtons = is_null($refund);

        $locations = OrderLocation::where('order_id', $id)->get();
        $payments = Payment::join('payment_gateways', 'payments.payment_gateway_id', '=', 'payment_gateways.id')
            ->select('payments.*', 'payment_gateways.name as gateway_name')
            ->where('payments.order_id',$orders->id)
            ->get();

        $userId = auth()->id();
        $carts  = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }

        $cartCount = $carts->sum('quantity');
        $address = Address::getActiveAddress(Auth::user()->id);

        $wishlistCount = WishList::where('user_id',$userId)->count();

        $orderItems = $orders->items;
        $firstProduct = $orderItems->first()->product;
        $similarProducts = Product::where('category_id', $firstProduct->category_id)
            ->where('id', '!=', $firstProduct->id)
            ->take(5)
            ->get();
        $bestSellingProducts = $this->productService->bestSellingProducts();

        return view('client.users.show_detail_order', compact(
            'orders', 
            'locations', 
            'carts', 
            'cartCount', 
            'address', 
            'payments', 
            'orderItems', 
            'similarProducts', 
            'refundStatus', 
            'orderStatus',
            'showButtons',
            'dateTimeOrders',
            'messageStatus',
            'wishlistCount',
            'bestSellingProducts'
        ));
    }


    public function listdeleteMultiple()
    {
        $user = $this->userService->getAllTrashedUsers();
        return view('admin.users.deleted', compact('user'));
    }

    public function manage(Request $request, int $id)
    {
        // Tìm người dùng đã bị xóa mềm (soft delete)
        $user = User::onlyTrashed()->find($id);

        // Nếu không tìm thấy người dùng, thông báo lỗi và chuyển hướng
        if (!$user) {
            session()->flash('error', 'Không tìm thấy người dùng.');
            return redirect()->route('users.index');
        }

        // Xử lý hành động khôi phục
        if ($request->input('action') === 'restore') {
            $user->restore(); // Khôi phục người dùng
            session()->flash('success', 'Khôi phục người dùng thành công.');
            return redirect()->route('users.index'); // Chuyển hướng về danh sách tất cả người dùng
        }

        // Xử lý hành động xóa vĩnh viễn
        if ($request->input('action') === 'hard-delete') {
            $user->forceDelete(); // Xóa vĩnh viễn người dùng
            session()->flash('success', 'Xóa vĩnh viễn người dùng thành công.');
            return redirect()->route('users.index'); // Chuyển hướng về danh sách tất cả người dùng
        }

        // Nếu không xác định được hành động, chuyển hướng với lỗi
        session()->flash('error', 'Hành động không hợp lệ.');
        return redirect()->route('users.index');
    }



    public function updateOrInsertAddress(Request $request)
    {
        Log::info('Request received for creating address:', $request->all());
        // Lấy user hiện tại (giả định đã đăng nhập)
        $userId = Auth::id();

        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'specific_address' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'username' => 'nullable|string|unique:users,username,' . $userId,
            'phone_number' => 'nullable|string|unique:users,phone_number,' . $userId,
        ]);
        if (isset($validatedData['username']) || isset($validatedData['phone_number'])) {
            $data = [
                'username' => $validatedData['username'],
                'phone_number' => $validatedData['phone_number'],
            ];
            $this->userService->saveOrUpdate($data, $userId);
        }

        $is_active = Address::hasActiveAddress($userId);
        // Tạo địa chỉ mới cho user
        $address = Address::create([
            'user_id' => $userId,
            'specific_address' => $validatedData['specific_address'],
            'ward' => $validatedData['ward'],
            'district' => $validatedData['district'],
            'city' => $validatedData['city'],
            'active' => $is_active ? false : true
        ]);

        // Trả về phản hồi thành công dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'Thêm địa chỉ mới thành công!',
            'address' => $address
        ]);
    }
    public function setDefaultAddress(Request $request, $id)
    {
        $userId = Auth::id();
        Address::where('user_id', $userId)->update(['active' => false]);
        $address = Address::where('user_id', $userId)->where('id', $id)->first();
        if ($address) {
            $address->active = true;
            $address->save();

            return response()->json(['success' => true, 'message' => 'Cập nhật địa chỉ mặc định thành công!']);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy địa chỉ!'], 404);
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'id_address' => 'required|exists:addresses,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:10,15',
            'city' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
            'address' => 'required|string',
        ]);

        $dataUser = [
            'username' => $request->name,
            'phone_number' => $request->phone
        ];
        $this->userService->saveOrUpdate($dataUser, Auth::id());
        $address = Address::find($request->id_address);
        $address->city = $request->city;
        $address->district = $request->district;
        $address->ward = $request->ward;
        $address->specific_address = $request->address;
        $address->save();

        return response()->json(['success' => 'Địa chỉ đã được cập nhật thành công!']);
    }

    public function showRank($id)
    {
        $user = $this->userService->getById($id);
        if($user) {
            $carts = Cart::with(['product', 'productVariant.attributeValues.attribute', 'product.galleries'])
            ->where('user_id', $user->id)
            ->get();
        }
        $cartCount = $carts->sum('quantity');
        $wishlistCount = WishList::where('user_id',$user)->count();
        return view('client.users.show_rank', compact('user','carts','cartCount','wishlistCount'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        if ($order->status === 'Chờ xác nhận') {
            $order->status = 'Đã hủy';
            $order->save();
            if ($order && $order->items) {
                foreach ($order->items as $item) {
                    $this->restoreStock($item->product_id, $item->variant_id, $item->quantity);
                }
            }
            return redirect()->back()->with('success', 'Đơn hàng đã được hủy.');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
    }
    private function restoreStock($productId, $productVariantId, $quantity)
    {
        $product = Product::find($productId);
        if (!empty($productVariantId)) {
            $productVariant = ProductVariant::find($productVariantId);
            $newStockVariant = $productVariant->stock + $quantity;
            $productVariant->update(['stock' => $newStockVariant]);
        }
        $newStockProduct = $product->stock + $quantity;
        $newBuyCount = $product->buycount - $quantity;
        $product->update(['stock' => $newStockProduct , 'buycount'=>$newBuyCount]);
    }

    public function submitReview(Request $request, $productId)
    {
        $userId = Auth::id();
        $existingReview = UserReview::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá cho đơn hàng này rồi.');
        }

        // Validate dữ liệu form
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string',
        ]);

        // Lưu dữ liệu vào bảng users_reviews
        UserReview::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $request->input('rating'),
            'review_text' => $request->input('review_text'),
            'review_date' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi thành công!');
    }
}
