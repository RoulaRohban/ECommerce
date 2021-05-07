<?php

namespace App\Models;

use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public  function  orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
