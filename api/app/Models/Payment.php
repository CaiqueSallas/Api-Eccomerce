<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment';

    protected $fillable = [
        'id',
        'order_id',
        'method',
        'value',
        'status_id'
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    protected $with = [
        'status'
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function status(){
        return $this->hasOne(PaymentStatus::class, 'id', 'status_id');
    }
}
