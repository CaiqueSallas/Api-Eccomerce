<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserService extends BaseService
{
    public function __construct(User $user)
    {
        $this->modelInstance = $user;
    }

    public function login(array $params)
    {
        $user = $this->modelInstance->where('email', $params['email'])->first();

        if (!$user || !Hash::check($params['password'], $user->password)) {
            throw new UnauthorizedHttpException('Email ou senha incorretos');
        }

        $user->token = $user->createToken('my-app-token')->plainTextToken;

        return $user;
    }

    public function register(array $params)
    {
        $user = $this->modelInstance->where('email', $params['email'])->first();

        if(isset($user)){
            throw new ConflictHttpException('Email já está em uso');
        }

        $params['password'] = Hash::make($params['password']);

        $user = $this->modelInstance->create($params);

        return $user;
    }
}
