<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function get(array $params)
    {
        $model = $this->product;

        if (isset($params['filter'])) {
            $model = $model->where('name', 'ilike', '%' . $params['filter'] . '%');
        }

        if (isset($params['order'])) {
            $model = $model->orderBy($params['order'], 'desc');
        }

        $model = $model->get();

        return $model;
    }

    public function verifyStock(array $products){
        foreach($products as $product)
        {
            $model = $this->product->find($product['product_id']);

            if($model->quantity < $product['quantity']){
                throw new NotFoundHttpException('Produto fora de estoque: ' . $model->name);
            }
        }

        return $product;

    }

    public function create(array $params)
    {
        $model = $this->product->create([
            'name'      =>  $params['name'],
            'value'     =>  $params['value'],
            'quantity'  =>  $params['quantity']
        ]);

        return $model;
    }

    public function setStock(array $params)
    {
        $model = $this->product->find($params['id']);

        $model->quantity = $params['quantity'];

        $model->save();

        return $model;
    }
}
