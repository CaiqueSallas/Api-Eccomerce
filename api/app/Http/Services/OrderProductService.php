<?php

namespace App\Http\Services;

use App\Models\OrderProduct;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderProductService
{
    public function __construct(OrderProduct $orderProduct)
    {
        $this->orderProduct = $orderProduct;
    }

    public function create(array $params)
    {
        $orderProduct = $this->orderProduct->create($params);

        return $orderProduct;
    }

    public function get()
    {
        $model = $this->orderProduct->with('product')->get();

        return $model;
    }


}
