<?php

namespace App\Http\Controllers;

use App\Events\AdminActivityLogged;
use App\Http\Requests\CarrierRequest;
use App\Models\Carrier;
use App\Services\CarrierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarrierController extends Controller
{
    protected $carrierService;

    public function __construct(CarrierService $carrierService,)
    {
        $this->carrierService = $carrierService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $status = $request->input('status');

        $carrier = $this->carrierService->getAllCarrier($search, $perPage, $status);

        return view('admin.carriers.index', compact('carrier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carriers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarrierRequest $carrierRequest, $id = null)
    {
        $data = $carrierRequest->validated();

        Carrier::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'api_url' => $data['api_url'],
            'api_token' => $data['api_token'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'is_active' => $data['is_active'], // Giá trị trạng thái
        ]);
        
        return redirect()->route('admin.carriers.index')->with('success', 'Nhà vận chuyển đã được thêm thành công.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Carrier $carrier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $carrier = $this->carrierService->getById($id);
        return view('admin.carriers.edit', compact('carrier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarrierRequest $carrierRequest, string $id)
    {
        // Lấy dữ liệu từ request
        $data = $carrierRequest->validated();

        // Tìm nhà vận chuyển cần cập nhật
        $carrier = Carrier::findOrFail($id);

        // Cập nhật thông tin nhà vận chuyển
        $carrier->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'api_url' => $data['api_url'],
            'api_token' => $data['api_token'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'is_active' => $data['is_active'], // Giá trị trạng thái
        ]);

        // Chuyển hướng với thông báo thành công
        return redirect()->route('admin.carriers.index')->with('success', 'Nhà vận chuyển đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search'); // Từ khóa tìm kiếm
        $perPage = $request->input('perPage', 10); // Số lượng hiển thị mỗi trang
        $status = $request->input('status'); // Lọc theo trạng thái
        
        // Gọi service để lấy dữ liệu
        $data = $this->carrierService->show_soft_delete($search, $perPage, $status);
        
        // Trả về view với dữ liệu
        return view('admin.carriers.deleted', compact('data', 'search', 'status', 'perPage'));
    }

    public function restore($id)
    {
        try {
            $this->carrierService->restore_delete($id);
            return redirect()->route('admin.carriers.deleted')->with('success', 'Khôi phục nhà vận chuyển thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.carriers.deleted')->with('error', 'Không thể khôi phục nhà vận chuyển: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCarrier(int $id)
    {
        $data = $this->carrierService->getById($id);

        if (!$data) {
            return abort(404);
        }
        $logDetails = sprintf(
            'Xóa vận chuyển: Tên - %s',
            $data->name
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa Mềm',
            $logDetails
        ));
        $data->delete();
        if ($data->trashed()) {
            return redirect()->route('admin.carriers.index')->with('success', 'Nhà vận chuyển đã được xóa thành công');
        }

        return redirect()->route('admin.carriers.index')->with('success', 'Nhà vận chuyển đã bị xóa vĩnh viễn');
    }

    public function hardDeleteCarrier(int $id)
    {
        $data = $this->carrierService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->route('admin.carriers.index')->with('error', 'Nhà vận chuyển không tồn tại hoặc đã được xóa.');
        }

        $logDetails = sprintf(
            'Xóa vận chuyển: Tên - %s',
            $data->name
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa Cứng',
            $logDetails
        ));

        // Xóa vĩnh viễn
        $data->forceDelete();

        return redirect()->route('admin.carriers.deleted')->with('success', 'Nhà vận chuyển đã bị xóa vĩnh viễn.');
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
                    case 'soft_delete_carrier':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->carrierService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroyCarrier($id);
                            }
                        }
                        return response()->json(['message' => 'Xóa nhà vận chuyển thành công'], 200);

                    case 'hard_delete_carrier':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->carrierService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteCarrier($id);
                            }
                        }
                        return response()->json(['message' => 'Xóa dữ liệu thành công'], 200);
                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
                }
            }
            return response()->json(['message' => 'Categories deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }
}
