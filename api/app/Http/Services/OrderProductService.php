<?php

namespace App\Http\Services;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderProductService extends BaseService
{
    public function __construct(OrderProduct $orderProduct)
    {
        $this->modelInstance = $orderProduct;
    }

    public function get(array $params = null): Collection
    {
        $model = $this->modelInstance->with('product')->get();

        return $model;
    }


}
