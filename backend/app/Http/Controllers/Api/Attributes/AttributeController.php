<?php

namespace App\Http\Controllers\Api\Attributes;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest; // Xác thực cho thuộc tính
use App\Models\Attribute;
use App\Services\AttributeService;
use App\Services\AttributeValueService;
use Illuminate\Http\JsonResponse;
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

    // CRUD cho Attributes-AttributeValue
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $attributes = $this->attributeService->getAllAttribute($search, $perPage);
        return response()->json([
            'message' => 'success',
            'attributes' => $attributes,
        ], 200);
    }

    public function show(int $id): JsonResponse
    {
        try {
            // Tìm thuộc tính theo ID và bao gồm giá trị thuộc tính
            $attribute = Attribute::with('attributeValues')->findOrFail($id);

            return response()->json([
                'attribute' => $attribute,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi xóa thuộc tính',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    //------------------------Create Attribute - AttributeValue
    public function store(AttributeRequest $request): JsonResponse
    {
        // Bắt đầu giao dịch
        DB::beginTransaction();

        // Lấy dữ liệu đã được xác thực từ request
        $validatedData = $request->validated();

        try {
            // Tạo thuộc tính
            $attribute = $this->attributeService->saveOrUpdate([
                'attribute_name' => $validatedData['attribute_name'],
                'description' => $validatedData['description'],
            ]);

            // Kiểm tra xem 'attribute_value' có tồn tại và là mảng
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
            return response()->json([
                'attribute' => $attribute,
                'message' => 'Thêm mới thành công'
            ], 201);
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback
            DB::rollBack();
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi thêm thuộc tính',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    //------------------------Update Attribute - AttributeValue

    public function update(AttributeRequest $request, $id): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            // Tìm thuộc tính theo id
            $attribute = $this->attributeService->findById($id);

            if (!$attribute) {
                return response()->json(['error' => 'Không tìm thấy thuộc tính.'], 404);
            }

            // Cập nhật thuộc tính
            $attribute->attribute_name = $validatedData['attribute_name'];
            $attribute->description = $validatedData['description'];
            $attribute->save(); // Lưu thay đổi thuộc tính

            // Lấy tất cả giá trị thuộc tính hiện có
            $currentValues = $attribute->attributeValues->pluck('id')->toArray(); // Lấy danh sách ID giá trị thuộc tính hiện tại

            // Lưu trữ ID của các giá trị thuộc tính mới được gửi lên
            $newValueIds = [];

            // Cập nhật hoặc thêm mới giá trị thuộc tính
            if ($request->has('attribute_value') && is_array($request->input('attribute_value'))) {
                foreach ($request->input('attribute_value') as $value) {
                    if (isset($value['id'])) {
                        // Nếu có id, tìm giá trị thuộc tính và cập nhật
                        $attributeValue = $this->attributeValueService->findById($value['id']);
                        if ($attributeValue && !($attributeValue->attribute_value == $value['attribute_value'])) {
                            $attributeValue->attribute_value = $value['attribute_value'];
                            $attributeValue->save(); // Lưu thay đổi
                            $newValueIds[] = $attributeValue->id; // Lưu ID của giá trị đã cập nhật
                        }
                    } else {
                        // Nếu không có id, thêm giá trị thuộc tính mới
                        $newAttributeValue = $this->attributeValueService->saveOrUpdate([
                            'id_attributes' => $attribute->id,
                            'attribute_value' => $value['attribute_value'],
                        ]);
                        $newValueIds[] = $newAttributeValue->id; // Lưu ID của giá trị mới thêm
                    }
                }
            }

            // Xóa các giá trị thuộc tính không còn trong danh sách mới
            $valuesToDelete = array_diff($currentValues, $newValueIds);
            if (!empty($valuesToDelete)) {
                $this->attributeValueService->deleteValues($valuesToDelete); // Xóa giá trị thừa
            }

            return response()->json(['attribute' => $attribute, 'message' => 'Cập nhật thành công.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi khi cập nhật thuộc tính.', 'message' => $e->getMessage()], 500);
        }
    }

    //------------------------Delete Attribute
    public function deleteMultiple(Request $request)
    {
        // Xác thực yêu cầu
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer', // Đảm bảo tất cả các ID là kiểu số nguyên
            'action' => 'required|string', // Thêm xác thực cho trường action
        ]);

        // Lấy các ID và action từ yêu cầu
        $ids = $request->input('ids'); // Lấy mảng ID
        $action = $request->input('action'); // Lấy giá trị của trường action

        if (count($ids) > 0) {
            foreach ($ids as $id) {
                switch ($action) {
                    case 'soft_delete':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->attributeService->isAttributeSoftDeleted($id);
                            if (!$isSoftDeleted) {
                                $this->softDelete($id);
                            }
                        }
                        return response()->json(['message' => 'Xóa mềm thành công'], 200);

                    case 'hard_delete':
                        foreach ($ids as $id) {
                            $this->hardDelete($id);
                        }
                        return response()->json(['message' => 'Xóa cứng thành công'], 200);

                    default:
                        return response()->json(['message' => 'Hành động không hợp lệ'], 400);
                }
            }
        } else {
            return response()->json(['message' => 'Lỗi: Không có ID nào được cung cấp'], 500);
        }
    }

    public function softDelete(int $id)
    {
        $data = $this->attributeService->getIdWithTrashed($id);

        if (!$data) {
            return response()->json(['message' => 'Không tìm thấy thuộc tính'], 404);
        }
        // Xóa mềm
        $data->delete();

        if ($data->trashed()) {
            return response()->json(['message' => 'Thuộc tính đã được xóa mềm thành công'], 200);
        }

        return response()->json(['message' => 'Có lỗi xảy ra trong quá trình xóa mềm'], 500);
    }

    public function hardDelete(int $id)
    {
        $data = $this->attributeService->getIdWithTrashed($id);

        if (!$data) {
            return response()->json(['message' => 'Không tìm thấy thuộc tính.'], 404);
        }

        // Xóa cứng thuộc tính
        $data->forceDelete();


        return response()->json(['message' => 'Xóa cứng thành công'], 200);
    }


    //---------------------------Delete AttributeValue

    public function deleteAttributeValueMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'action' => 'required|string',
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');

        if (count($ids) > 0) {
            switch ($action) {
                case 'soft_delete':
                    foreach ($ids as $id) {
                        $this->softDeleteMultipleValue($id);
                    }
                    return response()->json(['message' => 'Xóa mềm thành công'], 200);

                case 'hard_delete':
                    foreach ($ids as $id) {
                        $this->hardDeleteAttributeValue($id);
                    }
                    return response()->json(['message' => 'Xóa cứng thành công'], 200);

                default:
                    return response()->json(['message' => 'Hành động không hợp lệ'], 400);
            }
        } else {
            return response()->json(['message' => 'Lỗi: Không có ID nào được cung cấp'], 400);
        }
    }


    public function softDeleteMultipleValue(int $id)
    {
        $attributeValue = $this->attributeValueService->getIdWithTrashed($id);

        if (!$attributeValue) {
            return response()->json(['message' => 'Giá trị thuộc tính không tìm thấy'], 404);
        }

        // Xóa mềm giá trị thuộc tính
        $attributeValue->delete();

        return response()->json(['message' => 'Giá trị thuộc tính đã được xóa mềm thành công'], 200);
    }

    public function hardDeleteAttributeValue(int $id)
    {
        $attributeValue = $this->attributeValueService->getIdWithTrashed($id);

        if (!$attributeValue) {
            return response()->json(['message' => 'Giá trị thuộc tính không tìm thấy'], 404);
        }

        // Xóa cứng giá trị thuộc tính
        $attributeValue->forceDelete();

        return response()->json(['message' => 'Giá trị thuộc tính đã được xóa cứng thành công'], 200);
    }
}
