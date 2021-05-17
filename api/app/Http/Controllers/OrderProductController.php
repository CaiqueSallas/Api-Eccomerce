<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderProductService;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function __construct(OrderProductService $product)
    {
        $this->serviceInstance = $product;
    }

    public function get()
    {
        return OrderProduct::all();
    }
}
