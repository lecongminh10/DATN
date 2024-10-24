<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;


class ProductRepository extends BaseRepository
{
    protected $productRepository;

    // làm việc với model viết query builder và elogant

    public function __construct(Product $productRepository)
    {
        parent::__construct($productRepository);
        $this->productRepository = $productRepository;
    }


    public function getAll($search = null, $perPage = null)
    {

        $query = Product::with('variants')->with('galleries')->select('products.*', 'categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'products.category_id');


        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.code', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.short_description', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.content', 'LIKE', '%' . $search . '%');
            });

            // Lọc theo tên tag
            $query->orWhereHas('tags', function ($q) use ($search) {
                $q->where('tags.name', 'LIKE', '%' . $search . '%');
            });

            // Lọc theo tên danh mục (categories)
            $query->orWhere('categories.name', 'LIKE', '%' . $search . '%');

            // Bạn có thể thêm điều kiện lọc theo các thuộc tính khác như biến thể
            // $query->orWhereHas('variants', function ($q) use ($search) {
            //     $q->where('color', 'LIKE', '%' . $search . '%')
            //         ->orWhere('ram', 'LIKE', '%' . $search . '%');
            // });
        }

        return $query->paginate($perPage);
    }

    public function isSoftDeleted(int $id): bool
    {
        // Lấy product bao gồm cả các product đã bị xóa mềm
        $product = $this->model->withTrashed()->findOrFail($id);

        // Kiểm tra xem product có tồn tại và đã bị xóa mềm không
        return $product ? $product->trashed() : false;
    }

    public function getByIdWithTrashed(int $id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    public function show_soft_delete($search = null, $perPage = 10) // $perPage mặc định là 10
    {
        // Query to retrieve soft-deleted products with related models
        $query = Product::onlyTrashed()
            ->with('variants')
            ->with('galleries')
            ->select('products.*', 'categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->latest('id');
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.code', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.short_description', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.content', 'LIKE', '%' . $search . '%');
            });
    
            // Lọc theo tên tag
            $query->orWhereHas('tags', function ($q) use ($search) {
                $q->where('tags.name', 'LIKE', '%' . $search . '%');
            });
    
            // Lọc theo tên danh mục (categories)
            $query->orWhere('categories.name', 'LIKE', '%' . $search . '%');
    
            // Thêm điều kiện lọc theo các thuộc tính khác nếu cần
            // $query->orWhereHas('variants', function ($q) use ($search) {
            //     $q->where('color', 'LIKE', '%' . $search . '%')
            //         ->orWhere('ram', 'LIKE', '%' . $search . '%');
            // });
        }
    
        // Sử dụng paginate để phân trang
        return $query->paginate($perPage);
    }
    



    // public function getById($id)
    // {
    //     return $this->model->findOrFail($id);
    // }
    // public function paginate($perPage = 10)
    // {
    //     return $this->model->paginate($perPage);
    // }


    // public function delete(int $id)
    // {
    //     try {
    //         DB::beginTransaction();
    //         if (isset($id)) {
    //             $result = $this->model->findOrFail($id);
    //             if ($result) {
    //                 $result->delete();
    //             }
    //         }
    //         DB::commit();

    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         throw $e;
    //     }
    // }

    // public function saveOrUpdateItem(array $data, int $id = null)
    // {

    //     try {
    //         DB::beginTransaction();
    //         if (isset($id)) {
    //             $result = $this->model->findOrFail($id);
    //             if (!$result) {
    //                 return null;
    //             }
    //             $result->update($data);
    //         } else {
    //             $result = $this->model->create($data);
    //         }

    //         DB::commit();
    //         if ($result) {
    //             return $result;
    //         } else {
    //             throw new Exception("Cant save or update information");
    //         }
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         throw $e;
    //     }
    // }
}
