<?php

namespace App\Repositories;

use App\Models\PaymentGateway;


class PaymentGatewayRepository extends BaseRepository
{
    protected $paymentGatewayRepository;

    public function __construct(PaymentGateway $paymentGatewayRepository)
    {
        parent::__construct($paymentGatewayRepository);
        $this->paymentGatewayRepository = $paymentGatewayRepository;
    }

    public function getAllPaymentGateway()
    {
        return PaymentGateway::get();
    }

    public function create(array $data)
    {
        return PaymentGateway::create($data);
    }

    public function findById($id)
    {
        return PaymentGateway::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $paymentGateway = PaymentGateway::findOrFail($id);
        $paymentGateway->update($data);
        return $paymentGateway;
    }

    public function delete($id)
    {
        $paymentGateway = PaymentGateway::findOrFail($id);
        $paymentGateway->delete();
    }

   
}