<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController extends BaseController
{
    public function __construct(PaymentService $payment)
    {
        $this->serviceInstance = $payment;
    }

    public function update(int $id): JsonResponse
    {
        $collection = $this->serviceInstance->update($id);

        return response()->json([
            'error'     => false,
            'message'   => 'Pagamento efetuado com sucesso!',
            'data'      => $collection
        ], 200);
    }
}
