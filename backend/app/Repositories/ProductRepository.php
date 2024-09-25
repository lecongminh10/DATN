<?php

namespace App\Repositories;

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


    // public function getAll()
    // {

    //     return $this->model->all();
    // }

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
