<?php

namespace App\Http\Controllers;

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
        $validatedData = $carrierRequest->validated();

        try {
            DB::beginTransaction();

            $this->carrierService->update_status($id, $validatedData);
            $this->carrierService->saveOrUpdate([
                'name' => $validatedData['name'],
                'api_url' => $validatedData['api_url'],
                'api_token' => $validatedData['api_token'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'is_active' => $validatedData['is_active'],
            ]);

            DB::commit();
            return redirect()->route('admin.carriers.index')->with('success', 'Thêm mới carrier thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi thêm carrier: ' . $e->getMessage()]);
        }
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
        $validatedData = $carrierRequest->validated();

        try {
            DB::beginTransaction();
            $this->carrierService->update_status($id, $validatedData);
            $carrier = $this->carrierService->getById($id);
            $carrier->update([
                'name' => $validatedData['name'],
                'api_url' => $validatedData['api_url'],
                'api_token' => $validatedData['api_token'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'is_active' => $validatedData['is_active'] === 'active' ? 'active' : 'inactive',
            ]);

            DB::commit();

            return redirect()->route('admin.carriers.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi cập nhật carrier: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $status = $request->input('status');
        $data = $this->carrierService->show_soft_delete($search, $perPage, $status);
        return view('admin.carriers.deleted', compact('data'));
    }

    public function restore($id)
    {
        try {
            $this->carrierService->restore_delete($id);
            return redirect()->route('admin.carriers.deleted')->with('success', 'Khôi phục thuộc tính thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.carriers.deleted')->with('error', 'Không thể khôi phục thuộc tính: ' . $e->getMessage());
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
        $data->delete();
        if ($data->trashed()) {
            return redirect()->route('admin.carriers.index')->with('success', 'Thuộc tính mềm đã được xóa không thành công');
        }

        return redirect()->route('admin.carriers.index')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }

    public function hardDeleteCarrier(int $id)
    {
        $data = $this->carrierService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->route('admin.carriers.index')->with('success', 'Thuộc tính đã được xóa không thành công');
        }
        $data->forceDelete();
        return redirect()->route('admin.carriers.deleted')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
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
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_carrier':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->carrierService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteCarrier($id);
                            }
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);
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
