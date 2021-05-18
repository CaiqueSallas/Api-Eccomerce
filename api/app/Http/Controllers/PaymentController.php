<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct(PaymentService $payment)
    {
        $this->payment = $payment;
    }

    public function get()
    {
        $payment = $this->payment->get();

        return response()->Json([
            'error'     => false,
            'data'      => $payment
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_id'        => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $data = $this->payment->update($request->input('payment_id'));

        return response()->json([
            'error'     => false,
            'message'   => 'Pagamento efetuado com sucesso!',
            'data'      => $data
        ]);
    }
}
