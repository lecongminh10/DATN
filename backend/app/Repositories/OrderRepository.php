<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class OrderRepository extends BaseRepository
{
    protected $orderRepository;

    public function __construct(Order $orderRepository)
    {
        parent::__construct($orderRepository);
        $this->orderRepository = $orderRepository;
    }

    public function getAll($search = null, $perPage = null)
    {

        $query = Order::select('orders.*', 'users.email as user_email', 'addresses.address_line as address', 'payment_gateways.name as payment_gateway_name')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('addresses', 'addresses.id', '=', 'orders.shipping_address_id')
            ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id')
            ->leftJoin('payment_gateways', 'payment_gateways.id', '=', 'payments.payment_gateway_id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('orders.code', 'LIKE', '%' . $search . '%')
                    ->orWhere('orders.total_price', 'LIKE', '%' . $search . '%')
                    ->orWhere('orders.note', 'LIKE', '%' . $search . '%')
                    ->orWhere('orders.status', 'LIKE', '%' . $search . '%')
                    ->orWhere('orders.tracking_number', 'LIKE', '%' . $search . '%');
            });

            // Lọc theo users
            // $query->orWhereHas('users', function ($q) use ($search) {
            //     $q->where('users.username', 'LIKE', '%' . $search . '%');
            // });

        }

        return $query->paginate($perPage);
    }

    public function getTrashOrder($search = null, $perPage = null)
    {
        // Chọn các trường cần thiết từ bảng orders và các bảng liên quan
        $query = Order::select('orders.*', 'users.email as user_email', 'addresses.address_line as address', 'payment_gateways.name as payment_gateway_name')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('addresses', 'addresses.id', '=', 'orders.shipping_address_id')
            ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id')
            ->leftJoin('payment_gateways', 'payment_gateways.id', '=', 'payments.payment_gateway_id')
            ->onlyTrashed(); // Chỉ lấy các đơn hàng đã bị xóa mềm

        // Nếu có tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('orders.code', 'LIKE', '%' . $search . '%')
                    ->orWhere('orders.total_price', 'LIKE', '%' . $search . '%')
                    ->orWhere('orders.note', 'LIKE', '%' . $search . '%')
                    ->orWhere('orders.status', 'LIKE', '%' . $search . '%')
                    ->orWhere('orders.tracking_number', 'LIKE', '%' . $search . '%');
            });

            // Nếu cần tìm kiếm theo user (nếu có trường username)
            // $query->orWhereHas('users', function ($q) use ($search) {
            //     $q->where('users.username', 'LIKE', '%' . $search . '%');
            // });
        }

        // Trả về kết quả phân trang
        return $query->paginate($perPage);
    }

    public function checkStatus(string $status, int $id)
    {
        $statusOrder = [
            Order::CHO_XAC_NHAN => 1,
            Order::DA_XAC_NHAN => 2,
            Order::DANG_GIAO => 3,
            Order::HOAN_THANH => 4,
            Order::HANG_THAT_LAC => 5,
            Order::DA_HUY => 6,
        ];
    
        // Lấy đơn hàng theo ID
        $order = $this->getById($id);
        if (!$order) {
            return false; // Trả về false nếu không tìm thấy đơn hàng
        }
    
        // Lấy giá trị trạng thái hiện tại và trạng thái mới từ mảng $statusOrder
        $currentStatusValue = $statusOrder[$order->status] ?? null;
        $newStatusValue = $statusOrder[$status] ?? null;
    
        // Kiểm tra điều kiện bổ sung cho trạng thái "Hoàn thành"
        if ($order->status === Order::HOAN_THANH) {
            // Nếu trạng thái hiện tại là "Hoàn thành", không cho phép chuyển sang "Hàng thất lạc" hoặc "Đã hủy"
            if ($status === Order::HANG_THAT_LAC || $status === Order::DA_HUY) {
                return false; // Không cho phép cập nhật
            }
        }

        if ($order->status === Order::DANG_GIAO) {
            if($status === Order::DA_HUY){
                return false;
            }
        }
    
        // Kiểm tra nếu trạng thái mới hợp lệ và lớn hơn trạng thái hiện tại thì cho phép cập nhật
        if ($newStatusValue && $currentStatusValue && $newStatusValue > $currentStatusValue) {
            $data['status'] = $status; // Gán trạng thái mới
            $this->saveOrUpdateItem($data, $id);
            return true;
        } else {
            // Nếu trạng thái mới không hợp lệ hoặc nhỏ hơn trạng thái hiện tại, không cập nhật
            return false;
        }
    }
    
    public function getDataOrderRefund($code)
    {
        return DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(
                'orders.id as order_id',
                'orders.user_id',
                'orders.total_price as amount',
                DB::raw('SUM(order_items.quantity) as quantity') // Tổng số lượng sản phẩm
            )
            ->where('orders.code', $code)
            ->groupBy('orders.id', 'orders.user_id', 'orders.total_price') // Thêm tất cả các cột không sử dụng hàm tổng hợp vào GROUP BY
            ->first(); // Dùng first() để lấy một kết quả duy nhất
    }
    


}