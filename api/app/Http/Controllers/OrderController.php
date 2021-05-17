<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderProductService;
use App\Http\Services\OrderService;
use App\Http\Services\PaymentService;
use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Class OrderController extends Controller {

    protected $createRules = [
        'payment.method'        => 'required|string',
        'products.*.product_id'   => 'required|numeric',
        'products.*.quantity'     => 'required|numeric'
    ];

    public function __construct(
        Request $request,
        OrderService $orderService,
        ProductService $productService,
        OrderProductService $orderProductService,
        PaymentService $paymentService
        )
    {
        $this->paymentService = $paymentService;
        $this->serviceInstance = $orderService;
        $this->request = $request;
        $this->productService = $productService;
        $this->orderProductService = $orderProductService;
    }

    public function getByUser($userId)
    {
        $data = $this->serviceInstance->get($userId);

        return response()->json([
            'error' => false,
            'data'  => $data
        ]);
    }

    public function delete($id)
    {

    }

    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->createRules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $order = $this->serviceInstance->create(auth()->user()->id);

        $products = $this->request->products;

        foreach($products as &$product) {
            $this->productService->verifyStock($product['product_id'], $product['quantity']);

            $productModel = Product::find($product['product_id']);
            $product['value'] = $productModel->value * $product['quantity'];

            $this->orderProductService->create([
                'quantity'      => $product['quantity'],
                'order_id'      => $order->id,
                'product_id'    => $product['product_id']
            ]);

            $stock = $productModel->quantity - $product['quantity'];

            $this->productService->setStock([
                'id'        => $productModel->id,
                'quantity'  => $stock
            ]);
        }

        $products = collect($products);

        $total = $products->sum('value');

        $payment = $this->paymentService->create([
            'order_id'  => $order->id,
            'status_id' => 1,
            'method'    => $this->request->payment['method'],
            'value'     => $total,
        ]);

        $data = $order
                    ->with('payment')
                    ->with('orderProduct')
                    ->with('user');

        return response()->json([
            'error'     => false,
            'message'   => 'Pedido feito com sucesso, aguardando pagamento.',
            'data'      => $data
        ]);
    }
}
