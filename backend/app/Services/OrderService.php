<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;

class OrderService extends BaseService
{
    protected $orderService;

    public function __construct(OrderRepository $orderService)
    {
        parent::__construct($orderService);
        $this->orderService = $orderService;
    }

    public function getOrder($search, $perPage)
    {
        return $this->orderService->getAll($search, $perPage);
    }

    public function getTrashOrder($search, $perPage) {
        // Gọi repository để lấy danh sách các đơn hàng bị xóa mềm
        return $this->orderService->getTrashOrder($search, $perPage);
    }

    public function checkStatus($input , $id){
        return $this->orderService->checkStatus($input , $id);
    }

    public function getbyCode(string $code)
    {
       return  Order::where('code',$code)->first();
    }

    public function getDataOrderRefund($code)
    {
        return $this->orderService->getDataOrderRefund($code);
    }
}