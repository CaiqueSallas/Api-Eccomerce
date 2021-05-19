<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    protected $serviceInstance;
    protected $updateRules;
    protected $createRules;

    public function get(): JsonResponse
    {
        $instance = $this->serviceInstance->get();

        return response()->json([
            'error'     => false,
            'data'      => $instance
        ], 200);
    }

    public function create(): JsonResponse
    {
        $validator = Validator::make($this->request->all(), $this->createRules);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'data' => $validator->errors()
            ], 422);
        }

        $model = $this->serviceInstance->create($this->request->all());

        return response()->json([
            'error'     => false,
            'data'      => $model
        ], 201);
    }

    public function delete(int $id): JsonResponse
    {
        $this->serviceInstance->delete($id);

        return response()->json([
            'error'         => false,
            'message'       => 'Recurso excluído com sucesso!'
        ], 200);
    }
}
