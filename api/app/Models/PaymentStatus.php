<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;

    protected $table = 'payment_status';

    protected $fillable = [
        'id',
        'name'
    ];

    public $timestamps = false;

    public function payment(){
        return $this->hasMany(Payment::class, 'status_id', 'id');
    }
}
