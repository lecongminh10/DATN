<?php

namespace App\Services;

use App\Repositories\PaymentRepository;

class PaymentService extends BaseService
{
    protected $paymentService;
    protected $paymentRepository;

    public function __construct(PaymentRepository $paymentService)
    {
        parent::__construct($paymentService);
        $this ->paymentService = $paymentService;
    }

    public function getAll(){
        return $this->paymentService->getAllPayment();
    }


    public function createPayment(array $data)
    {
        return $this->paymentService->create($data);
    }

    public function updatePayment($id, array $data)
    {
        return $this->paymentService->update($id, $data);
    }

    public function deletePayment($id)
    {
        return $this->paymentService->delete($id);
    }
}