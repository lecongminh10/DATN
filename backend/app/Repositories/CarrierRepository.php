<?php

namespace App\Repositories;

use App\Models\Carrier;

class CarrierRepository extends BaseRepository
{
    protected $model;

    public function __construct(Carrier $carrierRepository)
    {
        parent::__construct($carrierRepository);
        $this->model = $carrierRepository;
    }

    public function getAll($search = null, $perPage = null, $status = null)
    {
        $query = Carrier::query()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }
        if ($status) {
            $query->where('is_active', $status);
        }

        return $query->paginate($perPage);
    }

    public function show_soft_delete($search = null, $perPage = 10, $status = null) // $perPage mặc định là 10
    {
        $query = Carrier::onlyTrashed()->latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        if ($status) {
            $query->where('is_active', $status);
        }
        $model = $query->paginate($perPage);

        return $model;
    }

    public function restore_delete($id)
    {
        $model = Carrier::onlyTrashed()->findOrFail($id);
        $model->restore();
    }

    public function update_status($id, $validatedData)
    {
        if ($validatedData['is_active'] === 'active') {
            Carrier::where('id', '!=', $id)
                ->whereNull('deleted_at')
                ->update(['is_active' => 'inactive']);
        }
    }
}
