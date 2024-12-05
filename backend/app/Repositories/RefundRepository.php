<?php

namespace App\Repositories;

use App\Models\Refund;
use Illuminate\Http\Request;

class RefundRepository extends BaseRepository
{
    protected $refundRepository;

    public function __construct(Refund $refundRepository)
    {
        parent::__construct($refundRepository);
        $this->refundRepository = $refundRepository;
    }

    public function getAllRefund()
    {
        return Refund::with('permissionsValues')->get();
    }

    public function create(array $data)
    {
        return Refund::create($data);
    }

    public function findById($id)
    {
        return Refund::findOrFail($id);
    }

    public function getSearchRefund(array $filters)
    {
        // Khởi tạo query cơ bản
        $refundsQuery = Refund::with(['user', 'order', 'product']);

        // Kiểm tra tìm kiếm theo mã đơn hàng, tên người dùng, số tiền, trạng thái hoặc ngày yêu cầu
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $refundsQuery->where(function ($query) use ($search) {
                $query->whereHas('order', function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%");
                })
                ->orWhere('amount', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('requested_at', 'like', "%{$search}%");
            });
        }

        // Kiểm tra tìm kiếm theo trạng thái
        if (!empty($filters['status'])) {
            $status = $filters['status'];
            $refundsQuery->where('status', $status);
        }

        // Lọc theo ngày yêu cầu hoàn trả nếu có
        if (!empty($filters['requested_at'])) {
            $refundsQuery->whereDate('requested_at', $filters['requested_at']);
        }

        // Trả về kết quả tìm kiếm
        return $refundsQuery->get();
    }
}
