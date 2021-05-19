<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
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

    public function __construct(ProductService $productService, Request $request)
    {
        $this->serviceInstance = $productService;
        $this->request = $request;
    }

    public function get(): JsonResponse
    {
        $validator = Validator::make($this->request->all(), [
            'filter'        =>      'string|nullable',
            'order'         =>      'string|nullable',
            'id'            =>      'numeric|nullable'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $data = $this->serviceInstance->get($this->request->only('filter', 'order', 'id'));

        return response()->json([
            'error'     => false,
            'data'      => $data,
        ], 200);
    }

    public function setStock(): JsonResponse
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
        ], 200);
    }
}
