<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Exception;
use Faker\Extension\Extension;
use Illuminate\Support\Facades\DB;

class BaseService
{
    protected $service;

    public function __construct(BaseRepository $service)
    {
        $this->service = $service;
    }

    public function getAll()
    {

        return $this->service->getAll();
    }

    public function getById($id)
    {

        return $this->service->getById($id);
    }

    public function paginate($perPage = 10)
    {
        return $this->service->paginate($perPage);
    }

    public function saveOrUpdate(array $input, int $id = null)
    {
        try {
            DB::beginTransaction();
            if (isset($id)) {
                $input['id'] = $id;
            }
            $result = $this->service->saveOrUpdateItem($input, $id);
            DB::commit();
            if ($result) {
                return $result;
            } else {
                throw new Exception("Cant save or update information");
            }
        } catch (Extension $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id)
    {
        try {
            DB::beginTransaction();
            $result = $this->service->delete($id);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getIdWithTrashed(int $id)
    {
        return $this->service->getByIdWithTrashed($id);
    }

    public function isSoftDeleted(int $id)
    {
        return $this->service->isSoftDeleted($id);
    }
}
