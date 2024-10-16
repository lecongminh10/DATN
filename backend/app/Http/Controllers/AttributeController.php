<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest; // Xác thực cho thuộc tính
use App\Models\Attribute;
use App\Models\AttributeValue;
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

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $attributes =$this->attributeService->getAllAttribute($search , $perPage);
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

    // CRUD cho Attributes

    public function store(AttributeRequest $request): JsonResponse
    {
        // Lấy dữ liệu đã được xác thực từ request
        $validatedData = $request->validated();

        try {
            // Tạo thuộc tính
            $attribute = $this->attributeService->saveOrUpdate([
                'attribute_name' => $validatedData['attribute_name'],
                'description' => $validatedData['description'],
            ]);

            // Kiểm tra xem 'attribute_value' có tồn tại
            if (!empty($validatedData['attribute_value'])) {
                foreach ($validatedData['attribute_value'] as $value) {
                    if (!empty($value)) {
                        $this->attributeValueService->saveOrUpdate([
                            'id_attributes' => $attribute->id,
                            'attribute_value' => $value,
                        ]);
                    }
                }
            }

            return response()->json([
                'attribute' => $attribute,
                'message' => 'Thêm mới Attribute và AttributeValue thành công'
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

    public function update(AttributeRequest $request, $id): JsonResponse
    {
        // Lấy dữ liệu đã được xác thực từ request
        $validatedData = $request->validated();


        try {
            // Cập nhật thuộc tính
            $attribute = $this->attributeService->saveOrUpdate($validatedData, $id);

            // Xóa các giá trị thuộc tính cũ
            $attribute->attributeValues()->delete();

            // Thêm giá trị thuộc tính mới
            if (!empty($validatedData['attribute_value'])) {
                foreach ($validatedData['attribute_value'] as $value) {
                    if (!empty($value)) {
                        $this->attributeValueService->saveOrUpdate([
                            'id_attributes' => $attribute->id,
                            'attribute_value' => $value,
                        ]);
                    }
                }
            }

            return response()->json([
                'attribute' => $attribute,
                'message' => 'Cập nhật thành công thuộc tính và giá trị thuộc tính.'
            ], 200);
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback
            DB::rollBack();
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi cập nhật thuộc tính',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        $data = $this->attributeService->getById($id);
        if(!$data){
            return abort(404);
        }
        $data->delete();
        if($data->trashed()){
            return response()->json(['message' => 'Attribute soft deleted successfully'], 200); 
        }

        return response()->json(['message' => 'Attribute permanently deleted and cover file removed'], 200);
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
                return response()->json(['message' => 'Attribute Values soft deleted successfully'], 200);
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

    public function hardDeleteAttribute(int $id){
        $data= $this->attributeService->getIdWithTrashed($id);
        if (!$data) {
            return response()->json(['message' => 'Attribute not found.'], 404);
        }
        $data->forceDelete();
        return response()->json(['message' => 'Delete with success'], 200);
    }

    public function hardDeleteAttributeValue(int $id){
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
                            if(!$isSoftDeleted){
                                $this->destroy($id); 
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);
                     
                    case 'hard_delete_attribute':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->attributeService->isSoftDeleted($id);
                            if( $isSoftDeleted){
                                $this->hardDeleteAttribute($id);
                            } 
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);

                    case 'soft_delete_attribute_values':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->attributeValueService->isSoftDeleted($id);
                            if(!$isSoftDeleted){
                                    $this->destroyValue($id); 
                                }
                            }
                            return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_attribute_value':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->attributeValueService->isSoftDeleted($id);
                            if($isSoftDeleted){
                                $this->hardDeleteAttributeValue($id);
                            } 
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);
                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
                }
            }
            return response()->json(['message' => 'Categories deleted successfully'],200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }
}
