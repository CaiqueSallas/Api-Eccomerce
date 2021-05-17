<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $createRules = [
        'name'      => 'required|string',
        'value'     => 'required|numeric',
        'quantity'  => 'required|numeric'
    ];

    public function __construct(ProductService $serviceInstance, Request $request)
    {
        $this->serviceInstance = $serviceInstance;
        $this->request = $request;
    }

    public function get()
    {
        $validator = Validator::make($this->request->all(), [
            'filter'        =>      'string|nullable',
            'order'         =>      'string|nullable'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $data = $this->serviceInstance->get($this->request->only('filter', 'order'));

        return response()->json([
            'error'     => false,
            'data'      => $data,
        ]);
    }

    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->createRules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $data = $this->serviceInstance->create($this->request->only('name', 'value', 'quantity'));

        return response()->json([
            'error'     => false,
            'message'   => 'Produto criado com sucesso',
            'data'      => $data
        ]);
    }

    public function setStock()
    {
        $validator = Validator::make($this->request->all(), [
            'id'        =>  'required|numeric',
            'quantity'  =>  'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $data = $this->serviceInstance->setStock($this->request->only('id', 'quantity'));

        return response()->json([
            'error'     =>  false,
            'message'   =>  'Estoque modificado com sucesso',
            'data'      =>  $data
        ]);
    }
}
