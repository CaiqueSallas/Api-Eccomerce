<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment';

    protected $fillable = [
        'id',
        'order_id',
        'method',
        'value',
        'status_id',
        'created_at'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];

    protected $with = [
        'status'
    ];

    public function order() {
        return $this->belongsTo(Request::class, 'request_id', 'id');
    }

    public function status(){
        return $this->hasOne(PaymentStatus::class, 'id', 'status_id');
    }
}
