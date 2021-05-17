<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserController extends Controller
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

    public function __construct(Request $request, User $user){
        $this->request  = $request;
        $this->user     = $user;
    }

    function get(){
        return response()->Json([
            'error'     => false,
            'data'      => User::all()
         ], 201);
    }

    function login()
    {
        $validator = Validator::make($this->request->all(), $this->loginRules);

        if($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $user = User::where('email', $this->request->email)->first();
            if (!$user || !Hash::check($this->request->password, $user->password)) {
                throw new UnauthorizedHttpException('Email ou senha incorretos');
            }

        $token = $user->createToken('my-app-token')->plainTextToken;

        return response()->Json([
            'error'     => false,
            'message'   => 'Usuário logado com sucesso',
            'user'      => $user,
            'token'     => $token
        ], 201);
    }

    function register() {
        $validator = Validator::make($this->request->all(), $this->createRules);

        if($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $user = User::where('email', $this->request->email)->first();

        if(isset($user)){
            throw new ConflictHttpException('Email já está em uso');
        }

        $params = [
            'name'      => $this->request->name,
            'email'     => $this->request->email,
            'password'  => Hash::make($this->request->password)
        ];

        $user = User::create($params);

        return response()->Json([
            'error'         => false,
            'message'       => 'Usuário criado com sucesso',
            'data'          => $user
        ]);
    }

    public function logout() {
        $this->request->user()->currentAccessToken()->delete();
        return response()->Json([
            'error' => false,
            'message' => 'Usuário deslogado com sucesso!'
        ]);
    }
}
