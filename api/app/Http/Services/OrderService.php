<?php

namespace App\Http\Services;

use App\Models\Order;

class OrderService
{
    public function __construct(Order $order)
    {
        $this->modelInstance = $order;
    }

    public function create($user_id)
    {
        $model = $this->modelInstance->create(['user_id' => $user_id]);

        return $model;
    }

    public function get($userId = null)
    {
        $model = $this->modelInstance->where('user_id', $userId);

        $model = $model->whereHas(['payment', function($q) use($model) {
            $q->where('order_id', $model->id);
        }])->first();

        return $model;
    }
}
