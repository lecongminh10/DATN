<?php

namespace App\Repositories;

use App\Models\Payment;


class PaymentRepository extends BaseRepository
{
    protected $paymentRepository;

    public function __construct(Payment $paymentRepository)
    {
        parent::__construct($paymentRepository);
        $this->paymentRepository = $paymentRepository;
    }

    public function getAllPayment()
    {
        return Payment::get();
    }

    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function findById($id)
    {
        return Payment::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($data);
        return $payment;
    }

    public function delete($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
    }

   
}