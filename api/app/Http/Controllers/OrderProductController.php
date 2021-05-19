<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderProductService;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderProductController extends BaseController
{
    public function __construct(OrderProductService $product)
    {
        $this->serviceInstance = $product;
    }
}
