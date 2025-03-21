<?php

namespace App\Http\Controllers;

use App\Events\AdminActivityLogged;
use App\Http\Requests\AttributeRequest;
use App\Models\AttributeValue;
use App\Services\AttributeService;
use App\Services\AttributeValueService;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    protected $attributeService;
    protected $attributeValueService;

    public function __construct(AttributeService $attributeService, AttributeValueService $attributeValueService)
    {
        $this->attributeService = $attributeService;
        $this->attributeValueService = $attributeValueService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $attributes = $this->attributeService->getAllAttribute($search, $perPage);
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeRequest $attributeRequest)
    {
        $validatedData = $attributeRequest->validated();

        try {
            DB::beginTransaction();
            // Tạo thuộc tính
            $attribute = $this->attributeService->saveOrUpdate([
                'attribute_name' => $validatedData['attribute_name'],
                'description' => $validatedData['description'],
            ]);
            if (!empty($validatedData['attribute_value']) && is_array($validatedData['attribute_value'])) {
                foreach ($validatedData['attribute_value'] as $value) {
                    if (!empty($value)) {
                        $this->attributeValueService->saveOrUpdate([
                            'id_attributes' => $attribute->id,
                            'attribute_value' => $value,
                        ]);
                    }
                }
            }
            $logDetails = sprintf(
                'Thêm mới thuộc tính: Tên - %s',
                $validatedData['attribute_name']
            );

            // Ghi nhật ký hoạt động
            event(new AdminActivityLogged(
                auth()->user()->id,
                'Thêm mới',
                $logDetails
            ));
            DB::commit();
            return redirect()->route('admin.attributes.index')->with('success', 'Thêm mới Attribute và Attribute Values thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi thêm thuộc tính: ' . $e->getMessage()]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attribute = $this->attributeService->getById($id);

        if (!$attribute) {
            return redirect()->route('admin.attributes.index')->withErrors(['error' => 'Thuộc tính không tồn tại']);
        }

        return view('admin.attributes.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attribute = $this->attributeService->getById($id);
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeRequest $attributeRequest, string $id)
    {

        $validatedData = $attributeRequest->validated();

        try {
            DB::beginTransaction();
            $attribute = $this->attributeService->getById($id);

            if (!$attribute) {
                return redirect()->back()->withErrors(['error' => 'Thuộc tính không tồn tại']);
            }

            $attribute->update([
                'attribute_name' => $validatedData['attribute_name'],
                'description' => $validatedData['description'],
            ]);
            // Thêm các giá trị thuộc tính mới
            foreach ($validatedData['attribute_value'] as $index => $value) {
                if (!empty($value)) {
                    $attributeValueId = $validatedData['attribute_value_id'][$index] ?? null;
                    if ($attributeValueId) {
                        $this->attributeValueService->saveOrUpdate([
                            'id_attributes' => $attribute->id,
                            'attribute_value' => $value,
                        ], $attributeValueId);
                    } else {
                        $this->attributeValueService->saveOrUpdate([
                            'id_attributes' => $attribute->id,
                            'attribute_value' => $value,
                        ]);
                    }
                }
            }
            $logDetails = sprintf(
                'Sửa thuộc tính: Tên - %s',
                $validatedData['attribute_name']
            );

            // Ghi nhật ký hoạt động
            event(new AdminActivityLogged(
                auth()->user()->id,
                'Sửa',
                $logDetails
            ));
            DB::commit();
            return redirect()->route('admin.attributes.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi cập nhật thuộc tính: ' . $e->getMessage()]);
        }
    }

    public function showSotfDelete(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $data = $this->attributeService->show_soft_delete($search, $perPage);
        return view('admin.attributes.deleted', compact('data'));
    }

    public function restore($id)
    {
        try {
            $this->attributeService->restore_delete($id);
            return redirect()->route('admin.attributes.attributeshortdeleted')->with('success', 'Khôi phục thuộc tính thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.attributes.attributeshortdeleted')->with('error', 'Không thể khôi phục thuộc tính: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $data = $this->attributeService->getById($id);

        if (!$data) {
            return abort(404);
        }
        $logDetails = sprintf(
            'XÓa thuộc tính: Tên - %s',
            $data['attribute_name']
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa Mềm',
            $logDetails
        ));
        $data->delete();
        if ($data->trashed()) {
            return redirect()->route('admin.attributes.index')->with('success', 'Thuộc tính mềm đã được xóa không thành công');
        }
        return redirect()->route('admin.attributes.index')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }
    public function destroyValue(int $id)
    {
        try {
            $data = $this->attributeValueService->getById($id);
            if (!$data) {
                return response()->json(['message' => 'Attribute Values not found'], 404);
            }
            $data->delete();
            if ($data->trashed()) {
                return response()->json(['message' => 'Giá trị thuộc tính đã được xóa thành công'], 200);
            }
            return response()->json([
                'message' => 'Xóa thành công giá trị thuộc tính'
            ], 200);
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback
            DB::rollBack();
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi xóa giá trị thuộc tính',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function hardDeleteAttribute(int $id)
    {
        $data = $this->attributeService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->route('admin.attributes.index')->with('success', 'Thuộc tính đã được xóa không thành công');
        }
        $logDetails = sprintf(
            'Xóa thuộc tính: Tên - %s',
            $data->attribute_name
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa Cứng',
            $logDetails
        ));
        $data->forceDelete();
        return redirect()->route('admin.attributes.attributeshortdeleted')->with('success', 'Thuộc tính đã bị xóa vĩnh viễn');
    }

    public function hardDeleteAttributeValue(int $id)
    {
        $data = $this->attributeValueService->getIdWithTrashed($id);
        if (!$data) {
            return response()->json(['message' => 'Attribute Value not found.'], 404);
        }
        $data->forceDelete();
        return response()->json(['message' => 'Delete with success'], 200);
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
                    case 'soft_delete_attribute':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->attributeService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroy($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_attribute':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->attributeService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteAttribute($id);
                            }
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);

                    case 'soft_delete_attribute_values':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->attributeValueService->isSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->destroyValue($id);
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_attribute_value':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->attributeValueService->isSoftDeleted($id);
                            if ($isSoftDeleted) {
                                $this->hardDeleteAttributeValue($id);
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

    public function saveAttributes(Request $request)
    {
        session()->forget('product_attributes');
        $selectedValues = $request->input('attributes', []);

        if (empty($selectedValues)) {
            return response()->json(['message' => 'Không có dữ liệu thuộc tính để lưu.'], 400);
        }

        session(['product_attributes' => $selectedValues]);

        return response()->json([
            'message' => 'Các thuộc tính đã được lưu thành công!',
            'data' => $selectedValues
        ]);
    }
}
