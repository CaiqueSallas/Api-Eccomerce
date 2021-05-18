<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class OrderService
{
    public function __construct(Order $order, ProductService $product)
    {
        $this->modelInstance = $order;
        $this->product = $product;
    }

    public function create($user_id)
    {
        $model = $this->modelInstance->create(['user_id' => $user_id, 'status' => 'Aguardando pagamento']);

        return $model;
    }

    public function get($userId = null)
    {
        $order = $this->modelInstance
        ->with('user')
        ->with(['payment' => function($q) {
            $q->get();
        }])->with(['orderProduct' => function($q) {
            $q->with('product')->get();
        }])->get();

        if(isset($userId))
        {
            $order = $order->where('user_id', $userId);
        }

        return $order;
    }

    public function delete($id)
    {
        $order = $this->modelInstance->find($id);

        if(!isset($order))
        {
            throw new NotFoundHttpException('Pedido não encontrado');
        }

        $payment = $order->payment();
        $orderProducts = $order->orderProduct();

        $iterable = $orderProducts->get();

        foreach($iterable as $orderProduct)
        {
            $product = Product::find($orderProduct->product_id);

            $quantity = $product->quantity;

            $this->product->setStock([
                'id'        =>  $product->id,
                'quantity'  =>  $quantity + $orderProduct->quantity
            ]);
        }

        $orderProducts->delete();
        $payment->delete();
        $order->delete();

        return $order;
    }
}
