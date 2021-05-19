<?php

namespace App\Http\Services;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;

class BaseService
{
    protected $modelInstance;

    public function create(array $data): BaseModel
    {
        return $this->modelInstance->create($data);
    }

    public function get(array $params = null): Collection
    {
        return $this->modelInstance->get();
    }
}
