<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Exception;
use Faker\Extension\Extension;
use Illuminate\Support\Facades\DB;

class BaseService
{
    protected $repository;

    public function __construct(BaseRepository $repository )
    {
        $this ->repository = $repository;
    }

    public function getAll(){

        return $this ->repository ->getAll();
    }

    public function getById($id){

        return $this ->repository ->getById($id);
    }

    public function paginate($perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function saveOrUpdate(array $input , int $id = null){
        try{
            DB::beginTransaction();
            if(isset($id)){
                $input['id'] = $id;
                
            }
            $result = $this->repository->saveOrUpdateItem($input , $id);
            DB::commit();
            if($result){
                return $result;
            }else{
                throw new Exception("Cant save or update information");
            }
        }catch(Extension $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id){
        try{
            DB::beginTransaction();
            $result = $this->repository->delete($id);
            DB::commit();
            return $result;

        }
        catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
