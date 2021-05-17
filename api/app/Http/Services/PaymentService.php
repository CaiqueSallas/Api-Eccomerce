<?php

namespace App\Http\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Request;

class PaymentService
{
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function create(array $params){
        $payment = $this->payment->create($params);

        return $payment;
    }

    public function get(){
        $payment = $this->payment->get();

        return $payment;
    }
}
