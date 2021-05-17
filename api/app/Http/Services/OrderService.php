<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class OrderService
{
    public function __construct(Order $order)
    {
        $this->modelInstance = $order;
    }

    public function create($user_id)
    {
        $model = $this->modelInstance->create(['user_id' => $user_id, 'status' => 'aguardando pagamento']);

        return $model;
    }

    public function get($userId = null)
    {
        $order = $this->modelInstance
        ->with(['payment' => function($q) {
            $q->get();
        }])->with(['orderProduct' => function($q) {
            $q->get();
        }])
        ->where('user_id', $userId)->get();

        return $order;
    }

    public function delete($id)
    {
        $order = $this->modelInstance->find($id);

        if(!isset($order))
        {
            throw new NotFoundHttpException('Pedido não encontrado');
        }

        $payment = Payment::where('order_id', $id);
        $orderProduct = OrderProduct::where('order_id', $id);

        $orderProduct->delete();
        $payment->delete();
        $order->delete();

        return $order;
    }
}
