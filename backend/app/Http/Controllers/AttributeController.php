<?php

namespace App\Http\Controllers;

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
        $data = $this->attributeService->show_soft_delete($search , $perPage);
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
   
    // Lưu dữ liệu để thêm product(attribute ->variant)
    public function saveAttributes(Request $request)
    {
        // Lấy các giá trị thuộc tính được gửi từ request
        $selectedValues = $request->input('attributes', []); // Mặc định là mảng rỗng nếu không có giá trị
    
        $attributesData = []; // Mảng để lưu dữ liệu thuộc tính
    
        // Lặp qua từng giá trị thuộc tính được chọn
        foreach ($selectedValues as $value) {
            // Tìm kiếm giá trị thuộc tính trong cơ sở dữ liệu
            $attributeValue = AttributeValue::where('attribute_value', $value)->first();
    
            // Nếu tìm thấy giá trị thuộc tính
            if ($attributeValue) {
                // Lấy thông tin của thuộc tính tương ứng
                $attribute = $attributeValue->attribute; // Lấy thông tin thuộc tính liên quan
    
                // Tạo mảng dữ liệu cho thuộc tính
                $attributesData[] = [
                    'id' => $attributeValue->id,
                    'name' => $attribute->attribute_name,
                    'value' => $attributeValue->attribute_value,
                    'price_modifier' => $attributeValue->price_modifier ?? 0, // Giả sử bạn có thuộc tính price_modifier trong bảng attributes_values
                    'stock' => $attributeValue->stock ?? 0, // Giả sử bạn có thuộc tính stock trong bảng attributes_values
                    'status' => $attributeValue->status ?? '', // Giả sử bạn có thuộc tính status trong bảng attributes_values
                    'variant_image' => $attributeValue->variant_image ?? '', // Giả sử bạn có thuộc tính variant_image trong bảng attributes_values
                ];
            }
        }
    
        // Lưu mảng ID vào session
        session(['product_attribute_ids' => array_column($attributesData, 'id')]);
    
        // Trả về phản hồi JSON
        return response()->json([
            'message' => 'Giá trị đã được lưu thành công!',
            'attributes' => $attributesData // Trả về danh sách thuộc tính
        ]);
    }
    

}
