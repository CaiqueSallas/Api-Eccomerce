<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(PaymentService $payment)
    {
        $this->payment = $payment;
    }

    public function get(){
        $payment = $this->payment->get();

        return response()->Json([
            'error'     => false,
            'data'      => $payment
        ]);
    }
}
