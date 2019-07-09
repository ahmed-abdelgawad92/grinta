<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function table()
    {
        return $this->belongsTo('App\Table');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }

    public function orderItem()
    {
        return $this->hasMany('App\OrderItem');
    }
}
