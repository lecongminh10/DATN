<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    protected $orderService;

    public function __construct(
        OrderService $orderService,

    ) {
        $this->orderService = $orderService;
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
    
        return view('admin.orders.order-detail', compact('data', 'user'));
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

    // public function showAdd()
    // {
    //     $category = $this->categoryService->getAll();
    //     return view('admin.products.add-product')->with([
    //         'categories' => $category
    //     ]);
    // }

    public function store(Request $request)
    {
        // // $baseUrl = env('APP_URL') . '/storage'; => sau mở lại
        // $dataProduct = $request->except(['product_variants', 'product_galaries']);

        // // Gán giá trị mặc định cho các trường boolean nếu không có
        // $dataProduct['is_active'] ??= 0;
        // $dataProduct['is_hot_deal'] ??= 0;
        // $dataProduct['is_show_home'] ??= 0;
        // $dataProduct['is_new'] ??= 0;
        // $dataProduct['is_good_deal'] ??= 0;

        // // Xử lý slug(tạo slug)
        // if (!empty($dataProduct['name']) && !empty($dataProduct['code'])) {
        //     $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['code'];
        // }

        // Xử lý images
        // if (isset($dataProduct['images']) && $dataProduct['images'] instanceof UploadedFile) {
        //     $relativePathProduct = $dataProduct['images']->store(self::PATH_UPLOAD);
        //     $dataProduct['images'] = $baseUrl . '/' . str_replace('public/', '', $relativePathProduct);
        // }

        // $product = $this->productService->saveOrUpdate($dataProduct);

        // if ($request->has('product_variants')) {
        //     $dataProductVariants = [];
        //     foreach ($request->product_variants as $item) {

        //         $dataProductVariants = [
        //             'product_id' => $product->id,
        //             'product_attribute_id' => $item['product_attribute_id'],
        //             'price_modifier' => $item['price_modifier'],
        //             'stock' => $item['stock'] ?? 0,
        //             'sku' => $item['sku'] ?? null,
        //             "status" => $item["status"] ?? 0,
        //         ];
        //         $this->productVariantService->saveOrUpdate($dataProductVariants);
        //     }
        // }

        // if ($request->has('product_galaries')) {
        //     foreach ($request->product_galaries as $image_gallery) {
        //         // Kiểm tra nếu image_gallery là một file tải lên hợp lệ
        //         if (isset($image_gallery['image_gallery'])) {

        //             // if (isset($image_gallery['image_gallery']) && $image_gallery['image_gallery'] instanceof UploadedFile) => thay vào if
        //             // $relativePath = $image_gallery['image_gallery']->store(self::PATH_UPLOAD);
        //             // $dataProductGallery = $baseUrl . '/' . str_replace('public/', '', $relativePath); => khi muốn lưu và folder

        //             $dataProductGallery = $image_gallery['image_gallery'];
        //             $this->productGalleryService->saveOrUpdate([
        //                 'product_id' => $product->id,
        //                 'image_gallery' => $dataProductGallery,
        //                 'is_main' => $image_gallery['is_main'] ?? 0,  // Thiết lập giá trị is_main
        //             ]);
        //         }
        //     }
        // }

        // if ($request->has('product_tags')) {
        //     foreach ($request->product_tags as $tag_id) {
        //         $product->tags()->attach($tag_id);
        //     }
        // }

        // return response()->json([
        //     'message' => 'Success',
        //     'product' => $product
        // ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        return response()->json(['status'=>$response]);
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
        if(count($ids) > 0) {
            foreach($ids as $id) {
                if($id > 0) {
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