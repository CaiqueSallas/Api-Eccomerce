<?php

namespace App\Http\Services;

use App\Models\Payment;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentService extends BaseService
{
    public function __construct(Payment $payment)
    {
        $this->modelInstance = $payment;
    }

    public function update($id)
    {
        $payment = $this->modelInstance->find($id);

        if (!isset($payment))
        {
            throw new NotFoundHttpException('Ordem não encontrada');
        }

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
