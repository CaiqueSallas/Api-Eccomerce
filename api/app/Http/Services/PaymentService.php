<?php

namespace App\Http\Services;

use App\Models\Payment;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class PaymentService
{
    public function __construct(Payment $payment)
    {
        $this->modelInstance = $payment;
    }

    public function create(array $params)
    {
        $payment = $this->modelInstance->create($params);

        return $payment;
    }

    public function get()
    {
        $payment = $this->modelInstance->get();

        return $payment;
    }

    public function update($id)
    {
        $payment = $this->modelInstance->find($id);

        if($payment->status_id == 1)
        {
            throw new ConflictHttpException('Pagamento já realizado');
        }
        $payment->status_id = 1;

        $payment->save();

        $order = $payment->order;

        $order->status = 'Pagamento realizado';

        $order->save();

        return $payment;
    }
}
