<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserController extends BaseController
{
    protected $createRules = [
        'name'                  => 'required|string',
        'email'                 => 'required|email',
        'password'              => 'required'
    ];

    protected $loginRules = [
        'email'                 => 'required|email',
        'password'              => 'required'
    ];

    public function __construct(Request $request, UserService $userService){
        $this->request              = $request;
        $this->serviceInstance      = $userService;
    }

    public function login()
    {
        $validator = Validator::make($this->request->all(), $this->loginRules);

        if($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $user = $this->serviceInstance->login($this->request->all());

        return response()->Json([
            'error'     => false,
            'message'   => 'Usuário logado com sucesso',
            'user'      => $user
        ], 201);
    }

    public function register() {
        $validator = Validator::make($this->request->all(), $this->createRules);

        if($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $user = $this->serviceInstance->register($this->request->all());

        return response()->Json([
            'error'         => false,
            'message'       => 'Usuário criado com sucesso',
            'data'          => $user
        ], 200);
    }

    public function logout()
    {
        $this->request->user()->currentAccessToken()->delete();

        return response()->Json([
            'error' => false,
            'message' => 'Usuário deslogado com sucesso!'
        ], 200);
    }
}
