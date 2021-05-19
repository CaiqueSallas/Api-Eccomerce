<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'name',
        'quantity',
        'value',
        'created_at'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'product_id', 'id');
    }
}
