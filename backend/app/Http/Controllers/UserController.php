<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Permission;
use App\Models\UserReview;
use Illuminate\Http\Request;
use App\Models\OrderLocation;
use App\Services\UserService;
use App\Services\ProductService;
use App\Services\AddressServices;
use App\Events\AdminActivityLogged;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $userService;
    protected $userRepository;
    protected $productService;

    public function __construct(UserService $userService, AddressServices $addressServices, ProductService $productService,)
    {
        $this->userService = $userService;
        $this->productService = $productService;
    }


    public function index()
    {
        $user = $this->userService->getAll();
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

        // Quay lại trang danh sách người dùng
        return redirect()->route('admin.users.index')->with('success', 'Người dùng được xóa thành công');
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

        $cartCount = $carts->sum('quantity');
        return view('client.users.index', compact('carts', 'cartCount'));
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

        $cartCount = $carts->sum('quantity');
        return view('client.users.show', compact('user', 'address', 'carts', 'cartCount'));
    }

    public function updateClient(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'email' => 'required|email|max:255|unique:users,email',
            'date_of_birth' => 'required|date',
        ]);
        $data = $request->all();

        $user = $this->userService->updateUser($id, $data);

        return redirect()->route('users.showClient', $user->id);
    }

    public function showOrder(Request $request)
    {
        $id = Auth::user()->id;
        $status = $request->input('status', 'all');

        // Tạo query
        $query = Order::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Sử dụng paginate để phân trang
        $orders = $query->paginate(5);
        $totalOrders = $query->count();

        // Lấy giỏ hàng
        $carts = collect();
        if ($id) {
            $carts = Cart::where('user_id', $id)->with('product')->get();
        }

        $cartCount = $carts->sum('quantity');

        return view('client.users.show_order', compact('orders', 'totalOrders', 'status', 'carts', 'cartCount'));
    }


    public function showDetailOrder($id)
    {

        $orders = Order::with([
            'items.product',
            'items.productVariant.attributeValues.attribute',
            'payment.paymentGateway',
            'shippingMethod'
        ])->findOrFail($id);


        $locations = OrderLocation::where('order_id', $id)->get();
        $payments = Payment::join('payment_gateways', 'payments.payment_gateway_id', '=', 'payment_gateways.id')
            ->select('payments.*', 'payment_gateways.name as gateway_name')
            ->where('order_id', $id)
            ->get();

        $userId = auth()->id();
        $carts  = collect();
        if ($userId) {
            $carts = Cart::where('user_id', $userId)->with('product')->get();
        }

        $cartCount = $carts->sum('quantity');
        $address = Address::getActiveAddress(Auth::user()->id);

        $orderItems = $orders->items;
        $firstProduct = $orderItems->first()->product;
        $similarProducts = Product::where('category_id', $firstProduct->category_id)
            ->where('id', '!=', $firstProduct->id)
            ->take(5)
            ->get();
        $bestSellingProducts = $this->productService->bestSellingProducts();
        return view('client.users.show_detail_order', compact('orders', 'locations', 'carts', 'cartCount', 'address', 'payments', 'orderItems', 'similarProducts', 'bestSellingProducts'));
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
        return view('client.users.show_rank', compact('user'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Kiểm tra xem trạng thái có phải là "Chờ xác nhận" không
        if ($order->status === 'Chờ xác nhận') {
            // Cập nhật trạng thái của đơn hàng thành "Đã hủy"
            $order->status = 'Đã hủy';
            $order->save();

            // Trả về thông báo thành công hoặc chuyển hướng về trang chi tiết đơn hàng
            return redirect()->back()->with('success', 'Đơn hàng đã được hủy.');
        }

        // Nếu không phải "Chờ xác nhận", trả về thông báo lỗi
        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
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
