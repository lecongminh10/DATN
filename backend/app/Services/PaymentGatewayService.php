<?php

namespace App\Services;

use App\Repositories\PaymentGatewayRepository;

class PaymentGatewayService extends BaseService
{
    protected $paymentGatewayService;
    protected $paymentGatewayRepository;

    public function __construct(PaymentGatewayRepository $paymentGatewayService)
    {
        parent::__construct($paymentGatewayService);
        $this ->paymentGatewayService = $paymentGatewayService;
    }

    public function getAll(){
        return $this->paymentGatewayService->getAllPaymentGateway();
    }


    public function createPaymentGateway(array $data)
    {
        return $this->paymentGatewayService->create($data);
    }

    public function updatePaymentGateway($id, array $data)
    {
        return $this->paymentGatewayService->update($id, $data);
    }

    public function deletePaymentGateway($id)
    {
        return $this->paymentGatewayService->delete($id);
    }
}