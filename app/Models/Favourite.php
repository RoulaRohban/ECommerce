<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at','user'];
    protected $with = ['product'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
