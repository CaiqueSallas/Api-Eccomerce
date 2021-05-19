<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class OrderService
{
    public function __construct(
        Order $order,
        ProductService $product,
        OrderProductService $orderProductService,
        PaymentService $paymentService
        )
    {
        $this->modelInstance = $order;
        $this->product = $product;
        $this->orderProductService = $orderProductService;
        $this->paymentService = $paymentService;
    }

    public function create($userId, $products, $payment)
    {
        $this->product->verifyStock($products);

        $order = $this->modelInstance->create(['user_id' => $userId, 'status' => 'Aguardando pagamento']);

        foreach($products as &$product) {
            $productModel = Product::find($product['product_id']);
            $product['value'] = $productModel->value * $product['quantity'];

            $this->orderProductService->create([
                'quantity'      => $product['quantity'],
                'order_id'      => $order->id,
                'product_id'    => $product['product_id']
            ]);

            $stock = $productModel->quantity - $product['quantity'];

            $this->product->setStock([
                'id'        => $productModel->id,
                'quantity'  => $stock
            ]);
        }

        $products = collect($products);

        $total = $products->sum('value');

        $this->paymentService->create([
            'order_id'  => $order->id,
            'status_id' => 2,
            'method'    => $payment['method'],
            'value'     => $total,
        ]);

        return $order;
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
