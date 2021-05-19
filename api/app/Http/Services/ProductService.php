<?php

namespace App\Http\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService extends BaseService
{
    public function __construct(Product $product)
    {
        $this->modelInstance = $product;
    }

    public function get(array $params = null): Collection
    {
        $model = $this->modelInstance;

        if (isset($params['id'])) {
            $model = $model->where('id', $params['id']);
        }

        if (isset($params['filter'])) {
            $model = $model->where('name', 'ilike', '%' . $params['filter'] . '%');
        }

        if (isset($params['order'])) {
            $model = $model->orderBy($params['order'], 'desc');
        }

        $collection = $model->get();

        return $collection;
    }

    public function verifyStock(array $products)
    {
        foreach($products as $product)
        {
            $model = $this->modelInstance->find($product['product_id']);

            if($model->quantity < $product['quantity']){
                throw new NotFoundHttpException('Produto fora de estoque: ' . $model->name);
            }
        }

        return $product;
    }

    public function setStock(array $params)
    {
        $model = $this->modelInstance->find($params['id']);

        if (!isset($model))
        {
            throw new NotFoundHttpException('Produto não encontrado');
        }

        $model->quantity = $params['quantity'];

        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->modelInstance->find($id);

        if (!isset($model))
        {
            throw new NotFoundHttpException('Produto não encontrado');
        }

        $relation = $model->orderProduct->first();

        if (isset($relation))
        {
            throw new ConflictHttpException('Produto atualmente requisitado em pelo menos um pedido');
        }

        return $model->delete();
    }
}
